<?php
/**
 * Post media layout: main image + optional gallery
 */

// Get gallery
$gallery     = get_post_gallery(get_the_ID(), false);
$gallery_ids = !empty($gallery['ids'])
    ? array_slice(explode(',', $gallery['ids']), 0, 4)
    : [];
$has_gallery = !empty($gallery_ids);

// Set layout classes
$main_col_class   = $has_gallery ? 'md:w-1/2' : 'md:w-full';
$container_height = $has_gallery
    ? 'md:h-[50vh]'
    : 'h-[50vh] md:h-auto';

// Fallback image from Gutenberg content if no featured image
$content_image_url = '';
if (!has_post_thumbnail()) {
    foreach (parse_blocks(get_the_content()) as $block) {
        if (
            $block['blockName'] === 'core/image' &&
            !empty($block['attrs']['id'])
        ) {
            $content_image_url = wp_get_attachment_image_url(
                $block['attrs']['id'],
                'full'
            );
            break;
        }
    }
}
?>

<div class="flex flex-col md:flex-row w-full <?= esc_attr($container_height); ?> bg-black">

    <!-- MAIN IMAGE -->
    <div class="w-full <?= esc_attr($main_col_class); ?> <?= $has_gallery ? 'md:h-full' : 'h-full'; ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('full', [
                'class' => 'w-full h-full object-cover shadow-sm'
            ]); ?>
        <?php elseif ($content_image_url) : ?>
            <img
                src="<?= esc_url($content_image_url); ?>"
                alt="<?= esc_attr(get_the_title()); ?>"
                class="w-full h-full object-cover shadow-sm"
            >
        <?php else : ?>
            <div class="flex items-center justify-center h-full bg-gray-200">
                <span class="text-gray-500 font-medium">
                    No image available
                </span>
            </div>
        <?php endif; ?>
    </div>

    <!-- GALLERY -->
    <?php if ($has_gallery) : ?>
        <div class="grid w-full md:w-1/2 grid-cols-2 md:grid-rows-2 md:h-full">
            <?php foreach ($gallery_ids as $id) : ?>
                <div class="w-full h-[160px] sm:h-[300px] md:h-full overflow-hidden">
                    <?= wp_get_attachment_image($id, 'full', false, [
                        'class' => 'w-full h-full object-cover transition-transform duration-300 hover:scale-105'
                    ]); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>