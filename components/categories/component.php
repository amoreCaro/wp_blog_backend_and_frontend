<?php
if ( ! defined('ABSPATH') ) {
    exit;
}

$categories = get_the_category();

if ( ! empty( $categories ) ) : ?>
    <div class="post__categories flex flex-wrap gap-2">

        <?php foreach ( $categories as $category ) : 
            $category_link = esc_url( get_category_link( $category->term_id ) );
            $icon_id = intval( get_field( 'acf_category_icon', 'category_' . $category->term_id ) );
        ?>
            <a
                href="<?php echo $category_link; ?>"
                class="category-chip flex items-center gap-2 rounded-full border border-white px-4 py-1.5 text-white transition-all duration-300 hover:bg-white hover:text-black max-w-[200px] w-fit"
            >

                <?php if ( $icon_id ) : ?>
                    <?php image( $icon_id, 16, 16 ); ?>
                <?php endif; ?>

                <span class="text-xs font-medium leading-[16px] truncate">
                    <?php echo esc_html( $category->name ); ?>
                </span>

            </a>
        <?php endforeach; ?>

    </div>
<?php endif; ?>