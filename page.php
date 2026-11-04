<?php
/**
 * The template for displaying all pages
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main py-12 md:py-16 flex-1">
	<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'page' );
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
