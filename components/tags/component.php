<?php
if (!defined('ABSPATH')) {
    exit;
}

$tags = get_the_tags();

if (isset( $tags ) && !empty($tags)) : ?>
    <div class="post__tags flex flex-wrap gap-2 mx-auto mb-12">
        <?php foreach ($tags as $tag) : 
            $tag_link = get_term_link($tag); 
            if (is_wp_error($tag_link)) continue;
        ?>
            <a href="<?php echo esc_url($tag_link); ?>"
            class="font-medium text-[12px] leading-[12px] uppercase p-2 text-[#9395ab]/80 border border-[#9395ab] transition-colors hover:text-blue-400 hover:border-blue-400">
                <?php echo esc_html($tag->name); ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>