<?php
if ( ! defined('ABSPATH') ) {
    exit;
}

$categories = get_the_category();

if ( ! empty( $categories ) ) : ?>
    <div class="post__categories flex flex-wrap gap-2">

        <?php foreach ( $categories as $category ) : 
            $category_link = esc_url( get_category_link( $category->term_id ) );
            $icon_id = get_field( 'acf_category_icon', 'category_' . $category->term_id ); 
            $icon_svg = '';

            if ( $icon_id ) {
                $icon_url = wp_get_attachment_url( $icon_id );
                if ( $icon_url && pathinfo( $icon_url, PATHINFO_EXTENSION ) === 'svg' ) {
                    $icon_svg = file_get_contents( get_attached_file( $icon_id ) );
                }
            }
        ?>
            <a
                href="<?php echo $category_link; ?>"
                class="category-chip flex items-center gap-2 rounded-full border border-[#E5E7EB] dark:border-white/20 px-4 py-1.5 text-[#374151] dark:text-white  dark:bg-transparenttransition-all duration-300hover:bg-black hover:text-whitedark:hover:bg-white dark:hover:text-blackmax-w-[200px] w-fit"
            >

                <?php if ( $icon_svg ) : ?>
                    <?php
                        $icon_svg = preg_replace('/(width|height)=".*?"/', '', $icon_svg);
                        $icon_svg = preg_replace('/fill=".*?"/', 'fill="currentColor"', $icon_svg);
                        $icon_svg = preg_replace('/stroke=".*?"/', 'stroke="currentColor"', $icon_svg);
                        $icon_svg = str_replace('<svg', '<svg class="w-4 h-4 flex-shrink-0"', $icon_svg);

                        echo $icon_svg;
                    ?>
                <?php endif; ?>

                <span class="text-xs font-medium leading-[16px] truncate">
                    <?php echo esc_html( $category->name ); ?>
                </span>

            </a>
        <?php endforeach; ?>

    </div>
<?php endif; ?>