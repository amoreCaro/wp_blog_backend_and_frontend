<?php
if (!defined('ABSPATH')) exit;

get_header(); // підключає header.php з усіма стилями
?>

<div class="main-page">
    <div class="lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px]">
    <?php 
        require PATH . "/components/breadcrumbs/component.php";
        require PATH . "/components/hero/component.php";
        require PATH . "/components/bento/component.php";
    ?>
    </div>
</div>

<?php get_footer(); ?>