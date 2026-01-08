<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function theme_register_styles() {
    // CSS
    wp_enqueue_style( 'theme-style', PATH_URL . '/assets/dist/css/main.css', [], null );
    // JS
    wp_enqueue_script( 'theme-script', PATH_URL . '/assets/dist/js/main.js', [], null, true );
    wp_enqueue_style('google-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap', [], null);
} 
add_action( 'wp_enqueue_scripts', 'theme_register_styles' );