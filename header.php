<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="nav-container">
        <?php wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class' => 'primary-nav-menu',
            'container' => false,
        ]); ?>
        <button class="hamburger" aria-label="Toggle menu">☰</button>
    </div>
</header>
<main>