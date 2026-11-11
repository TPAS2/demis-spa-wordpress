<?php
/**
 * Demi's Spa theme: loader.
 *
 * The real code lives in inc/main.php. It is loaded inside try/catch so that a
 * mistake there can never lock you out of the WordPress admin.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DEMIS_VERSION', '1.0.0' );

$demis_main = get_template_directory() . '/inc/main.php';
if ( file_exists( $demis_main ) ) {
	try {
		require $demis_main;
	} catch ( \Throwable $demis_error ) {
		error_log( "Demi's Spa theme: " . $demis_error->getMessage() );
	}
}
