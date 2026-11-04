<?php
/**
 * Custom template tags for HexleonWP
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'hexleonwp_pagination' ) ) {
	/**
	 * Render universal Tailwind-styled pagination.
	 *
	 * @param WP_Query|null $custom_query Optional custom query object. Defaults to global $wp_query.
	 */
	function hexleonwp_pagination( $custom_query = null ) {
		if ( ! $custom_query ) {
			global $wp_query;
			$custom_query = $wp_query;
		}

		if ( $custom_query->max_num_pages <= 1 ) {
			return;
		}

		$big   = 999999999;
		$paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );

		$paginate_args = array(
			'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'total'     => intval( $custom_query->max_num_pages ),
			'current'   => $paged,
			'prev_text' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg><span class="sr-only sm:not-sr-only sm:text-xs sm:font-bold">' . esc_html__( 'Prev', 'hexleonwp' ) . '</span>',
			'next_text' => '<span class="sr-only sm:not-sr-only sm:text-xs sm:font-bold">' . esc_html__( 'Next', 'hexleonwp' ) . '</span><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
			'type'      => 'array',
		);

		$pages = paginate_links( $paginate_args );

		if ( is_array( $pages ) ) {
			echo '<nav class="mt-12 text-center" aria-label="' . esc_attr__( 'Pagination Navigation', 'hexleonwp' ) . '">';
			echo '<ul class="inline-flex flex-wrap items-center justify-center gap-1.5">';

			foreach ( $pages as $page ) {
				$is_current = strpos( $page, 'current' ) !== false;
				$is_dots    = strpos( $page, 'dots' ) !== false;

				$base_classes = 'inline-flex items-center justify-center min-w-[2.5rem] h-10 px-3 text-sm font-medium rounded-lg transition-colors duration-150';

				if ( $is_current ) {
					$color_classes = 'bg-brand-accent text-white font-semibold shadow-sm';
				} elseif ( $is_dots ) {
					$color_classes = 'text-slate-400 cursor-default';
				} else {
					$color_classes = 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100 hover:text-slate-900';
				}

				$page = str_replace( "class='page-numbers", "class='page-numbers $base_classes $color_classes", $page );
				$page = str_replace( 'class="page-numbers', 'class="page-numbers ' . $base_classes . ' ' . $color_classes, $page );

				echo '<li>' . $page . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			echo '</ul>';
			echo '</nav>';
		}
	}
}

if ( ! function_exists( 'hexleonwp_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function hexleonwp_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		echo '<span class="posted-on text-xs text-slate-500 inline-flex items-center gap-1">' . $time_string . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'hexleonwp_posted_by' ) ) {
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function hexleonwp_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'hexleonwp' ),
			'<span class="author vcard"><a class="url fn n hover:text-brand-accent transition-colors font-medium text-slate-700" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline text-xs text-slate-500"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

