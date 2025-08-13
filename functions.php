<?php
if (!defined('ABSPATH')) exit;

/**
 * Theme setup for Tung Elementor Theme
 */
function tungtheme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('elementor', ['post-types' => ['page', 'post', 'product'], 'theme_builder']);

    register_nav_menus([
        'primary' => __('Primary Navigation', 'tungtheme'),
    ]);

    // Register footer widget area
    register_sidebar([
        'name' => __('Footer Sidebar', 'tungtheme'),
        'id' => 'footer-sidebar',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ]);
}
add_action('after_setup_theme', 'tungtheme_setup');

/**
 * Enqueue theme styles and scripts
 */
function tungtheme_scripts() {
    wp_enqueue_style('tungtheme-style', get_stylesheet_uri(), [], '1.5');
    wp_enqueue_style('tungtheme-fonts', 'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap', [], null);
    wp_enqueue_script('tungtheme-nav', get_template_directory_uri() . '/assets/js/nav.js', [], '1.1', true);
}
add_action('wp_enqueue_scripts', 'tungtheme_scripts');

/**
 * Disable Elementor default colors & fonts
 */
add_action('elementor/frontend/after_register_styles', function() {
    \Elementor\Plugin::$instance->kits_manager->create_default_kit();
});

/**
 * Register Elementor theme locations
 */
add_action('elementor/theme/register_locations', function($elementor_theme_manager) {
    $elementor_theme_manager->register_location('header');
    $elementor_theme_manager->register_location('footer');
    $elementor_theme_manager->register_location('single');
    $elementor_theme_manager->register_location('archive');
    $elementor_theme_manager->register_location('404');
});

/**
 * Load custom Elementor widgets
 */
add_action('elementor/widgets/register', function($widgets_manager) {
    require_once get_template_directory() . '/inc/widgets/class-top-header-banner.php';
    require_once get_template_directory() . '/inc/widgets/class-bottom-cta-banner.php';
    $widgets_manager->register(new \Top_Header_Banner_Widget());
    $widgets_manager->register(new \Bottom_CTA_Banner_Widget());
});

/**
 * Add custom Elementor widget category
 */
add_action('elementor/elements/categories_registered', function($elements_manager) {
    $elements_manager->add_category('theme-widgets', [
        'title' => __('Tung\' Widgets', 'tungtheme'),
        'icon' => 'fa fa-plug'
    ]);
});

/**
 * Register product gallery widget
 */
function tungtheme_register_elementor_widgets() {
    if (did_action('elementor/loaded')) {
        require_once get_template_directory() . '/elementor-widgets/class-product-gallery-widget.php';
        \Elementor\Plugin::instance()->widgets_manager->register(new \TungTheme_Product_Gallery_Widget());
    }
}
add_action('elementor/widgets/register', 'tungtheme_register_elementor_widgets');

/**
 * Enqueue product gallery assets
 */
function tungtheme_enqueue_assets() {
    wp_enqueue_style('tungtheme-product-gallery', get_template_directory_uri() . '/assets/css/product-gallery.css', [], '2.0');
    wp_enqueue_script('tungtheme-product-gallery', get_template_directory_uri() . '/assets/js/product-gallery.js', ['jquery'], '1.8', true);
    wp_localize_script('tungtheme-product-gallery', 'tungtheme_pg', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'api_url' => 'https://dummyjson.com/products'
    ]);
}
add_action('wp_enqueue_scripts', 'tungtheme_enqueue_assets');

/**
 * Support dynamic product queries in Elementor
 */
add_action('elementor/query/product_query', function($query) {
    if ($product_id = get_query_var('product_id')) {
        $query->set('post_type', 'page'); // Set to page to match single-product.php
        $query->set('pagename', 'single-product');
        $query->set('meta_query', [
            [
                'key' => '_tungtheme_product_id',
                'value' => $product_id,
                'compare' => '='
            ]
        ]);
    }
});

// Redirect /product/:id to WooCommerce single-product.php template
add_action('init', function () {
    add_rewrite_rule(
        '^product/([0-9]+)/?$',
        'index.php?custom_product_id=$matches[1]',
        'top'
    );
    flush_rewrite_rules();
});

add_filter('query_vars', function ($query_vars) {
    $query_vars[] = 'custom_product_id';
    return $query_vars;
});

add_action('template_include', function ($template) {
    $custom_id = get_query_var('custom_product_id');
    if ($custom_id) {
        // Force WooCommerce single product template from theme
        $woocommerce_template = get_stylesheet_directory() . '/woocommerce/single-product.php';
        if (file_exists($woocommerce_template)) {
            return $woocommerce_template;
        }
    }
    return $template;
});
