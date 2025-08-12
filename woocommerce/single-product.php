<?php
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

while ( have_posts() ) :
    the_post();

    wc_get_template_part( 'content', 'single-product' );

endwhile;

get_footer( 'shop' );