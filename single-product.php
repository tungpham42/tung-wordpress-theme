<?php
/**
 * Template Name: Single Product (DummyJSON)
 */
get_header();

$product_id = get_query_var('custom_product_id');

if (!$product_id) {
    echo '<div id="single-product" class="single-product-container">
            <p style="color:var(--price-color);text-align:center;">Invalid product ID.</p>
          </div>';
    get_footer();
    return;
}

// Fetch product data
$product_response = @file_get_contents("https://dummyjson.com/products/$product_id");
$product = $product_response ? json_decode($product_response, true) : null;

// Fetch categories
$categories_response = @file_get_contents('https://dummyjson.com/products/categories');
$categories = $categories_response ? json_decode($categories_response, true) : [];

// Handle category name
$category_name = '';
if ($product && isset($product['category'])) {
    if (!empty($categories) && isset($categories[0]['slug'])) {
        $category_obj = array_filter($categories, function($cat) use ($product) {
            return $cat['slug'] === $product['category'];
        });
        $category_obj = reset($category_obj);
        $category_name = $category_obj ? $category_obj['name'] : $product['category'];
    } else {
        $category_name = str_replace('-', ' ', $product['category']);
        $category_name = preg_replace_callback('/\b\w/', function($matches) {
            return strtoupper($matches[0]);
        }, $category_name);
    }
}

// Calculate discounted price
$discounted_price = null;
if ($product && isset($product['discountPercentage']) && $product['discountPercentage'] > 0) {
    $discounted_price = number_format($product['price'] * (1 - $product['discountPercentage'] / 100), 2);
}

// Set page title using filter hook
add_filter('the_title', function($title) use ($product) {
    return $product && isset($product['title']) ? $product['title'] . ' | ' . get_bloginfo('name') : $title;
});

// Fetch related products
$related_products = [];
if ($product && isset($product['category'])) {
    $related_response = @file_get_contents("https://dummyjson.com/products/category/" . urlencode($product['category']));
    if ($related_response) {
        $related_data = json_decode($related_response, true);
        $related_products = array_filter($related_data['products'], function($p) use ($product_id) {
            return $p['id'] != $product_id;
        });
        $related_products = array_slice($related_products, 0, 6);
    }
}
?>

<div id="single-product" class="single-product-container">
    <div class="pg-loading" style="display:none;">
        <span class="loading-spinner"></span>Loading product...
    </div>
    <div class="product-content">
        <div class="product-details">
            <?php if (!$product): ?>
                <p style="color:var(--price-color);text-align:center;">Error loading product.</p>
            <?php else: ?>
                <div class="product-gallery">
                    <img src="<?php echo esc_attr($product['thumbnail']); ?>" alt="<?php echo esc_attr($product['title']); ?>" class="main-image">
                    <div class="product-thumbnails">
                        <?php foreach ($product['images'] as $img): ?>
                            <img src="<?php echo esc_attr($img); ?>" alt="Thumbnail" onclick="changeImage('<?php echo esc_attr($img); ?>', this)">
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="product-info">
                    <h1><?php echo esc_html($product['title']); ?></h1>
                    <span class="category"><strong>Category:</strong> <?php echo esc_html($category_name); ?></span>
                    <div class="price-container">
                        <p class="price">$<?php echo esc_html($discounted_price ?: $product['price']); ?></p>
                        <?php if ($discounted_price): ?>
                            <p class="original-price">$<?php echo esc_html($product['price']); ?></p>
                            <span class="discount-badge"><?php echo esc_html($product['discountPercentage']); ?>% OFF</span>
                        <?php endif; ?>
                    </div>
                    <p><?php echo esc_html($product['description']); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="related-products tungtheme-product-gallery" data-items="3">
        <h2>Related Products</h2>
        <div class="pg-grid">
            <?php foreach ($related_products as $p):
                // Calculate discounted price for related products
                $rel_discounted_price = isset($p['discountPercentage']) && $p['discountPercentage'] > 0 
                    ? number_format($p['price'] * (1 - $p['discountPercentage'] / 100), 2) 
                    : null;
                
                // Handle related product category name
                $rel_category_name = '';
                if (!empty($categories) && isset($categories[0]['slug'])) {
                    $category_obj = array_filter($categories, function($cat) use ($p) {
                        return $cat['slug'] === $p['category'];
                    });
                    $category_obj = reset($category_obj);
                    $rel_category_name = $category_obj ? $category_obj['name'] : $p['category'];
                } else {
                    $rel_category_name = str_replace('-', ' ', $p['category']);
                    $rel_category_name = preg_replace_callback('/\b\w/', function($matches) {
                        return strtoupper($matches[0]);
                    }, $rel_category_name);
                }
            ?>
                <div class="pg-item">
                    <img src="<?php echo esc_attr($p['thumbnail']); ?>" alt="<?php echo esc_attr($p['title']); ?>">
                    <h3><?php echo esc_html($p['title']); ?></h3>
                    <div class="price-container">
                        <p class="price">$<?php echo esc_html($rel_discounted_price ?: $p['price']); ?></p>
                        <?php if ($rel_discounted_price): ?>
                            <p class="original-price">$<?php echo esc_html($p['price']); ?></p>
                            <span class="discount-badge"><?php echo esc_html($p['discountPercentage']); ?>% OFF</span>
                        <?php endif; ?>
                    </div>
                    <span class="category"><?php echo esc_html($rel_category_name); ?></span>
                    <a href="/product/<?php echo esc_attr($p['id']); ?>" class="btn-view">View Product</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
function changeImage(src, element) {
    const mainImage = document.querySelector('.main-image');
    mainImage.src = src;
    document.querySelectorAll('.product-thumbnails img').forEach(img => {
        img.style.borderColor = 'transparent';
    });
    element.style.borderColor = 'var(--highlight-color)';
}
</script>

<?php get_footer(); ?>