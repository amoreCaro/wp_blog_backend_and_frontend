<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function gnews_import_articles( $query = 'travel', $lang = 'en', $country = 'us', $max = 1 ) {

    $api_key = '32d8badeeee982e0465cb7c4ebd3ffa7';
    $url = "https://gnews.io/api/v4/search?q={$query}&lang={$lang}&country={$country}&max={$max}&apikey={$api_key}";

    $response = wp_remote_get( $url, [ 'timeout' => 15 ] );

    if ( is_wp_error( $response ) ) {
        return;
    }

    // get data
    $body = wp_remote_retrieve_body( $response );

    // data to array
    $data = json_decode( $body, true );

    // return 
    if ( empty( $data['articles'] ) ) {
        return;
    }

    //  get database
    global $wpdb;

    //  set table to wp_gnews_response
    $table = $wpdb->prefix . 'gnews_response';
    $saved          = 0;
    $skipped        = 0;

    // get articles 
    foreach ( $data['articles'] as $article ) {

        $article_id = md5( $article['url'] );

        $exists = $wpdb->get_var(
            $wpdb->prepare( "SELECT id FROM {$table} WHERE article_id = %s", $article_id )
        );

        if ( $exists ) {
            $skipped++;
            continue;
        }

        $insert_result = $wpdb->insert( $table, [
            'article_id'     => $article_id,
            'title'          => $article['title']             ?? '',
            'description'    => $article['description']       ?? '',
            'url'            => $article['url']               ?? '',
            'image'          => $article['image']             ?? '',
            'published_at'   => $article['publishedAt']       ?? '',
            'lang'           => $article['lang']              ?? '',
            'source_name'    => $article['source']['name']    ?? '',
            'source_url'     => $article['source']['url']     ?? '',
            'source_country' => $article['source']['country'] ?? '',
            'content'        => $article['content']           ?? '',
        ] );

        if ( $insert_result !== false ) {
            $saved++;
        }
    }
    dd($data['articles']);
    exit;
}

function get_all_posts_from_gnews_db() {
    global $wpdb;

    $table = $wpdb->prefix . 'gnews_response';

    $posts = $wpdb->get_results("
        SELECT *
        FROM {$table}
    ");

    if (empty($posts)) {
        return;
    }

foreach ($posts as $post) {

    $slug = sanitize_title($post->title);

    $existing = get_page_by_path($slug, OBJECT, 'post');

    if ($existing) {
        continue;
    }

    $post_id = wp_insert_post([
        'post_title'   => wp_strip_all_tags($post->title),
        'post_name'    => $slug,
        'post_content' => $post->content ?? '',
        'post_excerpt' => $post->description ?? '',
        'post_status'  => 'publish',
        'post_type'    => 'post',
        'post_date'    => date('Y-m-d H:i:s', strtotime($post->published_at)),
    ]);

    if ($post_id && !empty($post->image)) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $image_id = media_sideload_image($post->image, $post_id, null, 'id');

        if (!is_wp_error($image_id)) {
            set_post_thumbnail($post_id, $image_id);
        }
    }
}
}

gnews_import_articles();
get_all_posts_from_gnews_db();