<?php
/**
 * Mega Menu Walker for Hexleon Tech
 *
 * @package hexleontech
 */

class HX_Mega_Menu_Walker extends Walker_Nav_Menu {
 private $is_mega_menu = false;

 // Start Level (Dropdown container)
 public function start_lvl( &$output, $depth = 0, $args = null ) {
 if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
 $t = '';
 $n = '';
 } else {
 $t = "\t";
 $n = "\n";
 }
 $indent = str_repeat( $t, $depth );

 if ( $depth === 0 && $this->is_mega_menu ) {
 // Mega Menu Dropdown Container (High-tech Dark Glassmorphism)
 $output .= "{$n}{$indent}<div x-show=\"open\" x-transition:enter=\"transition ease-out duration-200\" x-transition:enter-start=\"opacity-0 trangray-y-2\" x-transition:enter-end=\"opacity-100 trangray-y-0\" x-transition:leave=\"transition ease-in duration-150\" x-transition:leave-start=\"opacity-100 trangray-y-0\" x-transition:leave-end=\"opacity-0 trangray-y-2\" class=\"absolute left-1/2 -trangray-x-1/2 top-full pt-3 w-[720px] max-w-[95vw] z-50\" style=\"display: none;\">{$n}";
 $output .= "{$t}<div class=\"bg-brand-primary/95 backdrop-blur-xl border border-gray-800 p-6 ring-1 ring-cyan-500/10\">{$n}";
 $output .= "{$t}<ul class=\"grid grid-cols-3 gap-6\">{$n}";
 } elseif ( $this->is_mega_menu ) {
 // Mega Menu inner columns
 $output .= "{$n}{$indent}<ul class=\"flex flex-col gap-1.5 mt-2\">{$n}";
 } else {
 // Standard Dropdown
 $position = $depth === 0 ? 'left-0 top-full pt-3' : 'left-full top-0 pl-2';
 $output .= "{$n}{$indent}<div x-show=\"open\" x-transition:enter=\"transition ease-out duration-200\" x-transition:enter-start=\"opacity-0 trangray-y-2\" x-transition:enter-end=\"opacity-100 trangray-y-0\" x-transition:leave=\"transition ease-in duration-150\" class=\"absolute {$position} w-60 z-50\" style=\"display: none;\">{$n}";
 $output .= "{$t}<ul class=\"bg-brand-primary/95 backdrop-blur-xl border border-gray-800 p-3 flex flex-col gap-1 w-full ring-1 ring-cyan-500/10\">{$n}";
 }
 }

 // End Level
 public function end_lvl( &$output, $depth = 0, $args = null ) {
 if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
 $t = '';
 $n = '';
 } else {
 $t = "\t";
 $n = "\n";
 }
 $indent = str_repeat( $t, $depth );

 if ( $depth === 0 && $this->is_mega_menu ) {
 $output .= "{$indent}</ul>{$n}</div>{$n}</div>{$n}";
 } elseif ( $this->is_mega_menu ) {
 $output .= "{$indent}</ul>{$n}";
 } else {
 $output .= "{$indent}</ul>{$n}</div>{$n}";
 }
 }

 // Start Element (Menu item)
 public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
 if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
 $t = '';
 $n = '';
 } else {
 $t = "\t";
 $n = "\n";
 }
 $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

 $classes = empty( $item->classes ) ? array() : (array) $item->classes;
 $classes[] = 'menu-item-' . $item->ID;

 // Check if this is a top-level mega menu
 if ( $depth === 0 ) {
 $this->is_mega_menu = in_array( 'mega-menu', $classes, true );
 }

 $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

 // Setup Alpine Data on Top Level items with children
 $alpine_data = '';
 if ( $depth === 0 && in_array( 'menu-item-has-children', $classes ) ) {
 $alpine_data = ' x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" ';
 $classes[] = 'relative';
 }

 if ( $depth === 0 ) {
 $classes[] = 'flex items-center h-full';
 } else {
 $classes[] = 'block w-full';
 }

 $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
 $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

 $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
 $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

 $output .= $indent . '<li' . $id . $class_names . $alpine_data . '>';

 $atts = array();
 $atts['title'] = ! empty( $item->attr_title ) ? $item->attr_title : '';
 $atts['target'] = ! empty( $item->target ) ? $item->target : '';
 $atts['rel'] = ! empty( $item->xfn ) ? $item->xfn : '';
 $atts['href'] = ! empty( $item->url ) ? $item->url : '';

 $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

 // Add Tailwind classes to links
 if ( $depth === 0 ) {
 $atts['class'] = 'flex items-center gap-1.5 py-4 text-sm font-bold uppercase tracking-wider text-gray-300 hover:text-cyan-400 transition-colors';
 } elseif ( $depth === 1 && $this->is_mega_menu ) {
 $atts['class'] = 'block w-full text-sm font-bold uppercase tracking-wider text-cyan-400 pb-2 border-b border-gray-800';
 } else {
 if ( $this->is_mega_menu && $depth >= 2 ) {
 $atts['class'] = 'block w-full py-1 text-sm text-gray-400 hover:text-cyan-400 hover:trangray-x-1 transition-all duration-150';
 } else {
 $atts['class'] = 'block w-full px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-cyan-400 transition-colors';
 }
 }

 // Highlight Link styling (e.g., PC Builder / Deals)
 if ( in_array( 'highlight-link', $classes, true ) ) {
 if ( $this->is_mega_menu && $depth >= 1 ) {
 $atts['class'] = 'block w-full mt-2 px-3 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-brand-primary hover:brightness-110 transition-all text-sm font-black tracking-wider uppercase text-center shadow-cyan-500/20';
 } else {
 $atts['class'] .= ' !text-cyan-400 !font-bold';
 }
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
 $item_output .= '<a' . $attributes . '>';
 $item_output .= $args->link_before . $title . $args->link_after;
 
 // Add dropdown chevron icon for top level
 if ( $depth === 0 && in_array( 'menu-item-has-children', $classes ) ) {
 $item_output .= '<svg class="w-3.5 h-3.5 opacity-60 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
 }

 $item_output .= '</a>';

 $item_output .= $args->after;

 $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
 }
}
