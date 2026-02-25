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

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function theme_setup() {
	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );


	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
}
add_action( 'after_setup_theme', 'theme_setup' );
if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Global Settings', // Заголовок сторінки
        'menu_title'    => 'Global Settings', // Назва в меню
        'menu_slug'     => 'global-settings', // Ваш унікальний slug
        'capability'    => 'manage_options',
        'icon_url'      => 'dashicons-admin-generic', // Ваша іконка
        'position'      => 2,                         // Позиція в меню
        'redirect'      => false                      // Не перенаправляти на підсторінки
    ));
}