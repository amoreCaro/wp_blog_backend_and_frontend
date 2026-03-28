<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ACF Global Settings
 */

$disclaimer = get_field('footer_disclamer', 'option');

$copyright = get_field('footer_copyright', 'option');

$pre_text     = $copyright['footer_copyright_before_link'] ?? '';
$link_data = $copyright['footer_agency_link'] ?? null;
$link_url  = $link_data['url'] ?? '';
$link_text = $link_data['title'] ?? '';
$link_target = $link_data['target'] ?? '_self';
$post_text    = $copyright['footer_text_after_link'] ?? '';

$before_year  = $copyright['footer_before_year'] ?? '';
$current_year = date('Y');
/**
 * Footer Menu
 */
$nav_menu = get_nav_menu_locations();
$footer_items = [];

if (isset($nav_menu['footer_menu'])) {
    $menu_id = $nav_menu['footer_menu'];
    $footer_items = wp_get_nav_menu_items($menu_id);
}
?>

<footer class="footer py-[100px] flex items-center bg-white dark:bg-black justify-center border-t dark:border-[#1a1a1a]">
    <div class="container mx-auto flex flex-col items-center gap-5 text-center">

        <!-- Disclaimer -->
        <?php if ( !empty($disclaimer) ) : ?> 
            <div class="text-[14px] leading-[28px]  font-normal max-w-[912px] mx-auto text-center text-dark dark:text-white">
                <?php echo $disclaimer; ?>
            </div>
        <?php endif; ?>

        <!-- Footer nav -->
        <?php if (!empty($footer_items)) : ?>
        <nav class="min-h-[46px] flex items-center">
            <ul class="flex justify-center flex-wrap">
                <?php foreach ($footer_items as $item) : 
                    $text = $item->title ?? '';
                    $url  = $item->url ?? '';

                    if (!$text) continue;
                ?>
                    <li>
                        <a
                            href="<?php echo esc_url($url); ?>"
                            class="text-[14px] leading-[20px] font-medium text-gray-700 dark:text-white px-5 py-3 transition-colors duration-300 hover:text-black hover:text-blue-400"
                        >
                            <?php echo esc_html($text); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <?php endif; ?>

        <!-- Socials -->
        <?php require PATH . "/components/socials/component.php"; ?> 

        <!-- Copyright -->
        <span class="text-[14px] leading-[28px] text-gray-500 dark:text-[#d5d5d5] font-normal">
            <?php 
                echo esc_html($before_year) . ' ' . $current_year; 
            ?>
            
            <?php if (!empty($link_url)) : ?>
                <?php echo esc_html($pre_text); ?>
                <a href="<?php echo esc_url($link_url); ?>" class="underline hover:text-black dark:hover:text-white transition-colors">
                    <?php echo esc_html($link_text); ?>
                </a>
            <?php endif; ?>

            <?php 
                echo esc_html($post_text); 
            ?> 
        </span>

    </div>
</footer>

</div>
<?php wp_footer(); ?>
</body>
</html>