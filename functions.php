<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Theme setup for Tung Elementor Theme
 */
function tungtheme_setup() {
    // Add support for dynamic title tags
    add_theme_support('title-tag');
    
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Enable WooCommerce support
    add_theme_support('woocommerce');

    // Enable Elementor compatibility for specified post types
    add_theme_support('elementor', array(
        'post-types' => array('page', 'post', 'product')
    ));

    // Register navigation menu
    register_nav_menus([
        'primary' => __('Primary Navigation', 'tungtheme'),
    ]);
}
add_action('after_setup_theme', 'tungtheme_setup');

/**
 * Enqueue theme styles and scripts
 */
function tungtheme_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('tungtheme-style', get_stylesheet_uri(), [], '1.3');
    
    // Enqueue Google Fonts (Inter)
    wp_enqueue_style('tungtheme-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap', [], null);

    // Enqueue hamburger menu script
    wp_enqueue_script('tungtheme-nav', get_template_directory_uri() . '/assets/js/nav.js', ['jquery'], '1.1', true);
}
add_action('wp_enqueue_scripts', 'tungtheme_scripts');

/**
 * Disable Elementor default colors & fonts and set up default kit
 */
add_action( 'elementor/frontend/after_register_styles', function() {
    \Elementor\Plugin::$instance->kits_manager->create_default_kit();
});

/**
 * Register Elementor theme locations
 */
add_action( 'elementor/theme/register_locations', function( $elementor_theme_manager ) {
    $elementor_theme_manager->register_location( 'single' );
    $elementor_theme_manager->register_location( 'archive' );
});

/**
 * Load custom Elementor widgets
 */
add_action( 'elementor/widgets/register', function( $widgets_manager ) {
    require_once get_template_directory() . '/inc/widgets/class-top-header-banner.php';
    require_once get_template_directory() . '/inc/widgets/class-bottom-cta-banner.php';

    $widgets_manager->register( new \Top_Header_Banner_Widget() );
    $widgets_manager->register( new \Bottom_CTA_Banner_Widget() );
});

/**
 * Add custom Elementor widget category
 */
add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
    $elements_manager->add_category(
        'theme-widgets',
        [
            'title' => __( 'Theme Widgets', 'tungtheme' ),
            'icon'  => 'fa fa-plug'
        ]
    );
});

/**
 * Register product gallery widget
 */
function tungtheme_register_elementor_widgets() {
    if ( did_action( 'elementor/loaded' ) ) {
        require_once get_template_directory() . '/elementor-widgets/class-product-gallery-widget.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \TungTheme_Product_Gallery_Widget() );
    }
}
add_action('elementor/widgets/register', 'tungtheme_register_elementor_widgets');

/**
 * Enqueue product gallery assets
 */
function tungtheme_enqueue_assets() {
    wp_enqueue_style('tungtheme-product-gallery', get_template_directory_uri() . '/assets/css/product-gallery.css', [], '1.3');
    wp_enqueue_script('tungtheme-product-gallery', get_template_directory_uri() . '/assets/js/product-gallery.js', ['jquery'], '1.3', true);
    wp_localize_script('tungtheme-product-gallery', 'tungtheme_pg', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'api_url'  => 'https://dummyjson.com/products'
    ]);
}
add_action('wp_enqueue_scripts', 'tungtheme_enqueue_assets');

/**
 * Register custom rewrite rule for product pages
 */
add_action('init', function() {
    add_rewrite_rule('^product/([0-9]+)/?', 'index.php?pagename=single-product&product_id=$matches[1]', 'top');
});

/**
 * Add product_id to query vars
 */
add_filter('query_vars', function($vars) {
    $vars[] = 'product_id';
    return $vars;
});