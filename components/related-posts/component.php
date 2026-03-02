<?php
if (!defined('ABSPATH')) {
    exit;
}

// Placeholder image
$placeholder = get_template_directory_uri() . '/assets/dist/images/placeholder.png';

// Отримуємо пов'язані пости
$related_posts = get_posts(array(
    'category__in' => wp_get_post_categories(get_the_ID()),
    'numberposts'  => 5,
    'post__not_in' => array(get_the_ID())
));

if (empty($related_posts)) return;
?>

<section class="related-posts py-12 lg:py-[100px]">
    <div class="container mx-auto px-5 xl:px-[40px] 2xl:px-0">

        <h2 class="text-white text-3xl md:text-5xl font-medium mb-12">
            <?php _e("Related Posts", THEME); ?>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">

            <?php foreach ($related_posts as $index => $post) : setup_postdata($post); ?>
                <?php
                // Беремо thumbnail або перший attachment як fallback
                $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'medium');

                if (!$thumbnail_url) {
                    // Спроба взяти перше зображення з галереї/прикріплень
                    $attachments = get_attached_media('image', $post->ID);
                    if (!empty($attachments)) {
                        $first_attachment = reset($attachments);
                        $thumbnail_url = wp_get_attachment_image_url($first_attachment->ID, 'medium');
                    } else {
                        // Якщо нічого немає — placeholder
                        $thumbnail_url = $placeholder;
                    }
                }
                ?>

                <!-- CARD -->
                <div class="flex flex-col gap-4 group">
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="relative h-52 overflow-hidden cursor-pointer border border-white/10">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-700 z-10"></div>

                        <img
                            src="<?php echo esc_url($placeholder); ?>"
                            data-src="<?php echo esc_url($thumbnail_url); ?>"
                            alt="<?php echo esc_attr(get_the_title()); ?>"
                            class="lazy-img w-full h-full object-cover transition-transform duration-[1000ms] ease-out group-hover:scale-105"
                            loading="lazy"
                            decoding="async"
                        >
                    </a>

                    <div class="flex flex-col gap-2">
                        <a href="<?php the_permalink(); ?>" class="text-white font-semibold text-[16px] leading-snug transition-colors duration-300 group-hover:text-blue-400">
                            <?php the_title(); ?>
                        </a>
                        <time class="text-sm text-[#C5C5C5]" datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date('F j, Y'); ?>
                        </time>
                    </div>
                </div>

            <?php endforeach; wp_reset_postdata(); ?>

        </div>
    </div>
</section>