<?php 
if (!defined('ABSPATH')) exit;

$categories = get_categories();

get_header();

?>  

<div class="blog-page">
    <div class="lg:pt-[46px] pt-[92px]">
    <?php 
        require PATH . "/components/media-menu/component.php";
        require PATH . "/components/bento/component-new.php";
    ?>
    </div>
</div>

<?php get_footer(); ?>