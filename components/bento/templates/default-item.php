<?php
if (!defined('ABSPATH')) exit;

if (!isset($category_id) || empty($category_id)) return;

/**
 * Отримуємо останній пост у категорії
 */
$posts_in_cat = get_posts([
    'cat' => (int) $category_id,
    'posts_per_page' => 5,
    'orderby' => 'date',
    'order' => 'DESC'
]);


$post = $posts_in_cat[0];
setup_postdata($post);

// Post data
$post_id = get_the_ID();

$placeholder = get_template_directory_uri() . '/assets/src/images/placeholder.png';

$title = get_the_title($post_id);
$link = get_permalink($post_id);

$thumbnail = get_the_post_thumbnail_url($post_id, 'large');
$thumbnail = $thumbnail ? $thumbnail : $placeholder;

$excerpt = get_the_excerpt($post_id);
$date = get_the_date('', $post_id);

/**
 * Category data
 */
$category_svg = get_term_meta($category_id, 'category_icon_svg', true);
$category_name = get_cat_name($category_id);
?>
<a href="#" class="order-1 group flex flex-col bg-white overflow-hidden rounded-[24px] shadow-sm w-full min-h-[450px]">
    <div class="h-[200px] md:h-[285px] overflow-hidden">
        <picture class="block w-full h-full">
            <img src="./images/pasta.jpg" alt="Food" loading="lazy"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        </picture>
    </div>
    
    <div class="p-6 md:p-8 flex flex-col flex-grow">
        <span class="bg-[#FDF0D0] flex items-center gap-2 text-black text-[14px] font-medium capitalize px-5 py-1 rounded-full w-fit mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>
            </svg>
            Where to eat
        </span>

        <h4 class="text-black text-lg md:text-2xl xl:text-[27px] font-semibold leading-snug mb-3">
            <?php echo $title; ?>
        </h4>

        <p class="text-[#373A39] text-sm lg:text-lg lg:leading-[29.3px] mb-4 line-clamp-3">
            Calling all foodies! Explore the ultimate dining hotspots in San Francisco, handpicked for serious culinary enthusiasts who crave authentic flavors.
        </p>

        <time class="text-black text-xs mt-auto font-bold" datetime="2024-03-08">Mar 8, 2024</time>
    </div>
</a>