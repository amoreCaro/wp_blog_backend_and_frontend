<?php 

if ( ! defined( 'ABSPATH' ) ) {
 exit;
}

setup_postdata($post);

$post_id     = $post->ID;

$date       = get_the_date('', $post_id);
$avatar_url = get_avatar_url($author_id, ['size' => 28]);
$username = get_the_author_meta('display_name', $author_id);
?>

<section class="magazine ">
    <div class="container grid grid-cols-1 gap-5 md:max-w-[768px] md:px-4 lg:max-w-[1280px] xl:px-[0px] md:gap-7 lg:grid-cols-2 px-4">
        <!-- left -->
        <div>
            <!-- large item -->
            <div>
                <!-- clickable image -->
                <a class="aspect-h-3 aspect-w-4 h-[469px]  relative block h-0 w-full shrink-0 grow overflow-hidden rounded-[24px]" href="">
                    <div class="absolute inset-0">
                        <img class="object-cover w-full h-full" loading="lazy" src="https://www.royalcaribbean.com/media-assets/pmc/content/dam/shore-x/santorini-jtr/soc8-oia-and-fira-town/stock-photo-oia-whitewash-dome-cliff-bay-santorini-greece_387166810.jpg?w=1440" alt="Iconic blue domes and whitewashed buildings of Oia, Santorini overlooking the Aegean Sea">
                    </div>
                </a>
                <!-- content -->
                <div class="mt-5 flex flex-col pe-10 sm:mt-8">
                    <h2 class="font-semibold md:text-[18px] md:leading-[28px] lg:text-[24px] lg:leading-[32px] text-[#111827] hover:text-[#312e81] dark:text-[#f3f4f6] dark:hover:text-[#a5b4fc] ">
                        <a href="">
                            Take a 3D tour through a Microsoft datacenter?
                        </a>
                    </h2>
                    <div class="mt-4 hidden text-[#6b7280] sm:block dark:text-[#9ca3af]">
                        <p>Immerse yourself in the world of literature with our curated collection of books. From bestsellers to hidden gems, our assortment caters to a variety of interests and genres.</p>
                    </div>
                    <div class="mt-5 flex items-center">
                        <a class="flex items-center" href="author">
                            <?php if ( $avatar_url ) : ?>
                                <div class="post__author-name-img mr-2">
                                    <picture class="block w-full h-full">
                                        <img 
                                            src="data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23cccccc'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E" 
                                            data-src="<?php echo esc_url($avatar_url); ?>" 
                                            alt="<?php echo esc_attr($display_name); ?>" 
                                            width="28" 
                                            height="28" 
                                            loading="lazy" 
                                            decoding="async"
                                            class="lazy-img w-[28px] h-[28px] rounded-full object-cover bg-[#f5f5f5]"
                                        >
                                    </picture>
                                </div>
                            <?php endif; ?>
                            <?php if ( $username ) : ?>
                                <span class="block font-medium capitalize text-[14px] leading-[20px] text-[#404040] hover:text-black dark:text-[#d4d4d8] dark:hover:text-white">
                                    <?php echo esc_html( $username ); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <?php if (!empty($date)) : ?>
                            <span class="mx-[6px] font-medium text-[#6C7280] dark:text-[#9DA3AF]">·</span>
                            <time class="font-normal text-[14px] leading-[20px] text-[#6C7280] dark:text-[#9DA3AF]">
                                <?php echo esc_html($date); ?>
                            </time>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- right -->
        <div class="flex flex-col gap-5 md:gap-7">
            <!-- small item -->
            <div class="flex items-stretch justify-between w-full">
                
                <!-- left -->
                <div class="flex flex-1 flex-col py-2">
                    <h2 class="font-semibold text-[16px] leading-[24px] text-[#111827] hover:text-[#312e81] dark:text-[#f3f4f6] dark:hover:text-[#a5b4fc] ">
                        <a href="">
                            How architects visualize design for world’s biggest airport
                        </a>
                    </h2>
                    <div class="my-3 text-[16px] leading-[24px] hidden text-[#6b7280] sm:block dark:text-[#9ca3af] ">
                        <div class="line-clamp-3">
                            <p>Immerse yourself in the world of literature with our curated collection of books. From bestsellers to hidden gems, our assortment caters to a variety of interests and genres.</p>
                        </div>
                    </div>
                    <div class="flex items-center xl:mt-4">
                        <a class="hidden sm:flex items-center" href="author">
                            <?php if ( $avatar_url ) : ?>
                                <div class="post__author-name-img mr-2">
                                    <picture class="block w-full h-full">
                                        <img 
                                            src="data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23cccccc'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E" 
                                            data-src="<?php echo esc_url($avatar_url); ?>" 
                                            alt="<?php echo esc_attr($display_name); ?>" 
                                            width="28" 
                                            height="28" 
                                            loading="lazy" 
                                            decoding="async"
                                            class="lazy-img w-[28px] h-[28px] rounded-full object-cover bg-[#f5f5f5]"
                                        >
                                    </picture>
                                </div>
                            <?php endif; ?>
                            <?php if ( $username ) : ?>
                                <span class="block font-medium capitalize text-[12px] leading-[12px] text-[#404040] hover:text-black dark:text-[#d4d4d8] dark:hover:text-white">
                                    <?php echo esc_html( $username ); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <?php if (!empty($date)) : ?>
                            <span class="mx-[6px] font-medium text-[#6C7280] dark:text-[#9DA3AF] hidden sm:block">·</span>
                            <time class="font-normal mt-4 sm:mt-0 text-[12px] leading-[12px] text-[#6C7280] dark:text-[#9DA3AF]">
                                <?php echo esc_html($date); ?>
                            </time>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- right -->
                <a class="relative ms-4 block h-auto aspect-[1/1] w-24 shrink-0 overflow-hidden rounded-xl sm:ms-5 sm:w-36 lg:w-40 xl:w-48 2xl:w-[200px]" href="">
                    <div class="h-full w-full">
                        <img 
                            class="h-full w-full object-cover rounded-xl sm:rounded-3xl" 
                            src="https://www.royalcaribbean.com/media-assets/pmc/content/dam/shore-x/santorini-jtr/soc8-oia-and-fira-town/stock-photo-oia-whitewash-dome-cliff-bay-santorini-greece_387166810.jpg?w=1440" 
                            alt=""
                        >
                    </div>
                </a>
            </div>
                        <!-- small item -->
            <div class="flex items-stretch justify-between w-full">
                
                <!-- left -->
                <div class="flex flex-1 flex-col py-2">
                    <h2 class="font-semibold text-[16px] leading-[24px] text-[#111827] hover:text-[#312e81] dark:text-[#f3f4f6] dark:hover:text-[#a5b4fc] ">
                        <a href="">
                            How architects visualize design for world’s biggest airport
                        </a>
                    </h2>
                    <div class="my-3 text-[16px] leading-[24px] hidden text-[#6b7280] sm:block dark:text-[#9ca3af] ">
                        <div class="line-clamp-3">
                            <p>Immerse yourself in the world of literature with our curated collection of books. From bestsellers to hidden gems, our assortment caters to a variety of interests and genres.</p>
                        </div>
                    </div>
                    <div class="flex items-center xl:mt-4">
                        <a class="hidden sm:flex items-center" href="author">
                            <?php if ( $avatar_url ) : ?>
                                <div class="post__author-name-img mr-2">
                                    <picture class="block w-full h-full">
                                        <img 
                                            src="data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23cccccc'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E" 
                                            data-src="<?php echo esc_url($avatar_url); ?>" 
                                            alt="<?php echo esc_attr($display_name); ?>" 
                                            width="28" 
                                            height="28" 
                                            loading="lazy" 
                                            decoding="async"
                                            class="lazy-img w-[28px] h-[28px] rounded-full object-cover bg-[#f5f5f5]"
                                        >
                                    </picture>
                                </div>
                            <?php endif; ?>
                            <?php if ( $username ) : ?>
                                <span class="block font-medium capitalize text-[12px] leading-[12px] text-[#404040] hover:text-black dark:text-[#d4d4d8] dark:hover:text-white">
                                    <?php echo esc_html( $username ); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <?php if (!empty($date)) : ?>
                            <span class="mx-[6px] font-medium text-[#6C7280] dark:text-[#9DA3AF] hidden sm:block">·</span>
                            <time class="font-normal mt-4 sm:mt-0 text-[12px] leading-[12px] text-[#6C7280] dark:text-[#9DA3AF]">
                                <?php echo esc_html($date); ?>
                            </time>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- right -->
                <a class="relative ms-4 block h-auto aspect-[1/1] w-24 shrink-0 overflow-hidden rounded-xl sm:ms-5 sm:w-36 lg:w-40 xl:w-48 2xl:w-[200px]" href="">
                    <div class="h-full w-full">
                        <img 
                            class="h-full w-full object-cover rounded-xl sm:rounded-3xl" 
                            src="https://www.royalcaribbean.com/media-assets/pmc/content/dam/shore-x/santorini-jtr/soc8-oia-and-fira-town/stock-photo-oia-whitewash-dome-cliff-bay-santorini-greece_387166810.jpg?w=1440" 
                            alt=""
                        >
                    </div>
                </a>
            </div>
                        <!-- small item -->
            <div class="flex items-stretch justify-between w-full">
                
                <!-- left -->
                <div class="flex flex-1 flex-col py-2">
                    <h2 class="font-semibold text-[16px] leading-[24px] text-[#111827] hover:text-[#312e81] dark:text-[#f3f4f6] dark:hover:text-[#a5b4fc] ">
                        <a href="">
                            How architects visualize design for world’s biggest airport
                        </a>
                    </h2>
                    <div class="my-3 text-[16px] leading-[24px] hidden text-[#6b7280] sm:block dark:text-[#9ca3af] ">
                        <div class="line-clamp-3">
                            <p>Immerse yourself in the world of literature with our curated collection of books. From bestsellers to hidden gems, our assortment caters to a variety of interests and genres.</p>
                        </div>
                    </div>
                    <div class="flex items-center xl:mt-4">
                        <a class="hidden sm:flex items-center" href="author">
                            <?php if ( $avatar_url ) : ?>
                                <div class="post__author-name-img mr-2">
                                    <picture class="block w-full h-full">
                                        <img 
                                            src="data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23cccccc'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E" 
                                            data-src="<?php echo esc_url($avatar_url); ?>" 
                                            alt="<?php echo esc_attr($display_name); ?>" 
                                            width="28" 
                                            height="28" 
                                            loading="lazy" 
                                            decoding="async"
                                            class="lazy-img w-[28px] h-[28px] rounded-full object-cover bg-[#f5f5f5]"
                                        >
                                    </picture>
                                </div>
                            <?php endif; ?>
                            <?php if ( $username ) : ?>
                                <span class="block font-medium capitalize text-[12px] leading-[12px] text-[#404040] hover:text-black dark:text-[#d4d4d8] dark:hover:text-white">
                                    <?php echo esc_html( $username ); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <?php if (!empty($date)) : ?>
                            <span class="mx-[6px] font-medium text-[#6C7280] dark:text-[#9DA3AF] hidden sm:block">·</span>
                            <time class="font-normal mt-4 sm:mt-0 text-[12px] leading-[12px] text-[#6C7280] dark:text-[#9DA3AF]">
                                <?php echo esc_html($date); ?>
                            </time>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- right -->
                <a class="relative ms-4 block h-auto aspect-[1/1] w-24 shrink-0 overflow-hidden rounded-xl sm:ms-5 sm:w-36 lg:w-40 xl:w-48 2xl:w-[200px]" href="">
                    <div class="h-full w-full">
                        <img 
                            class="h-full w-full object-cover rounded-xl sm:rounded-3xl" 
                            src="https://www.royalcaribbean.com/media-assets/pmc/content/dam/shore-x/santorini-jtr/soc8-oia-and-fira-town/stock-photo-oia-whitewash-dome-cliff-bay-santorini-greece_387166810.jpg?w=1440" 
                            alt=""
                        >
                    </div>
                </a>
            </div>
        </div>
    </div>
</section> 