<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main flex-1 flex items-center justify-center py-20 bg-slate-50">
	<div class="max-w-xl mx-auto px-4 text-center">
		<div class="card p-8 sm:p-12">
			<span class="inline-block px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full uppercase tracking-wider mb-4">
				<?php esc_html_e( 'Error 404', 'hexleonwp' ); ?>
			</span>
			<h1 class="text-6xl sm:text-7xl font-black text-slate-900 mb-2">404</h1>
			<h2 class="text-xl sm:text-2xl font-bold text-slate-800 mb-4"><?php esc_html_e( 'Page Not Found', 'hexleonwp' ); ?></h2>
			<p class="text-sm sm:text-base text-slate-600 mb-8 leading-relaxed">
				<?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'hexleonwp' ); ?>
			</p>
			
			<div class="flex flex-col sm:flex-row items-center justify-center gap-3">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary w-full sm:w-auto">
					<?php esc_html_e( 'Back to Home', 'hexleonwp' ); ?>
				</a>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
