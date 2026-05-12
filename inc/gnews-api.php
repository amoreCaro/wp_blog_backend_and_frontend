<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Fetch posts from GNews API
function get_gnews_data() {

    $url = "https://gnews.io/api/v4/search?q=travel&lang=en&country=us&max=1&apikey=9ada3a7b19304eb54178900d655b3a28";

    $response = wp_remote_get( $url );

    if ( is_wp_error( $response ) ) {
        return null;
    }

    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    if ( empty( $data['articles'] ) ) {
        return null;
    }

    return $data['articles'];
}

/**
 * Save posts WordPress
 *
 */
function save_gnews_data( array $articles ) {

    foreach ( $articles as $article ) {
        $title = ( isset( $article['title'] ) && ! empty( $article['title'] ) )
            ? sanitize_text_field( $article['title'] )
            : '';

        $excerpt = ( isset( $article['description'] ) && ! empty( $article['description'] ) )
            ? sanitize_textarea_field( $article['description'] )
            : '';

        $content = ( isset( $article['content'] ) && ! empty( $article['content'] ) )
            ? wp_kses_post( $article['content'] )
            : '';

        $thumbnail = ( isset( $article['image'] ) && ! empty( $article['image'] ) )
            ? esc_url( $article['image'] )
            : '';

        $article_url = ( isset( $article['url'] ) && ! empty( $article['url'] ) )
            ? esc_url( $article['url'] )
            : '';

        $published_at = ( isset( $article['publishedAt'] ) && ! empty( $article['publishedAt'] ) )
            ? sanitize_text_field( $article['publishedAt'] )
            : '';

        $source_name = ( isset( $article['source']['name'] ) && ! empty( $article['source']['name'] ) )
            ? sanitize_text_field( $article['source']['name'] )
            : '';

        $source_url = ( isset( $article['source']['url'] ) && ! empty( $article['source']['url'] ) )
            ? esc_url( $article['source']['url'] )
            : '';

        $slug = sanitize_title( $title );

        if ( empty( $slug ) ) {
            continue;
        }

        // Ckeck if post exists by slug
        $existing_post = get_page_by_path( $slug, OBJECT, 'post' );

        if ( $existing_post ) {
            continue; 
        }

        //  create post
        $post_id = wp_insert_post( array(
            'post_title'   => $title,
            'post_excerpt' => $excerpt,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => 'post',
        ) );

        if ( is_wp_error( $post_id ) || ! $post_id ) {
            continue;
        }
    }
}

$articles = get_gnews_data();

if ( ! empty( $articles ) ) {
    save_gnews_data( $articles );
}