<?php
/**
 * The template for displaying archive pages (Clean Light Mode)
 *
 * @package hexleontech
 */

get_header();
?>

<main id="primary" class="site-main py-12 bg-slate-50 text-slate-800 min-h-screen">
	<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">

		<?php if ( have_posts() ) : ?>

			<header class="page-header mb-8 pb-4 border-b border-slate-200 text-center max-w-xl mx-auto">
				<?php
				the_archive_title( '<h1 class="page-title text-2xl sm:text-3xl font-black font-sans text-brand-primary mb-1">', '</h1>' );
				the_archive_description( '<div class="archive-description text-sm text-slate-500">', '</div>' );
				?>
			</header>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;
				?>
			</div>

			<?php hx_styled_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
