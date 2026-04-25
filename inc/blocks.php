<?php

if (!defined('ABSPATH')) exit;

/**
 * Register custom Gutenberg blocks using ACF.
 *
 * Checks whether ACF Pro is active and the block registration
 * function exists, then registers custom theme blocks.
 *
 */
function theme_acf_blocks() {

    // Check if ACF block registration is available
    if (function_exists('acf_register_block')) {

        /**
         * Banner block
         * Displays a banner section block.
         */
        acf_register_block_type(array(
            'name'            => 'banner',
            'title'           => 'Block - Banner',
            'category'        => 'awenn',
            'render_template' => PATH . '/blocks/banner/preview.php',
            'mode'            => 'preview',
            'icon'            => 'cover-image',
            'keywords'        => array('banner'),
            'enqueue_style'   => get_template_directory_uri() . '/blocks/banner/style.css',
        ));

        /**
         * Products block
         * Displays a products section block.
         */
        acf_register_block(array(
            'name'            => 'products',
            'title'           => 'Block - Products',
            'category'        => 'awenn',
            'render_template' => PATH . '/blocks/products/preview.php',
            'mode'            => 'preview',
            'icon'            => 'cart',
            'keywords'        => array('products'),
        ));

        /**
         * Innovation block
         * Displays a innovation section block.
         */
        acf_register_block(array(
            'name'            => 'innovation',
            'title'           => 'Block - Innovation',
            'category'        => 'awenn',
            'render_template' => PATH . '/blocks/innovation/preview.php',
            'mode'            => 'preview',
            'icon'            => 'lightbulb',
            'keywords'        => array('products', 'shop'),
        ));

        /**
         * Dedicated block
         * Displays a products section block.
         */
        acf_register_block(array(
            'name'            => 'dedicated',
            'title'           => 'Block - Dedicated',
            'category'        => 'awenn',
            'render_template' => PATH . '/blocks/dedicated/preview.php',
            'mode'            => 'preview',
            'icon'            => 'cart',
            'keywords'        => array('dedicated'),

            // 'enqueue_style'   => THEME . '/blocks/dedicated/style.css',
        ));

        /**
         * News block
         * Displays a news section block.
         */
        acf_register_block(array(
            'name'            => 'news',
            'title'           => 'Block - News',
            'category'        => 'awenn',
            'render_template' => PATH . '/blocks/news/preview.php',
            'mode'            => 'preview',
            'icon'            => 'megaphone',
            'keywords'        => array('products', 'shop'),
        ));

        /**
         * Leaders block
         * Displays a leaders section block.
         */
        acf_register_block(array(
            'name'            => 'leaders',
            'title'           => 'Block - Leaders',
            'category'        => 'awenn',
            'render_template' => PATH . '/blocks/leaders/preview.php',
            'mode'            => 'preview',
            'icon'            => 'groups',
            'keywords'        => array('products', 'shop'),
        ));
    }
}

// Register blocks when ACF is initialized
add_action('acf/init', 'theme_acf_blocks');