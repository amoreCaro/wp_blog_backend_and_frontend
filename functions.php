<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define('_S_VERSION', '1.0.0');
define('PATH', get_template_directory());
define('PATH_URL', esc_url( get_template_directory_uri()));
define('THEME', 'test-theme');

require PATH . '/inc/enqueues.php';
require PATH . '/inc/helper.php';


add_filter('template_include', function($template) {
    if (is_page('ui-kit')) { 
        $new_template = locate_template(['page-ui-kit.php']);
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
});