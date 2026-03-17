<?php 
if (!defined('ABSPATH')) exit;

$tags = get_tags([
    'hide_empty' => true
]);

get_header();
?>

<main class="main">
    <div class="tag-page bg-white">
        <div class="lg:pt-[46px] pt-[92px]">
            <?php 
                require PATH . "/components/media-menu/component.php";
                require PATH . "/components/bento/component-new.php";
                require PATH . "/components/pagination/component.php";
            ?>
        </div>
    </div>
    <?php 
        require PATH . "/components/burger-menu/component.php";
    ?>
</main>

<?php get_footer(); ?>