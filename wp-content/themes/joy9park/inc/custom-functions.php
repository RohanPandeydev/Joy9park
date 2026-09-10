<?php
/**
 * Custom Functions
 *
 * @package Joy_9_Park
 */

/**
 * Returns an ACF field value, falling back to $fallback when empty.
 * Keeps templates rendering the original static copy before an editor
 * has saved content for that field in wp-admin.
 */
function jp_field( $selector, $fallback = '', $post_id = false ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $fallback;
	}

	$value = get_field( $selector, $post_id );

	return ( $value === false || $value === '' || $value === null ) ? $fallback : $value;
}

/**
 * Same as jp_field() but for image fields returning a URL,
 * falling back to a path inside the theme directory.
 */
function jp_img( $selector, $fallback_path, $post_id = false ) {
	$value = jp_field( $selector, '', $post_id );

	return $value ? $value : get_template_directory_uri() . $fallback_path;
}

/**
 * Resolves the permalink of whichever published Page is assigned a given
 * page template, so cross-page buttons (Reserve a Spot, Testimonials, Home)
 * keep working without hardcoding slugs that may not exist yet.
 */
function jp_template_page_url( $template_filename, $fallback = '#' ) {
	static $cache = array();

	if ( array_key_exists( $template_filename, $cache ) ) {
		return $cache[ $template_filename ];
	}

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => $template_filename,
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'fields'         => 'ids',
		)
	);

	$url = ! empty( $pages ) ? get_permalink( $pages[0] ) : $fallback;

	$cache[ $template_filename ] = $url;

	return $url;
}


/**
 * Reads the front page's "pricing_cards" ACF repeater
 * (group_front_page_content.json) into a flat [ 'Vehicle Type' => (float)
 * rate ] map. Single source of truth for daily rates, consumed both by the
 * server-side booking email calculation below and — via wp_localize_script
 * in functions.php — by the live calculator in js/script.js, so editing a
 * rate in wp-admin updates it everywhere without touching code.
 */
function jp_get_pricing_cards_rates() {
	static $rates = null;

	if ( null !== $rates ) {
		return $rates;
	}

	$rates = array();

	$front_page_id = (int) get_option( 'page_on_front' );

	if ( $front_page_id && function_exists( 'have_rows' ) ) {
		while ( have_rows( 'pricing_cards', $front_page_id ) ) {
			the_row();

			$vehicle_type = trim( get_sub_field( 'vehicle_type' ) );
			$rate_text    = get_sub_field( 'rate' );

			// "rate" is stored as free text, e.g. "$17 / Day" — pull the number out.
			if ( '' === $vehicle_type || ! preg_match( '/[\d.]+/', $rate_text, $matches ) ) {
				continue;
			}

			$rates[ $vehicle_type ] = (float) $matches[0];
		}
	}

	// No editor has saved the Pricing tab in wp-admin yet (have_rows() found
	// nothing) — mirror front-page.php's own $pricing_cards_default fallback
	// so the rate map still matches what's actually on screen.
	if ( empty( $rates ) ) {
		$rates = array(
			'Sedan'        => 15,
			'Regular SUV'  => 17,
			'Large SUV'    => 21,
			'Minivan'      => 21,
			'Pickup Truck' => 23,
		);
	}

	return $rates;
}

/**
 * Looks up a single vehicle's daily rate from jp_get_pricing_cards_rates().
 * Falls back to $fallback when there's no matching row (e.g. ACF
 * unavailable, or the form's car_model value doesn't exactly match a
 * pricing card's vehicle type label).
 */
function jp_get_vehicle_daily_rate( $vehicle_type, $fallback = 17 ) {
	$vehicle_type = trim( (string) $vehicle_type );

	if ( '' === $vehicle_type ) {
		return $fallback;
	}

	foreach ( jp_get_pricing_cards_rates() as $type => $rate ) {
		if ( 0 === strcasecmp( $type, $vehicle_type ) ) {
			return $rate;
		}
	}

	return $fallback;
}

/**
 * Parking Booking Calculation for Contact Form 7
 */

add_filter('wpcf7_mail_components', 'parking_booking_calculation', 10, 2);

function parking_booking_calculation($components, $contact_form)
{
	$submission = WPCF7_Submission::get_instance();

	if (!$submission) {
		return $components;
	}

	$posted_data = $submission->get_posted_data();

	// --------------------------------------------------
	// Get form values
	// --------------------------------------------------

	$dropoff_date = isset($posted_data['dropoff-date'])
		? $posted_data['dropoff-date']
		: '';

	$pickup_date = isset($posted_data['pickup-date'])
		? $posted_data['pickup-date']
		: '';

	$dropoff_time = isset($posted_data['dropoff-time'])
		? $posted_data['dropoff-time']
		: '';

	$pickup_time = isset($posted_data['pickup-time'])
		? $posted_data['pickup-time']
		: '';

	if (
		empty($dropoff_date) ||
		empty($pickup_date) ||
		empty($dropoff_time) ||
		empty($pickup_time)
	) {
		return $components;
	}

	// --------------------------------------------------
	// Create DateTime objects
	// --------------------------------------------------

	try {

		$dropoff = new DateTime(
			$dropoff_date . ' ' . $dropoff_time,
			wp_timezone()
		);

		$pickup = new DateTime(
			$pickup_date . ' ' . $pickup_time,
			wp_timezone()
		);
	} catch (Exception $e) {

		return $components;
	}

	// --------------------------------------------------
	// Validate dates
	// --------------------------------------------------

	if ($pickup <= $dropoff) {
		return $components;
	}

	// --------------------------------------------------
	// Calculate parking duration
	// --------------------------------------------------

	$seconds = $pickup->getTimestamp() - $dropoff->getTimestamp();

	$days = ceil($seconds / DAY_IN_SECONDS);

	// Minimum 1 day
	$days = max(1, $days);


	// --------------------------------------------------
	// Pricing
	// --------------------------------------------------

	$car_model = isset($posted_data['car_model']) ? $posted_data['car_model'] : '';

	$daily_rate = jp_get_vehicle_daily_rate($car_model, 17);

	$price = $days * $daily_rate;


	// Tax percentage
	$tax_rate = 10.36;

	$tax = round(
		$price * ($tax_rate / 100),
		2
	);

	$total = round(
		$price + $tax,
		2
	);


	// --------------------------------------------------
	// Replace calculation tags in email
	// --------------------------------------------------

	$replacements = array(

		'[parking-days]' => $days,

		'[daily-rate]' => '$' . number_format($daily_rate, 2),

		'[parking-price]' => '$' . number_format($price, 2),

		'[tax]' => '$' . number_format($tax, 2),

		'[total]' => '$' . number_format($total, 2),

	);


	foreach ($replacements as $tag => $value) {

		$components['body'] = str_replace(
			$tag,
			$value,
			$components['body']
		);
	}


	return $components;
}