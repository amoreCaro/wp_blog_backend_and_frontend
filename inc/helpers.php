<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/** Short debug **/
if (!function_exists('dd')) {
    function dd($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}


if (!function_exists('get_post_main_image')) {
    function get_post_main_image($post_id) {
        $main_type     = get_field('acf_main_media_type', $post_id);
        $main_image_id = get_field('acf_main_image', $post_id);
        $gallery       = get_field('acf_gallery', $post_id);

        if ($main_type === 'image' && $main_image_id) {
            return wp_get_attachment_image_url($main_image_id, 'medium');
        } elseif (!empty($gallery)) {
            return wp_get_attachment_image_url($gallery[0]['acf_gallery_image_id'], 'medium');
        }
        
        return get_template_directory_uri() . '/assets/img/default.jpg';
    }
}

if (!function_exists('limit_gallery_items')) {
    function limit_gallery_items($items, $max_count = 4) {
        if (empty($items) || !is_array($items)) {
            return [];
        }
        return array_slice($items, 0, $max_count);
    }
}

if (!function_exists('get_attachment_image_no_srcset')) {
    /**
     * Get attachment image without generating srcset
     */
    function get_attachment_image_no_srcset($attachment_id, $size = 'thumbnail', $icon = false, $attr = '') {
        add_filter('wp_calculate_image_srcset_meta', '__return_null');
        $html = wp_get_attachment_image($attachment_id, $size, $icon, $attr);
        remove_filter('wp_calculate_image_srcset_meta', '__return_null');
        return $html;
    }
}

if (!function_exists('get_image')) {
    /**
     * Get image with optional width/height and lazy class
     */
    function get_image($image_id, $width_size, $height_size) {
        if (!empty($image_id)) {
            if (!empty($width_size) && !empty($height_size)) {
                return get_attachment_image_no_srcset($image_id, [$width_size, $height_size], false, ['class' => 'lazy']);
            }
            return get_attachment_image_no_srcset($image_id, 'full', false, ['class' => 'lazy']);
        }
        return false;
    }
}


if (!function_exists('image')) {
    /**
     * Echo image helper
     */
    function image($image_id, $width_size, $height_size) {
        echo get_image($image_id, $width_size, $height_size);
    }
}


if (!function_exists('render_gallery_image')) {
    function render_gallery_image($url, $alt, $wrapper_class = '', $img_class = 'w-full h-full object-cover') {
        $wrapper_class = $wrapper_class ? "overflow-hidden $wrapper_class" : 'overflow-hidden';
        echo '<div class="'.esc_attr($wrapper_class).'">';
        echo '<img data-src="'.esc_url($url).'" src="'.esc_url($url).'" alt="'.esc_attr($alt).'" class="lazy-img '.esc_attr($img_class).'">';
        echo '</div>';
    }
}