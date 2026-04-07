<?php

if (!defined('ABSPATH')) exit;

add_action('wp_ajax_register_user', 'handle_register_user');
add_action('wp_ajax_nopriv_register_user', 'handle_register_user');

function handle_register_user() {
    $nonce = $_POST['nonce'] ?? '';

    if (!wp_verify_nonce($nonce, 'register_user_action')) {
        wp_send_json_error([
            'message' => 'Invalid nonce'
        ]);
    }

    $username = (isset($_POST['username']) && !empty($_POST['username'])) ? sanitize_user($_POST['username']) : '';
    $email = (isset($_POST['email']) && !empty($_POST['email'])) ? sanitize_email($_POST['email']) : '';
    $password = $_POST['password'] ?? '';

    // Валідація
    if (empty($username)) {
        wp_send_json_error([
            'field' => 'username',
            'message' => 'Username is required'
        ]);
    }

    if (empty($email)) {
        wp_send_json_error([
            'field' => 'email',
            'message' => 'Email is required'
        ]);
    }

    if (empty($password)) {
        wp_send_json_error([
            'field' => 'password',
            'message' => 'Password is required'
        ]);
    }

    // Перевірка чи існує користувач
    if (username_exists($username)) {
        wp_send_json_error([
            'field' => 'username',
            'message' => 'Username already exists'
        ]);
    }

    if (email_exists($email)) {
        wp_send_json_error([
            'field' => 'email',
            'message' => 'Email already exists'
        ]);
    }

    $user_id = wp_insert_user([
        'user_login' => $username,
        'user_email' => $email,
        'user_pass'  => $password,
        'role'       => 'subscriber'
    ]);

    // Перевірка помилки
    if (is_wp_error($user_id)) {
        wp_send_json_error([
            'message' => $user_id->get_error_message()
        ]);
    }

    // autologin
    // wp_set_current_user($user_id);
    // wp_set_auth_cookie($user_id);

    wp_send_json_success([
        'message' => 'User created successfully',
        'user_id' => $user_id
    ]);
}