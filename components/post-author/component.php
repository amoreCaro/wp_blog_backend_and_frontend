<?php
if (!defined('ABSPATH')) {
    exit;
}

$author_id = get_post_field('post_author', get_the_ID());
$avatar_url = get_avatar_url($author_id, ['size' => 48]);
$display_name = get_the_author_meta('display_name', $author_id);
$share_url   = urlencode(get_permalink());
$share_title = urlencode(get_the_title());
?>

<div class="post__author flex flex-col md:flex-row justify-between md:items-center text-white max-w-[800px] mx-auto">
    <div class="post__author-name flex gap-3 mb-8 md:mb-0">
        <div class="flex items-center gap-3">
            <?php if ( $avatar_url ) : ?>
                <div class="post__author-name-img shrink-0">
                    <picture class="block w-full h-full">
                        <img 
                            src="data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23cccccc'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E" 
                            data-src="<?php echo esc_url($avatar_url); ?>" 
                            alt="<?php echo esc_attr($display_name); ?>" 
                            width="48" 
                            height="48" 
                            loading="lazy" 
                            decoding="async"
                            class="lazy-img w-12 h-12 rounded-full object-cover bg-[#f5f5f5]"
                        >
                    </picture>
                </div>
            <?php endif; ?>
        </div>
        <div class="post__author-name-txt flex flex-col">
            <span class="text-white text-[16px] leading-[26px] font-semibold"><?php echo esc_html($display_name); ?></span>
            <time class="text-[#c2c5c9] text-[13px] leading-[16px] font-bold" datetime="<?php echo get_the_date('c'); ?>">
                <?php echo get_the_date(); ?>
            </time>
        </div>
    </div>


<div class="post__author-share items-center flex gap-3">
    <span class="text-white text-[16px] leading-[26px] font-semibold">Share</span>
    <div class="flex gap-2 text-white items-center">
        
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" 
           target="_blank" rel="nofollow" 
           class="flex items-center justify-center w-[32px] h-[32px]">
            <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 8C16 3.6 12.4 0 8 0C3.6 0 0 3.6 0 8C0 12 2.9 15.3 6.7 15.9V10.3H4.7V8H6.7V6.2C6.7 4.2 7.9 3.1 9.7 3.1C10.6 3.1 11.5 3.3 11.5 3.3V5.3H10.5C9.5 5.3 9.2 5.9 9.2 6.5V8H11.4L11 10.3H9.1V16C13.1 15.4 16 12 16 8Z" fill="white"></path>
            </svg>
        </a>
        
        <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" 
           target="_blank" rel="nofollow" 
           class="flex items-center justify-center w-[32px] h-[32px]">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.70409 10.9364L0.0486662 0H6L10.9677 7.09678L17 0H20L12.3224 9.03246L20 20H14.0487L9.05906 12.8717L3 20H0L7.70409 10.9364ZM4.35459 1.37629H3.62057L15.6937 18.6237H16.4278L4.35459 1.37629Z" fill="white"></path>
            </svg>
        </a>
        
        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" 
           target="_blank" rel="nofollow" 
           class="flex items-center justify-center w-[32px] h-[32px]">
            <svg width="20" height="20" viewBox="0.5 0.5 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.56602 18.0003H0.882679V6.40866H4.56602V18.0003ZM2.72435 4.78366C1.53268 4.78366 0.666016 3.91699 0.666016 2.72533C0.666016 1.53366 1.64102 0.666992 2.72435 0.666992C3.91602 0.666992 4.78269 1.53366 4.78269 2.72533C4.78269 3.91699 3.91602 4.78366 2.72435 4.78366ZM17.9993 18.0003H14.316V11.717C14.316 9.87533 13.5577 9.33366 12.4743 9.33366C11.391 9.33366 10.3077 10.2003 10.3077 11.8253V18.0003H6.62435V6.40866H10.091V8.03366C10.416 7.27533 11.716 6.08366 13.5577 6.08366C15.616 6.08366 17.7827 7.27533 17.7827 10.8503V18.0003H17.9993Z" fill="white"></path>
            </svg>
        </a>
        
    </div>
</div>
</div>