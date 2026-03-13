<?php
if (!defined('ABSPATH')) exit;

// Отримуємо секцію Bento
$bento_section = get_field('bento') ?: [];
if (empty($bento_section['bento_categories'])) return;

foreach ($bento_section['bento_categories'] as $category_index => $category_item) :

    $category = $category_item['bento_category'];
    if (!$category) continue;

    $category_id   = $category->term_id;
    $category_name = $category->name;
    $category_link = get_category_link($category_id);

    $category_svg        = get_inline_svg_category_from_acf($category_id);
    $category_bg_color   = get_field('category_bg', 'category_' . $category_id);
    $category_text_color = get_field('category_text_color', 'category_' . $category_id);
    $category_decor_type = get_field('category_decor_type', 'category_' . $category_id);

    // Bento options
    $bento_button = $category_item['bento_button'] ?? '';
    $bento_design = $category_item['bento_design'] ?? '';

    // Отримуємо останні 6 постів
    $posts_in_cat = get_posts([
        'cat' => (int) $category_id,
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_type' => 'post',
    ]);
    // posts_in_cat improve
    if (empty($posts_in_cat)) continue;

    switch ($template) {
        case "reverse":
                include PATH . '/components/bento/templates/reverse.php';
            break;
        case "default":
                include PATH . '/components/bento/templates/default.php';
            break;
        default: 
            include PATH . '/components/bento/templates/default.php';
            break;
    }
?>



<?php endforeach; ?>