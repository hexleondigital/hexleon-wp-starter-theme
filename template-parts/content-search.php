<?php
/**
 * Template part for displaying results in search pages (Using brand variables)
 *
 * @package hexleontech
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white border border-gray-200 p-4 flex flex-col justify-between '); ?>>
	<div>
		<div class="text-[10px] font-mono text-gray-400 uppercase tracking-wider mb-1.5">
			<?php echo esc_html( get_post_type() ); ?>
		</div>

		<header class="entry-header mb-2">
			<?php the_title( sprintf( '<h2 class="text-sm font-bold text-gray-800 hover:text-brand-primary transition-colors line-clamp-2"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header>

		<div class="entry-summary text-sm text-gray-500 line-clamp-3 mb-3">
			<?php the_excerpt(); ?>
		</div>
	</div>

	<div class="pt-3 border-t border-gray-100">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="text-sm font-bold uppercase tracking-wider text-brand-accent hover:underline">
			<?php esc_html_e('View', 'hexleontech'); ?> &rarr;
		</a>
	</div>
</article>
