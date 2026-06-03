<?php
if (!defined('ABSPATH')) exit;

if (!isset($post)) return;

setup_postdata($post);

// Дані поста
$post_id     = $post->ID;
$placeholder = get_template_directory_uri() . '/assets/src/images/placeholder.png';

$title      = get_the_title($post_id);
$link       = get_permalink($post_id);
$thumbnail  = get_the_post_thumbnail_url($post_id, 'large') ?: $placeholder;
$excerpt    = get_the_excerpt($post_id);
$date       = get_the_date('', $post_id);

// Дані категорії
$categories = get_the_category($post_id);
$category_id = !empty($categories) ? $categories[0]->term_id : null;
$category_svg  = get_inline_svg_category_from_acf($category_id);
$category_name = get_cat_name($category_id);

$avatar_url = get_avatar_url($author_id, ['size' => 28]);
$username = get_the_author_meta('display_name', $author_id);
?>

<a href="<?php echo esc_url($link); ?>" 
   class="group lg:col-span-3 bg-white dark:bg-[#121216] rounded-[24px] md:rounded-[32px] overflow-hidden flex flex-col lg:flex-row lg:min-h-[280px]">

    <div class="h-[300px] sm:h-[350px] lg:h-auto lg:w-[55%] overflow-hidden relative">
        <?php if (!empty($category_name)) : ?>
            <span class="top-4 left-4 z-10 absolute flex items-center gap-2 text-[12px] leading-[16px] font-medium capitalize px-5 py-1 rounded-full w-fit mb-4
                <?php echo $has_custom_style ? '' : 'border border-black dark:border-white text-black dark:text-white'; ?>"
            style="
                <?php if (!empty($category_bg_color)) echo 'background-color:' . esc_attr($category_bg_color) . ';'; ?>
                <?php if (!empty($category_text_color)) echo 'color:' . esc_attr($category_text_color) . ';'; ?>
            ">

                <?php if (!empty($category_svg)) : ?>
                    <span class="w-5 h-5 flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:fill-current [&>svg]:stroke-current">
                        <?php echo $category_svg; ?>
                    </span>
                <?php endif; ?>

                <?php echo esc_html($category_name); ?>
            </span>
        <?php endif; ?>
        <picture class="block w-full h-full">
            <img 
                data-src="<?php echo esc_url($thumbnail); ?>" 
                src="<?php echo esc_url($thumbnail); ?>" 
                alt="<?php echo esc_attr($title); ?>" 
                loading="lazy"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            >
        </picture>

        <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-black/20 lg:from-black/10">
        </div>
    </div>

    <div class="lg:w-[45%] p-8 md:p-12 lg:p-12 flex flex-col text-black relative min-h-[300px] md:h-full">
        <div class="flex flex-col">
            <div class="flex items-center mb-4">
                <?php if ( $avatar_url ) : ?>
                    <div class="post__author-name-img mr-2">
                        <picture class="block w-full h-full">
                            <img 
                                src="data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23cccccc'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E" 
                                data-src="<?php echo esc_url($avatar_url); ?>" 
                                alt="<?php echo esc_attr($display_name); ?>" 
                                width="28" 
                                height="28" 
                                loading="lazy" 
                                decoding="async"
                                class="lazy-img w-[28px] h-[28px] rounded-full object-cover bg-[#f5f5f5]"
                            >
                        </picture>
                    </div>
                <?php endif; ?>
                <?php if ( $username ) : ?>
                    <span class="block font-medium capitalize text-[12px] leading-[12px] text-[#404040] hover:text-black dark:text-[#d4d4d8] dark:hover:text-white">
                        <?php echo esc_html( $username ); ?>
                    </span>
                <?php endif; ?>
                <?php if (!empty($date)) : ?>
                    <span class="mx-[6px] font-medium text-[#6C7280] dark:text-[#9DA3AF]">·</span>
                    <time class="font-normal text-[12px] leading-[12px] text-[#6C7280] dark:text-[#9DA3AF]">
                        <?php echo esc_html($date); ?>
                    </time>
                <?php endif; ?>
            </div>
            <?php if (!empty($title)) : ?>
                <h4 style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" class="text-black dark:text-white text-[24px] font-semibold leading-[32px] mb-3">
                    <?php echo esc_html($title); ?>
                </h4>
            <?php endif; ?>
            <?php if (!empty($excerpt)) : ?>
                <p style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"  class="text-[#373A39] dark:text-[#C4C4C4] text-[16px] leading-[24px] mb-4">
                    <?php echo esc_html($excerpt); ?>
                </p>
            <?php endif; ?>
        </div>


    </div>

</a>