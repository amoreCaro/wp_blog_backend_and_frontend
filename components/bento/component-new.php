<?php
if (!defined('ABSPATH')) exit;

$categories_to_show = [];

// --- Категорії ---
if (is_category()) {
    $current_category = get_queried_object();
    if (!($current_category instanceof WP_Term)) return;

    $category_id   = $current_category->term_id;

    // --- Пагінація ---
    $paged = max(1, get_query_var('paged'));
    $posts_per_page = 12;

    $posts_query = new WP_Query([
        'post_type'      => 'post',
        'cat'            => $category_id,
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    $posts_in_cat = $posts_query->posts;
    if (!empty($posts_in_cat)) {
        $categories_to_show[] = [
            'category'      => $current_category,
            'bento_template'=> 'single-category',
            'bento_button'  => '',
            'posts_in_cat'  => $posts_in_cat, 
        ];
    }

// --- Теги ---
} else if (is_tag()) {
    $current_tag = get_queried_object();
    if (!($current_tag instanceof WP_Term)) return;

    $tag_id   = $current_tag->term_id;
    $tag_name = $current_tag->name;
    $tag_link = get_tag_link($tag_id);

    // --- Пагінація ---
    $paged = max(1, get_query_var('paged'));
    $posts_per_page = 12;

    $posts_query = new WP_Query([
        'post_type'      => 'post',
        'tag_id'         => $tag_id,
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    $posts_in_tag = $posts_query->posts;
    if (!empty($posts_in_tag)) {
        $categories_to_show[] = [
            'category'      => $current_tag,
            'bento_template'=> 'single-tag',
            'bento_button'  => '',
            'posts_in_tag'  => $posts_in_tag,
        ];
    }

} else {
    $bento_section = get_field('bento') ?: [];
    if (!empty($bento_section['bento_categories'])) {
        foreach ($bento_section['bento_categories'] as $item) {
            $categories_to_show[] = [
                'category'      => $item['bento_category'] ?? null,
                'bento_template'=> $item['bento_template'] ?? 'default',
                'bento_button'  => $item['bento_button'] ?? '',
            ];
        }
    }
}

foreach ($categories_to_show as $category_item) :

    $category = $category_item['category'] ?? null;
    if (!$category) continue;

    $category_id   = $category->term_id;
    $category_name = $category->name;
    $category_link = is_category() ? get_category_link($category_id) : get_tag_link($category_id);

    $category_svg        = get_inline_svg_category_from_acf($category_id);
    $category_bg_color   = get_field('category_bg', 'category_' . $category_id);
    $category_text_color = get_field('category_text_color', 'category_' . $category_id);
    $category_decor_type = get_field('category_decor_type', 'category_' . $category_id);

    // Дані постів передаємо у шаблон
    if (is_category()) {
        $posts_in_cat = $category_item['posts_in_cat'] ?? [];
    } else if (is_tag()) {
        $posts_in_cat = $category_item['posts_in_tag'] ?? [];
    } else {
        $posts_in_cat = get_posts([
            'cat' => (int) $category_id,
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_type' => 'post',
        ]);
    }
    if (empty($posts_in_cat)) continue;

    // --- bento_button тільки якщо є ---
    if (isset($category_item['bento_button'])) {
        $bento_button = $category_item['bento_button'];
    } else {
        unset($bento_button);
    }

    // --- Include template ---
    switch ($category_item['bento_template']) {
        case 'single-category':
            include PATH . '/components/bento/templates/single-category.php';
            break;
        case 'single-tag':
            include PATH . '/components/bento/templates/single-tag.php';
            break;
        case 'reverse':
            include PATH . '/components/bento/templates/reverse.php';
            break;
        case 'default':
        default:
            include PATH . '/components/bento/templates/default.php';
            break;
    }

endforeach;