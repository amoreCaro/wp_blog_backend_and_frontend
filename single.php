<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<main class="bg-black"> 
    <?php require get_template_directory() . '/app/components/hero/hero.php'; ?>
</main>

<?php get_footer(); ?>