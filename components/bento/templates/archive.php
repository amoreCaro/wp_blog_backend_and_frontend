<?php
if (!defined('ABSPATH')) exit;

global $wp_query;

$category_obj = $wp_query->get_queried_object();

if (!$category_obj || !isset($category_obj->term_id)) {
    return;
}

// Дані категорії
$category_name = $category_obj->name;

$category_bg_color   = get_field('category_bg', 'category_' . $category_obj->term_id);
$category_text_color = get_field('category_text_color', 'category_' . $category_obj->term_id);
$category_decor_type = get_field('category_decor_type', 'category_' . $category_obj->term_id);

$category_svg = function_exists('get_inline_svg_category_from_acf')
    ? get_inline_svg_category_from_acf($category_obj->term_id)
    : '';

// Пости
$posts_in_cat = $wp_query->posts;
?>

<section class="bento-grid mx-auto bg-[#F6F5F8] lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px] px-5 xl:px-10 2xl:px-0">

    <!-- HEADER -->
    <?php if (!empty($category_name)) : ?>
        <div class="flex items-center mb-12 justify-between container">
            <div class="flex items-center gap-4">

                <h2 class="text-black text-[32px] md:text-[40px] lg:text-[48px] xl:text-[56px] font-semibold tracking-tight leading-tight first-letter:uppercase">
                    <?= esc_html($category_name); ?>
                </h2>

                <?php if (!empty($category_svg)) : ?>
                    <div class="decor <?= esc_attr($category_decor_type); ?> -translate-y-1/2 w-14 h-14 flex items-center justify-center rounded-t-full rounded-br-full shadow-sm p-2"
                        style="
                            <?= $category_bg_color ? 'background-color:' . esc_attr($category_bg_color) . ';' : ''; ?>
                            <?= $category_text_color ? 'color:' . esc_attr($category_text_color) . ';' : ''; ?>
                        ">
                        <?= $category_svg; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    <?php endif; ?>

    <div class="space-y-8 md:space-y-12 container">

        <?php
        $total_posts = count($posts_in_cat);

        for ($i = 0; $i < $total_posts; $i += 6) :
            $block_posts = array_slice($posts_in_cat, $i, 6);
        ?>

            <!-- 1-й ряд -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-10">
                <?php foreach ($block_posts as $index => $post) :
                    setup_postdata($post);

                    if ($index > 1) continue;

                    if ($index === 0) {
                        include PATH . '/components/bento/elements/large-item.php';
                    } else {
                        include PATH . '/components/bento/elements/default-item.php';
                    }

                endforeach; ?>
            </div>

            <!-- 2-й ряд -->
            <?php if (count($block_posts) > 2) : ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-10 mt-6">
                    <?php foreach ($block_posts as $index => $post) :
                        if ($index < 2) continue;

                        setup_postdata($post);
                        include PATH . '/components/bento/elements/default-item.php';

                    endforeach; ?>
                </div>
            <?php endif; ?>

        <?php endfor; ?>

    </div>

</section>

<?php wp_reset_postdata(); ?>