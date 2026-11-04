<?php
/**
 * WooCommerce Compatibility File
 *
 * This file is only loaded when the WooCommerce plugin is installed and active.
 * Provides basic integration, gallery support, and clean container wrappers.
 *
 * @link https://woocommerce.com/
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce theme setup.
 */
function hexleonwp_woocommerce_setup() {
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 450,
		'single_image_width'    => 800,
		'product_grid'          => array(
			'default_rows'    => 3,
			'min_rows'        => 1,
			'max_rows'        => 6,
			'default_columns' => 3,
			'min_columns'     => 1,
			'max_columns'     => 4,
		),
	) );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'hexleonwp_woocommerce_setup' );

/**
 * Remove default WooCommerce page wrappers.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Add custom Tailwind-styled WooCommerce content wrappers.
 */
function hexleonwp_woocommerce_wrapper_before() {
	?>
	<main id="primary" class="site-main py-10 md:py-16">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
	<?php
}
add_action( 'woocommerce_before_main_content', 'hexleonwp_woocommerce_wrapper_before' );

function hexleonwp_woocommerce_wrapper_after() {
	?>
		</div>
	</main>
	<?php
}
add_action( 'woocommerce_after_main_content', 'hexleonwp_woocommerce_wrapper_after' );

