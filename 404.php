<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package tung-wordpress-theme
 */

get_header(); ?>

<div class="error-404 not-found">
    <div class="error-container" style="max-width: 1280px; margin: 3rem auto; padding: 2rem; text-align: center;">
        <h1 style="font-size: 3rem; font-weight: 700; color: var(--primary-color); margin-bottom: 1rem;">
            404 - Page Not Found
        </h1>
        <p style="font-size: 1.2rem; color: var(--text-color); margin-bottom: 2rem;">
            Oops! It looks like the page you're looking for doesn't exist or has been moved.
        </p>
        <div class="search-form-container" style="max-width: 500px; margin: 0 auto 2rem;">
            <h3 style="font-size: 1.5rem; color: var(--primary-color); margin-bottom: 1rem;">
                Try Searching
            </h3>
            <?php get_search_form(); ?>
        </div>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-view">
            Return to Homepage
        </a>
    </div>
</div>

<?php get_footer(); ?>