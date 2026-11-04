<?php
/**
 * Handle custom AJAX form submissions securely.
 */

/**
 * Verify Cloudflare Turnstile token.
 * 
 * @param string $token The cf-turnstile-response token.
 * @return bool True if valid or if turnstile is not configured, false otherwise.
 */
function hx_verify_turnstile( $token ) {
    if ( empty( $token ) ) {
        return false;
    }
    if ( ! defined( 'CF_TURNSTILE_SECRET_KEY' ) ) {
        return true; // Fallback if not configured
    }

    $response = wp_remote_post( 'https://challenges.cloudflare.com/turnstile/v0/siteverify', array(
        'body' => array(
            'secret'   => CF_TURNSTILE_SECRET_KEY,
            'response' => $token,
        ),
    ) );

    if ( is_wp_error( $response ) ) {
        return false;
    }

    $body = json_decode( wp_remote_retrieve_body( $response ), true );
    return ! empty( $body['success'] );
}

/**
 * Handle generic contact page form submissions securely.
 */
add_action( 'wp_ajax_nopriv_hx_submit_contact_request', 'hx_handle_contact_request' );
add_action( 'wp_ajax_hx_submit_contact_request', 'hx_handle_contact_request' );

function hx_handle_contact_request() {
 // 1. Verify Nonce for security
 if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'hx_contact_request_nonce' ) ) {
 wp_send_json_error( array( 'message' => 'Security check failed. Please refresh the page and try again.' ) );
 wp_die();
 }

 // 1.2 Verify Cloudflare Turnstile
 $turnstile_token = isset($_POST['cf-turnstile-response']) ? $_POST['cf-turnstile-response'] : '';
 if ( ! hx_verify_turnstile( $turnstile_token ) ) {
 wp_send_json_error( array( 'message' => 'Anti-spam verification failed. Please complete the captcha and try again.' ) );
 wp_die();
 }

 // 1.5 Honeypot Check (Anti-Spam)
 if ( ! empty( $_POST['website_url'] ) ) {
 // Silently discard: Bot detected
 wp_send_json_success( array( 'message' => 'Your message has been sent successfully!' ) );
 wp_die();
 }

 // 2. Sanitize and validate inputs
 $first_name = isset($_POST['firstName']) ? sanitize_text_field($_POST['firstName']) : '';
 $last_name = isset($_POST['lastName']) ? sanitize_text_field($_POST['lastName']) : '';
 $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
 $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

 if ( empty($first_name) || ! is_email($email) || empty($message) ) {
 wp_send_json_error( array( 'message' => 'Please provide a valid name, email address, and message.' ) );
 wp_die();
 }

 // 3. Build Email Template Data
 $admin_email = get_option('admin_email');
 $blog_name = get_bloginfo('name');
 $subject = 'New Contact Request from ' . $first_name . ' ' . $last_name;

 $data = array(
 'first_name' => $first_name,
 'last_name' => $last_name,
 'email' => $email,
 'message' => $message,
 );

 // 4. Render and Send Admin Email
 ob_start();
 include get_template_directory() . '/template-parts/emails/contact-request.php';
 $admin_body = ob_get_clean();

 $headers = array('Content-Type: text/html; charset=UTF-8');
 $headers[] = 'Reply-To: ' . $first_name . ' <' . $email . '>';

 $admin_mail_sent = wp_mail( $admin_email, $subject, $admin_body, $headers );

 // 5. Render and Send User Auto-Responder
 $user_subject = 'We Received Your Message - ' . $blog_name;
 $user_headers = array('Content-Type: text/html; charset=UTF-8');
 $user_headers[] = 'From: ' . $blog_name . ' <' . $admin_email . '>';
 
 ob_start();
 include get_template_directory() . '/template-parts/emails/contact-request-user.php';
 $user_body = ob_get_clean();

 wp_mail( $email, $user_subject, $user_body, $user_headers );

 if ( $admin_mail_sent ) {
 wp_send_json_success( array( 'message' => 'Your message has been sent successfully!' ) );
 } else {
 wp_send_json_error( array( 'message' => 'Failed to send message. Please verify your server email configuration.' ) );
 }

 wp_die();
}

/**
 * Handle Custom PC Build Request submissions securely.
 */
add_action( 'wp_ajax_nopriv_submit_pc_request', 'hx_handle_pc_request' );
add_action( 'wp_ajax_submit_pc_request', 'hx_handle_pc_request' );

function hx_handle_pc_request() {
    // Basic verification
    if ( ! isset( $_POST['data'] ) ) {
        wp_send_json_error( 'Invalid data provided.' );
        wp_die();
    }

    $data = json_decode( stripslashes( $_POST['data'] ), true );
    
    if ( ! $data || empty( $data['name'] ) || empty( $data['email'] ) ) {
        wp_send_json_error( 'Missing required fields.' );
        wp_die();
    }

    // Verify Cloudflare Turnstile
    $turnstile_token = isset($_POST['cf-turnstile-response']) ? $_POST['cf-turnstile-response'] : '';
    if ( ! hx_verify_turnstile( $turnstile_token ) ) {
        wp_send_json_error( 'Anti-spam verification failed. Please complete the captcha and try again.' );
        wp_die();
    }

    // Sanitize inputs
    $name = sanitize_text_field( $data['name'] );
    $email = sanitize_email( $data['email'] );
    $phone = sanitize_text_field( $data['phone'] );
    $usage = sanitize_text_field( $data['usage'] );
    $game_type = isset( $data['game_type'] ) ? sanitize_text_field( $data['game_type'] ) : 'N/A';
    $budget = sanitize_text_field( $data['budget'] );
    $cpu = sanitize_text_field( $data['cpu'] );
    $storage = sanitize_text_field( $data['storage'] );
    $windows_ready = sanitize_text_field( $data['windows_ready'] );
    $case_pref = sanitize_text_field( $data['case_preference'] );
    $monitor = !empty( $data['need_monitor'] ) ? 'Yes' : 'No';
    $peripherals = !empty( $data['need_peripherals'] ) ? 'Yes' : 'No';

    if ( ! is_email( $email ) ) {
        wp_send_json_error( 'Invalid email address.' );
        wp_die();
    }

    // Build Admin Email
    $admin_email = get_option( 'admin_email' );
    $blog_name = get_bloginfo( 'name' );
    $subject = 'New PC Build Request from ' . $name;

    ob_start();
    include get_template_directory() . '/template-parts/emails/pc-request.php';
    $admin_body = ob_get_clean();

    $headers = array('Content-Type: text/html; charset=UTF-8');
    $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';

    $admin_mail_sent = wp_mail( $admin_email, $subject, $admin_body, $headers );

    // Build User Auto-Responder
    $user_subject = 'We Received Your Custom PC Build Request - ' . $blog_name;
    $user_headers = array('Content-Type: text/html; charset=UTF-8');
    $user_headers[] = 'From: ' . $blog_name . ' <' . $admin_email . '>';
    
    ob_start();
    include get_template_directory() . '/template-parts/emails/pc-request-user.php';
    $user_body = ob_get_clean();

    wp_mail( $email, $user_subject, $user_body, $user_headers );

    if ( $admin_mail_sent ) {
        wp_send_json_success( 'Your request was sent successfully!' );
    } else {
        wp_send_json_error( 'Failed to send request. Please verify server email configuration.' );
    }

    wp_die();
}
