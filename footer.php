<?php
/**
 * The template for displaying the footer
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<footer id="colophon" class="site-footer mt-auto bg-slate-900 text-slate-400 border-t border-slate-800/80">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">

		<!-- Multi-column Footer Grid -->
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-12 mb-12">

			<!-- Column 1: Site Branding & Description (Span 4) -->
			<div class="lg:col-span-4 space-y-4">
				<?php if ( has_custom_logo() ) : ?>
					<div class="site-logo">
						<?php the_custom_logo(); ?>
					</div>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="inline-block text-xl font-black text-white tracking-tight hover:text-brand-accent transition-colors">
						<?php bloginfo( 'name' ); ?>
					</a>
				<?php endif; ?>

				<?php
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) :
					?>
					<p class="text-sm text-slate-400 leading-relaxed max-w-sm">
						<?php echo esc_html( $description ); ?>
					</p>
				<?php else : ?>
					<p class="text-sm text-slate-400 leading-relaxed max-w-sm">
						<?php esc_html_e( 'Ultra-fast WordPress starter theme built with Tailwind CSS v4, Alpine.js, and Vite. Designed for developers and AI agent workflows.', 'hexleonwp' ); ?>
					</p>
				<?php endif; ?>

				<!-- Tech Stack Pills -->
				<div class="flex flex-wrap items-center gap-2 pt-2">
					<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-800 text-slate-300 border border-slate-700/60">
						Tailwind CSS v4
					</span>
					<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-800 text-slate-300 border border-slate-700/60">
						Alpine.js v3
					</span>
					<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-800 text-slate-300 border border-slate-700/60">
						Vite HMR
					</span>
				</div>
			</div>

			<!-- Column 2: Navigation Links (Span 3) -->
			<div class="lg:col-span-3">
				<h3 class="text-xs font-bold text-white uppercase tracking-wider mb-4">
					<?php esc_html_e( 'Navigation', 'hexleonwp' ); ?>
				</h3>
				<nav aria-label="<?php esc_attr_e( 'Footer Navigation', 'hexleonwp' ); ?>">
					<?php
					if ( has_nav_menu( 'footer-menu' ) ) {
						wp_nav_menu( array(
							'theme_location' => 'footer-menu',
							'container'      => false,
							'menu_class'     => 'space-y-2.5 text-sm [&_a]:text-slate-400 [&_a:hover]:text-white [&_a]:transition-colors [&_a]:block',
							'fallback_cb'    => false,
						) );
					} else {
						// Clean starter fallback links when menu is not yet assigned
						?>
						<ul class="space-y-2.5 text-sm">
							<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-slate-400 hover:text-white transition-colors"><?php esc_html_e( 'Home', 'hexleonwp' ); ?></a></li>
							<li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" class="text-slate-400 hover:text-white transition-colors"><?php esc_html_e( 'Assign Footer Menu', 'hexleonwp' ); ?> &rarr;</a></li>
						</ul>
						<?php
					}
					?>
				</nav>
			</div>

			<!-- Column 3: Resources & Docs (Span 2) -->
			<div class="lg:col-span-2">
				<h3 class="text-xs font-bold text-white uppercase tracking-wider mb-4">
					<?php esc_html_e( 'Resources', 'hexleonwp' ); ?>
				</h3>
				<ul class="space-y-2.5 text-sm">
					<li>
						<a href="https://tailwindcss.com/docs" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1">
							<span>Tailwind CSS</span>
							<svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
						</a>
					</li>
					<li>
						<a href="https://alpinejs.dev/" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1">
							<span>Alpine.js</span>
							<svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
						</a>
					</li>
					<li>
						<a href="https://vitejs.dev/" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1">
							<span>Vite Bundler</span>
							<svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
						</a>
					</li>
					<li>
						<a href="https://developer.wordpress.org/" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1">
							<span>WordPress Docs</span>
							<svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
						</a>
					</li>
				</ul>
			</div>

			<!-- Column 4: AI & Developer Community (Span 3) -->
			<div class="lg:col-span-3">
				<h3 class="text-xs font-bold text-white uppercase tracking-wider mb-4">
					<?php esc_html_e( 'AI-First Theme', 'hexleonwp' ); ?>
				</h3>
				<p class="text-sm text-slate-400 leading-relaxed mb-4">
					<?php esc_html_e( 'Prompt your AI agent (Cursor, Claude, Copilot) to design, customize, or generate page templates instantly.', 'hexleonwp' ); ?>
				</p>
				<a href="https://github.com/hexleondigital/hexleonwp" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-slate-800 hover:bg-slate-700/80 text-white text-xs font-semibold border border-slate-700 transition-colors">
					<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
					<span>View on GitHub</span>
				</a>
			</div>

		</div>

		<!-- Bottom Colophon / Copyright Bar -->
		<div class="border-t border-slate-800/80 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
			<p>
				&copy; <?php echo date_i18n( 'Y' ); ?> <span class="text-slate-300 font-medium"><?php bloginfo( 'name' ); ?></span>. <?php esc_html_e( 'All rights reserved.', 'hexleonwp' ); ?>
			</p>

			<div class="flex items-center gap-6">
				<p>
					<?php
					printf(
						/* translators: %s: Author link */
						esc_html__( 'Starter theme by %s', 'hexleonwp' ),
						'<a href="https://hexleondigital.com/" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors font-medium">Hexleon Digital</a>'
					);
					?>
				</p>

				<!-- Back to top button (Alpine.js) -->
				<button type="button" 
						onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" 
						class="inline-flex items-center gap-1 text-slate-400 hover:text-white transition-colors cursor-pointer"
						aria-label="<?php esc_attr_e( 'Scroll to top', 'hexleonwp' ); ?>">
					<span><?php esc_html_e( 'Top', 'hexleonwp' ); ?></span>
					<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
				</button>
			</div>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
