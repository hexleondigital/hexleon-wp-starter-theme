<?php
/**
 * Template part for displaying posts in loops (Using brand variables)
 *
 * @package hexleontech
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white border border-gray-200 p-5 flex flex-col justify-between '); ?>>
	<div>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class=" overflow-hidden mb-3 bg-gray-100 aspect-video">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-200' ) ); ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="text-[11px] font-mono text-gray-400 mb-1">
			<?php echo esc_html( get_the_date() ); ?>
		</div>

		<header class="entry-header mb-2">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="text-2xl sm:text-3xl font-black font-sans text-brand-primary mb-4">', '</h1>' );
			else :
				the_title( '<h2 class="text-base font-bold font-sans text-gray-800 hover:text-brand-primary transition-colors line-clamp-2"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			?>
		</header>

		<div class="entry-content text-sm text-gray-600 leading-relaxed mb-4 line-clamp-3">
			<?php
			if ( is_singular() ) {
				the_content();
			} else {
				the_excerpt();
			}
			?>
		</div>
	</div>

	<?php if ( ! is_singular() ) : ?>
		<div class="pt-3 border-t border-gray-100 flex items-center justify-between">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="text-sm font-bold uppercase tracking-wider text-brand-accent hover:underline inline-flex items-center gap-1">
				<?php esc_html_e('Read More', 'hexleontech'); ?> &rarr;
			</a>
			<span class="text-[11px] text-gray-400"><?php echo esc_html( get_the_author() ); ?></span>
		</div>
	<?php endif; ?>
</article>
