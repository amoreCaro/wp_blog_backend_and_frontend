<?php

// Security: no direct access
if ( ! defined('ABSPATH') ) {
    exit;
}

/* -------------------------------------------------
 * Theme setup
 * ------------------------------------------------- */

if ( ! function_exists('theme_setup') ) {
    function theme_setup() {

        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable post thumbnails
        add_theme_support('post-thumbnails');

        // Enable HTML5 markup
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            ]
        );
    }
}
add_action('after_setup_theme', 'theme_setup');

if ( ! function_exists('theme_add_svg_upload') ) {
    function theme_add_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
    }
    add_filter('upload_mimes', 'theme_add_svg_upload');
}


/* -------------------------------------------------
 * Navigation menus
 * ------------------------------------------------- */

if ( ! function_exists('theme_register_menus') ) {
    function theme_register_menus() {
        register_nav_menus([
            'header_menu' => __('Header Menu', 'theme'),
            'footer_menu' => __('Footer Menu', 'theme'),
        ]);
    }
}
add_action('after_setup_theme', 'theme_register_menus');


/* -------------------------------------------------
 * ACF Options Page
 * ------------------------------------------------- */

add_action('acf/init', 'theme_add_global_settings');

function theme_add_global_settings() {

    if (function_exists('acf_add_options_page')) {

        acf_add_options_page([
            'page_title'  => 'Global Settings',
            'menu_title'  => 'Global Settings',
            'menu_slug'   => 'global-settings',
            'capability'  => 'manage_options',
            'redirect'    => false,
            'position'    => 2,
            'icon_url'    => 'dashicons-admin-generic'
        ]);

    }

}

add_action('admin_menu', function () {
    add_menu_page(
        'API Sync',
        'API Sync',
        'manage_options',
        'api-sync',
        'theme_api_sync_page',
        'dashicons-update',
        25
    );
});
 
add_action('admin_menu', function () {
    add_menu_page(
        'API Sync',
        'API Sync',
        'manage_options',
        'api-sync',
        'theme_api_sync_page',
        'dashicons-update',
        25
    );
});

function theme_api_sync_page() {
    $categories = get_categories([
        'taxonomy'   => 'category',
        'hide_empty' => false
    ]);
    ?>

    <div class="api">

        <!-- HEADER -->
        <div class="api__header">
            <h1 class="api__title"><?php _e("API Synchronization", THEME); ?></h1>
            <p class="api__subtitle"><?php _e("Manage and run content import from external API sources", THEME); ?></p>
        </div>

        <!-- GRID -->
        <div class="api__grid">

            <!-- LEFT CARD -->
            <div class="api__card">

                <div class="api__card-header">
                    <span class="api__badge"><?php _e("Configuration", THEME); ?></span>
                    <h2 class="api__card-title"><?php _e("Sync Settings", THEME); ?></h2>
                    <p class="api__card-desc"><?php _e("Configure import parameters", THEME); ?></p>
                </div>

                <div class="api__field">
                    <label class="api__field-label" for="api-category"><?php _e("Category", THEME); ?></label>

                    <select class="api__field-select" id="api-category">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo esc_attr($cat->slug); ?>">
                                <?php echo esc_html($cat->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button id="start-sync" class="api__btn" type="button">
                    <?php _e("Start Synchronization", THEME); ?>
                </button>

            </div>

            <!-- RIGHT CARD -->
            <div class="api__card">

                <div class="api__card-header">
                    <span class="api__badge"><?php _e("Live status", THEME); ?></span>
                    <h2 class="api__card-title"><?php _e("Progress", THEME); ?></h2>
                    <p class="api__card-desc"><?php _e("Real-time synchronization status", THEME); ?></p>
                </div>

                <div class="api__progress">

                    <div class="api__progress-track">
                        <div class="api__progress-fill" id="api-progress-fill"></div>
                    </div>

                    <div class="api__progress-meta">
                        <span class="api__progress-percent" id="sync-percent">0%</span>
                        <span class="api__progress-status">0 / 0 items</span>
                    </div>

                </div>

                <div class="api__stats">

                    <div class="api__stat api__stat--success">
                        <div class="api__stat-value" id="sync-imported">0</div>
                        <div class="api__stat-label"><?php _e("Imported", THEME); ?></div>
                    </div>

                    <div class="api__stat api__stat--warn">
                        <div class="api__stat-value" id="sync-skipped">0</div>
                        <div class="api__stat-label"><?php _e("Skipped", THEME); ?></div>
                    </div>

                </div>

            </div>

        </div>
    </div>
 
    <style>
/* =========================
   BLOCK: API
========================= */
.api {
    max-width: 860px;
    padding: 20px;
}

/* HEADER */
.api__header {
    margin-bottom: 20px;
}

.api__title {
    font-size: 22px;
    font-weight: 600;
    margin: 0 0 4px;
    color: #1a1917;
}

.api__subtitle {
    font-size: 13px;
    color: #8a8880;
    margin: 0;
}

/* GRID */
.api__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

/* CARD */
.api__card {
    background: #ffffff;
    border: 1px solid #e2dff0;
    border-radius: 16px;
    padding: 20px;
}

/* CARD HEADER */
.api__card-header {
    margin-bottom: 16px;
}

.api__badge {
    display: inline-block;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #7c6fff;
    background: #f0eeff;
    border: 1px solid #d9d4ff;
    padding: 3px 8px;
    border-radius: 6px;
    margin-bottom: 6px;
}

.api__card-title {
    font-size: 15px;
    font-weight: 600;
    margin: 0;
    color: #1a1917;
}

.api__card-desc {
    font-size: 12px;
    color: #9a9793;
    margin: 2px 0 0;
}

/* FIELD */
.api__field {
    margin-bottom: 16px;
}

.api__field-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #3d3a4a;
}

.api__field-select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d9d4ff;
    border-radius: 10px;
    background: #faf9ff;
    font-size: 13px;
    outline: none;
    cursor: pointer;
}

