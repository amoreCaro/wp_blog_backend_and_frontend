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

        category_slug VARCHAR(255) NULL,
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

        -- для відслідковування які пости записані у WP 
        processed TINYINT(1) DEFAULT 0, 
        -- Статус обробки статті:
        -- 0 = ще не імпортовано в WordPress
        -- 1 = вже створено WP пост

        wp_post_id BIGINT(20) NULL,
        -- ID створеного WordPress поста
        -- використовується для зв'язку між API записом і WP постом

        imported_at DATETIME NULL,
        -- Дата і час, коли стаття була успішно імпортована в WordPress
        -- використовується для логування та контролю імпорту

        failed TINYINT(1) DEFAULT 0,
        -- Статус помилки при імпорті:
        -- 0 = без помилок
        -- 1 = імпорт завершився помилкою

        error_message TEXT NULL
        -- Текст помилки, якщо імпорт не вдався
        -- використовується для дебагу та аналізу причин failure
    ) $charset_collate;";

    // dbDelta cтворює таблицю
    dbDelta($sql);
}

// use action after_switch_theme because theme_create_gnews_response_table is used only in this theme
add_action('after_switch_theme', 'theme_create_api_response_table');

// 1. Get posts from API 
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

// 3. Get articles from table
function theme_get_api_response_table() {
    global $wpdb;

    $table = $wpdb->prefix . 'gnews_response';

    return $wpdb->get_results("
        SELECT * FROM gnews_response
            WHERE processed = 0
            LIMIT N
    ");
}

// 4. Check if post exists helper by slug
function theme_post_exists_by_slug( string $title ) {

    $slug = sanitize_title( $title );

    $existing_post = get_page_by_path( $slug, OBJECT, 'post' );

    return ! empty( $existing_post );
}

// 5. Sanitize article data before insert
function theme_sanitize_post( object $article ) {
    $title = isset( $article->title ) && !empty( $article->title ) ? wp_strip_all_tags( $article->title ) : '';
    $category = isset( $article->category ) && ! empty( $article->category ) ? sanitize_text_field( $article->category ) : '';
    $slug = isset( $article->title ) && !empty( $article->title ) ? sanitize_title( $article->title ) : '';
    $content = isset( $article->content ) && !empty( $article->content ) ?  theme_clean_content( wp_kses_post( $article->content ) ) : '';
    $excerpt = isset( $article->description ) && !empty( $article->description ) ? sanitize_text_field( $article->description ) : '';
    $image = isset( $article->image ) && !empty( $article->image ) ? esc_url( $article->image ) : '';
    $published_at = isset( $article->published_at ) && ! empty( $article->published_at )
    ? date( 'Y-m-d H:i:s', strtotime( sanitize_text_field( $article->published_at ) ) )
    : current_time( 'mysql' );

    return [
        'title'       => $title,
        'category'       => $category,
        'slug'        => $slug,
        'content'     => $content,
        'excerpt'     => $excerpt,
        'image'       => $image,
        'published_at' => $published_at,
    ];
}


// 6. Create WP post
function theme_insert_post(array $article) {

    // 1. Create post
    $post_data = [
        'post_title'   => $article['title'] ?? '',
        'post_name'    => $article['slug'] ?? '',
        'post_content' => $article['content'] ?? '',
        'post_excerpt' => $article['excerpt'] ?? '',
        'post_status'  => 'publish',
        'post_type'    => 'post',
    ];

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id) || !$post_id) {
        return false;
    }

    if (!empty($article['category'])) {

        $category_slug = sanitize_title($article['category']);

        // check if term exists
        $term = get_term_by('slug', $category_slug, 'category');

        // if not exists → create it
        if (!$term) {
            $term_result = wp_insert_term($category_slug, 'category');

            if (!is_wp_error($term_result)) {
                $term_id = $term_result['term_id'];
            } else {
                $term_id = 0;
            }
        } else {
            $term_id = $term->term_id;
        }

        // assign category to post
        if (!empty($term_id)) {
            wp_set_post_terms($post_id, [$term_id], 'category');
        }
    }

    // 3. Featured image
    if (!empty($article['image'])) {
        theme_insert_post_thumbnail(
            $post_id,
            $article['image'],
            $article['title']
        );
    }

    // 4. Meta
    if (!empty($article['published_at'])) {
        update_post_meta($post_id, 'published_at', $article['published_at']);
    }

    // 5. Optional: prevent duplicates (store external ID if exists)
    if (!empty($article['id'])) {
        update_post_meta($post_id, 'external_id', $article['id']);
    }

    return $post_id;
}

// Insert post thumbnail 
function theme_insert_post_thumbnail( int $post_id, string $image, string $title = '' ) {

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $attachment_id = media_sideload_image(
        $image,
        $post_id,
        $title,
        'id'
    );

    if ( is_wp_error( $attachment_id ) ) {
        return false;
    }

    set_post_thumbnail( $post_id, $attachment_id );

    return $attachment_id;
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
function theme_clean_content( string $content ) {

    $position = strpos( $content, '... [' );

    if ( $position !== false ) {
        $content = substr( $content, 0, $position );
    }

    return trim( $content );
}

// Get posts categories
function theme_get_posts_categories() {

    $categories = get_categories([
        'taxonomy'   => 'category',
        'hide_empty' => false,
    ]);

    $category_slugs = [];

    foreach ($categories as $category) {
        $category_slugs[] = $category -> slug;
    }

    return $category_slugs;
}


/**
 * Get posts from API by category
 */
function theme_api_posts_by_category(
    string $category_name,
    int $limit = 1,
    int $paged = 1,
    string $lang = 'en'
): array {

    $allowed_categories = [
        'general',
        'world',
        'nation',
        'business',
        'technology',
        'entertainment',
        'sports',
        'science',
        'health',
    ];

    $category_name = sanitize_text_field($category_name);
    $lang          = sanitize_text_field($lang);
    $limit         = absint($limit);
    $paged         = absint($paged);

    if ( ! in_array($category_name, $allowed_categories, true) ) {
        $category_name = 'general';
    }

    $api_key = '9ada3a7b19304eb54178900d655b3a28';

    $url = add_query_arg([
        'category' => $category_name,
        'lang'     => $lang,
        'max'      => $limit,
        'page'     => $paged,
        'apikey'   => $api_key,
    ], 'https://gnews.io/api/v4/top-headlines');

    $response = wp_remote_get($url);

    if ( is_wp_error($response) ) {
        return [];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);


    return $data['articles'] ?? [];
}


function theme_handler_posts_by_categories(
    int $limit = 12,
    int $paged = 1,
    string $lang = 'en'
){

    $categories = theme_get_posts_categories();

    if (empty($categories)) {
        return;
    }

    foreach ($categories as $category_slug) {

        $posts = theme_api_posts_by_category(
            $category_slug,
            $limit,
            $paged,
            $lang
        );

        if (empty($posts)) {
            continue;
        }

        foreach ($posts as $post) {

            // додаємо категорію прямо тут
            $post['category'] = $category_slug;

            // санітизація
            $post_object = (object) $post;

            $clean_post = theme_sanitize_post($post_object);

            theme_insert_post($clean_post);
        }
    }
}

// $data = theme_handler_posts_by_categories(
//     1,      
//     1,      
//     'en'   
// );


// function theme_handler_api() {
//     $api = theme_get_api();
//     theme_save_api_response_table( $api );
//     $posts = theme_get_api_response_table();
//     theme_posts_save($posts);
// }

// theme_handler_api();