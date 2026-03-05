<?php
if (!defined('ABSPATH')) exit;

$categories = get_categories();
$tags = get_tags([
    'hide_empty' => true
]);
?>
<div class="media-menu absolute w-full top-[80px] z-50 bg-[#F6F5F8] flex flex-col py-2">
    <div class="container w-full mx-auto px-5 xl:px-10 2xl:px-0">

        <div class="media-menu__head flex items-center justify-between">
            <!-- Category Button -->
            <button class="media-menu__categories-btn flex items-center gap-2 md:hidden py-3 text-black">
                <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" class="fill-current">
                    <rect width="7" height="7" rx="1"></rect>
                    <rect x="11" width="7" height="7" rx="1"></rect>
                    <rect y="11" width="7" height="7" rx="1"></rect>
                    <rect x="11" y="11" width="7" height="7" rx="1"></rect>
                </svg>
                <span class="font-bold uppercase text-[15px] leading-[15px]">Category</span>
            </button>
            <!-- Десктопне меню -->
            <?php if ( isset( $categories ) && ! empty ( $categories ) ) : ?>
            <div class="media-menu__categories-content hidden md:block overflow-x-auto no-scrollbar">
                
                <ul class="flex items-center gap-8 whitespace-nowrap">

                    <li>
                        <a href="<?php echo esc_url( home_url('/category/') ); ?>"
                        class="media-menu__tab uppercase block py-3 text-[15px] leading-[18px] font-bold hover:text-black">
                            All News
                        </a>
                    </li>

                    <?php foreach ($categories as $category) : ?>
                        <li>
                            <a href="<?php echo esc_url( get_category_link($category->term_id) ); ?>"
                            class="media-menu__tab uppercase block py-3 text-[15px] leading-[18px] font-bold hover:text-black">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>

                </ul>

            </div>
            <?php endif; ?>
            <!-- All Tags Button -->
            <button class="media-menu__tags-btn cursor-pointer flex items-center gap-2 uppercase font-bold text-[15px] leading-[15px] transition-all duration-300 text-slate-400 hover:text-blue-600">
                <span class="group-hover:text-blue-600 peer-checked:text-blue-600">All tags</span>
                <svg class="transition-transform duration-300 transform group-hover:stroke-blue-600" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9l6 6 6-6"></path>
                </svg>
            </button>
        </div>

        <!-- Мобільне меню -->
        <div class="media-menu__navigation  transition-all duration-500 max-h-0 opacity-0 mobile">
            <ul class="flex flex-col sm:flex-row items-start sm:items-center justify-start sm:justify-between w-full whitespace-nowrap">
                
                <li class="flex-1 text-left">
                <a href="/all-news.html" class="media-menu__tab active uppercase py-3 text-[15px] leading-[18px] font-bold inline-block relative hover:text-black">
                    All news
                </a>
                </li>
                <?php foreach ( $categories as $category ) : ?>
                <li class="flex-1 text-left">
                <a href="<?php echo esc_url(get_category_link( $category->term_id ) ); ?>" class="media-menu__tab uppercase py-3 text-[15px] leading-[18px] font-bold inline-block relative hover:text-black">
                    <?php echo esc_html ( $category->name ); ?>
                </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- tags -->
        <div class="media-menu__tags overflow-hidden transition-all duration-500 max-h-0 opacity-0">

            <ul class="media-menu__tags-list grid grid-cols-1 md:grid-cols-3 gap-y-4 py-8">
                <?php if (!empty($tags)) : ?>
                    <?php foreach ($tags as $tag) : ?>
                        <li>
                            <a 
                                href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                                class="media-menu__tag uppercase text-[15px] leading-[18px] font-bold text-[#9395ab] hover:text-[#252735] transition-all duration-300 cursor-pointer"
                            >
                                #<?php echo esc_html($tag->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</div>