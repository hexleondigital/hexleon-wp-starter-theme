<?php
/**
 * The template for displaying 404 pages (Clean Light Mode)
 *
 * @package hexleontech
 */

get_header();
?>

<main id="primary" class="site-main flex items-center justify-center min-h-[65vh] bg-slate-50 text-slate-800 py-16">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<div class="max-w-md mx-auto bg-white border border-slate-200 p-8 ">
			<span class="inline-block px-2.5 py-1 bg-red-100 text-red-700 text-sm font-mono font-bold uppercase mb-3">
				<?php esc_html_e('Page Not Found', 'hexleontech'); ?>
			</span>
			<h1 class="text-6xl font-mono font-black text-brand-primary mb-2">404</h1>
			<h2 class="text-xl font-bold text-slate-800 mb-2 font-sans"><?php esc_html_e('Product or Page Missing', 'hexleontech'); ?></h2>
			<p class="text-sm text-slate-500 mb-6 leading-relaxed">
				<?php esc_html_e('The item or page you are looking for might have been moved, sold out, or removed.', 'hexleontech'); ?>
			</p>
			
			<div class="flex flex-col sm:flex-row items-center justify-center gap-2.5">
				<a href="<?php echo esc_url( home_url('/') ); ?>" class="tech-glow-btn w-full sm:w-auto">
					<?php esc_html_e('Back to Home', 'hexleontech'); ?>
				</a>
				<a href="<?php echo esc_url( function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/') ); ?>" class="tech-outline-btn w-full sm:w-auto">
					<?php esc_html_e('Browse Hardware Catalog', 'hexleontech'); ?>
				</a>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
