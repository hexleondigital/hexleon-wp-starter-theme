<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header text-center mb-10 max-w-3xl mx-auto">
		<?php the_title( '<h1 class="entry-title text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">', '</h1>' ); ?>
	</header>

	<div class="card p-6 sm:p-10">
		<div class="entry-content prose prose-slate prose-lg max-w-none prose-headings:font-bold prose-a:text-brand-accent hover:prose-a:underline">
			<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links mt-8 flex gap-2 font-medium text-sm">' . esc_html__( 'Pages:', 'hexleonwp' ),
				'after'  => '</div>',
			) );
			?>
		</div>
	</div>
</article>
