<?php
if (!defined('ABSPATH')) exit;

get_header(); // підключає header.php з усіма стилями
?>

<div class="archive-page">
    <div class="lg:pt-[46px] pt-[120px] lg:pb-[100px] pb-[50px] bg-white">
    <?php 
        require PATH . "/components/breadcrumbs/component.php";
        require PATH . "/components/bento/component.php";
        require PATH . "/components/pagination/component.php";
    ?>
    </div>
</div>

<?php get_footer(); ?>