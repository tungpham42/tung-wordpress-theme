<?php
/**
 * Custom search form template for WordPress
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="search-label">
        <span class="screen-reader-text"><?php _e( 'Search for:', 'tungtheme' ); ?></span>
        <input type="search" class="search-field" placeholder="<?php _e( 'Search...', 'tungtheme' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    </label>
    <button type="submit" class="search-submit"><?php _e( 'Search', 'tungtheme' ); ?></button>
</form>