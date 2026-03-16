<?php
if (!defined('ABSPATH')) exit;

/*
|--------------------------------------------------------------------------
| Current category
|--------------------------------------------------------------------------
*/

$category = get_queried_object();
if (!$category instanceof WP_Term) return;

$category_id   = $category->term_id;
$category_name = $category->name;
$category_link = get_category_link($category_id);

/*
|--------------------------------------------------------------------------
| Category ACF fields
|--------------------------------------------------------------------------
*/

$category_svg        = get_inline_svg_category_from_acf($category_id);
$category_bg_color   = get_field('category_bg', 'category_' . $category_id);
$category_text_color = get_field('category_text_color', 'category_' . $category_id);
$category_decor_type = get_field('category_decor_type', 'category_' . $category_id);

/*
|--------------------------------------------------------------------------
| Get posts from current category with pagination
|--------------------------------------------------------------------------
*/

$paged = max(1, get_query_var('paged')); // поточна сторінка
$posts_per_page = 12;

$posts_query = new WP_Query([
    'post_type' => 'post',
    'cat' => $category_id,
    'posts_per_page' => $posts_per_page,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC'
]);

$posts_in_cat = $posts_query->posts;

if (empty($posts_in_cat)) return;
?>

<section class="bento-grid mx-auto bg-[#F6F5F8] lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px] px-5 xl:px-10 2xl:px-0">

    <!-- HEADER -->
    <div class="flex items-center mb-12 justify-between container">
        <div class="flex items-center gap-4">
            <?php if ($category_name) : ?>
                <h2 class="text-black text-[32px] md:text-[40px] lg:text-[48px] xl:text-[56px] font-semibold tracking-tight leading-tight first-letter:uppercase">
                    <?= esc_html($category_name); ?>
                </h2>
            <?php endif; ?>

            <?php if ($category_svg) : ?>
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

    <div class="space-y-8 md:space-y-12 container">

        <?php
        $total_posts = count($posts_in_cat);

        for ($i = 0; $i < $total_posts; $i += 6) :
            $block_posts = array_slice($posts_in_cat, $i, 6);
        ?>

            <!-- FIRST TWO (BIG + SMALL) -->
            <div class="reverse grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-10">
                <?php foreach ($block_posts as $index => $post) :
                    setup_postdata($post);

                    if ($index > 1) continue;

                    $item_index = $index;

                    if ($index === 0) {
                        include PATH . '/components/bento/templates/large-item.php';
                    } else {
                        include PATH . '/components/bento/templates/default-item.php';
                    }

                endforeach; ?>
            </div>

            <!-- NEXT FOUR IN GRID -->
            <?php if (count($block_posts) > 2) : ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-10 mt-6">
                    <?php foreach ($block_posts as $index => $post) :
                        if ($index < 2) continue;
                        setup_postdata($post);
                        $item_index = $i + $index;
                        include PATH . '/components/bento/templates/default-item.php';
                    endforeach; ?>
                </div>
            <?php endif; ?>

        <?php endfor; ?>


    </div>

</section>

<?php wp_reset_postdata(); ?>