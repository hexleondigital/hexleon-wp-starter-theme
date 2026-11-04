<?php
/**
 * Hexleon Tech functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hexleontech
 */

/**
 * Load Theme Setup & Helpers
 */
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/enqueue-scripts.php';
require get_template_directory() . '/inc/post-types.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/mega-menu-walker.php';
require get_template_directory() . '/inc/ajax-form.php';
require get_template_directory() . '/inc/admin-columns.php';
require get_template_directory() . '/inc/pc-budget-calculator.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Render universal Tailwind-styled pagination.
 *
 * @param WP_Query|null $custom_query Optional custom query object. Defaults to global $wp_query.
 */
function hx_styled_pagination( $custom_query = null ) {
 if ( ! $custom_query ) {
 global $wp_query;
 $custom_query = $wp_query;
 }

 if ( $custom_query->max_num_pages <= 1 ) {
 return;
 }

 $big = 999999999;
 $paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
 
 $paginate_args = array(
 'base' => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
 'format' => '?paged=%#%',
 'total' => intval( $custom_query->max_num_pages ),
 'current' => $paged,
 'prev_text' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg><span class="hidden sm:inline text-sm uppercase font-bold tracking-wider">Prev</span>',
 'next_text' => '<span class="hidden sm:inline text-sm uppercase font-bold tracking-wider">Next</span><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
 'type' => 'array',
 );

 $pages = paginate_links( $paginate_args );

 if ( is_array( $pages ) ) {
 echo '<div class="mt-12 text-center">';
 echo '<ul class="flex flex-wrap justify-center items-center gap-2">';
 foreach ( $pages as $page ) {
 $is_current = strpos( $page, 'current' ) !== false;
 $is_text = strpos( $page, 'Prev' ) !== false || strpos( $page, 'Next' ) !== false;
 
 $base_classes = $is_text 
 ? "px-4 py-2 text-sm font-bold transition-all duration-200 border inline-flex items-center gap-1.5"
 : "w-10 h-10 text-sm font-bold font-mono transition-all duration-200 border inline-flex items-center justify-center";
 
 $color_classes = $is_current 
 ? "bg-brand-accent text-white border-brand-accent font-bold" 
 : "bg-white text-slate-700 border-slate-300 hover:border-brand-accent hover:text-brand-primary hover:bg-slate-50";
 
 $page = str_replace("class='page-numbers", "class='page-numbers $base_classes $color_classes", $page);
 $page = str_replace('class="page-numbers', 'class="page-numbers ' . $base_classes . ' ' . $color_classes, $page);
 
 if ( strpos( $page, 'dots' ) !== false ) {
 $page = str_replace('border-slate-800', 'border-transparent bg-transparent text-slate-600', $page);
 $page = str_replace('hover:border-cyan-500', '', $page);
 $page = str_replace('hover:text-cyan-400', '', $page);
 $page = str_replace('bg-brand-primary', '', $page);
 }
 
 echo '<li>' . $page . '</li>';
 }
 echo '</ul>';
 echo '</div>';
 }
}

/**
 * Load Custom Cart Hooks
 */
require get_template_directory() . '/inc/cart-hooks.php';
