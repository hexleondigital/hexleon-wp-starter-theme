<?php
/**
 * The template for displaying all single posts (Clean Light Mode)
 *
 * @package hexleontech
 */

get_header();
?>

<main id="primary" class="site-main py-10 md:py-12 bg-slate-50 text-slate-800 min-h-screen">
	<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
		?>

	</div>
</main>

<?php
get_footer();
