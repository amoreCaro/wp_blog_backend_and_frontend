<?php
if (!defined('ABSPATH')) exit;
?>
<section class="bento-grid mx-auto bg-[#F6F5F8] lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px] px-5 xl:px-10 2xl:px-0">

    <!-- HEADER -->
    <div class="flex items-center mb-12 justify-between container">

        <div class="flex items-center gap-4">

            <?php if ($category_name) : ?>
                <h2 class="text-black text-[32px] md:text-[40px] lg:text-[48px] xl:text-[56px] font-semibold tracking-tight leading-tight first-letter:uppercase">
                    <?= esc_html($category_name); ?>
                </h2>
            <?php endif; ?>

            <?php if ($category_svg) : ?>
                <div class="decor <?= esc_attr($category_decor_type); ?> -translate-y-1/2 w-14 h-14 flex items-center justify-center rounded-t-full rounded-br-full shadow-sm p-2"
                    style="
                        <?= $category_bg_color ? 'background-color:' . esc_attr($category_bg_color) . ';' : ''; ?>
                        <?= $category_text_color ? 'color:' . esc_attr($category_text_color) . ';' : ''; ?>
                    ">
                    <?= $category_svg; ?>
                </div>
            <?php endif; ?>

        </div>

        <?php if ($bento_button) : ?>
            <a href="<?= esc_url($category_link); ?>"
               class="group flex items-center justify-center gap-1.5 text-xs px-4 py-2 md:text-base md:px-9 md:py-3 md:gap-2 text-black border-2 border-black font-semibold rounded-full transition-all duration-300 hover:bg-black hover:text-white w-fit">

                <?= esc_html($bento_button); ?>

                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2.5"
                     class="w-3.5 h-3.5 md:w-5 md:h-5 transition-transform duration-300 group-hover:translate-x-1.5">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"/>
                </svg>

            </a>
        <?php endif; ?>

    </div>

    <div class="space-y-8 md:space-y-12 container">

        <!-- Two -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-10">

        <?php
        foreach ($posts_in_cat as $index => $post) {

            switch ($index) {

                case 0:
                    $item_index = 0;
                    include PATH . '/components/bento/templates/large-item.php';
                    break;

                case 1:
                    $item_index = 1;
                    include PATH . '/components/bento/templates/default-item.php';
                    break;

            }

        }
        ?>

        </div>

        <!-- GRID -->
        <?php if (count($posts_in_cat) > 2) : ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-10">

                <?php foreach ($posts_in_cat as $post_index => $post) : ?>

                    <?php if ($post_index < 2) continue; ?>

                    <?php
                    $item_index = $post_index;
                    include PATH . '/components/bento/templates/default-item.php';
                    ?>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>