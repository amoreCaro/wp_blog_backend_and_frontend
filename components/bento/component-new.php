<?php
if (!defined('ABSPATH')) exit;

switch ($template) {
    case 0:
        echo "template equals 0";
        break;
    case 1:
        echo "template equals 1";
        break;
    case 2:
        echo "template equals 2";
        break;
}

$bento_section = get_field('bento');

if (!empty($bento_section['bento_categories'])) :
    foreach ($bento_section['bento_categories'] as $category_item) :

        $category = $category_item['bento_category'];
        if (!$category) continue;

        $category_name = $category->name;
        $category_slug = $category->slug;
        $category_id = $category->term_id;
        $category_count = $category->count; 
        $category_link = get_category_link($category_id);

        $category_svg = get_term_meta($category_id, 'category_icon_svg', true);
        $category_bg_color = get_field('category_bg', 'category_' . $category_id);
        $category_text_color = get_field('category_text_color', 'category_' . $category_id);
        $category_decor_type = get_field('category_decor_type', 'category_' . $category_id);

        $bento_button = $category_item['bento_button'] ?? '';
        $bento_design = $category_item['bento_design'] ?? '';
        ?>

        <section class="bento-grid mx-auto bg-[#F6F5F8] lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px] px-5 xl:px-10 2xl:px-0">
            <div class="flex items-center mb-12 justify-between container">
                <div class="flex items-center gap-4">
                    <?php if (!empty($category_name)) : ?>
                        <h1 class="text-black text-[32px] md:text-[40px] lg:text-[48px] xl:text-[56px] font-semibold tracking-tight leading-tight first-letter:uppercase">
                            <?php echo esc_html($category_name); ?>
                        </h1>

                    <?php endif; ?>

                    <?php if (!empty($category_svg)) : ?>
                        <div class="decor <?php echo esc_attr($category_decor_type); ?> -translate-y-1/2 w-14 h-14 flex items-center justify-center rounded-t-full rounded-br-full shadow-sm p-2"
                            style="
                                <?php if (!empty($category_bg_color)) : ?>
                                    background-color: <?php echo esc_attr($category_bg_color); ?>;
                                <?php endif; ?>
                                <?php if (!empty($category_text_color)) : ?>
                                    color: <?php echo esc_attr($category_text_color); ?>;
                                <?php endif; ?>
                            "
                        >
                            <?php
                                $svg = $category_svg;
                                $svg = preg_replace('/fill=".*?"/', 'fill="currentColor"', $svg);
                                $svg = preg_replace('/stroke=".*?"/', 'stroke="currentColor"', $svg);
                                if (!preg_match('/width="/', $svg)) {
                                    $svg = str_replace('<svg', '<svg width="20" height="20"', $svg);
                                }
                                echo $svg;
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($bento_button)) : ?> 
                    <a href="<?php echo esc_url($category_link); ?>"
                       class="group flex items-center justify-center gap-1.5 text-xs px-4 py-2 md:text-base md:px-9 md:py-3 md:gap-2 text-black border-2 border-black font-semibold rounded-full transition-all duration-300 hover:bg-black hover:text-white w-fit">
                        <?php echo esc_html($bento_button); ?>    
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" 
                             class="w-3.5 h-3.5 md:w-5 md:h-5 transition-transform duration-300 group-hover:translate-x-1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <div class="space-y-8 md:space-y-12 container">

                <!-- Перша секція: default-item і large-item -->
                <div class="<?php echo esc_attr($bento_design); ?> grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-10">
                    <?php 
                    for ($i = 1; $i <= 2; $i++) {
                        if ($i === 1) {
                            require PATH . '/components/bento/templates/default-item.php';
                        } else {
                            require PATH . '/components/bento/templates/large-item.php';
                        }
                    }
                    ?>
                </div>

                <!-- Друга секція: пости від 3 до 6 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-10">
                    <?php 
                    for ($i = 3; $i <= 6; $i++) : 
                        require PATH . '/components/bento/templates/default-item.php';
                    endfor; 
                    ?>
                </div>

            </div>
        </section>

    <?php
    endforeach;
endif;
?>