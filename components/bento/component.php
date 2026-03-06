<?php
if (!defined('ABSPATH')) {
    exit;
}

$placeholder = get_template_directory_uri() . '/assets/src/images/placeholder.png';

$category = null; // для категорій
$tag      = null; // для тегів
$cat_posts = [];
$chunks    = [];
$category_name = '';
$category_bg_color = '';
$cat_icon = '';

if (is_category()) {
    $category = get_queried_object();
    $cat_posts = get_posts([
        'category' => $category->term_id,
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);

    $chunks = array_chunk($cat_posts, 6);

    $category_name = $category->name;
    $category_bg_color = esc_attr(get_field('acf_category_bg', 'category_' . $category->term_id));
    $cat_icon = get_field('acf_category_icon', 'category_' . $category->term_id);

} elseif (is_tag()) {
    $tag = get_queried_object();
    $cat_posts = get_posts([
        'tag_id' => $tag->term_id,
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);

    $chunks = array_chunk($cat_posts, 6);

    $category_name = $tag->name;
}

if (empty($cat_posts)) return;
?>

<section class="bento-grid bg-[#F6F5F8] mx-auto lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px] px-5 xl:px-10 2xl:px-0">

    <!-- Title -->
    <div class="flex items-center gap-4 mb-12 container">
        <h1 class="text-black text-[32px] md:text-[40px] lg:text-[48px] xl:text-[56px] font-semibold tracking-tight first-letter:uppercase">
            <?php echo esc_html($category_name); ?> 
        </h1>

        <?php if (!empty($category_bg_color) && !empty($cat_icon)) : ?>
        <div
            class="-translate-y-1/2 w-14 h-14 flex items-center justify-center rounded-t-full rounded-br-full shadow-sm"
            style="background-color: <?php echo esc_attr($category_bg_color); ?>"
        >
            <?php
                echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class' => 'w-10 h-10 object-contain']);
            ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="space-y-12 container">

        <!-- =======================
             Блоки по 6 постів
             ======================= -->
        <?php if (!empty($chunks)) : ?>
            <?php foreach ($chunks as $chunk) : ?>
                <div class="reverse grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-10">
                    <?php foreach ($chunk as $index => $post) : setup_postdata($post); ?>
                        <?php $post_image = theme_get_post_image(get_the_ID(), ($index === 0 ? 'large' : 'medium'), $placeholder); ?>

                        <?php if ($index === 0) : ?>
                        <!-- SMALL CARD -->
                        <a href="<?php echo esc_url(get_permalink()); ?>"
                           class="group flex flex-col bg-white rounded-[24px] shadow-sm overflow-hidden min-h-[450px]">

                            <div class="h-[200px] md:h-[285px] overflow-hidden">
                                <img src="<?php echo esc_url($post_image); ?>"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                     alt="<?php echo esc_attr(get_the_title()); ?>">
                            </div>

                            <div class="p-6 md:p-8 flex flex-col flex-grow">
                                <span
                                    class="flex items-center gap-2 text-[14px] font-medium px-5 py-1 rounded-full w-fit mb-4"
                                    style="background-color: <?php echo esc_attr($category_bg_color); ?>"
                                >
                                    <?php
                                        echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class' => 'w-5 h-5']);
                                 echo esc_html($category_name); 
                                    ?>
                                </span>

                                <h4 class="text-black text-lg md:text-2xl font-semibold mb-3"><?php echo esc_html(get_the_title()); ?></h4>
                                <p class="text-[#373A39] text-sm lg:text-lg mb-4 line-clamp-3">
                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 25)); ?>
                                </p>
                                <time class="text-black text-xs font-bold mt-auto"><?php echo esc_html(get_the_date()); ?></time>
                            </div>
                        </a>

                        <?php elseif ($index === 1) : ?>
                        <!-- BIG CARD -->
                        <a href="<?php echo esc_url(get_permalink()); ?>"
                           class="group lg:col-span-3 bg-neutral-950 rounded-[24px] md:rounded-[32px] overflow-hidden flex flex-col lg:flex-row min-h-[680px]">

                            <div class="lg:w-[55%] h-[300px] sm:h-[400px] lg:h-auto overflow-hidden relative">
                                <img src="<?php echo esc_url($post_image); ?>"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                     alt="<?php echo esc_attr(get_the_title()); ?>">

                                <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-black/80 to-transparent"></div>
                            </div>

                            <div class="lg:w-[45%] p-8 md:p-12 flex flex-col text-white">
                                <span class="border border-white/40 flex items-center gap-2 text-[14px] font-medium px-5 py-1 rounded-full w-fit mb-6">
                                    <?php
                                        echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class' => 'w-5 h-5']);
                                        echo esc_html($category->name); 
                                    ?>
                                </span>

                                <h4 class="text-2xl md:text-4xl lg:text-5xl font-medium mb-6"><?php echo esc_html(get_the_title()); ?></h4>
                                <p class="text-[#C4C4C4] text-base md:text-lg mb-10">
                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 35)); ?>
                                </p>
                                <time class="text-gray-400 text-sm font-bold mt-auto"><?php echo esc_html(get_the_date()); ?></time>
                            </div>
                        </a>

                        <?php else : ?>
                        <!-- REGULAR CARD -->
                        <a href="<?php echo esc_url(get_permalink()); ?>"
                           class="group flex flex-col bg-white rounded-[24px] shadow-sm overflow-hidden min-h-[450px]">

                            <div class="h-[200px] md:h-[285px] overflow-hidden">
                                <img src="<?php echo esc_url($post_image); ?>"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                     alt="<?php echo esc_attr(get_the_title()); ?>">
                            </div>

                            <div class="p-6 md:p-8 flex flex-col flex-grow">
                                <span
                                    class="flex items-center gap-2 text-[14px] font-medium px-5 py-1 rounded-full w-fit mb-4"
                                    style="background-color: <?php echo esc_attr($category_bg_color); ?>"
                                >
                                    <?php
                                        echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class' => 'w-5 h-5']);
                                        echo esc_html($category->name); 
                                    ?>
                                </span>

                                <h4 class="text-black text-lg md:text-2xl font-semibold mb-3"><?php echo esc_html(get_the_title()); ?></h4>
                                <p class="text-[#373A39] text-sm lg:text-lg mb-4 line-clamp-3">
                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 25)); ?>
                                </p>
                                <time class="text-black text-xs font-bold mt-auto"><?php echo esc_html(get_the_date()); ?></time>
                            </div>
                        </a>
                        <?php endif; ?>

                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>