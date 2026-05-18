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

add_action('admin_enqueue_scripts', function ($hook) {

    if ($hook !== 'toplevel_page_api-sync') return;

    wp_enqueue_script(
        'api',
        get_template_directory_uri() . '/assets/src/js/components/api.js',
        [],
        null,
        true
    );

    wp_localize_script('api', 'apiSyncData', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('theme_nonce'),
    ]);
});


add_filter('script_loader_tag', function ($tag, $handle) {

    if ($handle === 'api') {
        return str_replace('<script ', '<script type="module" ', $tag);
    }

    return $tag;

}, 10, 2);