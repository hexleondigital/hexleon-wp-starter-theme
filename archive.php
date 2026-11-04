<?php
/**
 * The template for displaying archive pages
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main py-12 md:py-16 flex-1">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

		<?php if ( have_posts() ) : ?>

			<header class="page-header mb-12 text-center max-w-2xl mx-auto">
				<?php
				the_archive_title( '<h1 class="page-title text-3xl sm:text-4xl font-extrabold text-slate-900 mb-2">', '</h1>' );
				the_archive_description( '<div class="archive-description text-base text-slate-600">', '</div>' );
				?>
			</header>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', get_post_type() );
				endwhile;
				?>
			</div>

			<?php hexleonwp_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
