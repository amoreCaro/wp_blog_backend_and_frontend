<?php
if (!defined('ABSPATH')) exit;

/**
 * Color Card component
 * Outputs all colors from the ACF Repeater (sections → items)
 */

// Get current page ID dynamically
$page_id = get_the_ID();

// Get color sections from ACF repeater
$sections = get_field('acf_color_section', $page_id);
?>

<section class="p-10 font-sans">
    <!-- Section header -->
    <div class="flex items-center gap-4 mb-10 group">
        <div class="w-[3px] h-6 bg-brand-indigo rounded-full"></div>
        <h2 class="text-content-muted font-medium text-[22px] tracking-tight group-hover:text-content-white transition-colors">
            Colors
        </h2>
    </div>

    <?php if ($sections && is_array($sections)) : ?>
        <!-- Wrapper for all color sections -->
        <div class="bg-surface-dark border border-border-light rounded-[24px] p-10 relative flex flex-col gap-14">

            <?php foreach ($sections as $section) : 
                // Section title (e.g. Base Colors, Brand Colors)
                $section_title = $section['acf_color_section_title'] ?? '';

                // Colors inside the current section
                $colors = $section['acf_color_item'] ?? [];
            ?>

                <div class="flex flex-col gap-6">
                    <!-- Section title -->
                    <h3 class="text-content-ghost text-[11px] font-bold uppercase tracking-[0.3em] ml-1">
                        <?php echo esc_html($section_title); ?>
                    </h3>

                    <!-- Color items -->
                    <div class="flex flex-wrap gap-4">
                        <?php if ($colors && is_array($colors)) : ?>
                            <?php foreach ($colors as $color) : 
                                // Color name and HEX code
                                $color_name = $color['acf_color_name'] ?? 'No name';
                                $color_code = $color['acf_color_code'] ?? '#000000';
                            ?>
                                <!-- Single color card -->
                                <div class="group flex items-center gap-5 px-4 py-3 rounded-2xl transition-all duration-200 hover:bg-surface-hover border border-transparent hover:border-border-hover min-w-[200px] cursor-pointer">
                                    
                                    <!-- Color preview -->
                                    <div
                                        class="w-[52px] h-[52px] rounded-xl flex-shrink-0"
                                        style="background-color: <?php echo esc_attr($color_code); ?>;">
                                    </div>

                                    <!-- Color meta -->
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
                            <!-- Fallback if no colors in section -->
                            <p class="text-content-gray">There are no colors</p>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <!-- Fallback if no color sections -->
        <p class="text-content-gray">There are no color sections</p>
    <?php endif; ?>
</section>
