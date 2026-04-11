<?php
/**
* Template Name: Contact Template Page
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

if (!defined('ABSPATH')) exit;

get_header(); 
?>

<div class="contact-page bg-white">
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
</div>

<?php get_footer(); ?>