<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Create GNEWS table using PHP 
function theme_create_api_response_table() {

    global $wpdb;

    $table = $wpdb->prefix . 'gnews_response';
    $charset_collate = $wpdb->get_charset_collate();

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $sql = "CREATE TABLE $table (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

        -- Унікальний ідентифікатор статті
        article_id VARCHAR(64) NOT NULL,

        -- Контент статті
        title TEXT NOT NULL,
        description TEXT NULL,
        content LONGTEXT NULL,

        url TEXT NOT NULL,
        image TEXT NULL,

        published_at DATETIME NULL,
        lang VARCHAR(10) NULL,

        source_id VARCHAR(64) NULL,
        source_name VARCHAR(255) NULL,
        source_url TEXT NULL,
        source_country VARCHAR(10) NULL,

        raw_response LONGTEXT NULL,

        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        -- доступ по ID
        PRIMARY KEY (id),
        UNIQUE KEY article_id (article_id)
    ) $charset_collate;";

    // dbDelta cтворює таблицю
    dbDelta($sql);
}
// use action after_switch_theme because theme_create_gnews_response_table is used only in this theme
add_action('after_switch_theme', 'theme_create_api_response_table');

// 1. Get posts from GNEWS API 
// returns an array with $data['articles']
function theme_get_api( array $props = [] ) {

    $defaults = [
        'query'   => 'google',
        'lang'    => 'en',
        'country' => 'us',
        'max'     => 10,
    ];

    $props = array_merge( $defaults, $props );
    $api_key = 'd1e76397f969d22c20873b9d955a31bc';

    $url = "https://gnews.io/api/v4/search?q={$props['query']}&lang={$props['lang']}&country={$props['country']}&max={$props['max']}&apikey={$api_key}";

    $response = wp_remote_get( $url, [ 'timeout' => 15 ] );

    if ( is_wp_error( $response ) ) {
        return [];
    }

    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    if ( empty( $data['articles'] ) ) {
        return [];
    }

    return $data['articles'];
}

// 2. Save GNews API articles into wp_gnews_response database table
function theme_save_api_response_table( array $articles ) {
    // Get access to WordPress database
    global $wpdb;

    // Table name with WordPress prefix
    $table = $wpdb->prefix . 'gnews_response';

    // Stop function if articles array is empty
    if ( empty( $articles ) ) {
        return false;
    }

    // Loop through all articles
    foreach ( $articles as $article ) {

        // Skip article if article id does not exist
        if ( empty( $article['id'] ) ) {
            continue;
        }

        // Check if article already exists in database
        $exists = $wpdb->get_var(
            $wpdb->prepare(
                "
                SELECT article_id 
                FROM $table 
                WHERE article_id = %s
                ",
                $article['id']
            )
        );

        // Skip duplicate article
        if ( $exists ) {
            continue;
        }

        // Insert article into database
        $result = $wpdb->insert(
            $table,
            [
                // Article fields
                'article_id'     => $article['id'],
                'title'          => $article['title'] ?? '',
                'description'    => $article['description'] ?? '',
                'content'        => $article['content'] ?? '',
                'url'            => $article['url'] ?? '',
                'image'          => $article['image'] ?? '',
                'published_at'   => $article['publishedAt'] ?? '',
                'lang'           => $article['lang'] ?? '',
            ],
            [
                // Data formats
                '%s', // article_id
                '%s', // title
                '%s', // description
                '%s', // content
                '%s', // url
                '%s', // image
                '%s', // published_at
                '%s', // lang
            ]
        );
        // Optional error log
        if ( $result === false ) {

            error_log(
                'GNews insert error: ' . $wpdb->last_error
            );
        }
    }

    return true;
}

// 3. Get articles from table wp_gnews_response
function theme_get_api_response_table() {
    global $wpdb;

    $table = $wpdb->prefix . 'gnews_response';

    return $wpdb->get_results("
        SELECT *
        FROM {$table}
    ");
}

// 4. Articles exists helper func
function theme_post_exists_by_slug( string $title ) {

    $slug = sanitize_title( $title );

    $existing_post = get_page_by_path( $slug, OBJECT, 'post' );

    return ! empty( $existing_post );
}

// Sanitize article data before insert
function theme_sanitize_post( object $article ) {
    // Make all items 
    $title = isset( $article->title ) && !empty( $article->title ) ? wp_strip_all_tags( $article->title ) : '';

    return [
        'title'       => $title,
        'slug'        => sanitize_title( $article->title ?? '' ),
        'content'     => wp_kses_post( $article->content ?? '' ),
        'excerpt'     => sanitize_text_field( $article->description ?? '' ),
        'image'       => esc_url_raw( $article->image ?? '' ),
        'published_at'=> ! empty( $article->published_at )
            ? date( 'Y-m-d H:i:s', strtotime( $article->published_at ) )
            : current_time( 'mysql' ),
    ];
}

// 5. Create WP post
function theme_insert_post( array $article ) {

    $post_data = [
        'post_title'   => $article['title'],
        'post_name'    => $article['slug'],
        'post_content' => $article['content'],
        'post_excerpt' => $article['excerpt'],
        'post_status'  => 'publish',
        'post_type'    => 'post',
    ];

    // Insert post
    $post_id = wp_insert_post( $post_data );

    if ( is_wp_error( $post_id ) ) {
        return false;
    }

    // Set featured image
    if ( ! empty( $article['image'] ) ) {

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $attachment_id = media_sideload_image(
            $article['image'],
            $post_id,
            $article['title'],
            'id'
        );

        if ( ! is_wp_error( $attachment_id ) ) {
            set_post_thumbnail( $post_id, $attachment_id );
        }
    }

    // optional meta
    update_post_meta( $post_id, 'published_at', $article['published_at'] );

    return $post_id;
}

function theme_posts_save($posts) {
    if ( ! empty( $posts ) ) {

        foreach ( $posts as $post ) {
            if ( theme_post_exists_by_slug( $post->title ) ) {
                continue;
            }
            // виконується для нових постів для тих що були створені не виконується
            $post_object = theme_sanitize_post( $post );
            $post_id = theme_insert_post( $post_object );
        }
    }
}

// helper function to remove … [3928 chars] from content
function theme_clean_content() {

}

// 8. GNEWS import run
function theme_handler_api() {
    $api = theme_get_api();
    theme_save_api_response_table( $api );
    $posts = theme_get_api_response_table();
    theme_posts_save($posts);
}

theme_handler_api();