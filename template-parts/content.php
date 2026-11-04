<?php
/**
 * Template part for displaying posts in archives/index
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'card overflow-hidden flex flex-col justify-between group' ); ?>>
	<div>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="aspect-video overflow-hidden bg-slate-100">
				<a href="<?php echo esc_url( get_permalink() ); ?>" tabindex="-1" aria-hidden="true">
					<?php the_post_thumbnail( 'hexleonwp-card', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300' ) ); ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="p-6">
			<div class="mb-2">
				<?php hexleonwp_posted_on(); ?>
			</div>

			<header class="entry-header mb-3">
				<?php the_title( '<h2 class="entry-title text-xl font-bold text-slate-900 group-hover:text-brand-accent transition-colors line-clamp-2"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</header>

			<div class="entry-summary text-sm text-slate-600 line-clamp-3 leading-relaxed">
				<?php the_excerpt(); ?>
			</div>
		</div>
	</div>

	<div class="px-6 pb-6 pt-0 flex items-center justify-between border-t border-slate-100 mt-4 pt-4">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="text-sm font-semibold text-brand-accent hover:text-brand-accent-hover inline-flex items-center gap-1 transition-colors">
			<?php esc_html_e( 'Read Article', 'hexleonwp' ); ?>
			<svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
		</a>
		<span class="text-xs text-slate-400"><?php echo esc_html( get_the_author() ); ?></span>
	</div>
</article>
