<?php

if (!defined('ABSPATH')) exit;

get_header(); 
?>

<div class="main-page">
    <div class=" lg:pb-[100px] pb-[50px]">
    <h1>
        <?php
            the_title();
        ?>
    </h1>
    <?php 
        the_content();
    ?>
    </div>
</div>

<?php get_footer(); ?>