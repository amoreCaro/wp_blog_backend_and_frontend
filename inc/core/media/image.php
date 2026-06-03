<?php

if (!defined('ABSPATH')) exit;
?>

<picture class="block w-full h-full">
    <img 
        data-src="<?php echo esc_url($thumbnail); ?>" 
        src="<?php echo esc_url($thumbnail); ?>" 
        alt="<?php echo esc_attr($title); ?>" 
        loading="lazy"
        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
    >
</picture>