<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Поточна сторінка
$paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );

// Параметри запиту
$args = [
    'post_type'      => 'post',
    'posts_per_page' => 12,
    'paged'          => $paged,
];

// Якщо ми на сторінці категорії
if ( is_category() ) {
    $category = get_queried_object();
    if ( $category instanceof WP_Term ) {
        $args['cat'] = $category->term_id;
    }
}

// Якщо ми на сторінці тегу
if ( is_tag() ) {
    $tag = get_queried_object();
    if ( $tag instanceof WP_Term ) {
        $args['tag_id'] = $tag->term_id;
    }
}

// Запит постів
$query = new WP_Query( $args );

if ( $query->have_posts() ) :

    $total_pages = $query->max_num_pages;

    // Показуємо пагінацію тільки якщо більше 1 сторінки
    if ( $total_pages > 1 ) :

        $current_page = $paged;
?>
<div class="pagination flex items-center justify-center bg-white">
    <ul class="flex items-center gap-3">

        <!-- Попередня сторінка -->
        <?php if ( $current_page > 1 ) : ?>
            <li>
                <a href="<?php echo get_pagenum_link( $current_page - 1 ); ?>"
                   class="pagination__btn flex items-center justify-center w-12 h-12 border border-[#9395ab] text-[#9395ab] hover:text-blue-600 hover:border-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </a>
            </li>
        <?php endif; ?>

        <!-- Нумерація сторінок -->
        <?php for ( $i = 1; $i <= $total_pages; $i++ ) : ?>
            <li>
                <?php if ( $i == $current_page ) : ?>
                    <span class="flex items-center justify-center w-12 h-12 border-2 border-blue-600 text-blue-600 font-bold">
                        <?php echo $i; ?>
                    </span>
                <?php else : ?>
                    <a href="<?php echo get_pagenum_link( $i ); ?>"
                       class="flex items-center justify-center w-12 h-12 border border-[#9395ab] text-[#9395ab] hover:text-blue-600 hover:border-blue-600">
                        <?php echo $i; ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endfor; ?>

        <!-- Наступна сторінка -->
        <?php if ( $current_page < $total_pages ) : ?>
            <li>
                <a href="<?php echo get_pagenum_link( $current_page + 1 ); ?>"
                   class="pagination__btn flex items-center justify-center w-12 h-12 border border-[#9395ab] text-[#9395ab] hover:text-blue-600 hover:border-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
            </li>
        <?php endif; ?>

    </ul>
</div>

<?php
    endif;

    wp_reset_postdata();

endif;
?>