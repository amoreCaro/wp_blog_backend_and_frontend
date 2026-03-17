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


if (!function_exists('render_decor_image')) {
    function render_decor_image($images, $index) {
        if (empty($images[$index])) return;

        $img = $images[$index];

        // Додаткова перевірка, чи є src
        if (empty($img['sizes']['medium'])) return;
        ?>
        <img
            src="<?php echo esc_url($img['sizes']['medium']); ?>"
            data-src="<?php echo esc_url($img['sizes']['medium']); ?>"
            alt="<?php echo esc_attr($img['alt'] ?? ''); ?>"
            class="lazy-img object-cover w-full h-full"
            loading="lazy"
        >
        <?php
    }
}


if (!function_exists('get_post_image_url')) {
    // Функція для отримання зображення поста
    function get_post_image_url($post_id, $placeholder) {
        // 1. Перевірка thumbnail
        if ( has_post_thumbnail( $post_id ) ) {
            return get_the_post_thumbnail_url( $post_id, 'large' );
        }

        // 2. Перевірка repeater галереї ACF
        $gallery = get_field('acf_gallery', $post_id);
        if ( ! empty($gallery) && is_array($gallery) ) {
            $first_image_id = $gallery[0]['acf_image'] ?? null;
            if ( $first_image_id ) {
                return wp_get_attachment_image_url( $first_image_id, 'large' );
            }
        }

        // 3. Placeholder
        return esc_url($placeholder);
    }
}


if (!function_exists('get_inline_svg_from_acf')) {
    function get_inline_svg_from_acf($menu_item_id, $field = 'acf_navigation_icon') {
        $icon = get_field($field, $menu_item_id);
        if (!$icon) return '';

        $icon_url = is_array($icon) ? ($icon['url'] ?? '') : $icon;
        if (!$icon_url) return '';

        $attachment_id = attachment_url_to_postid($icon_url);
        $svg_path = $attachment_id ? get_attached_file($attachment_id) : '';

        if (
            $svg_path &&
            file_exists($svg_path) &&
            pathinfo($svg_path, PATHINFO_EXTENSION) === 'svg'
        ) {
            $svg = file_get_contents($svg_path);

            return preg_replace(
                '/<svg([^>]*)>/',
                '<svg$1 class="w-4 h-4 fill-current">',
                $svg,
                1
            );
        }

        return '';
    }

}

if (!function_exists('get_inline_svg_category_from_acf')) {
    function get_inline_svg_category_from_acf($term_id, $field = 'category_icon', $width = 50, $height = 50) {

        // Отримуємо ID SVG з ACF поля
        $icon_id = get_field($field, 'category_' . $term_id);
        if (!$icon_id) return '';

        // Шлях до файлу SVG
        $svg_path = get_attached_file($icon_id);

        if (
            $svg_path &&
            file_exists($svg_path) &&
            pathinfo($svg_path, PATHINFO_EXTENSION) === 'svg'
        ) {

            $svg = file_get_contents($svg_path);

            // Замінюємо fill та stroke на currentColor
            $svg = preg_replace('/fill=".*?"/', 'fill="currentColor"', $svg);
            $svg = preg_replace('/stroke=".*?"/', 'stroke="currentColor"', $svg);

            // Додаємо width та height, якщо їх ще немає
            if (!preg_match('/width="/', $svg)) {
                $svg = preg_replace('/<svg([^>]*)>/', '<svg$1 width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" class="fill-current">', $svg, 1);
            } else {
                // Якщо width/height вже є, додаємо тільки клас
                $svg = preg_replace('/<svg([^>]*)>/', '<svg$1 class="fill-current">', $svg, 1);
            }

            return $svg;
        }

        return '';
    }
}


if (!function_exists('get_inline_svg_social_icons_from_acf')) {

    function get_inline_svg_social_icons_from_acf($icon_id, $width = 32, $height = 32) {

        if (!$icon_id) return '';

        $svg_path = get_attached_file($icon_id);

        if (
            $svg_path &&
            file_exists($svg_path) &&
            pathinfo($svg_path, PATHINFO_EXTENSION) === 'svg'
        ) {

            $svg = file_get_contents($svg_path);

            // Заміна кольорів
            $svg = preg_replace('/fill=".*?"/', 'fill="currentColor"', $svg);
            $svg = preg_replace('/stroke=".*?"/', 'stroke="currentColor"', $svg);

            // ❗ ВИДАЛЯЄМО старі width/height
            $svg = preg_replace('/\swidth=".*?"/', '', $svg);
            $svg = preg_replace('/\sheight=".*?"/', '', $svg);

            // ❗ ДОДАЄМО свої
            $svg = preg_replace(
                '/<svg([^>]*)>/',
                '<svg$1 width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" class="fill-current">',
                $svg,
                1
            );

            return $svg;
        }

        return '';
    }
}

if (!function_exists('theme_get_post_image')) {
    function theme_get_post_image($post_id, $size = 'medium', $placeholder = '') {
        $thumbnail = get_the_post_thumbnail_url($post_id, $size);
        return $thumbnail ? $thumbnail : $placeholder;
    }
}


/*
|--------------------------------------------------------------------------
| Get posts from one category
|--------------------------------------------------------------------------
*/

function get_posts_from_category(int $category_id, int $limit = 6): array
{
    return get_posts([
        'cat'            => $category_id,
        'posts_per_page' => $limit,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_type'      => 'post',
    ]) ?: [];
}

/*
|--------------------------------------------------------------------------
| Get posts from multiple categories
|--------------------------------------------------------------------------
*/

function get_posts_from_categories(array $categories, int $limit = 6): array
{
    $result = [];

    foreach ($categories as $category_item) {

        $category = $category_item['bento_category'] ?? null;

        if (!($category instanceof WP_Term)) {
            continue;
        }

        $result[$category->term_id] = get_posts_from_category(
            $category->term_id,
            $limit
        );
    }

    return $result;
}