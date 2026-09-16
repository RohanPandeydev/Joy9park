<?php
/**
 * Plugin Name: TiDB Compatibility
 * Description: Makes WordPress run on TiDB (Serverless). TiDB implements SQL_CALC_FOUND_ROWS / FOUND_ROWS()
 *              only as no-ops, so every paginated WP_Query would error (or return wrong totals). This strips
 *              SQL_CALC_FOUND_ROWS from the main query and computes found_posts with a real COUNT(*) instead.
 * Author:      Joy9 Park
 */

defined( 'ABSPATH' ) || exit;

// Belt and braces: ask TiDB to tolerate the no-op functions for anything that bypasses WP_Query.
add_action( 'plugins_loaded', static function () {
	global $wpdb;
	$wpdb->suppress_errors( true );
	$wpdb->query( 'SET SESSION tidb_enable_noop_functions = ON' );
	$wpdb->suppress_errors( false );
}, 0 );

// 1. Remove SQL_CALC_FOUND_ROWS from the posts request and remember the equivalent COUNT query.
add_filter( 'posts_request', static function ( $request, $query ) {
	if ( stripos( $request, 'SQL_CALC_FOUND_ROWS' ) === false ) {
		unset( $query->tidb_count_request );
		return $request;
	}

	$request = preg_replace( '/SQL_CALC_FOUND_ROWS\s+/i', '', $request, 1 );

	// COUNT(*) over the same query minus its LIMIT (ORDER BY is harmless inside the subquery).
	$count = preg_replace( '/\s+LIMIT\s+\d+(?:\s*,\s*\d+)?\s*$/i', '', $request );
	$query->tidb_count_request = "SELECT COUNT(*) FROM ( {$count} ) AS tidb_found_rows";

	return $request;
}, 1, 2 );

// 2. Replace "SELECT FOUND_ROWS()" with that COUNT query.
add_filter( 'found_posts_query', static function ( $found_query, $query ) {
	return ! empty( $query->tidb_count_request ) ? $query->tidb_count_request : $found_query;
}, 1, 2 );
