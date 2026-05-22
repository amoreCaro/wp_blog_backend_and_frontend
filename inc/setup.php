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

                <form class="api__form">

                    <div class="api__card-header">
                        <span class="api__badge">
                            <?php _e("Configuration", THEME); ?>
                        </span>

                        <h2 class="api__card-title">
                            <?php _e("Sync Settings", THEME); ?>
                        </h2>

                        <p class="api__card-desc">
                            <?php _e("Configure import parameters", THEME); ?>
                        </p>
                    </div>

                    <!-- CATEGORY FIELD -->
                    <div class="api__field">
                        <label class="api__field-label">
                            <?php _e("Category", THEME); ?>
                        </label>

                        <div class="api__multiselect">

                            <div class="api__multiselect-trigger">

                                <div class="api__multiselect-chips">
                                    <span class="api__multiselect-placeholder">
                                        <?php _e("Select categories...", THEME); ?>
                                    </span>
                                </div>

                                <span class="api__multiselect-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M6 9l6 6l6 -6" />
                                    </svg>
                                </span>

                            </div>

                            <div class="api__multiselect-dropdown">

                                <?php foreach ($categories as $category): ?>
                                    <div class="api__multiselect-option"
                                        data-slug="<?php echo esc_attr($category->slug); ?>"
                                        data-name="<?php echo esc_attr($category->name); ?>">

                                        <div class="api__multiselect-checkbox">
                                            <span class="api__multiselect-checkmark">✓</span>
                                        </div>

                                        <span><?php echo esc_html($category->name); ?></span>

                                    </div>
                                <?php endforeach; ?>

                            </div>

                        </div>

                        <!-- REAL SELECT (FORM DATA SOURCE) -->
                        <select id="api__category"
                                name="categories[]"
                                multiple
                                hidden>

                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo esc_attr($category->slug); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </option>
                            <?php endforeach; ?>

                        </select>

                        <!-- CHIP TEMPLATE -->
                        <div id="chip-template" class="is-hidden">
                            <div class="api__multiselect-chip">

                                <span class="api__multiselect-chip-name"></span>

                                <button type="button"
                                        class="api__multiselect-chip-remove">
                                    <svg width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none">
                                        <path d="M18 6L6 18"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round" />
                                        <path d="M6 6L18 18"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </button>

                            </div>
                        </div>

                    </div>

                    <!-- COUNTER -->
                    <div class="api__counter">

                        <button type="button"
                                class="api__button api__button--decrement">
                            <span>−</span>
                        </button>

                        <input type="number"
                            name="limit"
                            class="api__posts-per-category"
                            value="1"
                            min="1"
                            max="100" 
                        />

                        <button type="button"
                                class="api__button api__button--increment">
                            <span>+</span>
                        </button>

                    </div>

                    <!-- SUBMIT -->
                    <button id="api__sync"
                            class="api__btn"
                            type="submit">
                        <?php _e("Start Synchronization", THEME); ?>
                    </button>

                </form>

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
                        <div class="api__progress-fill"></div>
                    </div>

                    <div class="api__progress-meta">
                        <span class="api__progress-percent">0%</span>
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

        .is-hidden { display: none; }

        .api__counter {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 6px;
            border-radius: 12px;

            background: #faf9ff;
            border: 1px solid #e2dff0;

            width: fit-content;
            margin-bottom: 12px;
        }

        .api__button {
            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid #e2dff0;
            border-radius: 10px;

            background: #ffffff;
            color: #7c6fff;

            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease;
        }

        .api__button:hover {
            background: #f0eeff;
            border-color: #d9d4ff;
        }

        .api__posts-per-category {
            width: 60px;
            height: 36px;

            text-align: center;
            font-size: 14px;
            font-weight: 600;

            border: none;
            outline: none;

            background: transparent;
            color: #3d3a4a;
        }

        .api__posts-per-category {
            -moz-appearance: textfield;
        }

        .api {
            width: 100%;
            max-width: 980px;
            padding: 24px;
            box-sizing: border-box;
        }

        .api__header {
            margin-bottom: 20px;
        }

        .api__title {
            font-weight: 600;
            margin: 0 0 6px;
            color: #1a1917;
            line-height: 28px;
        }

        .api__subtitle {
            margin: 0;
            color: #8a8880;
            line-height: 20px;
        }

        .api__grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .api__card {
            width: 100%;
            background: #fff;
            border: 1px solid #e2dff0;
            border-radius: 16px;
            padding: 20px;
            box-sizing: border-box;
        }

        .api__card-header {
            margin-bottom: 16px;
        }

        .api__badge {
            display: inline-flex;
            align-items: center;
            height: 22px;
            padding: 0 10px;
            border-radius: 6px;
            color: #7c6fff;
            background: #f0eeff;
            border: 1px solid #d9d4ff;
            margin-bottom: 10px;
        }

        .api__card-title {
            margin: 0 0 6px;
            font-weight: 600;
            line-height: 22px;
            color: #1a1917;
        }

        .api__card-desc {
            margin: 0;
            color: #9a9793;
            line-height: 18px;
        }

        .api__field {
            margin-bottom: 16px;
        }

        .api__field-label {
            display: block;
            margin-bottom: 8px;
            color: #3d3a4a;
            font-weight: 600;
            line-height: 18px;
        }

        .api__btn {
            width: 100%;
            height: 44px;
            background: #2d2c2b;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.15s ease;
        }

        .api__btn:hover {
            background: #1a1917;
        }

        .api__multiselect {
            position: relative;
            width: 100%;
        }

        /* TRIGGER */
        .api__multiselect-trigger {
            width: 100%;
            min-height: 44px;
            padding: 8px 12px;
            border: 1px solid #d9d4ff;
            border-radius: 10px;
            background: #faf9ff;
            cursor: pointer;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;

            box-sizing: border-box;
            user-select: none;
            color: #3d3a4a;
            transition: 0.15s ease;
        }

        .api__multiselect-trigger:hover {
            border-color: #7c6fff;
        }

        .api__multiselect-trigger.open {
            border-color: #7c6fff;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            background: #fff;
        }

        .api__multiselect-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            flex: 1;
            min-width: 0;
            align-items: center;
        }

        .api__multiselect-placeholder {
            color: #9a9793;
            line-height: 20px;
        }

        .api__multiselect-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            height: 24px;
            padding: 0 8px;

            background: #f0eeff;
            border: 1px solid #d9d4ff;
            color: #534ab7;

            border-radius: 6px;
            flex-shrink: 0;
            max-width: 160px;
            min-width: 0;
        }

        .api__multiselect-chip-name {
            font-size: 12px; line-height: 12px; font-weight: 400;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            min-width: 0;
            flex: 1;
        }

        .api__multiselect-chip-remove {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            max-width: 8px;
            width: 100%;
            height: 8px;
            flex-shrink: 0;
            padding: 0;

            cursor: pointer;
            color: #7c6fff;
            transition: 0.15s ease;
            background: transparent;
            border: none;
            line-height: 1;
        }

        .api__multiselect-chip-remove:hover {
            color: #534ab7;
        }

        .api__multiselect-arrow {
            max-width: 16px;
            width: 100%;
            height: 16px;
            flex-shrink: 0;
            color: #7c6fff;
            transition: transform 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .api__multiselect-arrow.open {
            transform: rotate(180deg);
        }

        .api__multiselect-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #faf9ff;
            border: 1px solid #d9d4ff;
            border-top: none;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            z-index: 1000;
            max-height: 220px;
            overflow-y: auto;

            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .api__multiselect-dropdown.open {
            display: block;
        }

        .api__multiselect-option {
            min-height: 42px;
            padding: 0 12px;

            display: flex;
            align-items: center;
            gap: 10px;

            cursor: pointer;
            color: #3d3a4a;

            transition: background 0.1s ease;
        }

        .api__multiselect-option:hover {
            background: #f0eeff;
        }

        .api__multiselect-option.selected {
            background: #f6f5ff;
            color: #534ab7;
        }

        .api__multiselect-checkbox {
            max-width: 16px;
            width: 100%;
            height: 16px;
            min-width: 16px;   
            border-radius: 4px;

            border: 1px solid #d9d4ff;
            display: flex;
            align-items: center;
            justify-content: center;

            background: #fff;
            transition: background 0.15s ease, border-color 0.15s ease;
        }

        .api__multiselect-option.selected .api__multiselect-checkbox {
            background: #7c6fff;
            border-color: #7c6fff;
        }

        .api__multiselect-checkmark {
            color: #fff;
            font-size: 11px;
            line-height: 1;
            display: none;
        }

        .api__multiselect-option.selected .api__multiselect-checkmark {
            display: block;
        }

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
            line-height: 18px;
            color: #9a9793;
        }

        .api__progress-percent {
            font-weight: 600;
            color: #534ab7;
        }

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
            font-weight: 600;
            line-height: 22px;
        }

        .api__stat-label {
            color: #9a9793;
            line-height: 18px;
        }

        .api__stat--success .api__stat-value {
            color: #6d28d9;
        }

        .hidden {
            display: none;
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
        $query->set('s', '');
    }

    $query->set('posts_per_page', 12);
    $query->set('post_type', 'post');
});