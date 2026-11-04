<?php
/**
 * The template for displaying all pages (Clean Light Mode)
 *
 * @package hexleontech
 */

get_header();
?>

<main id="primary" class="site-main py-12 bg-gray-50 text-gray-800 min-h-screen">
	<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'page' ); ?>

		<?php endwhile; ?>
	</div>
</main>

<?php 
get_footer();
