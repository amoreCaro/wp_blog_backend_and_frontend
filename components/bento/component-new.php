<?php
if (!defined('ABSPATH')) exit;

// custom page => ACF template => default / reverse
// перевірка через switch 

$repeaters = get_field('bento_categories') ?? [];

foreach ($repeaters as $item) {
    $category_obj = $item['bento_category'];
    if (!$category_obj) continue;

    $template_type = $item['bento_template'];
    $posts_count = 6;

    $bento_button = $item['bento_button'];


    $category_name       = $category_obj->name;
    $category_link       = get_term_link($category_obj);
    $category_svg        = get_inline_svg_category_from_acf($category_obj->term_id);
    $category_bg_color   = get_field('category_bg', $category_obj) ?: '';
    $category_text_color = get_field('category_text_color', $category_obj) ?: '';
    $category_decor_type = get_field('category_decor_type', $category_obj) ?: 'default';
    $category_id = $category_obj->term_id;

    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    $args = [
        'post_type'      => 'post',
        'posts_per_page' => $posts_count,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'cat'            => $category_id,
    ];

    $query = new WP_Query($args);

    $posts_in_cat = $query->posts;

    if ( ! empty ( $posts_in_cat ) ) {
        switch ($template_type) {    
            case 'reverse':
                include PATH . '/components/bento/templates/reverse.php';
                break;
    
            default:
                include PATH . '/components/bento/templates/default.php';
                break;
        }
        wp_reset_postdata(); 
    }
}