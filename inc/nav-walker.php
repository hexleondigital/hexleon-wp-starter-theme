<?php
/**
 * HexleonWP Accessible Alpine.js Navigation Walker
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class HexleonWP_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );
		$position = $depth === 0 ? 'left-0 top-full pt-2' : 'left-full top-0 pl-2';

		$output .= "\n{$indent}<div x-show=\"open\" x-cloak x-transition:enter=\"transition ease-out duration-150\" x-transition:enter-start=\"opacity-0 translate-y-1\" x-transition:enter-end=\"opacity-100 translate-y-0\" x-transition:leave=\"transition ease-in duration-100\" x-transition:leave-start=\"opacity-100 translate-y-0\" x-transition:leave-end=\"opacity-0 translate-y-1\" class=\"absolute {$position} w-52 z-50\">\n";
		$output .= "{$indent}\t<ul class=\"bg-white border border-slate-200 rounded-lg shadow-lg py-2 flex flex-col gap-0.5 text-sm\">\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "{$indent}\t</ul>\n{$indent}</div>\n";
	}

	/**
	 * Starts the element output.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$has_children = in_array( 'menu-item-has-children', $classes, true );

		$alpine_attr = '';
		if ( $has_children ) {
			$classes[]    = 'relative';
			$alpine_attr = ' x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false"';
		}

		if ( $depth === 0 ) {
			$classes[] = 'flex items-center h-full';
		} else {
			$classes[] = 'w-full';
		}

		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . $alpine_attr . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		// Tailwind link styling
		if ( $depth === 0 ) {
			$atts['class'] = 'inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-slate-700 hover:text-brand-accent transition-colors';
		} else {
			$atts['class'] = 'block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-accent transition-colors';
		}

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && 'href' === $attr ) {
				$value = esc_url( $value );
			} elseif ( is_scalar( $value ) && '' !== $value ) {
				$value = esc_attr( $value );
			}
			if ( is_scalar( $value ) && '' !== $value ) {
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output = $args->before;
		$item_output .= '<a' . $attributes;
		if ( $has_children && $depth === 0 ) {
			$item_output .= ' @click.prevent="open = !open" :aria-expanded="open.toString()"';
		}
		$item_output .= '>';
		$item_output .= $args->link_before . $title . $args->link_after;

		// Dropdown chevron icon for items with children
		if ( $has_children ) {
			$item_output .= '<svg class="w-4 h-4 ml-0.5 text-slate-400 transition-transform duration-200" :class="{ \'rotate-180 text-brand-accent\': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
		}

		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

