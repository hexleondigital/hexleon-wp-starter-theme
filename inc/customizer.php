<?php
/**
 * Hexleon Tech Theme Customizer
 *
 * @package hexleontech
 */

function hexleon_customize_register( $wp_customize ) {

 // 1. Add Section: Store Information & Support
 $wp_customize->add_section( 'hx_company_details', array(
 'title' => __( 'Store & Support Details', 'hexleontech' ),
 'description' => __( 'Manage Hexleon Tech store contact details, support lines, and social links.', 'hexleontech' ),
 'priority' => 30,
 ) );

 // Store Address
 $wp_customize->add_setting( 'hx_company_address', array(
 'default' => '458, Orex City, Ja-Ela, Sri Lanka',
 'sanitize_callback' => 'sanitize_text_field',
 'transport' => 'refresh',
 ) );
 $wp_customize->add_control( 'hx_company_address', array(
 'label' => __( 'Store / Showroom Address', 'hexleontech' ),
 'section' => 'hx_company_details',
 'type' => 'text',
 ) );

 // Support Hotline Phone
 $wp_customize->add_setting( 'hx_company_phone', array(
 'default' => '+94 77 303 1777',
 'sanitize_callback' => 'sanitize_text_field',
 'transport' => 'refresh',
 ) );
 $wp_customize->add_control( 'hx_company_phone', array(
 'label' => __( 'Support Hotline Phone', 'hexleontech' ),
 'section' => 'hx_company_details',
 'type' => 'text',
 ) );

 // WhatsApp Support
 $wp_customize->add_setting( 'hx_company_whatsapp', array(
 'default' => '+94773031777',
 'sanitize_callback' => 'sanitize_text_field',
 'transport' => 'refresh',
 ) );
 $wp_customize->add_control( 'hx_company_whatsapp', array(
 'label' => __( 'WhatsApp Support Number', 'hexleontech' ),
 'section' => 'hx_company_details',
 'type' => 'text',
 ) );

 // Support Email
 $wp_customize->add_setting( 'hx_company_email', array(
 'default' => 'support@hexleontech.com',
 'sanitize_callback' => 'sanitize_email',
 'transport' => 'refresh',
 ) );
 $wp_customize->add_control( 'hx_company_email', array(
 'label' => __( 'Tech Support Email', 'hexleontech' ),
 'section' => 'hx_company_details',
 'type' => 'email',
 ) );

 // Store Hours
 $wp_customize->add_setting( 'hx_store_hours', array(
 'default' => 'Mon - Sat: 9:00 AM - 7:30 PM (Sun: Closed)',
 'sanitize_callback' => 'sanitize_text_field',
 'transport' => 'refresh',
 ) );
 $wp_customize->add_control( 'hx_store_hours', array(
 'label' => __( 'Store Opening Hours', 'hexleontech' ),
 'section' => 'hx_company_details',
 'type' => 'text',
 ) );

 // Facebook URL
 $wp_customize->add_setting( 'hx_company_facebook', array(
 'default' => 'https://facebook.com/hexleontech',
 'sanitize_callback' => 'esc_url_raw',
 'transport' => 'refresh',
 ) );
 $wp_customize->add_control( 'hx_company_facebook', array(
 'label' => __( 'Facebook URL', 'hexleontech' ),
 'section' => 'hx_company_details',
 'type' => 'url',
 ) );

 // Instagram URL
 $wp_customize->add_setting( 'hx_company_instagram', array(
 'default' => 'https://instagram.com/hexleontech',
 'sanitize_callback' => 'esc_url_raw',
 'transport' => 'refresh',
 ) );
 $wp_customize->add_control( 'hx_company_instagram', array(
 'label' => __( 'Instagram URL', 'hexleontech' ),
 'section' => 'hx_company_details',
 'type' => 'url',
 ) );

 // YouTube URL
 $wp_customize->add_setting( 'hx_company_youtube', array(
 'default' => 'https://youtube.com/@hexleontech',
 'sanitize_callback' => 'esc_url_raw',
 'transport' => 'refresh',
 ) );
 $wp_customize->add_control( 'hx_company_youtube', array(
 'label' => __( 'YouTube Channel URL', 'hexleontech' ),
 'section' => 'hx_company_details',
 'type' => 'url',
 ) );

 // Discord / Community URL
 $wp_customize->add_setting( 'hx_company_discord', array(
 'default' => 'https://discord.gg/hexleontech',
 'sanitize_callback' => 'esc_url_raw',
 'transport' => 'refresh',
 ) );
 $wp_customize->add_control( 'hx_company_discord', array(
 'label' => __( 'Discord Gaming Community URL', 'hexleontech' ),
 'section' => 'hx_company_details',
 'type' => 'url',
 ) );
}
add_action( 'customize_register', 'hexleon_customize_register' );
