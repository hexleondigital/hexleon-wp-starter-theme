<?php
/**
 * The header template for HexleonWP
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col' ); ?> x-data="{ mobileMenuOpen: false }">
<?php wp_body_open(); ?>

<!-- Accessible Skip to Content Link -->
<a class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-brand-accent focus:text-white focus:rounded-md focus:shadow-lg focus:outline-none" href="#primary">
	<?php esc_html_e( 'Skip to content', 'hexleonwp' ); ?>
</a>

<!-- Site Header -->
<header id="masthead" class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-xs">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex items-center justify-between h-20">

			<!-- Brand / Site Logo -->
			<div class="site-branding flex items-center">
				<?php if ( has_custom_logo() ) : ?>
					<div class="site-logo">
						<?php the_custom_logo(); ?>
					</div>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-xl sm:text-2xl font-black text-brand-primary tracking-tight hover:text-brand-accent transition-colors">
						<?php bloginfo( 'name' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<!-- Desktop Navigation -->
			<nav id="site-navigation" class="hidden md:flex items-center space-x-1" aria-label="<?php esc_attr_e( 'Primary Menu', 'hexleonwp' ); ?>">
				<?php
				if ( has_nav_menu( 'primary-menu' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'primary-menu',
						'container'      => false,
						'menu_class'     => 'flex items-center space-x-1',
						'fallback_cb'    => false,
						'walker'         => new HexleonWP_Nav_Walker(),
					) );
				} else {
					echo '<ul class="flex items-center space-x-4 text-sm text-slate-600"><li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" class="hover:text-brand-accent transition-colors">' . esc_html__( 'Assign Primary Menu', 'hexleonwp' ) . '</a></li></ul>';
				}
				?>
			</nav>

			<!-- Mobile Menu Button -->
			<div class="flex md:hidden items-center">
				<button type="button" 
						@click="mobileMenuOpen = !mobileMenuOpen" 
						class="inline-flex items-center justify-center p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand-accent transition-colors" 
						:aria-expanded="mobileMenuOpen.toString()"
						aria-controls="mobile-menu"
						aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'hexleonwp' ); ?>">
					<!-- Hamburger icon -->
					<svg class="w-6 h-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
					</svg>
					<!-- Close icon -->
					<svg class="w-6 h-6" x-show="mobileMenuOpen" x-cloak fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
					</svg>
				</button>
			</div>

		</div>
	</div>

	<!-- Mobile Navigation Drawer -->
	<div id="mobile-menu" 
		 class="md:hidden bg-white border-t border-slate-200" 
		 x-show="mobileMenuOpen" 
		 x-cloak 
		 x-collapse 
		 @click.outside="mobileMenuOpen = false">
		<nav class="px-4 pt-3 pb-6 space-y-1 text-sm font-medium" aria-label="<?php esc_attr_e( 'Mobile Menu', 'hexleonwp' ); ?>">
			<?php
			if ( has_nav_menu( 'primary-menu' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary-menu',
					'container'      => false,
					'menu_class'     => 'space-y-1 [&_a]:block [&_a]:px-3 [&_a]:py-2 [&_a]:rounded-md [&_a]:text-slate-700 [&_a:hover]:bg-slate-100 [&_a:hover]:text-brand-accent',
					'fallback_cb'    => false,
				) );
			} else {
				echo '<p class="text-sm text-slate-500 py-2"><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" class="underline">' . esc_html__( 'Assign Primary Menu in Dashboard', 'hexleonwp' ) . '</a></p>';
			}
			?>
		</nav>
	</div>
</header>
