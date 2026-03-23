<?php
if (!defined('ABSPATH')) exit;

global $wp_query;
$category_obj = $wp_query->get_queried_object() ;

$category_name       = $category_obj->name;
$category_link       = get_term_link($category_obj);
$category_svg        = get_inline_svg_category_from_acf($category_obj->term_id);
$category_bg_color   = get_field('category_bg', $category_obj) ?: '';
$category_text_color = get_field('category_text_color', $category_obj) ?: '';
$category_decor_type = get_field('category_decor_type', $category_obj) ?: 'default';

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$posts_in_cat = $wp_query->posts;

get_header(); 
?>

<main class="main">
    <div class="archive-page">
        <div class="lg:pt-[46px] pt-[92px] lg:pb-[100px] pb-[50px] bg-white">
        <?php 
            include_once( PATH . "/components/media-menu/component.php" );
            //rename bento to posts
            if ( ! empty ( $posts_in_cat ) ) {
                include PATH . '/components/bento/templates/archive.php';
            }
            include_once( PATH . "/components/pagination/component.php" );
        ?>
        </div>
    </div>
    <?php 
        include_once( PATH . "/components/burger-menu/component.php" );
    ?>
</main>

<?php get_footer(); ?>