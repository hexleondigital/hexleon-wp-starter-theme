<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="no-results not-found text-center py-16 max-w-lg mx-auto card p-8 sm:p-12">
	<div class="w-14 h-14 mx-auto mb-4 bg-slate-100 rounded-full flex items-center justify-center text-slate-400">
		<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
	</div>

	<header class="page-header mb-3">
		<h1 class="page-title text-2xl font-bold text-slate-900"><?php esc_html_e( 'Nothing Found', 'hexleonwp' ); ?></h1>
	</header>

	<div class="page-content text-sm sm:text-base text-slate-600 leading-relaxed mb-6">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php
				printf(
					wp_kses(
						/* translators: 1: link to WP admin new post page. */
						__( 'Ready to publish your first post? <a href="%1$s" class="text-brand-accent hover:underline">Get started here</a>.', 'hexleonwp' ),
						array(
							'a' => array(
								'href'  => array(),
								'class' => array(),
							),
						)
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hexleonwp' ); ?></p>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we cannot find what you are looking for. Perhaps searching can help.', 'hexleonwp' ); ?></p>

		<?php endif; ?>
	</div>

	<div>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary">
			<?php esc_html_e( 'Back to Home', 'hexleonwp' ); ?>
		</a>
	</div>
</section>
