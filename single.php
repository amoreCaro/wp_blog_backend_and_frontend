<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id = get_the_ID();
get_header();

// change require to include
?>

<main class="main">
    <!-- Single Post -->
    <div class="single-post">
        <div class="lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px]">
            <div class="container mx-auto relative 2xl:max-w-[1152px] xl:px-[0px] lg:px-[40px] px-[20px]">
                <div class="container mx-auto relative">
                    <?php require PATH . "/components/breadcrumbs/component.php"; ?>
                </div>
            </div>

            <div class="container mx-auto relative 2xl:max-w-[1152px] xl:px-[0px] lg:px-[40px] px-[20px]">
                <!-- Content -->
                <div class="mx-auto max-w-[800px] flex flex-col gap-5 pb-[50px] lg:pb-[100px] xl:pl-[0px]">
                    <?php
                        require PATH . "/components/categories/component.php";
                        require PATH . "/components/content/component.php";
                    ?>
                </div>
            </div>

            <?php require PATH . "/components/media/component.php"; ?>

            <div class="post__article max-w-[800px] mx-auto pb-[50px] lg:pb-[100px] px-[20px] lg:px-[0px]">
                <?php 
                    require PATH . "/components/article/component.php";
                    // Tags
                    require PATH . "/components/tags/component.php";
                    // Author
                    require PATH . "/components/post-author/component.php";
                ?>
            </div>

            <?php require PATH . "/components/related-posts/component.php"; ?>
        </div>
    </div>

    <?php 
        // Video modal
        require PATH . "/components/video-modal/component.php";
        require PATH . "/components/burger-menu/component.php";
    ?>
</main>

<?php get_footer(); ?>