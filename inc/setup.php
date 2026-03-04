<?php

// Security: no direct access
if ( ! defined('ABSPATH') ) {
    exit;
}

/* -------------------------------------------------
 * Theme setup
 * ------------------------------------------------- */

if ( ! function_exists('theme_setup') ) {
    function theme_setup() {

        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable post thumbnails
        add_theme_support('post-thumbnails');

        // Enable HTML5 markup
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            ]
        );
    }
}
add_action('after_setup_theme', 'theme_setup');


/* -------------------------------------------------
 * Navigation menus
 * ------------------------------------------------- */

if ( ! function_exists('theme_register_menus') ) {
    function theme_register_menus() {
        register_nav_menus([
            'header_menu' => __('Header Menu', 'theme'),
            'footer_menu' => __('Footer Menu', 'theme'),
        ]);
    }
}
add_action('after_setup_theme', 'theme_register_menus');


/* -------------------------------------------------
 * ACF Options Page
 * ------------------------------------------------- */

if ( function_exists('acf_add_options_page') ) {
    acf_add_options_page([
        'page_title' => 'Global Settings',
        'menu_title' => 'Global Settings',
        'menu_slug'  => 'global-settings',
        'capability' => 'manage_options',
        'icon_url'   => 'dashicons-admin-generic',
        'position'   => 2,
        'redirect'   => false,
    ]);
}

/* -------------------------------------------------
 * Locations taxonomy
 * ------------------------------------------------- */

if ( ! function_exists('theme_register_locations_taxonomy') ) {
    function theme_register_locations_taxonomy() {
        $labels = [
            'name'              => 'Locations',
            'singular_name'     => 'Location',
            'search_items'      => 'Search Locations',
            'all_items'         => 'All Locations',
            'parent_item'       => 'Parent Location',
            'parent_item_colon' => 'Parent Location:',
            'edit_item'         => 'Edit Location',
            'update_item'       => 'Update Location',
            'add_new_item'      => 'Add New Location',
            'new_item_name'     => 'New Location Name',
            'menu_name'         => 'Locations',
        ];

        $args = [
            'labels'            => $labels,
            'public'            => true,
            'hierarchical'      => true, // Працює як категорії (checkboxes)
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_in_rest'      => true, // Обов'язково для Gutenberg
            'rewrite'           => ['slug' => 'location'],
        ];

        register_taxonomy('locations', ['post'], $args);
    }
}
add_action('init', 'theme_register_locations_taxonomy');