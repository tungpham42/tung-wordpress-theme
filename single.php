<?php get_header(); ?>
<main>
    <?php
    if (did_action('elementor/loaded') && \Elementor\Plugin::$instance->preview->is_preview_mode()) {
        echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display(get_the_ID());
    } else {
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
    }
    ?>
</main>
<?php get_footer(); ?>