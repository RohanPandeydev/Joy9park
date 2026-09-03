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

	$daily_rate = 17;

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