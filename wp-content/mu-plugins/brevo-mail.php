<?php
/**
 * Plugin Name: Brevo Mail (HTTPS transport)
 * Description: Sends wp_mail() through Brevo's HTTPS API. Render blocks outbound SMTP ports (25/465/587),
 *              so SMTP transports cannot work there; HTTPS can. Set BREVO_API_KEY (and optionally
 *              BREVO_FROM / BREVO_FROM_NAME — the sender must be verified in Brevo). Does nothing if unset.
 * Author:      Joy9 Park
 */

defined( 'ABSPATH' ) || exit;

$jp_brevo_env = static function ( string $key, $default = '' ) {
	$v = getenv( $key );
	return ( $v === false || $v === '' ) ? $default : $v;
};

if ( ! $jp_brevo_env( 'BREVO_API_KEY' ) ) {
	return;
}

/**
 * Short-circuit wp_mail(): returning a bool from `pre_wp_mail` skips PHPMailer entirely.
 */
add_filter( 'pre_wp_mail', static function ( $null, array $atts ) use ( $jp_brevo_env ) {
	$to      = $atts['to'] ?? array();
	$subject = (string) ( $atts['subject'] ?? '' );
	$message = (string) ( $atts['message'] ?? '' );
	$headers = $atts['headers'] ?? array();

	$to = is_array( $to ) ? $to : preg_split( '/[,;]\s*/', $to );
	if ( is_string( $headers ) ) {
		$headers = preg_split( '/\r\n|\r|\n/', $headers );
	}

	$parse_addr = static function ( string $raw ): array {
		if ( preg_match( '/^\s*(.*?)\s*<([^>]+)>\s*$/', $raw, $m ) ) {
			return array( 'email' => trim( $m[2] ), 'name' => trim( $m[1], " \"'" ) );
		}
		return array( 'email' => trim( $raw ) );
	};
	$addr_list = static fn( array $list ) => array_values( array_filter(
		array_map( $parse_addr, $list ),
		static fn( $a ) => is_email( $a['email'] )
	) );

	$cc = $bcc = array();
	$reply_to     = null;
	$content_type = 'text/plain';

	foreach ( (array) $headers as $h ) {
		if ( strpos( $h, ':' ) === false ) {
			continue;
		}
		[ $name, $value ] = array_map( 'trim', explode( ':', $h, 2 ) );
		switch ( strtolower( $name ) ) {
			case 'cc':       $cc  = array_merge( $cc,  preg_split( '/,\s*/', $value ) ); break;
			case 'bcc':      $bcc = array_merge( $bcc, preg_split( '/,\s*/', $value ) ); break;
			case 'reply-to': $reply_to = $parse_addr( $value ); break;
			case 'content-type':
				if ( stripos( $value, 'text/html' ) !== false ) {
					$content_type = 'text/html';
				}
				break;
		}
	}
	if ( apply_filters( 'wp_mail_content_type', $content_type ) === 'text/html' ) {
		$content_type = 'text/html';
	}

	// Sender must be a verified Brevo sender; ignore whatever From the caller asked for.
	$from_email = $jp_brevo_env( 'BREVO_FROM', $jp_brevo_env( 'SMTP_USER' ) );
	$from_name  = $jp_brevo_env( 'BREVO_FROM_NAME', $jp_brevo_env( 'SMTP_FROM_NAME', get_bloginfo( 'name' ) ) );

	$payload = array(
		'sender'  => array( 'email' => $from_email, 'name' => $from_name ),
		'to'      => $addr_list( $to ),
		'subject' => $subject,
	);
	if ( $cc )  { $payload['cc']  = $addr_list( $cc ); }
	if ( $bcc ) { $payload['bcc'] = $addr_list( $bcc ); }
	if ( $reply_to && is_email( $reply_to['email'] ) ) {
		$payload['replyTo'] = $reply_to;
	}
	if ( 'text/html' === $content_type ) {
		$payload['htmlContent'] = $message;
	} else {
		$payload['textContent'] = $message;
	}

	if ( empty( $payload['to'] ) ) {
		error_log( '[brevo-mail] no valid recipient for "' . $subject . '"' );
		return false;
	}

	$response = wp_remote_post( 'https://api.brevo.com/v3/smtp/email', array(
		'timeout' => 15,
		'headers' => array(
			'api-key'      => $jp_brevo_env( 'BREVO_API_KEY' ),
			'Content-Type' => 'application/json',
			'Accept'       => 'application/json',
		),
		'body'    => wp_json_encode( $payload ),
	) );

	if ( is_wp_error( $response ) ) {
		error_log( '[brevo-mail] request failed: ' . $response->get_error_message() );
		do_action( 'wp_mail_failed', new WP_Error( 'brevo_error', $response->get_error_message(), $atts ) );
		return false;
	}

	$code = (int) wp_remote_retrieve_response_code( $response );
	if ( $code < 200 || $code >= 300 ) {
		$body = wp_remote_retrieve_body( $response );
		error_log( "[brevo-mail] HTTP {$code}: {$body}" );
		do_action( 'wp_mail_failed', new WP_Error( 'brevo_error', "Brevo HTTP {$code}: {$body}", $atts ) );
		return false;
	}

	do_action( 'wp_mail_succeeded', $atts );
	return true;
}, 10, 2 );
