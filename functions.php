<?php
// Theme setup
function tung_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    // WooCommerce support
    add_theme_support('woocommerce');

    // Elementor compatibility
    add_theme_support('elementor', array(
        'post-types' => array('page', 'post', 'product')
    ));
}
add_action('after_setup_theme', 'tung_theme_setup');

// Enqueue styles/scripts
function tung_theme_scripts() {
    wp_enqueue_style('tung_theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'tung_theme_scripts');

// Disable Elementor default colors & fonts
add_action( 'elementor/frontend/after_register_styles', function() {
    \Elementor\Plugin::$instance->kits_manager->create_default_kit();
});

add_action( 'elementor/theme/register_locations', function( $elementor_theme_manager ) {
    $elementor_theme_manager->register_location( 'single' );
    $elementor_theme_manager->register_location( 'archive' );
});