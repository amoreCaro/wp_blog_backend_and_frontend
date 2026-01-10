<?php

if (!defined('ABSPATH')) {
    exit; 
}

function theme_menu() {
    register_nav_menus([
        'header' => 'Header menu',
        'footer' => 'Footer menu',
    ]);
}
add_action("after_setup_theme", "theme_menu");