<?php
if (!defined('ABSPATH')) {
    exit;
}

// Placeholder image
$placeholder = get_template_directory_uri() . '/assets/src/images/placeholder.png';

// Функція для отримання зображення поста або placeholder
function theme_get_post_image($post_id, $size = 'medium', $placeholder = '') {
    $thumbnail = get_the_post_thumbnail_url($post_id, $size);
    return $thumbnail ? $thumbnail : $placeholder;
}

// Отримати всі категорії
$categories = get_categories([
    'orderby' => 'name',
    'order'   => 'ASC',
]);

if (empty($categories)) return;

// Знаходимо першу категорію, яка має пости
$cat = null;
$cat_posts = [];
foreach ($categories as $category) {
    $posts = get_posts([
        'category'       => $category->term_id,
        'posts_per_page' => 6,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    if (!empty($posts)) {
        $cat = $category;
        $cat_posts = $posts;
        break; // знайшли першу категорію з постами — виходимо з циклу
    }
}

// Якщо немає жодної категорії з постами, виходимо
if (!$cat || empty($cat_posts)) return;

// Перевірка кольору категорії
$category_bg_color = esc_attr(get_field('acf_category_bg', 'category_' . $cat->term_id));

// ACF category icon
$cat_icon = get_field('acf_category_icon', 'category_' . $cat->term_id);
?>

<section class="bento-grid bg-[#F6F5F8] mx-auto lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px] px-5 xl:px-10 2xl:px-0">

    <!-- Title -->
    <div class="flex items-center gap-4 mb-12 container">
        <h1 class="text-black text-[32px] md:text-[40px] lg:text-[48px] xl:text-[56px] font-semibold tracking-tight first-letter:uppercase">
            <?php echo isset($cat->name) ? esc_html($cat->name) : ''; ?>
        </h1>

        <?php if (!empty($category_bg_color)) : ?>
        <div
            class="-translate-y-1/2 w-14 h-14 flex items-center justify-center rounded-t-full rounded-br-full shadow-sm"
            style="background-color: <?php echo esc_attr($category_bg_color); ?>"
        >
            <?php
                if (!empty($cat_icon)) {
                    echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class' => 'w-10 h-10 object-contain']);
                }
            ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="space-y-12 container">

        <!-- FIRST TWO POSTS -->
        <?php if (!empty($cat_posts) && count($cat_posts) >= 2) : ?>
        <div class="reverse grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-10">

            <?php foreach (array_slice($cat_posts, 0, 2) as $index => $post) : setup_postdata($post); ?>
                <?php $post_image = theme_get_post_image(get_the_ID(), 'large', $placeholder); ?>

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
                                if (!empty($cat_icon)) {
                                    echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class' => 'w-5 h-5']);
                                }
                                echo isset($cat->name) ? esc_html($cat->name) : '';
                            ?>
                        </span>

                        <h4 class="text-black text-lg md:text-2xl font-semibold mb-3"><?php echo esc_html(get_the_title()); ?></h4>
                        <p class="text-[#373A39] text-sm lg:text-lg mb-4 line-clamp-3">
                            <?php echo esc_html(wp_trim_words(get_the_excerpt(), 25)); ?>
                        </p>
                        <time class="text-black text-xs font-bold mt-auto"><?php echo esc_html(get_the_date()); ?></time>
                    </div>
                </a>

                <?php else : ?>
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
                                if (!empty($cat_icon)) {
                                    echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class' => 'w-5 h-5']);
                                }
                                echo isset($cat->name) ? esc_html($cat->name) : '';
                            ?>
                        </span>

                        <h4 class="text-2xl md:text-4xl lg:text-5xl font-medium mb-6"><?php echo esc_html(get_the_title()); ?></h4>
                        <p class="text-[#C4C4C4] text-base md:text-lg mb-10">
                            <?php echo esc_html(wp_trim_words(get_the_excerpt(), 35)); ?>
                        </p>
                        <time class="text-gray-400 text-sm font-bold mt-auto"><?php echo esc_html(get_the_date()); ?></time>
                    </div>
                </a>
                <?php endif; ?>

            <?php endforeach; wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>

        <!-- OTHER POSTS -->
        <?php if (!empty($cat_posts) && count($cat_posts) > 2) : ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-10">

            <?php foreach (array_slice($cat_posts, 2) as $post) : setup_postdata($post); ?>
                <?php $post_image = theme_get_post_image(get_the_ID(), 'medium', $placeholder); ?>

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
                                if (!empty($cat_icon)) {
                                    echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class' => 'w-5 h-5']);
                                }
                                echo isset($cat->name) ? esc_html($cat->name) : '';
                            ?>
                        </span>

                        <h4 class="text-black text-lg md:text-2xl font-semibold mb-3"><?php echo esc_html(get_the_title()); ?></h4>
                        <p class="text-[#373A39] text-sm lg:text-lg mb-4 line-clamp-3">
                            <?php echo esc_html(wp_trim_words(get_the_excerpt(), 25)); ?>
                        </p>
                        <time class="text-black text-xs font-bold mt-auto"><?php echo esc_html(get_the_date()); ?></time>
                    </div>
                </a>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>
    </div>
</section>