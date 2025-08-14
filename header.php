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
        <div class="site-branding">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <h1 class="site-title"><?php bloginfo('name'); ?></h1>
                <?php endif; ?>
            </a>
        </div>
        <nav class="primary-nav">
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class' => 'primary-nav-menu',
                'container' => false,
                'fallback_cb' => false,
            ]); ?>
        </nav>
        <button class="hamburger" aria-label="Toggle navigation" aria-expanded="false"></button>
    </div>
</header>