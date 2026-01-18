<?php
if (!defined('ABSPATH')) {
    exit;
}

$post_id = get_the_ID();

// Post date
$date = get_the_date('F j, Y');

// Main media 
$media = '';
// Video or image
$media_type = get_field('acf_main_media_type');

switch ($media_type) {
    case 'image':
        $image_id = get_field('acf_main_image');
        if ($image_id) {
            $media = wp_get_attachment_image_url($image_id, 'medium'); // get image url
        } 
        break;
    case 'video':
        $video_url = get_field('acf_main_video');
        if ($video_url) {
            $media = esc_url($video_url);
        }
        break;
}

// Gallery
$gallery_images = [];
// Media class full width or half
$media_class = $gallery_images ? 'lg:basis-1/2' : 'w-full';

if (have_rows('acf_gallery')) {
    while (have_rows('acf_gallery')) {
        the_row();
        $image_id = get_sub_field('acf_gallery_image_id');
        if ($image_id) {
            $gallery_images[] = [
                'url' => esc_url( wp_get_attachment_image_url($image_id, 'large') ),
                'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true)
            ];
        }
    }
}



// Related posts
$related_posts = get_posts([
    'category__in' => wp_get_post_categories($post_id),
    'numberposts'  => 5,
    'post__not_in' => [$post_id],
]);

get_header();
?>

