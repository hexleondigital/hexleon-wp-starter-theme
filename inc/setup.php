<?php
/**
 * Theme Setup
 *
 * @package hexleontech
 */

if (!function_exists('hexleon_theme_setup')) {
    function hexleon_theme_setup() {
        // Load theme text domain for translation
        load_theme_textdomain('hexleontech', get_template_directory() . '/languages');

        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages
        add_theme_support('post-thumbnails');

        // Custom image sizes for tech products and banners
        add_image_size('hx-product-card', 600, 600, true);
        add_image_size('hx-product-thumb', 160, 160, true);
        add_image_size('hx-hero-banner', 1920, 800, true);
        add_image_size('hx-category-card', 400, 400, true);

        // Enable Custom Logo support
        add_theme_support('custom-logo', array(
            'height' => 80,
            'width' => 280,
            'flex-width' => true,
            'flex-height' => true,
        ));

        // Switch default core markup for search form, comment form, and comments to output valid HTML5
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        // Add theme support for selective refresh for widgets
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for core custom logo
        add_theme_support('align-wide');

        // Enable responsive embeds
        add_theme_support('responsive-embeds');

        // Enable WooCommerce Theme Support
        add_theme_support('woocommerce', array(
            'thumbnail_image_width' => 600,
            'single_image_width' => 1000,
            'product_grid' => array(
                'default_rows' => 4,
                'min_rows' => 2,
                'max_rows' => 8,
                'default_columns' => 4,
                'min_columns' => 2,
                'max_columns' => 5,
            ),
        ));
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        // Register Navigation Menus
        register_nav_menus(array(
            'primary-menu' => esc_html__('Primary Menu', 'hexleontech'),
            'category-mega-menu' => esc_html__('Hardware Mega Menu', 'hexleontech'),
            'top-bar-menu' => esc_html__('Top Bar Menu', 'hexleontech'),
            'footer-company' => esc_html__('Footer Company Links', 'hexleontech'),
            'footer-shop' => esc_html__('Footer Shop Links', 'hexleontech'),
            'footer-support' => esc_html__('Footer Support Links', 'hexleontech'),
        ));
    }
}
add_action('after_setup_theme', 'hexleon_theme_setup');
