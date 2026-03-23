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
                include PATH . "/components/media-menu/component.php";
                include PATH . '/components/bento/templates/tag.php';
                include PATH . "/components/pagination/component.php";
            ?>
        </div>
    </div>
    <?php 
        include PATH . "/components/burger-menu/component.php";
    ?>
</main>

<?php get_footer(); ?>