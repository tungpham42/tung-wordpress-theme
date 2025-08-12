<?php
/**
 * Template Name: Single Product
 * Template Post Type: product
 */

get_header();

// Get product ID from URL query string (?id=xx) or from WordPress post slug
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ( $product_id > 0 ) :
    $api_url = "https://dummyjson.com/products/" . $product_id;
    $response = wp_remote_get( $api_url );

    if ( is_array($response) && !is_wp_error($response) ) :
        $product = json_decode( wp_remote_retrieve_body($response), true );
        if ( isset($product['id']) ) :
?>
<div class="single-product-container">
    <div class="product-gallery">
        <img src="<?php echo esc_url($product['thumbnail']); ?>" alt="<?php echo esc_attr($product['title']); ?>" />
        <div class="product-thumbnails">
            <?php foreach ( $product['images'] as $img ) : ?>
                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($product['title']); ?>" />
            <?php endforeach; ?>
        </div>
    </div>
    <div class="product-details">
        <h1><?php echo esc_html($product['title']); ?></h1>
        <p class="price">$<?php echo esc_html($product['price']); ?></p>
        <p class="category"><strong>Category:</strong> <?php echo esc_html($product['category']); ?></p>
        <p class="description"><?php echo esc_html($product['description']); ?></p>
    </div>
</div>

<hr>

<div class="related-products">
    <h2>Related Products</h2>
    <div class="related-grid" id="related-products-container"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch(`https://dummyjson.com/products/category/<?php echo esc_js($product['category']); ?>?limit=4`)
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('related-products-container');
            data.products.forEach(prod => {
                container.innerHTML += `
                    <div class="related-item">
                        <a href="<?php echo site_url('/single-product'); ?>?id=${prod.id}">
                            <img src="${prod.thumbnail}" alt="${prod.title}" />
                            <p>${prod.title}</p>
                        </a>
                    </div>
                `;
            });
        });
});
</script>

<?php
        endif;
    endif;
else :
    echo '<p>Product not found.</p>';
endif;

get_footer();
