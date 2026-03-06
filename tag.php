<?php 
if (!defined('ABSPATH')) exit;

$tags = get_tags([
    'hide_empty' => true
]);

get_header();
?>

<div class="tags">
    <?php 
        require PATH . "/components/media-menu/component.php";
        require PATH . "/components/bento/component.php";
        require PATH . "/components/pagination/component.php";
    ?>
</div>

<?php get_footer(); ?>