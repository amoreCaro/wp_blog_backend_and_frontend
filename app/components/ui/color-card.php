<?php
if (!defined('ABSPATH')) exit;

/**
 * Single Color component
 * $color_name - назва кольору
 * $color_code - код кольору (#HEX)
 **/

?>
<div class="group flex items-center gap-5 px-4 py-3 rounded-2xl transition-all duration-200 hover:bg-surface-hover border border-transparent hover:border-border-hover min-w-[200px] cursor-pointer">
    <div class="w-[52px] h-[52px] rounded-xl flex-shrink-0" style="background-color: <?php echo esc_attr($color_code); ?>;"></div>
    <div class="flex flex-col gap-0.5">
        <p class="text-content-gray text-[15px] font-medium group-hover:text-content-white transition-colors">
            <?php echo esc_html($color_name); ?>
        </p>
        <code class="text-content-dimmed text-[11px] font-mono uppercase tracking-wider">
            <?php echo esc_html($color_code); ?>
        </code>
    </div>
</div>
