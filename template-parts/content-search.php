<?php
/**
 * Template part for displaying results in search pages
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'card p-6 flex flex-col justify-between group' ); ?>>
	<div>
		<div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
			<?php echo esc_html( get_post_type() ); ?>
		</div>

		<header class="entry-header mb-3">
			<?php the_title( sprintf( '<h2 class="entry-title text-lg font-bold text-slate-900 group-hover:text-brand-accent transition-colors line-clamp-2"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header>

		<div class="entry-summary text-sm text-slate-600 line-clamp-3 leading-relaxed mb-4">
			<?php the_excerpt(); ?>
		</div>
	</div>

	<div class="pt-4 border-t border-slate-100 flex items-center justify-between">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="text-sm font-semibold text-brand-accent hover:text-brand-accent-hover inline-flex items-center gap-1 transition-colors">
			<?php esc_html_e( 'View', 'hexleonwp' ); ?> &rarr;
		</a>
		<span class="text-xs text-slate-400"><?php echo esc_html( get_the_date() ); ?></span>
	</div>
</article>
