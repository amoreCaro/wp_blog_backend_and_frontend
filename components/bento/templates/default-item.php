<?php
if (!defined('ABSPATH')) exit;

/**
 * Цей template отримує дані з component-new.php
 * Очікує змінні:
 * $post
 * $category_id
 * $item_index
 */

if (!isset($post)) return;

setup_postdata($post);

// Дані поста
$post_id = $post->ID;

$placeholder = get_template_directory_uri() . '/assets/src/images/placeholder.png';

$title     = get_the_title($post_id);
$link      = get_permalink($post_id);
$thumbnail = get_the_post_thumbnail_url($post_id, 'large') ?: $placeholder;
$excerpt   = get_the_excerpt($post_id);
$date      = get_the_date('', $post_id);

// Дані категорії
$category_svg  = get_inline_svg_category_from_acf($category_id);
$category_name = get_cat_name($category_id);
?>

<a href="<?= esc_url($link); ?>"  
   class="group flex flex-col bg-white overflow-hidden rounded-[24px] shadow-sm w-full min-h-[450px] item-<?= esc_attr($item_index); ?>">

    <div class="h-[200px] md:h-[285px] overflow-hidden">
        <picture class="block w-full h-full">
            <img 
                data-src="<?= esc_url($thumbnail); ?>" 
                src="<?= esc_url($thumbnail); ?>" 
                alt="<?= esc_attr($title); ?>" 
                loading="lazy"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        </picture>
    </div>

    <div class="p-6 md:p-8 flex flex-col flex-grow">

        <?php if (!empty($category_name)) : ?>
            <span class="flex items-center gap-2 text-black text-[14px] font-medium capitalize px-5 py-1 rounded-full w-fit mb-4"
                style="
                    <?= !empty($category_bg_color) ? 'background-color:' . esc_attr($category_bg_color) . ';' : ''; ?>
                    <?= !empty($category_text_color) ? 'color:' . esc_attr($category_text_color) . ';' : ''; ?>
                ">

                <?php if (!empty($category_svg)) : ?>
                    <span class="w-5 h-5 flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:fill-current [&>svg]:stroke-current">
                        <?= $category_svg; ?>
                    </span>
                <?php endif; ?>

                <?= esc_html($category_name); ?>
            </span>
        <?php endif; ?>

        <?php if (!empty($title)) : ?>
            <h4 class="text-black text-lg md:text-2xl xl:text-[27px] font-semibold leading-snug mb-3">
                <?= esc_html($title); ?>
            </h4>
        <?php endif; ?>

        <?php if (!empty($excerpt)) : ?>
            <p class="text-[#373A39] text-sm lg:text-lg lg:leading-[29.3px] mb-4 line-clamp-3">
                <?= esc_html($excerpt); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($date)) : ?>
            <time class="text-black text-xs mt-auto font-bold">
                <?= esc_html($date); ?>
            </time>
        <?php endif; ?>

    </div>

</a>