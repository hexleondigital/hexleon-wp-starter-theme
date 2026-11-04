<?php
/**
 * HexleonWP Enqueue Scripts & Styles (Vite + Tailwind v4 + Alpine.js)
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue theme assets using Vite dev server or production manifest.
 */
function hexleonwp_scripts() {
	$theme_path = HEXLEONWP_DIR;
	$theme_uri  = HEXLEONWP_URI;
	$is_dev     = file_exists( $theme_path . '/.vite-dev' );

	if ( $is_dev ) {
		// Vite Dev Server (HMR)
		wp_enqueue_script(
			'hexleonwp-vite-client',
			'http://localhost:5173/@vite/client',
			array(),
			null,
			true
		);

		wp_enqueue_script(
			'hexleonwp-main',
			'http://localhost:5173/src/main.js',
			array(),
			null,
			true
		);
	} else {
		// Production Build: Read Manifest
		$manifest_path = $theme_path . '/dist/.vite/manifest.json';

		// Fallback for older Vite manifest location
		if ( ! file_exists( $manifest_path ) ) {
			$manifest_path = $theme_path . '/dist/manifest.json';
		}

		if ( file_exists( $manifest_path ) ) {
			$manifest = json_decode( file_get_contents( $manifest_path ), true );
			$entry    = isset( $manifest['src/main.js'] ) ? $manifest['src/main.js'] : null;

			if ( $entry ) {
				// Enqueue compiled CSS
				if ( ! empty( $entry['css'][0] ) ) {
					wp_enqueue_style(
						'hexleonwp-style',
						$theme_uri . '/dist/' . $entry['css'][0],
						array(),
						HEXLEONWP_VERSION
					);
				}

				// Enqueue compiled JS
				if ( ! empty( $entry['file'] ) ) {
					wp_enqueue_script(
						'hexleonwp-main',
						$theme_uri . '/dist/' . $entry['file'],
						array(),
						HEXLEONWP_VERSION,
						true
					);
				}
			}
		}
	}

	// Localize script for theme data and AJAX endpoints
	wp_localize_script( 'hexleonwp-main', 'hexleonwpData', array(
		'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'hexleonwp_nonce' ),
		'homeUrl'  => home_url( '/' ),
		'themeUri' => $theme_uri,
	) );

	// Threaded comments script for single posts
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hexleonwp_scripts' );

/**
 * Add type="module" to Vite scripts.
 */
function hexleonwp_script_loader_tag( $tag, $handle, $src ) {
	if ( in_array( $handle, array( 'hexleonwp-vite-client', 'hexleonwp-main' ), true ) ) {
		return '<script type="module" src="' . esc_url( $src ) . '"></script>' . "\n";
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'hexleonwp_script_loader_tag', 10, 3 );

/**
 * Preload production assets and add early x-cloak rule to eliminate FOUC.
 */
function hexleonwp_preload_and_cloak() {
	echo '<style>[x-cloak] { display: none !important; }</style>' . "\n";

	$is_dev = file_exists( HEXLEONWP_DIR . '/.vite-dev' );

	if ( ! $is_dev ) {
		$manifest_path = HEXLEONWP_DIR . '/dist/.vite/manifest.json';
		if ( ! file_exists( $manifest_path ) ) {
			$manifest_path = HEXLEONWP_DIR . '/dist/manifest.json';
		}

		if ( file_exists( $manifest_path ) ) {
			$manifest = json_decode( file_get_contents( $manifest_path ), true );
			$entry    = isset( $manifest['src/main.js'] ) ? $manifest['src/main.js'] : null;

			if ( $entry ) {
				if ( ! empty( $entry['css'][0] ) ) {
					echo '<link rel="preload" href="' . esc_url( HEXLEONWP_URI . '/dist/' . $entry['css'][0] ) . '" as="style">' . "\n";
				}
				if ( ! empty( $entry['file'] ) ) {
					echo '<link rel="preload" href="' . esc_url( HEXLEONWP_URI . '/dist/' . $entry['file'] ) . '" as="script" crossorigin="anonymous">' . "\n";
				}
			}
		}
	}
}
add_action( 'wp_head', 'hexleonwp_preload_and_cloak', 1 );
