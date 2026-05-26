<?php

if (!defined('ABSPATH')) exit;

function theme_post_media($post_id) {

    $type = get_field('post_type', $post_id);

    $allowed = [
        'image',
        'video',
        'gallery',
        'slider'
    ];

    if (!in_array($type, $allowed)) {
        $type = 'image';
    }

    get_template_part(
        'inc/core/media/' . $type,
        null,
        ['post_id' => $post_id]
    );
}