/* BUTTON */
.api__btn {
    width: 100%;
    padding: 12px 14px;
    background: #2d2c2b;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.15s ease;
}

.api__btn:hover {
    background: #1a1917;
}

.api__btn.disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* PROGRESS */
.api__progress {
    margin-bottom: 16px;
}

.api__progress-track {
    height: 6px;
    background: #ece9ff;
    border-radius: 999px;
    overflow: hidden;
    margin-bottom: 10px;
}

.api__progress-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #7c6fff, #a78bfa);
    transition: width 0.3s ease;
}

.api__progress-meta {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #9a9793;
}

.api__progress-percent {
    font-size: 20px;
    font-weight: 600;
    color: #1a1917;
}

/* STATS */
.api__stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.api__stat {
    background: #faf9ff;
    border: 1px solid #e2dff0;
    border-radius: 10px;
    padding: 10px 12px;
}

.api__stat-value {
    font-size: 16px;
    font-weight: 600;
    color: #1a1917;
}

.api__stat-label {
    font-size: 11px;
    color: #9a9793;
}

/* MODIFIERS */
.api__stat--success .api__stat-value {
    color: #6d28d9;
}

.api__stat--warn .api__stat-value {
    color: #1a1917;
}
    </style>
 
    <?php
}
 
/* -------------------------------------------------
 * Locations taxonomy
 * ------------------------------------------------- */
if ( ! function_exists('theme_register_locations_taxonomy') ) {
    function theme_register_locations_taxonomy() {
        $labels = [
            'name'              => 'Locations',
            'singular_name'     => 'Location',
            'search_items'      => 'Search Locations',
            'all_items'         => 'All Locations',
            'parent_item'       => 'Parent Location',
            'parent_item_colon' => 'Parent Location:',
            'edit_item'         => 'Edit Location',
            'update_item'       => 'Update Location',
            'add_new_item'      => 'Add New Location',
            'new_item_name'     => 'New Location Name',
            'menu_name'         => 'Locations',
        ];

        $args = [
            'labels'            => $labels,
            'public'            => true,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_in_rest'      => true, 
            'rewrite'           => ['slug' => 'location'    
],
        ];

        register_taxonomy('locations', ['post'], $args);
    }
}
add_action('init', 'theme_register_locations_taxonomy');

add_filter('acf/fields/taxonomy/query/name=bento_category', function($args) {
    $args['hide_empty'] = true;
    $args['orderby'] = 'count';
    $args['order'] = 'DESC';

    return $args;
});


add_action('acf/save_post', 'theme_listing_category_svg_save', 20);


if ( ! function_exists('theme_listing_category_svg_save') ) {
    function theme_listing_category_svg_save($post_id) {

        if ( is_admin() && isset($_GET['taxonomy']) && $_GET['taxonomy'] === 'category' ){
            return;
        }

        $file_field = 'category_icon';

        $file_id = get_field($file_field, $post_id);

        if (!$file_id) {
            return;
        }

        $file_path = get_attached_file($file_id);


        if (!$file_path || !file_exists($file_path)) {
            return;
        }

        if (pathinfo($file_path, PATHINFO_EXTENSION) !== 'svg') {
            return;
        }

        $svg_content = file_get_contents($file_path);

        if (!$svg_content) {
            return;
        }

        $term_id = str_replace('term_', '', $post_id);

        update_term_meta($term_id, 'category_icon_svg', $svg_content);
    }
}


add_filter('acf/fields/taxonomy/query', function($args, $field, $post_id) {

    // Фільтруємо тільки категорії
    if($field['taxonomy'] === 'category' || $field['taxonomy'] === 'post_tag') {
        $args['hide_empty'] = true;
    }

    return $args;
}, 10, 3);


add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->is_main_query() && is_archive()) {
        $query->set('posts_per_page', 12);
    }
});


/**
 * Extend WordPress search (pre_get_posts)
 * - limit to posts
 * - keep default search (title, content, excerpt)
 * - add taxonomy search (category, tag, locations)
 */
add_action('pre_get_posts', function ($query) {

    if (is_admin() || !$query->is_main_query() || !$query->is_search()) {
        return;
    }

    $search = trim($query->get('s'));
    if (!$search) return;

    set_query_var('original_search', $search);

    $slug = sanitize_title($search);

    $tax_query = ['relation' => 'OR'];
    $has_tax = false;

    // category
    if ($cat = get_term_by('slug', $slug, 'category')) {
        $tax_query[] = [
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $cat->term_id,
        ];
        $has_tax = true;
    }

    // tag
    if ($tag = get_term_by('slug', $slug, 'post_tag')) {
        $tax_query[] = [
            'taxonomy' => 'post_tag',
            'field'    => 'term_id',
            'terms'    => $tag->term_id,
        ];
        $has_tax = true;
    }

    // locations
    if ($location = get_term_by('slug', $slug, 'locations')) {
        $tax_query[] = [
            'taxonomy' => 'locations',
            'field'    => 'term_id',
            'terms'    => $location->term_id,
        ];
        $has_tax = true;
    }

    if ($has_tax) {
        $query->set('tax_query', $tax_query);

        // 🔥 важливо: прибираємо search щоб був OR
        $query->set('s', '');
    }

    $query->set('posts_per_page', 12);
    $query->set('post_type', 'post');
});