<?php get_header(); ?>
<main>
    <?php
    if (did_action('elementor/loaded') && \Elementor\Plugin::$instance->preview->is_preview_mode()) {
        echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display(get_queried_object_id());
    } else {
        if (have_posts()) :
            ?>
            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        </header>
                        <div class="entry-content">
                            <?php
                            if (is_home() || is_archive()) {
                                the_excerpt();
                            } else {
                                the_content();
                            }
                            ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p><?php _e('No posts found.', 'tungtheme'); ?></p>
        <?php endif;
    }
    ?>
</main>
<?php get_footer(); ?>