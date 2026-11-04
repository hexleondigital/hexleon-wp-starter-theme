<?php
/**
 * The header for Hexleon Tech (Using brand color variables)
 *
 * @package hexleontech
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="view-transition" content="same-origin">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'bg-gray-50 text-gray-800 antialiased' ); ?> x-data="{ mobileMenuOpen: false }">
	<?php wp_body_open(); ?>

	<!-- Top Announcement Bar -->
	<div class="bg-brand-primary border-b border-white/10 text-gray-300 py-1.5">
		<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-1">
			<div class="flex items-center gap-3 text-[11px] font-semibold tracking-wide">
				<span class="inline-flex items-center gap-1.5 text-gray-400 font-mono uppercase">
					<span class="material-symbols-outlined text-[14px]">local_shipping</span>
					<?php esc_html_e('Islandwide Delivery', 'hexleontech'); ?>
				</span>
				<span class="text-gray-600">•</span>
				<span class="uppercase text-gray-400"><?php esc_html_e('Cash on Delivery', 'hexleontech'); ?></span>
			</div>
			<div class="hidden md:flex items-center gap-4 text-gray-400 text-[11px] font-semibold tracking-wide uppercase">
				<a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', get_theme_mod('hx_company_whatsapp', '94762302957'))); ?>?text=Hello%20Hexleon%20Tech,%20I%20have%20an%20inquiry%20about%20PC%20parts" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1.5 hover:text-white font-mono transition-colors"> 
					<span class="material-symbols-outlined text-[14px] text-brand-accent">forum</span>
					<span>WhatsApp: <?php echo esc_html(get_theme_mod('hx_company_whatsapp', '+94 76 230 2957')); ?></span>
				</a>
				<span class="text-white/10">|</span>
				<a href="<?php echo esc_url(get_permalink(get_page_by_path('contact-us')) ?: home_url('/contact/')); ?>" class="hover:text-white transition-colors"><?php esc_html_e('Contact', 'hexleontech'); ?></a>
				<a href="<?php echo esc_url(get_permalink(get_page_by_path('faq')) ?: home_url('/faq/')); ?>" class="hover:text-white transition-colors"><?php esc_html_e('FAQ', 'hexleontech'); ?></a>
			</div>
		</div>
	</div>

	<!-- Main Header -->
	<header id="masthead" class="sticky top-0 z-40 bg-brand-primary border-b border-white/10 text-gray-100 shadow-sm">
		<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center justify-between h-20 gap-4">
				
				<!-- Brand Logo -->
				<div class="flex items-center shrink-0">
					<?php if ( has_custom_logo() ) : ?>
						<div class="site-logo">
							<?php the_custom_logo(); ?>
						</div>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="flex items-center group">
							<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo-hexleontech-dark.svg" 
								 alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" 
								 class="!h-9 sm:!h-10 md:!h-11 w-auto object-contain !max-w-[200px] sm:!max-w-[240px]">
						</a>
					<?php endif; ?>
				</div>

				<!-- Live Search Bar -->
				<div class="hidden md:flex flex-1 max-w-xl relative" x-data @click.away="$store.search.close()">
					<div class="relative w-full flex items-center h-11 border border-gray-300 rounded-md bg-white shadow-sm overflow-hidden">
						<div class="grid h-full">
							<select x-model="$store.search.category" 
									@change="$store.search.performSearch()" 
									class="col-start-1 row-start-1 hidden lg:block appearance-none h-full bg-gray-50 pl-3 pr-8 text-sm text-gray-700 font-medium focus:outline-none focus:border-brand-accent shrink-0">
								<option value="0"><?php esc_html_e('All Categories', 'hexleontech'); ?></option>
								<?php
								if (taxonomy_exists('product_cat')) {
									$cats = get_terms(array(
										'taxonomy' => 'product_cat',
										'hide_empty' => false,
										'parent' => 0,
									));
									if (!empty($cats) && !is_wp_error($cats)) {
										foreach ($cats as $cat) {
											if ($cat->slug === 'uncategorized') continue;
											echo '<option value="' . esc_attr($cat->term_id) . '">' . esc_html($cat->name) . '</option>';
										}
									}
								}
								?>
							</select>
							<span class="hidden lg:block material-symbols-outlined pointer-events-none col-start-1 row-start-1 justify-self-end self-center pr-2 text-gray-500">keyboard_arrow_down</span>
						</div>

						<input type="text" 
							 x-model="$store.search.query" 
							 @input.debounce.300ms="$store.search.performSearch(); $store.search.open()" 
							 @focus="$store.search.open()"
							 placeholder="<?php esc_attr_e('Search RAM, SSDs...', 'hexleontech'); ?>" 
							 class="w-full h-full bg-white pl-4 pr-12 border-l border-gray-300 text-sm text-gray-800 placeholder-gray-400 focus:outline-none transition-all">

						<button type="button" 
								@click="$store.search.performSearch()" 
								class="absolute right-0 top-0 bottom-0 px-4 text-gray-400 hover:text-brand-accent flex items-center justify-center transition-colors bg-transparent">
							<span class="material-symbols-outlined text-[20px]">search</span>
						</button>
					</div>

					<!-- Search Dropdown Results (Clean White Popup) -->
					<div x-show="$store.search.isOpen && ($store.search.query.length >= 2 || $store.search.results.length > 0)" 
						 x-transition
						 class="absolute left-0 right-0 top-full mt-2 bg-white border border-gray-200 p-3 pr-5 z-50 text-gray-800 custom-scrollbar max-h-96 overflow-y-auto"
						 style="display: none;">
						
						<div x-show="$store.search.loading" class="flex items-center justify-center py-6 text-gray-500 gap-2">
							<span class="material-symbols-outlined animate-spin text-[20px]">progress_activity</span>
							<span class="text-sm font-medium text-gray-600"><?php esc_html_e('Searching store...', 'hexleontech'); ?></span>
						</div>

						<template x-if="!$store.search.loading && $store.search.results.length > 0">
							<div class="space-y-1">
								<span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider block px-2 py-1"><?php esc_html_e('Matching Products', 'hexleontech'); ?></span>
								<template x-for="item in $store.search.results" :key="item.id">
									<a :href="item.link" class="flex items-center gap-3 p-2 hover:bg-gray-50 transition-colors group">
										<img :src="item.image" :alt="item.title" class="w-11 h-11 object-cover bg-gray-100 border border-gray-200 shrink-0">
										<div class="flex-1 min-w-0">
											<h4 class="text-sm font-bold text-gray-800 group-hover:text-gray-900 transition-colors truncate" x-text="item.title"></h4>
											<div class="flex items-center gap-2 mt-0.5">
												<span class="font-mono text-sm font-bold text-brand-accent" x-html="item.price"></span>
												<span x-show="item.sku" class="text-[10px] font-mono text-gray-500" x-text="'SKU: ' + item.sku"></span>
											</div>
										</div>
										<span x-show="item.in_stock" class="text-[10px] font-bold text-brand-green bg-emerald-50 border border-emerald-200 px-2 py-0.5 "><?php esc_html_e('In Stock', 'hexleontech'); ?></span>
									</a>
								</template>
							</div>
						</template>

						<template x-if="!$store.search.loading && $store.search.query.length >= 2 && $store.search.results.length === 0">
							<div class="text-center py-6 text-sm text-gray-500">
								<p><?php esc_html_e('No products found matching your search.', 'hexleontech'); ?></p>
							</div>
						</template>
					</div>
				</div>

				<!-- Right Actions (Build PC, Account, Cart) -->
				<div class="flex items-center gap-3 sm:gap-4">
					
					<!-- Build PC Button -->
					<a href="<?php echo esc_url( home_url('/custom-pc-build-request/') ); ?>" 
					 class="hidden md:flex items-center gap-2 px-4 h-11 bg-brand-accent hover:bg-[#438003] rounded-md text-white shadow-sm transition-all text-[13px] font-bold tracking-wide">
						<span class="material-symbols-outlined text-[18px]">memory</span>
						<span><?php esc_html_e('Custom PC', 'hexleontech'); ?></span>
					</a>

					<!-- My Account -->
					<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ?: home_url('/my-account/') ); ?>" 
					 class="hidden sm:flex items-center gap-1.5 px-3 h-11 text-gray-300 hover:text-white hover:bg-white/10 rounded-md transition-colors text-[13px] font-medium">
						<span class="material-symbols-outlined text-[18px]">person</span>
						<span><?php esc_html_e('Account', 'hexleontech'); ?></span>
					</a>

					<!-- Cart Dropdown Toggle -->
					<button type="button" 
							@click="$store.cart.toggle()" 
							class="relative flex items-center gap-2 px-3.5 h-11 border border-gray-700 hover:bg-gray-700 hover:border-gray-600 rounded-md shadow-sm text-white text-[13px] font-medium transition-all"
							aria-label="<?php esc_attr_e('Shopping Cart', 'hexleontech'); ?>">
						<span class="material-symbols-outlined text-[18px]">shopping_cart</span>
						<span class="hidden sm:inline"><?php esc_html_e('Cart', 'hexleontech'); ?></span>
						<span class="hx-cart-count bg-brand-accent text-white text-[10px] font-bold w-4.5 h-4.5 flex items-center justify-center rounded-full">
							<?php echo WC()->cart ? esc_html(WC()->cart->get_cart_contents_count()) : '0'; ?>
						</span>
					</button>

					<!-- Mobile Menu Toggle -->
					<button type="button" 
							@click="mobileMenuOpen = !mobileMenuOpen" 
							class="lg:hidden w-11 h-11 flex items-center justify-center bg-white/5 text-gray-300 hover:text-white border border-white/15"
							aria-label="<?php esc_attr_e('Toggle navigation menu', 'hexleontech'); ?>">
						<span class="material-symbols-outlined text-[24px]" x-show="!mobileMenuOpen">menu</span>
						<span class="material-symbols-outlined text-[24px]" x-show="mobileMenuOpen" style="display: none;">close</span>
					</button>
				</div>
			</div>

			<!-- Secondary Nav Bar -->
			<div class="hidden lg:flex items-center justify-between border-t border-white/10 h-11 text-sm">
				<nav id="site-navigation" class="flex items-center space-x-1 h-full w-full [&_ul]:flex [&_ul]:items-center [&_ul]:space-x-6 [&_ul]:text-[13px] [&_ul]:font-medium [&_ul]:text-gray-300 [&_a]:py-3 [&_a]:transition-colors [&_a:hover]:text-brand-accent [&_.current-menu-item>a]:text-brand-accent [&_.current-menu-item>a]:font-bold">
					<?php
					if (has_nav_menu('primary-menu')) {
						wp_nav_menu(array(
							'theme_location' => 'primary-menu',
							'container'      => false,
							'menu_class'     => '',
							'fallback_cb'    => false,
						));
					} else {
						echo '<ul class="flex items-center space-x-6 text-[13px] font-medium text-gray-300"><li><a href="' . esc_url(admin_url('nav-menus.php')) . '" class="hover:text-white py-3 transition-colors">' . esc_html__('Please assign a menu to Primary Menu', 'hexleontech') . '</a></li></ul>';
					}
					?>
				</nav>
			</div>
		</div>

		<!-- Mobile Menu Drawer -->
		<div class="lg:hidden bg-brand-primary border-t border-white/10 shadow-inner" 
			 x-show="mobileMenuOpen" 
			 x-transition 
			 style="display: none;">
			<nav class="px-4 py-4 text-sm font-semibold text-gray-200 [&_ul]:space-y-2 [&_li]:w-full [&_a]:block [&_a]:py-2 [&_a]:border-b [&_a]:border-white/10 [&_li:last-child>a]:border-b-0 [&_.current-menu-item>a]:text-brand-accent">
				<?php
				if (has_nav_menu('primary-menu')) {
					wp_nav_menu(array(
						'theme_location' => 'primary-menu',
						'container'      => false,
						'menu_class'     => '',
						'fallback_cb'    => false,
					));
				} else {
					echo '<ul class="space-y-2"><li class="w-full"><a href="' . esc_url(admin_url('nav-menus.php')) . '" class="block py-2 border-b border-white/10">' . esc_html__('Setup Primary Menu', 'hexleontech') . '</a></li></ul>';
				}
				?>
			</nav>
		</div>
	</header>

	<!-- Slide-over Mini Cart Drawer -->
	<?php get_template_part( 'template-parts/header/mini-cart-drawer' ); ?>
