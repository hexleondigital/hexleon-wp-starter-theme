<?php
/**
 * The template for displaying all single posts
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main py-12 md:py-16 flex-1">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header mb-8 text-center">
					<div class="flex items-center justify-center gap-2 mb-3">
						<?php hexleonwp_posted_on(); ?>
						<span class="text-slate-300">•</span>
						<?php hexleonwp_posted_by(); ?>
					</div>
					<?php the_title( '<h1 class="entry-title text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">', '</h1>' ); ?>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-thumbnail mb-10 overflow-hidden rounded-2xl shadow-sm">
						<?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
					</div>
				<?php endif; ?>

				<div class="entry-content bg-white p-6 sm:p-10 rounded-2xl border border-slate-200 shadow-sm prose prose-slate prose-lg max-w-none prose-headings:font-bold prose-a:text-brand-accent hover:prose-a:underline">
					<?php
					the_content();

					wp_link_pages( array(
						'before' => '<div class="page-links mt-8 flex gap-2 font-medium text-sm">' . esc_html__( 'Pages:', 'hexleonwp' ),
						'after'  => '</div>',
					) );
					?>
				</div>

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			</article>
			<?php
		endwhile;
		?>

	</div>
</main>

<?php
get_footer();
