<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Визначаємо номер поточної сторінки
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

// Параметри WP_Query
$args = [
    'post_type'      => 'post',
    'posts_per_page' => 12,
    'paged'          => $paged,
];

if ( is_category() ) {
    $category       = get_queried_object();
    $args['cat']    = $category->term_id;
}

$query = new WP_Query( $args );

if ( $query->have_posts() ) :

    // Пагінація у вигляді кнопок
    $total_pages = $query->max_num_pages;
    if ($total_pages > 1):
        $current_page = max(1, $paged);
        ?>
        <div class="pagination flex items-center justify-center bg-white mt-6">
            <ul class="flex items-center gap-3">
                <li>
                    <?php if($current_page > 1): ?>
                        <a href="<?php echo get_pagenum_link($current_page - 1); ?>" aria-label="Previous page" class="pagination__btn pagination__btn--prev flex items-center justify-center w-12 h-12 border border-[#9395ab] transition group hover:border-blue-600">
                            <svg class="w-5 h-5 text-[#9395ab] fill-none stroke-current stroke-2 transition group-hover:text-blue-600" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                    <?php else: ?>
                        <span class="pagination__btn pagination__btn--prev flex items-center justify-center w-12 h-12 border border-[#ccc] opacity-50 cursor-not-allowed">
                            <svg class="w-5 h-5 text-[#ccc] fill-none stroke-current stroke-2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                    <?php endif; ?>
                </li>

                <?php
                for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li>
                        <?php if ($i == $current_page): ?>
                            <span class="pagination__page pagination__page--active flex items-center justify-center w-12 h-12 border-2 border-blue-600 text-blue-600 font-bold"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="<?php echo get_pagenum_link($i); ?>" class="pagination__page flex items-center justify-center w-12 h-12 border border-[#9395ab] text-[#9395ab] hover:border-blue-600"><?php echo $i; ?></a>
                        <?php endif; ?>
                    </li>
                <?php endfor; ?>

                <li>
                    <?php if($current_page < $total_pages): ?>
                        <a href="<?php echo get_pagenum_link($current_page + 1); ?>" aria-label="Next page" class="pagination__btn pagination__btn--next flex items-center justify-center w-12 h-12 border border-[#9395ab] transition group hover:border-blue-600">
                            <svg class="w-5 h-5 text-[#9395ab] fill-none stroke-current stroke-2 transition group-hover:text-blue-600" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    <?php else: ?>
                        <span class="pagination__btn pagination__btn--next flex items-center justify-center w-12 h-12 border border-[#ccc] opacity-50 cursor-not-allowed">
                            <svg class="w-5 h-5 text-[#ccc] fill-none stroke-current stroke-2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    <?php
    endif;

    wp_reset_postdata();
else:
    echo '<p>Пости не знайдені.</p>';
endif;
?>