<?php
/**
 * The template for displaying the Hexleon Tech footer (Using brand variables)
 *
 * @package hexleontech
 */

if (!defined('ABSPATH')) {
 exit;
}
?>

<footer class="site-footer bg-brand-primary text-gray-400 border-t border-white/10 relative pt-16 pb-8 lg:pb-12">
	<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

		<!-- Store Information & Categories Grid -->
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-12 mb-16">
 
			<!-- Branding & Store Bio -->
			<div class="lg:col-span-4 space-y-4">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="block">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo-hexleontech-dark.svg" 
					alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" 
					class="h-12 md:h-16 w-auto object-contain !max-w-[220px]">
				</a>

				<p class="text-gray-400 text-sm leading-relaxed mt-4">
					<?php esc_html_e('Sri Lanka\'s trusted shop for budget & high-performance computer parts, custom desktop PCs, gaming accessories, and genuine electronics.', 'hexleontech'); ?>
				</p>

				<div class="pt-6 mt-6 border-t border-white/5">
					<span class="text-[11px] uppercase tracking-widest font-bold text-gray-500 block mb-3"><?php esc_html_e('Payment Methods Accepted:', 'hexleontech'); ?></span>
					<div class="flex flex-wrap items-center gap-2 text-[11px] font-mono text-gray-400">
						<span class="px-3 py-2 border border-white/5 rounded-sm">Cash on Delivery</span>
						<!-- <span class="px-3 py-1.5 bg-gray-900 border border-white/5">Bank Transfer</span>
						<span class="px-3 py-1.5 bg-gray-900 border border-white/5">Visa / Master</span>
						<span class="px-3 py-1.5 bg-gray-900 border border-white/5">Koko / Mintpay</span> -->
					</div>
				</div>
			</div>

 			<!-- Popular Categories -->
			<div class="lg:col-span-3">
				<h4 class="text-sm font-bold text-white tracking-wider uppercase mb-6">
					<?php esc_html_e('Shop', 'hexleontech'); ?>
				</h4>
				<nav class="text-sm text-gray-400 [&_ul]:space-y-3.5 [&_a]:transition-colors [&_a:hover]:text-white [&_.current-menu-item>a]:text-white">
					<?php
					if (has_nav_menu('footer-shop')) {
						wp_nav_menu(array(
							'theme_location' => 'footer-shop',
							'container'      => false,
							'menu_class'     => '',
							'fallback_cb'    => false,
						));
					} else {
						echo '<ul class="space-y-3.5"><li><a href="' . esc_url(admin_url('nav-menus.php')) . '" class="hover:text-white transition-colors">' . esc_html__('Setup Footer Categories Menu', 'hexleontech') . '</a></li></ul>';
					}
					?>
				</nav>
			</div>

 			<!-- Quick Links & Customer Care -->
			<div class="lg:col-span-2">
				<h4 class="text-sm font-bold text-white tracking-wider uppercase mb-6">
					<?php esc_html_e('Support', 'hexleontech'); ?>
				</h4>
				<nav class="text-sm text-gray-400 [&_ul]:space-y-3.5 [&_a]:transition-colors [&_a:hover]:text-white [&_.current-menu-item>a]:text-white">
					<?php
					if (has_nav_menu('footer-support')) {
						wp_nav_menu(array(
							'theme_location' => 'footer-support',
							'container'      => false,
							'menu_class'     => '',
							'fallback_cb'    => false,
						));
					} else {
						echo '<ul class="space-y-3.5"><li><a href="' . esc_url(admin_url('nav-menus.php')) . '" class="hover:text-white transition-colors">' . esc_html__('Setup Footer Support Menu', 'hexleontech') . '</a></li></ul>';
					}
					?>
				</nav>
			</div>

 			<!-- Showroom & Hotline Contact -->
			<div class="lg:col-span-3">
				<h4 class="text-sm font-bold text-white tracking-wider uppercase mb-6">
					<?php esc_html_e('Store & Hotline', 'hexleontech'); ?>
				</h4>
				<ul class="space-y-4 text-sm text-gray-400">
					<li class="flex items-start gap-3">
						<span class="material-symbols-outlined text-[18px] text-gray-500 shrink-0 mt-0.5">location_on</span>
						<span class="leading-relaxed"><?php echo esc_html( get_theme_mod( 'hx_company_address', 'Watinapaha, Minuwangoda' ) ); ?></span>
					</li>
					<li class="flex items-center gap-3">
						<span class="material-symbols-outlined text-[18px] text-gray-500 shrink-0">call</span>
						<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', get_theme_mod( 'hx_company_phone', '+94 76 230 2957' ) ) ); ?>" class="hover:text-white font-mono font-bold text-white transition-colors">
							<?php echo esc_html( get_theme_mod( 'hx_company_phone', '+94 76 230 2957' ) ); ?>
						</a>
					</li>
					<li class="flex items-center gap-3">
						<span class="material-symbols-outlined text-[18px] text-gray-500 shrink-0">mail</span>
						<a href="mailto:<?php echo esc_attr( sanitize_email( get_theme_mod( 'hx_company_email', 'support@hexleontech.com' ) ) ); ?>" class="hover:text-white transition-colors">
							<?php echo esc_html( get_theme_mod( 'hx_company_email', 'support@hexleontech.com' ) ); ?>
						</a>
					</li>
					<li class="text-[12px] text-gray-500 pt-2 font-mono">
						<?php echo esc_html( get_theme_mod( 'hx_store_hours', 'Mon - Sat: 9:00 AM - 6:00 PM (Sun: Closed)' ) ); ?>
					</li>
				</ul>
			</div>
 		</div>

 		<!-- Bottom Copyright -->
		<div class="flex flex-col sm:flex-row justify-between items-center pt-8 border-t border-white/10 text-sm text-gray-500 gap-4 mt-8">
			<p>&copy; <?php echo date_i18n( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'hexleontech' ); ?> Website by <a href="https://hexleondigital.com/" target="_blank" rel="noopener noreferrer">Hexleon Digital</a></p>
			<p><?php esc_html_e('Prices in Sri Lankan Rupees (LKR). Islandwide Delivery Available.', 'hexleontech'); ?></p>
		</div>
 
 	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
