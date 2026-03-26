<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title   = get_the_title();
$date    = get_the_date( 'F j, Y' );
$excerpt = get_the_excerpt() ?: '';
?>

<?php if ( ! empty( $title ) ) : ?>
    <h1 class="post__title text-black dark:text-white text-[30px] leading-[38px] md:text-[44px] md:leading-[52px] lg:text-[56px] lg:leading-[64px]">
        <?php echo esc_html( $title ); ?>
    </h1>
<?php endif; ?>

<?php if ( ! empty( $excerpt ) ) : ?>
    <p class="post__excerpt text-[#cecece] dark:text-[#C2C2C2] font-light text-[18px] leading-[36px] py-[18px]">
        <?php echo esc_html( $excerpt ); ?>
    </p>
<?php endif; ?>

<?php if ( ! empty( $date ) ) : ?>
<div class="flex items-center gap-4">
    <time 
        class="post__date text-black dark:text-white text-[16px] leading-[16px] font-normal" 
        datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
        <?php echo esc_html( $date ); ?>
    </time>
    <span class="post__read-time relative pl-4 dark:text-white before:content-['•'] before:absolute before:left-0  text-black dark:before:text-white">
    </span>
</div>
<?php endif; ?>