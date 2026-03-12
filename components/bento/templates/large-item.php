<?php
if (!defined('ABSPATH')) exit;

/**
 * Перевірка category_id
 */
if (!isset($category_id) || empty($category_id)) return;

/**
 * Отримуємо останній пост у категорії
 */
$posts_in_cat = get_posts([
    'cat' => (int) $category_id,
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC'
]);


if (empty($posts_in_cat) || !isset($posts_in_cat[0])) return;

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

<a href="<?php echo esc_url($link); ?>" 
   class="order-2 group lg:col-span-3 bg-neutral-950 rounded-[24px] md:rounded-[32px] overflow-hidden flex flex-col lg:flex-row lg:min-h-[680px]">

    <div class="h-[300px] sm:h-[400px] lg:h-auto lg:w-[55%] overflow-hidden relative">
        <picture class="block w-full h-full">
            <img 
                src="<?php echo esc_url($thumbnail); ?>" 
                alt="<?php echo esc_attr($title); ?>" 
                loading="lazy"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            >
        </picture>

        <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-black/80 lg:from-black/60 to-transparent z-10"></div>
    </div>

    <div class="lg:w-[45%] p-8 md:p-12 lg:p-12 flex flex-col text-white relative h-full">

        <?php if (!empty($category_name)) : ?>
        <span class="border border-white/40 flex items-center gap-2 text-white text-[14px] font-medium capitalize px-5 py-1 rounded-full w-fit mb-6">

            <?php if (!empty($category_svg)) : ?>
                <span class="w-5 h-5 flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:fill-current [&>svg]:stroke-current">
                    <?php
                        $svg = $category_svg;

                        // Замінюємо fill/stroke на currentColor
                        $svg = preg_replace('/fill=".*?"/', 'fill="currentColor"', $svg);
                        $svg = preg_replace('/stroke=".*?"/', 'stroke="currentColor"', $svg);

                        // Додаємо width/height якщо немає
                        if (!preg_match('/width="/', $svg)) {
                            $svg = str_replace('<svg', '<svg width="20" height="20"', $svg);
                        }

                        echo $svg;
                    ?>
                </span>
            <?php endif; ?>

            <?php echo esc_html($category_name); ?>

        </span>
        <?php endif; ?>

        <?php if (!empty($title)) : ?>
            <h4 class="text-2xl md:text-4xl lg:text-5xl font-medium leading-[1.15] mb-6">
                <?php echo esc_html($title); ?>
            </h4>
        <?php endif; ?>

        <?php if (!empty($excerpt)) : ?>
            <p class="text-[#C4C4C4] text-base md:text-[18px] lg:text-[20px] leading-relaxed mb-10 font-light">
                <?php echo esc_html($excerpt); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($date)) : ?>
            <time class="text-gray-400 text-sm font-bold mt-auto">
                <?php echo esc_html($date); ?>
            </time>
        <?php endif; ?>

    </div>
</a>

<?php wp_reset_postdata(); ?>