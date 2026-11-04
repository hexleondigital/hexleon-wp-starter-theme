<?php
/**
 * The main template file (Clean Light Mode)
 *
 * @package hexleontech
 */

get_header();
?>

<main id="primary" class="site-main py-10 md:py-12 bg-slate-50 text-slate-800 min-h-screen">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header class="mb-8 text-center">
					<h1 class="page-title text-2xl sm:text-3xl font-black font-sans text-brand-primary"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;

			echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">';
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;
			echo '</div>';

			hx_styled_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</div>
</main>

<?php
get_footer();
