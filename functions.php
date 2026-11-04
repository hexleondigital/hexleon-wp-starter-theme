<?php
/**
 * HexleonWP functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Theme Constants
define( 'HEXLEONWP_VERSION', '1.0.0' );
define( 'HEXLEONWP_DIR', get_template_directory() );
define( 'HEXLEONWP_URI', get_template_directory_uri() );

/**
 * Load Core Modules
 */
require_once HEXLEONWP_DIR . '/inc/setup.php';
require_once HEXLEONWP_DIR . '/inc/enqueue-scripts.php';
require_once HEXLEONWP_DIR . '/inc/template-tags.php';
require_once HEXLEONWP_DIR . '/inc/nav-walker.php';

/**
 * Optional WooCommerce Support (Loads only if WooCommerce is installed & active)
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once HEXLEONWP_DIR . '/inc/woocommerce.php';
}