<main class="main bg-black">
    <div class="single-post">
        <div class="pt-[150px] pb-[100px]">
            <section class="container mx-auto relative max-w-[1152px] px-[48px] sm:px-0">
                <!-- Socials -->
                <nav class="absolute flex flex-col gap-[30px] w-[45px] items-center">
                    <ul class="flex flex-col gap-[30px] list-none p-0 m-0">
                        <li>
                            <a href="#" aria-label="Facebook" class="block max-w-[25px] w-full h-[25px] outline-none focus:outline-none active:outline-none no-underline">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full object-cover">
                                    <circle cx="12" cy="12" r="12" fill="white"/>
                                    <path d="M13.5 12H15.5L16 9.5H13.5V8C13.5 7.31 13.5 6.5 14.5 6.5H16V4.285C15.717 4.25 14.655 4 13.599 4C11.396 4 9.5 5.344 9.5 7.82V9.5H7.5V12H9.5V18H13.5V12Z" fill="black"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" aria-label="Telegram" class="block max-w-[25px] w-full h-[25px] outline-none focus:outline-none active:outline-none no-underline">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full object-cover">
                                    <circle cx="12" cy="12" r="12" fill="white"/>
                                    <path d="M17.5 7L5.5 11.5L8.5 13L10 17.5L12.5 14.5L15.5 17L17.5 7Z" stroke="black" stroke-width="1.2" stroke-linejoin="round"/>
                                    <path d="M8.5 13L17.5 7L10 14.5" stroke="black" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" aria-label="WhatsApp" class="block max-w-[25px] w-full h-[25px] outline-none focus:outline-none active:outline-none no-underline">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full object-cover">
                                    <path d="M12.04 2C6.51 2 2.01 6.5 2 12.04C2 13.81 2.46 15.54 3.34 17.07L2 22L7.05 20.67C8.52 21.47 10.18 21.9 11.88 21.9C17.41 21.9 21.91 17.4 21.92 11.87C21.92 9.19 20.88 6.69 18.99 4.8C17.1 2.91 14.61 2.01 12.04 2ZM17.43 15.65C17.19 16.32 16.27 16.89 15.54 17.05C15.04 17.16 14.4 17.26 12.21 16.35C9.41 15.19 7.6 12.33 7.46 12.15C7.32 11.96 6.31 10.63 6.31 9.25C6.31 7.87 7.02 7.2 7.3 6.92C7.51 6.7 7.87 6.6 8.16 6.6C8.26 6.6 8.35 6.6 8.43 6.6C8.68 6.61 8.81 6.63 8.97 7.03C9.18 7.54 9.68 8.78 9.74 8.91C9.8 9.04 9.87 9.21 9.78 9.38C9.7 9.55 9.62 9.64 9.5 9.78C9.38 9.92 9.24 10.1 9.14 10.22C9.02 10.36 8.89 10.51 9.05 10.78C9.21 11.05 9.76 11.95 10.57 12.67C11.61 13.6 12.47 13.9 12.77 14.03C13.01 14.13 13.25 14.1 13.43 13.9C13.65 13.65 13.92 13.26 14.2 12.87C14.4 12.59 14.65 12.56 14.91 12.66C15.18 12.76 16.6 13.46 16.89 13.61C17.18 13.76 17.37 13.84 17.45 13.98C17.53 14.12 17.53 14.8 17.29 15.47" fill="white"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" aria-label="X" class="block max-w-[25px] w-full h-[25px] outline-none focus:outline-none active:outline-none no-underline">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full object-cover">
                                    <path d="M14.2141 10.0384L23.1023 0H20.9961L13.2773 8.75618L7.11364 0H0L9.32182 13.2438L0 24H21.0623L15.1509 14.526L24 24H21.0623L14.2136 10.0384H14.2141ZM16.2168 22.7738H15.0495L7.84409 2.508H9.01136L16.2168 22.7738Z" fill="white"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Content -->
                <div class="mx-auto max-w-[800px] flex flex-col gap-5 pb-[100px]">
                    <h1 class="text-white text-[56px] leading-[64px]"><?php the_title(); ?></h1>
                    <p class="text-gray font-light text-[18px] leading-[36px] py-[18px]"><?php echo get_the_excerpt(); ?></p>
                    <div class="flex items-center gap-4 font-normal text-white text-base leading-[16px]">
                        <span><?php echo $date; ?></span>
                        <ul class="list-disc list-inside">
                            <li class="single-post__read-time marker:text-white"></li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Images -->
            <section class="w-full max-w-[1920px] mx-auto flex flex-col lg:flex-row gap-0 px-[40px] 2xl:px-[0px]">
                <div class="h-[400px] lg:h-[642px] bg-[#ff0000] <?php echo $media_class; ?>">
                    <?php if ($media_type === 'image' && $media): ?>
                        <img src="<?php echo esc_url($media); ?>" alt="Featured image" class="w-full h-full object-cover cursor-pointer">
                    <?php elseif ($media_type === 'video' && $media): ?>
                        <video class="w-full h-full object-cover cursor-pointer" controls>
                            <source src="<?php echo $media; ?>" type="video/mp4">

                        </video>
                    <?php endif; ?>
                </div>

                <?php if ($gallery_images): ?>
                    <div class="w-full lg:basis-1/2 grid grid-cols-2">
                        <?php foreach ($gallery_images as $img): ?>
                            <div class="w-full min-h-[160px] lg:h-[321px] overflow-hidden bg-white">
                                <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-full h-full object-cover">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Article -->
            <article class="article max-w-[800px] mx-auto py-[100px] px-[88px] lg:px-[0px]">
                <?php echo wp_kses_post(get_the_content()); ?>
            </article>

            <!-- Related posts -->
            <?php if ($related_posts): ?>
                <section class="related-posts py-[100px]">
                    <div class="container xl:px-[5px] 3xl:px-[0px] 2xl:max-w-[1920px] lg:px-[120px] md:px-[52px] mx-auto gap-5 flex flex-col">
                        <h2 class="text-white text-[48px] leading-[48px] font-medium pb-12">Related Posts</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-5">
                            <?php foreach ($related_posts as $post):
                                setup_postdata($post);
                                $image_id = get_field('acf_main_image', $post->ID);
                                $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
                            ?>
                                <div class="flex flex-col gap-5">
                                    <a href="<?php the_permalink(); ?>" class="h-[200px] sm:max-w-[500px] w-full overflow-hidden cursor-pointer">
                                        <?php if ($image_url): ?>
                                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
                                        <?php endif; ?>
                                    </a>
                                    <a href="<?php the_permalink(); ?>" class="text-base leading-[16px] text-white font-semibold"><?php the_title(); ?></a>
                                    <span class="text-base leading-[16px] text-dark-gray font-normal"><?php echo get_the_date('F j, Y'); ?></span>
                                </div>
                            <?php endforeach; wp_reset_postdata(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>