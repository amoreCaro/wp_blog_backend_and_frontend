<?php
if (!defined('ABSPATH')) {
    exit;
}
// Отримуємо соц мережі з ACF
$socials = get_field("acf_social_icons", "option");

// Масив валідних елементів
$valid_socials = [];

if (!empty($socials)) {

    foreach ($socials as $social_item) {

        $url = $social_item['acf_social_url'] ?? '';
        $icon_id = $social_item['acf_social_icon'] ?? 0;
        $color = $social_item['acf_social_color'] ?? '#ffffff';
        $hover_color = $social_item['acf_social_hover_color'] ?? '#2CC197';

        $icon_svg = get_inline_svg_social_icons_from_acf($icon_id);

        // Пропускаємо якщо нема url або svg
        if (!empty($url) && !empty($icon_svg)) {
            $valid_socials[] = [
                'url' => $url,
                'svg' => $icon_svg,
                'color' => $color,
                'hover_color' => $hover_color
            ];
        }
    }
}

// Рендеримо лише якщо є валідні соц. елементи
if (!empty($valid_socials)) : ?>
<div class="socials flex gap-2 items-center">

    <?php foreach ($valid_socials as $social) : ?>
        <a href="<?php echo esc_url($social['url']); ?>" 
           class="flex items-center justify-center w-[32px] h-[32px] transition-colors duration-200"
           style="color: <?php echo esc_attr($social['color']); ?>;"
           onmouseover="this.style.color='<?php echo esc_js($social['hover_color']); ?>';"
           onmouseout="this.style.color='<?php echo esc_js($social['color']); ?>';"
        >
            <?php echo $social['svg']; ?>
        </a>
    <?php endforeach; ?>

</div>
<?php endif; ?>