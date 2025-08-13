<?php
/**
 * Template Name: Single Product (DummyJSON)
 */
get_header();

$product_id = get_query_var('custom_product_id');
?>

<div id="single-product" class="single-product-container">
    <div class="pg-loading" style="display:none;text-align:center;padding:2rem;font-size:1.2rem;color:var(--text-color);">
        <span class="loading-spinner"></span>Loading product...
    </div>
    <div class="product-content">
        <div class="product-details"></div>
    </div>
    <div class="related-products"></div>
</div>

<style>
.loading-spinner {
    display: inline-block;
    width: 24px;
    height: 24px;
    border: 3px solid var(--accent-color);
    border-top: 3px solid var(--highlight-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-right: 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const productContainer = document.querySelector(".product-details");
    const relatedContainer = document.querySelector(".related-products");
    const loader = document.querySelector(".pg-loading");
    const productId = <?php echo json_encode($product_id); ?>;

    if (!productId) {
        productContainer.innerHTML = `<p style="color:var(--price-color);text-align:center;">Invalid product ID.</p>`;
        return;
    }

    loader.style.display = "block";

    Promise.all([
        fetch(`https://dummyjson.com/products/${productId}`).then(res => res.json()),
        fetch('https://dummyjson.com/products/categories').then(res => res.json())
    ])
    .then(([product, categories]) => {
        let categoryName;
        if (categories.length && typeof categories[0] === "object" && categories[0].slug) {
            const categoryObj = categories.find(cat => cat.slug === product.category);
            categoryName = categoryObj ? categoryObj.name : product.category;
        } else {
            categoryName = product.category
                .replace(/-/g, " ")
                .replace(/\b\w/g, l => l.toUpperCase());
        }

        loader.style.display = "none";
        productContainer.innerHTML = `
            <div class="product-gallery">
                <img src="${product.thumbnail}" alt="${product.title}" class="main-image">
                <div class="product-thumbnails">
                    ${product.images.map(img => `
                        <img src="${img}" alt="Thumbnail" onclick="changeImage('${img}', this)">
                    `).join('')}
                </div>
            </div>
            <div class="product-info">
                <h1>${product.title}</h1>
                <p><strong>Category:</strong> ${categoryName}</p>
                <p class="price">$${product.price}</p>
                <p>${product.description}</p>
                <button class="btn-add-cart">Add to Cart</button>
            </div>
        `;
    })
    .catch(err => {
        loader.style.display = "none";
        productContainer.innerHTML = `<p style="color:var(--price-color);text-align:center;">Error loading product: ${err.message}</p>`;
    });

    fetch(`https://dummyjson.com/products/${productId}`)
        .then(res => res.json())
        .then(product => {
            fetch(`https://dummyjson.com/products/category/${encodeURIComponent(product.category)}`)
                .then(res => res.json())
                .then(data => {
                    relatedContainer.innerHTML = `
                        <h2>Related Products</h2>
                        <div class="related-grid">
                            ${data.products
                                .filter(p => p.id !== product.id)
                                .slice(0, 6)
                                .map(p => `
                                    <div class="related-item">
                                        <img src="${p.thumbnail}" alt="${p.title}">
                                        <h3>${p.title}</h3>
                                        <p class="price">$${p.price}</p>
                                        <a href="/product/${p.id}" class="btn-view">View Product</a>
                                    </div>
                                `).join('')}
                        </div>
                    `;
                });
        })
        .catch(() => {
            loader.style.display = "none";
            productContainer.innerHTML = `<p style="color:var(--price-color);text-align:center;">Error loading product.</p>`;
        });
});

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