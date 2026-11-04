<?php
/**
 * Template part for displaying a message that posts cannot be found (Clean Light Mode)
 *
 * @package hexleontech
 */

?>

<section class="no-results not-found text-center py-12 max-w-md mx-auto bg-white border border-gray-200 p-6 ">
	<div class="w-12 h-12 mx-auto mb-3 bg-gray-100 flex items-center justify-center text-gray-400">
		<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
	</div>

	<header class="page-header mb-2">
		<h1 class="page-title text-lg font-bold text-gray-800 font-sans"><?php esc_html_e( 'Nothing Found', 'hexleontech' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content text-sm text-gray-500">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s" class="text-blue-600 hover:underline">Get started here</a>.', 'hexleontech' ),
					array(
						'a' => array(
							'href' => array(),
							'class' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p class="mb-4"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hexleontech' ); ?></p>
			<a href="<?php echo esc_url( home_url('/') ); ?>" class="tech-glow-btn">
				<?php esc_html_e( 'Back to Home', 'hexleontech' ); ?>
			</a>

			<?php
		else :
			?>

			<p class="mb-4"><?php esc_html_e( 'It seems we cannot find what you are looking for. Perhaps searching can help.', 'hexleontech' ); ?></p>
			<a href="<?php echo esc_url( home_url('/') ); ?>" class="tech-glow-btn">
				<?php esc_html_e( 'Back to Home', 'hexleontech' ); ?>
			</a>

			<?php
		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
