<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// Theme setup
function tungtheme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    // WooCommerce support
    add_theme_support('woocommerce');

    // Elementor compatibility
    add_theme_support('elementor', array(
        'post-types' => array('page', 'post', 'product')
    ));
}
add_action('after_setup_theme', 'tungtheme_setup');

// Enqueue styles/scripts
function tungtheme_scripts() {
    wp_enqueue_style('tungtheme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'tungtheme_scripts');

// Disable Elementor default colors & fonts
add_action( 'elementor/frontend/after_register_styles', function() {
    \Elementor\Plugin::$instance->kits_manager->create_default_kit();
});

add_action( 'elementor/theme/register_locations', function( $elementor_theme_manager ) {
    $elementor_theme_manager->register_location( 'single' );
    $elementor_theme_manager->register_location( 'archive' );
});

// Load Elementor Widgets
add_action( 'elementor/widgets/register', function( $widgets_manager ) {

    require_once get_template_directory() . '/inc/widgets/class-top-header-banner.php';
    require_once get_template_directory() . '/inc/widgets/class-bottom-cta-banner.php';

    $widgets_manager->register( new \Top_Header_Banner_Widget() );
    $widgets_manager->register( new \Bottom_CTA_Banner_Widget() );
});

// Add custom Elementor category
add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
    $elements_manager->add_category(
        'theme-widgets',
        [
            'title' => __( 'Theme Widgets', 'tungtheme' ),
            'icon'  => 'fa fa-plug'
        ]
    );
});

// Load widget files
function tungtheme_register_elementor_widgets() {
    if ( did_action( 'elementor/loaded' ) ) {
        require_once get_template_directory() . '/elementor-widgets/class-product-gallery-widget.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \TungTheme_Product_Gallery_Widget() );
    }
}
add_action('elementor/widgets/register', 'tungtheme_register_elementor_widgets');

// Enqueue scripts
function tungtheme_enqueue_assets() {
    wp_enqueue_style('tungtheme-product-gallery', get_template_directory_uri() . '/assets/css/product-gallery.css', [], '1.0');
    wp_enqueue_script('tungtheme-product-gallery', get_template_directory_uri() . '/assets/js/product-gallery.js', ['jquery'], '1.0', true);
    wp_localize_script('tungtheme-product-gallery', 'tungtheme_pg', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'api_url'  => 'https://dummyjson.com/products'
    ]);
}
add_action('wp_enqueue_scripts', 'tungtheme_enqueue_assets');