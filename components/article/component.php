<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$content = apply_filters( 'the_content', get_the_content() );

if ( ! empty( $content ) ) : ?>
    <article class="h-article mb-12">
        <!-- Article -->
        <?php echo $content; ?>
    </article>
<?php endif; ?>