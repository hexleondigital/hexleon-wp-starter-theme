<?php
/**
 * Template part for displaying page content in page.php (Using brand variables)
 *
 * @package hexleontech
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="text-center max-w-2xl mx-auto mb-10">
		<?php the_title( '<h1 class="text-3xl sm:text-4xl font-bold font-sans text-brand-primary">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="bg-white border border-gray-200 p-6 sm:p-8">
		<div class="entry-content prose prose-gray prose-sm sm:prose-base max-w-none prose-headings:font-sans prose-headings:text-brand-primary prose-a:text-brand-accent hover:prose-a:underline">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links mt-6 flex gap-2 font-mono text-sm">' . esc_html__( 'Pages:', 'hexleontech' ),
					'after' => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
