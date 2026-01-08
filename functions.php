<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define('_S_VERSION', '1.0.0');
define('PATH', get_template_directory());
define('PATH_URL', esc_url( get_template_directory_uri()));
define('THEME', 'test-theme');

require PATH . '/inc/enqueues.php';
require PATH . '/inc/helpers.php';

add_filter('template_include', function($template) {
    if (is_page('ui-kit')) { 
        $new_template = locate_template(['page-ui-kit.php']);
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
});

function my_menu() {
    register_nav_menus([
        'header' => 'Header menu',
        'footer' => 'Footer menu',
    ]);
}
add_action("after_setup_theme", "my_menu");


// Зміна стандартного закінчення уривка на посилання Read More
add_filter('excerpt_more', function($more) {
    return '... <a href="' . get_permalink() . '" class="text-white underline hover:text-content-gray transition-colors ml-1">Read more</a>';
});

// Опціонально: встановлення довжини уривка (наприклад, 40 слів)
add_filter('excerpt_length', function($length) {
    return 40;
}, 999);