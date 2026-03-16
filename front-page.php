<?php
if (!defined('ABSPATH')) exit;

get_header(); // підключає header.php з усіма стилями
?>

<div class="main-page">
    <div class=" lg:pb-[100px] pb-[50px]">
    <?php 
        require PATH . "/components/hero/component.php";
        require PATH . "/components/bento/component-new.php";
        require PATH . "/components/burger-menu/component.php";
    ?>
    </div>
</div>

<?php get_footer(); ?>