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
        // дефолтне зображення
        return get_template_directory_uri() . '/assets/img/default.jpg';
    }
}