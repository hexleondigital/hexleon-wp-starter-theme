<?php
/**
 * Theme Setup and Configuration
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'hexleonwp_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function hexleonwp_setup() {
		// Make theme available for translation
		load_theme_textdomain( 'hexleonwp', get_template_directory() . '/languages' );

		// Let WordPress manage the document title
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 630, true );

		// Add custom image size for blog archive cards
		add_image_size( 'hexleonwp-card', 800, 450, true );

		// Enable Custom Logo support
		add_theme_support( 'custom-logo', array(
			'height'      => 80,
			'width'       => 280,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Switch default core markup to output valid HTML5
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		) );

		// Add support for full and wide align images
		add_theme_support( 'align-wide' );

		// Enable responsive embeds
		add_theme_support( 'responsive-embeds' );

		// Add theme support for selective refresh for widgets in customizer
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Register Navigation Menus
		register_nav_menus( array(
			'primary-menu' => esc_html__( 'Primary Navigation', 'hexleonwp' ),
			'footer-menu'  => esc_html__( 'Footer Navigation', 'hexleonwp' ),
		) );
	}
}
add_action( 'after_setup_theme', 'hexleonwp_setup' );

/**
 * Register Widget Areas.
 */
function hexleonwp_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'hexleonwp' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'hexleonwp' ),
		'before_widget' => '<section id="%1$s" class="widget card p-6 mb-6 %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'hexleonwp_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function hexleonwp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hexleonwp_content_width', 1200 );
}
add_action( 'after_setup_theme', 'hexleonwp_content_width', 0 );
