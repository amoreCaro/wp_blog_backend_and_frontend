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


if (!function_exists('theme_get_post_image')) {
    function theme_get_post_image($post_id, $size = 'medium', $placeholder = '') {
        $thumbnail = get_the_post_thumbnail_url($post_id, $size);
        return $thumbnail ? $thumbnail : $placeholder;
    }
}


function theme_get_category_meta($category_id) {
	return [
		'category_bg_color' => get_field('acf_category_bg', 'category_' . $category_id),
		'cat_icon' => get_field('acf_category_icon', 'category_' . $category_id),
	];
}


function theme_build_section($category, $posts, $extra = []) {
	if (!$category || empty($posts)) return null;
	$meta = theme_get_category_meta($category->term_id);
	return array_merge([
		'posts' => $posts,
		'category_name' => $category->name,
		'category_link' => get_category_link($category->term_id),
		'category_bg_color' => $meta['category_bg_color'],
		'cat_icon' => $meta['cat_icon'],
		'is_tag' => false,
		'first_category_name' => '',
	], $extra);
}


function theme_get_posts($args) {
	$default = [
		'post_type' => 'post',
		'orderby' => 'date',
		'order' => 'DESC',
	];
	return get_posts(array_merge($default, $args));
}


function get_all_categories_object() {
    // Отримуємо всі категорії, включаючи порожні
    $categories = get_categories(array(
        'hide_empty' => false,
    ));

    return $categories;
}


$all_categories = get_all_categories_object();
?>