<?php
/**
 * Plugin Name: SMTP Mail (env-configured)
 * Description: Routes wp_mail() through SMTP using environment variables, because the Render container has
 *              no local mailer. Set SMTP_HOST, SMTP_PORT, SMTP_USER, SMTP_PASS (and optionally SMTP_FROM,
 *              SMTP_FROM_NAME, SMTP_SECURE=tls|ssl) on the service. Does nothing if SMTP_HOST is unset.
 * Author:      Joy9 Park
 */

defined( 'ABSPATH' ) || exit;

$jp_smtp_env = static function ( string $key, $default = '' ) {
	$v = getenv( $key );
	return ( $v === false || $v === '' ) ? $default : $v;
};

if ( ! $jp_smtp_env( 'SMTP_HOST' ) ) {
	return;
}

add_action( 'phpmailer_init', static function ( $phpmailer ) use ( $jp_smtp_env ) {
	$phpmailer->isSMTP();
	$phpmailer->Host       = $jp_smtp_env( 'SMTP_HOST' );
	$phpmailer->Port       = (int) $jp_smtp_env( 'SMTP_PORT', 587 );
	$phpmailer->SMTPSecure = $jp_smtp_env( 'SMTP_SECURE', 'tls' );
	$phpmailer->SMTPAuth   = (bool) $jp_smtp_env( 'SMTP_USER' );
	$phpmailer->Username   = $jp_smtp_env( 'SMTP_USER' );
	$phpmailer->Password   = $jp_smtp_env( 'SMTP_PASS' );
	$phpmailer->Timeout    = 15;

	// Gmail and most providers reject a From that isn't the authenticated account.
	$from = $jp_smtp_env( 'SMTP_FROM', $jp_smtp_env( 'SMTP_USER' ) );
	if ( $from ) {
		$phpmailer->setFrom( $from, $jp_smtp_env( 'SMTP_FROM_NAME', get_bloginfo( 'name' ) ), false );
	}
} );

add_filter( 'wp_mail_from', static fn( $email ) => $jp_smtp_env( 'SMTP_FROM', $jp_smtp_env( 'SMTP_USER', $email ) ) );
add_filter( 'wp_mail_from_name', static fn( $name ) => $jp_smtp_env( 'SMTP_FROM_NAME', get_bloginfo( 'name' ) ?: $name ) );

// Surface SMTP failures in the Render logs instead of failing silently.
add_action( 'wp_mail_failed', static function ( $error ) {
	error_log( '[smtp-mail] wp_mail failed: ' . $error->get_error_message() );
} );
