<?php
if (!defined('ABSPATH')) exit;

get_header(); 
?>

<div class="archive-page">
    <div class="lg:pt-[46px] pt-[92px] lg:pb-[100px] pb-[50px] bg-white">
    <?php 
        require PATH . "/components/media-menu/component.php";
        require PATH . "/components/bento/component-new.php";
        require PATH . "/components/pagination/component.php";
    ?>
    </div>
</div>

<?php get_footer(); ?>