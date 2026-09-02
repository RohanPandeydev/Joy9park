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
