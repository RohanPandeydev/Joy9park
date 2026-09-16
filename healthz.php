<?php
/**
 * Lightweight health endpoint for uptime pings (cron-job.org, Render health check).
 * Does NOT load WordPress, so it is cheap to hit every few minutes.
 *   GET /healthz.php        -> 200 {"status":"ok"}
 *   GET /healthz.php?db=1   -> also pings the database (200 ok / 503 on failure)
 */
header( 'Content-Type: application/json' );
header( 'Cache-Control: no-store' );

$out = [ 'status' => 'ok', 'time' => gmdate( 'c' ) ];

if ( isset( $_GET['db'] ) ) {
	$env  = static fn( $k, $d = '' ) => ( ( $v = getenv( $k ) ) === false || $v === '' ) ? $d : $v;
	$m    = mysqli_init();
	$flag = filter_var( $env( 'DB_SSL', 'false' ), FILTER_VALIDATE_BOOLEAN ) ? MYSQLI_CLIENT_SSL : 0;
	$ok   = @mysqli_real_connect( $m, $env( 'DB_HOST' ), $env( 'DB_USER' ), $env( 'DB_PASSWORD' ),
	                              $env( 'DB_NAME' ), (int) $env( 'DB_PORT', 3306 ), null, $flag )
	        && @mysqli_query( $m, 'SELECT 1' );
	$out['db'] = $ok ? 'ok' : 'error';
	if ( ! $ok ) {
		http_response_code( 503 );
		$out['status'] = 'degraded';
	}
	@mysqli_close( $m );
}

// Outbound-connectivity probe (admin-only diagnostics for SMTP setup): /healthz.php?net=host:port,host:port
if ( isset( $_GET['net'] ) && getenv( 'HEALTHZ_NET_PROBE' ) ) {
	foreach ( explode( ',', $_GET['net'] ) as $hp ) {
		[ $h, $p ] = array_pad( explode( ':', $hp ), 2, 25 );
		$t = microtime( true );
		$fp = @fsockopen( $h, (int) $p, $errno, $errstr, 8 );
		$out['net'][ $hp ] = $fp ? 'open (' . round( ( microtime( true ) - $t ) * 1000 ) . 'ms)' : "closed: $errno $errstr";
		if ( $fp ) { fclose( $fp ); }
	}
	$out['dns'] = gethostbynamel( 'smtp.gmail.com' );
}

echo json_encode( $out ), "\n";
