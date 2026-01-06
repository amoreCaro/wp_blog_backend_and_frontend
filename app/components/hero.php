<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<section>
    <div class="flex flex-col items-center">
        <?php require get_template_directory() . '/app/components/socials.php'; ?>
        <div class="w-full max-w-[800px] h-[50vh] flex flex-col justify-center text-left mx-auto px-[40px] sm:px-0">

            <h1 class="font-roboto font-normal text-white text-[56px] leading-[64px]">
                <?php the_title(); ?>
            </h1>
            <p class="font-roboto font-light text-grey-light text-[18px] leading-[36px] mt-4 max-w-[650px]">
                <?php echo get_the_excerpt(); ?>
            </p>
            <span class="font-roboto font-normal text-white text-[16px] leading-[16px] mt-2">
                <?php echo get_field('acf_event_date'); ?>
            </span>
        </div>

        <div class="flex w-full h-auto md:h-[50vh]">            
            <?php require get_template_directory() . '/app/components/gallery.php'; ?>
        </div>
    </div>
</section>