<?php
if (!defined('ABSPATH')) {
    exit;
}

$socials = get_field("acf_social_icons");

if ( isset( $socials ) && ! empty( $socials ) ) : ?> 
    <div class="socials flex gap-2 text-white items-center">
        <?php foreach ($socials as $social_item) : 
            $url = isset($social_item['acf_social_url']) ? $social_item['acf_social_url'] : '#';
            $icon_id = isset($social_item['acf_social_icon']) ? $social_item['acf_social_icon'] : 0;
            $icon_svg = $icon_id ? wp_get_attachment_image($icon_id, 'full') : ''; 
        ?>
            <a href="<?php echo esc_url($url); ?>" class="flex items-center justify-center w-[32px] h-[32px]">
                <?php echo $icon_svg; ?>
            </a>
        <?php endforeach; ?> 
    </div>
<?php endif; ?> 