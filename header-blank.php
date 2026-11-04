<?php
/**
 * A blank header for full-screen apps (like the Book Tour Wizard)
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="view-transition" content="same-origin">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class('bg-slate-50 antialiased overflow-x-hidden'); ?>>
	<?php wp_body_open(); ?>
