<?php
if (!defined('ABSPATH')) exit;

/**
 * Color Card component
 * Виводить всі кольори з ACF Repeater (sections → items)
 */

$page_id = get_the_ID();
$sections = get_field('acf_color_section', $page_id);
?>

<section class="p-10 font-sans">
    <div class="flex items-center gap-4 mb-10 group">
        <div class="w-[3px] h-6 bg-brand-indigo rounded-full"></div>
        <h2 class="text-content-muted font-medium text-[22px] tracking-tight group-hover:text-content-white transition-colors">
            Colors
        </h2>
    </div>

    <?php if ($sections && is_array($sections)) : ?>
        <div class="bg-surface-dark border border-border-light rounded-[24px] p-10 relative flex flex-col gap-14">

            <?php foreach ($sections as $section) : 
                $section_title = $section['acf_color_section_title'] ?? '';
                $colors = $section['acf_color_item'] ?? [];
            ?>

                <div class="flex flex-col gap-6">
                    <h3 class="text-content-ghost text-[11px] font-bold uppercase tracking-[0.3em] ml-1">
                        <?php echo esc_html($section_title); ?>
                    </h3>

                    <div class="flex flex-wrap gap-4">
                        <?php if ($colors && is_array($colors)) : ?>
                            <?php foreach ($colors as $color) : 
                                $color_name = $color['acf_color_name'] ?? 'No name';
                                $color_code = $color['acf_color_code'] ?? '#000000';
                            ?>
                                <div class="group flex items-center gap-5 px-4 py-3 rounded-2xl transition-all duration-200 hover:bg-surface-hover border border-transparent hover:border-border-hover min-w-[200px] cursor-pointer">
                                    <div
                                        class="w-[52px] h-[52px] rounded-xl flex-shrink-0"
                                        style="background-color: <?php echo esc_attr($color_code); ?>;">
                                    </div>

                                    <div class="flex flex-col gap-0.5">
                                        <p class="text-content-gray text-[15px] font-medium group-hover:text-content-white transition-colors">
                                            <?php echo esc_html($color_name); ?>
                                        </p>
                                        <code class="text-content-dimmed text-[11px] font-mono uppercase tracking-wider">
                                            <?php echo esc_html($color_code); ?>
                                        </code>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="text-content-gray">Кольорів немає</p>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="text-content-gray">Секцій немає</p>
    <?php endif; ?>
</section>
