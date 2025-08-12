<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <nav>
        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
    </nav>
</header>
<main>