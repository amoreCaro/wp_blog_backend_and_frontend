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
                'category_slug' => $article['category'] ?? '',
            ],
             [
                '%s','%s','%s','%s','%s','%s','%s','%s','%s'
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
// треба додати фільтр по категорії
function theme_get_api_response_table(string $category = '') {

    global $wpdb;

    $table = $wpdb->prefix . 'gnews_response';

    if ($category) {
        return $wpdb->get_results(
            $wpdb->prepare("
                SELECT *
                FROM {$table}
                WHERE category_slug = %s
                ORDER BY id DESC
            ", $category)
        );
    }

    return $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC");
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
    $category = isset( $article->category_slug ) && ! empty( $article->category_slug ) ? sanitize_text_field( $article->category_slug ) : '';
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

    if (!empty($article['id'])) {

        $existing = get_posts([
            'post_type'      => 'post',
            'meta_key'       => 'external_id',
            'meta_value'     => $article['id'],
            'fields'         => 'ids',
            'posts_per_page' => 1,
        ]);

        if (!empty($existing)) {
            return false;
        }
    }

    $post_id = wp_insert_post([
        'post_title'   => $article['title'] ?? '',
        'post_name'    => $article['slug'] ?? '',
        'post_content' => $article['content'] ?? '',
        'post_excerpt' => $article['excerpt'] ?? '',
        'post_status'  => 'publish',
        'post_type'    => 'post',
    ]);

    if (is_wp_error($post_id) || !$post_id) {
        return false;
    }

    if (!empty($article['category'])) {

        $category_slugs = array_filter(
            array_map('trim', explode(',', $article['category']))
        );

        $term_ids = [];

        foreach ($category_slugs as $slug) {

            $term = get_term_by('slug', $slug, 'category');

            if (!$term) {
                $new_term = wp_insert_term($slug, 'category');
                $term_id  = is_array($new_term) ? $new_term['term_id'] : 0;
            } else {
                $term_id = $term->term_id;
            }

            if (!empty($term_id)) {
                $term_ids[] = $term_id;
            }
        }

        if (!empty($term_ids)) {
            wp_set_post_terms($post_id, $term_ids, 'category');
        }
    }

    // thumbnail
    if (!empty($article['image'])) {
        theme_insert_post_thumbnail(
            $post_id,
            $article['image'],
            $article['title']
        );
    }

    if (!empty($article['published_at'])) {
        update_post_meta($post_id, 'published_at', $article['published_at']);
    }

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

function theme_posts_save(array $posts) {

    $result = [
        'inserted' => [],
        'skipped'  => [],
        'errors'   => [],
    ];

    if (empty($posts)) {
        return $result;
    }

    foreach ($posts as $post) {

        $title = $post['title'] ?? '';

        if (!$title) {
            $result['errors'][] = 'Missing title';
            continue;
        }

        // duplicate
        if (theme_post_exists_by_slug($title)) {
            $result['skipped'][] = $title;
            continue;
        }

        // convert array -> object
        $post_object = (object) $post;

        // sanitize
        $sanitized = theme_sanitize_post($post_object);

        // insert
        $post_id = theme_insert_post($sanitized);

        if ($post_id) {
            $result['inserted'][] = $title;
        } else {
            $result['errors'][] = $title;
        }
    }

    return $result;
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

// Get posts from API by category
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

    $api_key = '32d8badeeee982e0465cb7c4ebd3ffa7';

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

// handler
function theme_handler_posts_by_categories() {

    if ( ! wp_verify_nonce($_POST['nonce'], 'api_sync_nonce')) {
        wp_die();
    }

    $categories = isset($_POST['categories']) ? (array) $_POST['categories'] : [];
    $categories = array_map( 'sanitize_text_field', $categories );
    $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 2;
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $lang = isset($_POST['lang']) ? sanitize_text_field($_POST['lang']) : 'en';

    if (empty($categories)) {
        wp_send_json_error([
            'message' => 'Missing categories'
        ]);
    }

    $all_posts = [];

    foreach ($categories as $category) {

        $posts = theme_api_posts_by_category(
            $category,
            $limit,
            $paged,
            $lang
        );

        if (empty($posts)) {
            continue;
        }

        foreach ($posts as &$post) {

            $post['category_slug'] = $category;
        }

        unset($post);


        // Save DB
        theme_save_api_response_table($posts);

        // Create WP posts
        theme_posts_save($posts);

        $all_posts = array_merge(
            $all_posts,
            $posts
        );
    }

    wp_send_json_success([
        'articles'   => $all_posts,
        'count'      => count($all_posts),
        'categories' => $categories
    ]);
}

add_action('wp_ajax_theme_get_posts_by_category', 'theme_handler_posts_by_categories');