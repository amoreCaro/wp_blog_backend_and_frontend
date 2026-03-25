<?php
/**
* Template Name: Home Page Template
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

if (!defined('ABSPATH')) exit;

get_header(); 
?>

<div class="home-page">
    <div class=" lg:pb-[100px] pb-[50px]">
    <?php 
        require PATH . "/components/hero/component.php";
        require PATH . "/components/bento/component-new.php";
        require PATH . "/components/burger-menu/component.php";
    ?>
    </div>
</div>

<?php get_footer(); ?>