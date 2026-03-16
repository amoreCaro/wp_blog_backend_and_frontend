<?php
if (!defined('ABSPATH')) exit;

/*
|--------------------------------------------------------------------------
| Categories source
|--------------------------------------------------------------------------
*/

if (is_category()) {

    // Поточна категорія
    $current_category = get_queried_object();

    if (!($current_category instanceof WP_Term)) return;

    $categories_to_show = [
        [
            'bento_category' => $current_category,
            'bento_template' => 'single-category'
        ]
    ];

} else {

    // ACF Bento
    $bento_section = get_field('bento') ?: [];

    if (empty($bento_section['bento_categories'])) return;

    $categories_to_show = $bento_section['bento_categories'];
}


/*
|--------------------------------------------------------------------------
| Loop categories
|--------------------------------------------------------------------------
*/

foreach ($categories_to_show as $category_index => $category_item) :

    $category = $category_item['bento_category'] ?? null;
    if (!$category) continue;

    $category_id   = $category->term_id;
    $category_name = $category->name;
    $category_link = get_category_link($category_id);

    /*
    |--------------------------------------------------------------------------
    | Category ACF
    |--------------------------------------------------------------------------
    */

    $category_svg        = get_inline_svg_category_from_acf($category_id);
    $category_bg_color   = get_field('category_bg', 'category_' . $category_id);
    $category_text_color = get_field('category_text_color', 'category_' . $category_id);
    $category_decor_type = get_field('category_decor_type', 'category_' . $category_id);


    /*
    |--------------------------------------------------------------------------
    | Bento options
    |--------------------------------------------------------------------------
    */

    $bento_button   = $category_item['bento_button'] ?? '';
    $bento_template = $category_item['bento_template'] ?? 'default';


    /*
    |--------------------------------------------------------------------------
    | Posts
    |--------------------------------------------------------------------------
    */

    if (is_category()) {

        // використовуємо WordPress main query
        global $wp_query;
        $posts_in_cat = $wp_query->posts;

    } else {

        // для Bento показуємо тільки 6 постів
        $posts_in_cat = get_posts([
            'cat' => (int) $category_id,
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_type' => 'post',
        ]);
    }

    if (empty($posts_in_cat)) continue;


    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    */

    if (is_category()) {

        include PATH . '/components/bento/templates/single-category.php';

    } else {

        switch ($bento_template) {

            case "reverse":
                include PATH . '/components/bento/templates/reverse.php';
                break;

            case "default":
            default:
                include PATH . '/components/bento/templates/default.php';
                break;
        }

    }

endforeach;
?>