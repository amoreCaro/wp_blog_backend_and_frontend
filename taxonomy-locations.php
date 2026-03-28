<?php
if (!defined('ABSPATH')) exit;

$term = get_queried_object();

// Basic
$location_name = $term->name;
$location_description = $term->description;
$post_count = $term->count;

// Query
$query_args = [
    'post_type' => 'post',
    'posts_per_page' => -1,
    'tax_query' => [
        [
            'taxonomy' => 'locations',
            'field'    => 'slug',
            'terms'    => $term->slug,
        ],
    ],
];

$posts_query = new WP_Query($query_args);

$posts = [];
if ($posts_query->have_posts()) {
    while ($posts_query->have_posts()) {
        $posts_query->the_post();
        $posts[] = get_post(); 
    }
    wp_reset_postdata();
}

$total_posts = count($posts);

get_header();
?>

<div class="main-page">
    <div class="lg:pb-[100px] pb-[50px] bg-white dark:bg-black">
        <!-- BENTO GRID -->
<section class="bento-grid mx-auto bg-[#F6F5F8] dark:bg-[#0B0B0D] lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px] px-5 xl:px-10 2xl:px-0">

    <!-- HEADER -->
    <?php if (!empty($location_name)) : ?>
        <div class="flex items-center mb-12 justify-between container">
            <h2 class="text-black dark:text-white 
            text-[32px] md:text-[40px] lg:text-[48px] xl:text-[56px] 
            font-semibold tracking-tight leading-tight first-letter:uppercase">
                Found <?php echo number_format_i18n($post_count); ?> locations
            </h2>
        </div>
    <?php endif; ?>

    <?php if ($total_posts > 0 ) : ?>
    <div class="space-y-8 md:space-y-12 container">

        <?php for ($i = 0; $i < $total_posts; $i += 6) : 
            $block_posts = array_slice($posts, $i, 6);
        ?>

            <!-- ROW 1 -->
            <div class="reverse grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-10">
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

            <!-- ROW 2 -->
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

        <?php wp_reset_postdata(); ?>

    </div>
    <?php endif; ?>

</section>
    </div>
</div>

<?php get_footer(); ?>