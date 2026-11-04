<?php
/**
 * The template for displaying search results pages (Using brand variables)
 *
 * @package hexleontech
 */

get_header();
?>

<main id="primary" class="site-main py-10 md:py-12 bg-slate-50 text-slate-800 min-h-screen">
	<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">

		<?php if ( have_posts() ) : ?>

			<header class="page-header mb-8 pb-4 border-b border-slate-200">
				<span class="text-sm font-mono text-slate-500 uppercase tracking-wider block mb-1"><?php esc_html_e('Search Results', 'hexleontech'); ?></span>
				<h1 class="page-title text-2xl sm:text-3xl font-black font-sans text-brand-primary">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Results for: %s', 'hexleontech' ), '<span class="text-brand-accent font-bold">' . get_search_query() . '</span>' );
					?>
				</h1>
			</header>

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					if ( 'product' === get_post_type() ) {
						wc_get_template_part( 'content', 'product' );
					} else {
						get_template_part( 'template-parts/content', 'search' );
					}

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
