<?php
if (!defined('ABSPATH')) exit;

global $wp_query;
$tag_obj = $wp_query->get_queried_object();

if (!$tag_obj || !isset($tag_obj->term_id)) {
    return;
}

$tag_name = $tag_obj->name;
$tag_link = get_term_link($tag_obj);

$posts_in_tag = $wp_query->posts;
?>
<?php if ( ! empty ( $posts_in_tag ) ) : ?>
<section class="bento-grid mx-auto bg-[#F6F5F8] lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px] px-5 xl:px-10 2xl:px-0">

    <!-- HEADER -->
    <?php if (!empty($tag_name)) : ?>
        <div class="flex items-center mb-12 justify-between container">
            <div class="flex items-center gap-4">

                <h2 class="text-black text-[32px] md:text-[40px] lg:text-[48px] xl:text-[56px] font-semibold tracking-tight leading-tight first-letter:uppercase">
                    <?= esc_html($tag_name); ?>
                </h2>
            </div>
        </div>
    <?php endif; ?>

    <div class="space-y-8 md:space-y-12 container">

        <?php
        $total_posts = count($posts_in_tag);

        for ($i = 0; $i < $total_posts; $i += 6) :
            $block_posts = array_slice($posts_in_tag, $i, 6);
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
<?php endif; ?>

<?php wp_reset_postdata(); ?>