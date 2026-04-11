<?php

if (!defined('ABSPATH')) {
    exit;
}

function theme_register_styles()
{
    // CSS
    wp_enqueue_style(
        'theme-style',
        PATH_URL . '/assets/dist/css/main.css',
        [],
        null
    );

    wp_enqueue_style(
        'google-roboto',
        'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap',
        [],
        null
    );

    // JS
    wp_enqueue_script(
        'theme-script',
        PATH_URL . '/assets/dist/js/main.js',
        [],
        null,
        true
    );

    wp_localize_script(
        'theme-script',
        'theme',
        [
            'ajax_url'        => admin_url('admin-ajax.php'),
            'nonce_register'  => wp_create_nonce('register_user_nonce'),
            'nonce_login'     => wp_create_nonce('login_user_nonce'),
        ]
    );
}

add_action('wp_enqueue_scripts', 'theme_register_styles');