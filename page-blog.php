<?php 
if (!defined('ABSPATH')) exit;

$categories = get_categories();

get_header();

?>  

<div class="blog-page">
    <div class="lg:pt-[46px] pt-[92px] lg:pb-[100px] pb-[50px] bg-white">
    <?php 
        require PATH . "/components/media-menu/component.php";
        require PATH . "/components/bento/component.php";
        require PATH . "/components/pagination/component.php";
    ?>
    </div>
</div>

<?php get_footer(); ?>