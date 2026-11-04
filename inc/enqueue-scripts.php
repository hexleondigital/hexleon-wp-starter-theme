<?php
/**
 * Hexleon Tech Enqueue Scripts & Styles
 *
 * @package hexleontech
 */

function hexleon_theme_assets() {
 // Fonts and icons are now bundled locally via Vite (see main.js)

 $theme_path = get_template_directory();
 $theme_uri = get_template_directory_uri();
 $is_dev = file_exists($theme_path . '/.vite-dev'); // toggle file

 if ($is_dev) {
 // Vite Dev Server
 wp_enqueue_script(
 'vite-client',
 'http://localhost:5173/@vite/client',
 [],
 null,
 true
 );

 wp_enqueue_script(
 'theme-main',
 'http://localhost:5173/src/main.js',
 ['jquery'],
 null,
 true
 );
 } else {
 // Production build
 $manifest_path = $theme_path . '/dist/.vite/manifest.json';

 if (file_exists($manifest_path)) {
 $manifest = json_decode(file_get_contents($manifest_path), true);
 $main = isset($manifest['src/main.js']) ? $manifest['src/main.js'] : null;

 if ($main) {
 // JS
 wp_enqueue_script(
 'theme-main',
 $theme_uri . '/dist/' . $main['file'],
 ['jquery'],
 null,
 true
 );

 // CSS
 if (isset($main['css'][0])) {
 wp_enqueue_style(
 'theme-style',
 $theme_uri . '/dist/' . $main['css'][0],
 [],
 null
 );
 }
 }
 }
 }

 // Localize Script for AJAX actions (Search, Cart drawer, Nonces)
 wp_localize_script('theme-main', 'hexleonData', array(
 'ajaxUrl' => admin_url('admin-ajax.php'),
 'nonce' => wp_create_nonce('hexleon_tech_nonce'),
 'cartUrl' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'),
 'checkoutUrl' => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/'),
 'currencySymbol' => function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '$',
 ));
}
add_action('wp_enqueue_scripts', 'hexleon_theme_assets');

// Preload production assets and add x-cloak to prevent FOUC
function hexleon_preload_and_cloak() {
 // Fonts are now bundled locally, so we don't need Google Fonts preconnect.

 $theme_path = get_template_directory();
 $theme_uri = get_template_directory_uri();
 $is_dev = file_exists($theme_path . '/.vite-dev');
 
 // Add Alpine x-cloak style to prevent HTML cluttering (FOUC)
 echo '<style>[x-cloak] { display: none !important; }</style>' . "\n";

 if (!$is_dev) {
 $manifest_path = $theme_path . '/dist/.vite/manifest.json';
 if (file_exists($manifest_path)) {
 $manifest = json_decode(file_get_contents($manifest_path), true);
 $main = isset($manifest['src/main.js']) ? $manifest['src/main.js'] : null;
 if ($main) {
 // Preload CSS
 if (isset($main['css'][0])) {
 echo '<link rel="preload" href="' . esc_url($theme_uri . '/dist/' . $main['css'][0]) . '" as="style">' . "\n";
 }
 // Preload JS
 echo '<link rel="preload" href="' . esc_url($theme_uri . '/dist/' . $main['file']) . '" as="script" crossorigin="anonymous">' . "\n";
 }
 }
 }
}
add_action('wp_head', 'hexleon_preload_and_cloak', 1);

// Enqueue Cloudflare Turnstile API Script
function hexleon_enqueue_turnstile() {
    if ( defined('CF_TURNSTILE_SITE_KEY') ) {
        echo '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>' . "\n";
    }
}
add_action('wp_head', 'hexleon_enqueue_turnstile');

// Add type="module" to Vite dev scripts
add_filter('script_loader_tag', function($tag, $handle, $src) {
 if (in_array($handle, ['vite-client', 'theme-main', 'vite-client-editor', 'theme-main-editor'])) {
 return '<script type="module" src="' . esc_url($src) . '"></script>';
 }
 return $tag;
}, 10, 3);
