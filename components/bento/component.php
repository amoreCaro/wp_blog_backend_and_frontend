<?php
if (!defined('ABSPATH')) exit;

$placeholder = get_template_directory_uri() . '/assets/src/images/placeholder.png';
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$all_sections = [];

if (is_front_page()) {

    $categories = get_categories([
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => true,
        'number' => 1
    ]);

    foreach ($categories as $category) {

        $posts = get_posts([
            'category' => $category->term_id,
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        if (empty($posts)) continue;

        $all_sections[] = [
            'posts' => $posts,
            'category_name' => $category->name,
            'category_bg_color' => get_field('acf_category_bg', 'category_' . $category->term_id),
            'cat_icon' => get_field('acf_category_icon', 'category_' . $category->term_id),
            'is_tag' => false,
        ];
    }

}
// --- BLOG PAGE: всі категорії ---
elseif (is_page('blog')) {

    $categories = get_categories([
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => true
    ]);

    foreach ($categories as $category) {
        $cat_posts = get_posts([
            'category' => $category->term_id,
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        if (empty($cat_posts)) continue;

        $all_sections[] = [
            'posts' => $cat_posts,
            'category_name' => $category->name,
            'category_bg_color' => get_field('acf_category_bg', 'category_' . $category->term_id),
            'cat_icon' => get_field('acf_category_icon', 'category_' . $category->term_id),
            'is_tag' => false,
        ];
    }

} else { 
    // --- CATEGORY або TAG ---
    $args = [
        'post_type' => 'post',
        'posts_per_page' => 12,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    if (is_category()) {
        $category = get_queried_object();
        $args['cat'] = $category->term_id;
        $posts = get_posts($args);

        $all_sections[] = [
            'posts' => $posts,
            'category_name' => $category->name,
            'category_bg_color' => get_field('acf_category_bg', 'category_' . $category->term_id),
            'cat_icon' => get_field('acf_category_icon', 'category_' . $category->term_id),
            'is_tag' => false,
        ];

    } elseif (is_tag()) {
    $tag = get_queried_object();
    $args['tag_id'] = $tag->term_id;
    $posts = get_posts($args);

    if (!empty($posts)) {
        // для items: перша категорія першого поста
        $first_post = $posts[0];
        $post_categories = get_the_category($first_post->ID);
        $first_category = !empty($post_categories) ? $post_categories[0] : null;

        $all_sections[] = [
            'posts' => $posts,
            'category_name' => $tag->name, // для заголовка <h1> беремо тег
            'category_bg_color' => $first_category ? get_field('acf_category_bg', 'category_' . $first_category->term_id) : '',
            'cat_icon' => $first_category ? get_field('acf_category_icon', 'category_' . $first_category->term_id) : '',
            'first_category_name' => $first_category ? $first_category->name : '', // для items
            'is_tag' => true,
        ];
    }
}
}

// --- Вивід секцій ---
if (!empty($all_sections)):
?>
<section class="bento-grid bg-[#F6F5F8] mx-auto lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px] px-5 xl:px-10 2xl:px-0">
    <?php foreach ($all_sections as $section): ?>

        <?php
            $posts = $section['posts'];
            $category_name = esc_html($section['category_name'] ?? '');
            $category_bg_color = esc_attr($section['category_bg_color'] ?? '');
            $cat_icon = $section['cat_icon'] ?? '';
            $is_tag = $section['is_tag'] ?? false;

            $chunks = array_chunk($posts, 6);
        ?>

        <div class="flex items-center gap-4 mb-12 container">
            <?php if (! empty ($category_name)) : ?>
            <h1 class="text-black text-[32px] md:text-[40px] lg:text-[48px] xl:text-[56px] font-semibold tracking-tight first-letter:uppercase">
                <?php echo $category_name; ?>
            </h1>
            <?php endif; ?>

            <?php if (!$is_tag && !empty($category_bg_color) && !empty($cat_icon)): ?>
                <div class="-translate-y-1/2 w-14 h-14 flex items-center justify-center rounded-t-full rounded-br-full shadow-sm" style="background-color: <?php echo $category_bg_color; ?>">
                    <?php echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class' => 'w-10 h-10 object-contain']); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="space-y-12 container">
            <?php foreach ($chunks as $chunk): ?>

                <div class="<?php if (is_front_page()) echo 'reverse'; ?> grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-10">
                    <?php foreach ($chunk as $index => $post): setup_postdata($post); ?>
                        <?php
                            $post_image = get_the_post_thumbnail_url($post->ID) ?: $placeholder;
                        ?>

                        <?php if ($index === 0): ?>
                            <!-- SMALL CARD -->
                            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="group flex flex-col bg-white rounded-[24px] shadow-sm overflow-hidden min-h-[450px]">
                                <div class="h-[200px] md:h-[285px] overflow-hidden">
                                    <img src="<?php echo esc_url($post_image); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                                </div>
                                <div class="p-6 md:p-8 flex flex-col flex-grow">
                                    <span class="flex items-center gap-2 text-[14px] font-medium px-5 py-1 rounded-full w-fit mb-4"
                                        <?php if($category_bg_color) echo 'style="background-color: '.$category_bg_color.';"'; ?>>
                                        <?php if($cat_icon) echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class'=>'w-5 h-5']); ?>
                                        <?php echo $is_tag ? esc_html($section['first_category_name']) : esc_html($category_name); ?>
                                    </span>
                                    <h4 class="text-black text-lg md:text-2xl font-semibold mb-3"><?php echo esc_html(get_the_title($post->ID)); ?></h4>
                                    <p class="text-[#373A39] text-sm lg:text-lg mb-4 line-clamp-3"><?php echo esc_html(wp_trim_words(get_the_excerpt($post->ID), 25)); ?></p>
                                    <time class="text-black text-xs font-bold mt-auto"><?php echo esc_html(get_the_date('', $post->ID)); ?></time>
                                </div>
                            </a>

                        <?php elseif ($index === 1): ?>
                            <!-- BIG CARD -->
                            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="group lg:col-span-3 bg-neutral-950 rounded-[24px] md:rounded-[32px] overflow-hidden flex flex-col lg:flex-row min-h-[680px]">
                                <div class="lg:w-[55%] h-[300px] sm:h-[400px] lg:h-auto overflow-hidden relative">
                                    <img src="<?php echo esc_url($post_image); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                                    <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-black/80 to-transparent"></div>
                                </div>
                                <div class="lg:w-[45%] p-8 md:p-12 flex flex-col text-white">
                                    <span class="border border-white/40 flex items-center gap-2 text-[14px] font-medium px-5 py-1 rounded-full w-fit mb-6">
                                        <?php if(!$is_tag && $cat_icon) echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class'=>'w-5 h-5']); ?>
                                        <?php echo !$is_tag ? esc_html($category_name) : ''; ?>
                                    </span>
                                    <h4 class="text-2xl md:text-4xl lg:text-5xl font-medium mb-6"><?php echo esc_html(get_the_title($post->ID)); ?></h4>
                                    <p class="text-[#C4C4C4] text-base md:text-lg mb-10"><?php echo esc_html(wp_trim_words(get_the_excerpt($post->ID), 35)); ?></p>
                                    <time class="text-gray-400 text-sm font-bold mt-auto"><?php echo esc_html(get_the_date('', $post->ID)); ?></time>
                                </div>
                            </a>

                        <?php else: ?>
                            <!-- REGULAR CARD -->
                            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="group flex flex-col bg-white rounded-[24px] shadow-sm overflow-hidden min-h-[450px]">
                                <div class="h-[200px] md:h-[285px] overflow-hidden">
                                    <img src="<?php echo esc_url($post_image); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                                </div>
                                <div class="p-6 md:p-8 flex flex-col flex-grow">
                                    <span class="flex items-center gap-2 text-[14px] font-medium px-5 py-1 rounded-full w-fit mb-4" <?php if(!$is_tag && $category_bg_color) echo 'style="background-color: '.$category_bg_color.';"'; ?>>
                                        <?php if(!$is_tag && $cat_icon) echo wp_get_attachment_image($cat_icon, 'thumbnail', false, ['class'=>'w-5 h-5']); ?>
                                        <?php echo !$is_tag ? $category_name : ''; ?>
                                    </span>
                                    <h4 class="text-black text-lg md:text-2xl font-semibold mb-3"><?php echo esc_html(get_the_title($post->ID)); ?></h4>
                                    <p class="text-[#373A39] text-sm lg:text-lg mb-4 line-clamp-3"><?php echo esc_html(wp_trim_words(get_the_excerpt($post->ID), 25)); ?></p>
                                    <time class="text-black text-xs font-bold mt-auto"><?php echo esc_html(get_the_date('', $post->ID)); ?></time>
                                </div>
                            </a>
                        <?php endif; ?>

                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</section>
<?php endif; ?>