<?php
/**
 * The main template file
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

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header class="mb-10 text-center">
					<h1 class="page-title text-3xl sm:text-4xl font-extrabold text-slate-900"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
				<?php
				/* Start the Loop */
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
