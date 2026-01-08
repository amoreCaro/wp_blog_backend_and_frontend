<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hero component
 */

$content_raw = get_the_content();
// dd($content_raw);
// exit;
// clear content without HTML
$content_text = trim(wp_strip_all_tags($content_raw));

// Limit text for Read More button
$CONTENT_LIMIT = 200;
$is_long_content = mb_strlen($content_text) > $CONTENT_LIMIT;
?>

<section class="hero">
    <div class="hero__container">

        <div class="hero__wrapper">

            <?php
            require get_template_directory() . '/app/components/hero/socials.php';
            ?>

            <div class="hero__inner">

                <h1 class="hero__title">
                    <?php the_title(); ?>
                </h1>

                <div
                    class="read-more-block"
                    data-read-more
                    data-expanded="false"
                >
                    <div class="read-more-block__content-wrapper">

                        <div
                            class="read-more-block__text is-collapsed"
                            data-content
                        >
                            <?php echo esc_html($content_text); ?>
                        </div>

                        <?php if ($is_long_content): ?>
                            <div class="read-more-block__overlay"></div>
                        <?php endif; ?>

                    </div>

                    <?php if ($is_long_content): ?>
                        <button
                            type="button"
                            class="read-more-block__btn"
                            data-read-more-toggle
                        >
                            Read more
                        </button>
                    <?php endif; ?>
                </div>

                <?php
                $event_date = get_field('acf_event_date');
                if ($event_date):
                ?>
                    <span class="hero__date">
                        <?php echo esc_html($event_date); ?>
                    </span>
                <?php endif; ?>

            </div>
        </div>

        <div class="hero__gallery">
            <?php
            require get_template_directory() . '/app/components/hero/gallery.php';
            ?>
        </div>
    </div>
</section>
