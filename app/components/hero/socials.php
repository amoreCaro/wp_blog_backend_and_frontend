<?php
if (!defined('ABSPATH')) {
    exit;
}

$social_icons = get_field('acf_social_icons');

if ($social_icons) : ?>
    <div class="flex flex-col gap-[30px] absolute top-1/4 -translate-y-1/4">
        <?php foreach ($social_icons as $icon) : 
            $image_id  = $icon['acf_social_icon'] ?? 0;
            $image_url = $image_id ? wp_get_attachment_url($image_id) : '';
            $alt_text  = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : '';
            $link      = $icon['acf_social_url'] ?? '#';
        ?>
            <a href="<?php echo esc_url($link); ?>" class="w-[25px] h-[25px] block">
                <img
                    class="w-full h-full object-contain"
                    src="<?php echo esc_url($image_url); ?>"
                    alt="<?php echo esc_attr($alt_text); ?>"
                />
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>