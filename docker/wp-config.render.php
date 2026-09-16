<?php
/**
 * Joy9 Park — wp-config.php for Render.
 *
 * Everything environment-specific comes from env vars set on the Render service.
 * This file is copied to the project root at image build time (see Dockerfile).
 */

$env = static function ( string $key, $default = null ) {
	$v = getenv( $key );
	return ( $v === false || $v === '' ) ? $default : $v;
};

// ** Database ** //
define( 'DB_NAME',     $env( 'DB_NAME', 'wordpress' ) );
define( 'DB_USER',     $env( 'DB_USER', 'wordpress' ) );
define( 'DB_PASSWORD', $env( 'DB_PASSWORD', '' ) );
define( 'DB_HOST',     $env( 'DB_HOST', 'localhost' ) . ( $env( 'DB_PORT' ) ? ':' . $env( 'DB_PORT' ) : '' ) );
define( 'DB_CHARSET',  'utf8mb4' );
// TiDB lacks utf8mb4_unicode_520_ci, and wpdb silently upgrades utf8mb4_unicode_ci to it
// (class-wpdb.php determine_charset), so pin a collation wpdb leaves untouched.
define( 'DB_COLLATE',  $env( 'DB_COLLATE', 'utf8mb4_0900_ai_ci' ) );

// Managed MySQL providers (Aiven, TiDB, PlanetScale…) require TLS.
if ( filter_var( $env( 'DB_SSL', 'false' ), FILTER_VALIDATE_BOOLEAN ) ) {
	define( 'MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_SSL );
}

$table_prefix = $env( 'DB_TABLE_PREFIX', 'wp_' );

// ** Keys & salts — set via Render env vars (generateValue: true in render.yaml) ** //
foreach ( [ 'AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY',
            'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT' ] as $k ) {
	define( $k, $env( $k, 'change-me-' . $k ) );
}

// ** Site URL — Render gives us RENDER_EXTERNAL_URL automatically ** //
$site_url = rtrim( $env( 'WP_HOME', $env( 'RENDER_EXTERNAL_URL', '' ) ), '/' );
if ( $site_url ) {
	define( 'WP_HOME',    $site_url );
	define( 'WP_SITEURL', $site_url );
}

// ** Behind Render's TLS-terminating proxy ** //
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
	$_SERVER['HTTPS'] = 'on';
}
define( 'FORCE_SSL_ADMIN', true );

// ** Filesystem is ephemeral on Render: no core/plugin auto-updates from wp-admin ** //
define( 'DISALLOW_FILE_MODS', filter_var( $env( 'WP_DISALLOW_FILE_MODS', 'true' ), FILTER_VALIDATE_BOOLEAN ) );
define( 'AUTOMATIC_UPDATER_DISABLED', true );
define( 'FS_METHOD', 'direct' );

// ** Debug ** //
define( 'WP_DEBUG',         filter_var( $env( 'WP_DEBUG', 'false' ), FILTER_VALIDATE_BOOLEAN ) );
define( 'WP_DEBUG_LOG',     WP_DEBUG );
define( 'WP_DEBUG_DISPLAY', false );

define( 'WP_ENVIRONMENT_TYPE', $env( 'WP_ENVIRONMENT_TYPE', 'production' ) );
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'DISABLE_WP_CRON', false );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
