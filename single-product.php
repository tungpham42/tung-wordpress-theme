<?php
/**
 * Template Name: Single Product (DummyJSON)
 */
get_header();

$product_id = get_query_var('custom_product_id');
?>

<div id="single-product" class="single-product-container">
    <div class="pg-loading" style="display:none;">
        <span class="loading-spinner"></span>Loading product...
    </div>
    <div class="product-content">
        <div class="product-details"></div>
    </div>
    <div class="related-products tungtheme-product-gallery" data-items="3"></div>
</div>

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

        // Calculate discounted price
        const discountPercentage = product.discountPercentage || 0;
        const discountedPrice = discountPercentage > 0 
            ? (product.price * (1 - discountPercentage / 100)).toFixed(2) 
            : null;

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
                <span class="category"><strong>Category:</strong> ${categoryName}</span>
                <div class="price-container">
                    <p class="price">$${discountedPrice || product.price}</p>
                    ${discountPercentage > 0 ? `
                        <p class="original-price">$${product.price}</p>
                        <span class="discount-badge">${discountPercentage}% OFF</span>
                    ` : ''}
                </div>
                <p>${product.description}</p>
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
            fetch(`https://dummyjson.com/products/categories`)
                .then(res => res.json())
                .then(categories => {
                    fetch(`https://dummyjson.com/products/category/${encodeURIComponent(product.category)}`)
                        .then(res => res.json())
                        .then(data => {
                            relatedContainer.innerHTML = `
                                <h2>Related Products</h2>
                                <div class="pg-grid">
                                    ${data.products
                                        .filter(p => p.id !== product.id)
                                        .slice(0, 6)
                                        .map(p => {
                                            let categoryName;
                                            if (categories.length && typeof categories[0] === "object" && categories[0].slug) {
                                                const categoryObj = categories.find(cat => cat.slug === p.category);
                                                categoryName = categoryObj ? categoryObj.name : p.category;
                                            } else {
                                                categoryName = p.category
                                                    .replace(/-/g, " ")
                                                    .replace(/\b\w/g, l => l.toUpperCase());
                                            }
                                            // Calculate discounted price for related products
                                            const discountPercentage = p.discountPercentage || 0;
                                            const discountedPrice = discountPercentage > 0 
                                                ? (p.price * (1 - discountPercentage / 100)).toFixed(2) 
                                                : null;
                                            return `
                                                <div class="pg-item">
                                                    <img src="${p.thumbnail}" alt="${p.title}">
                                                    <h3>${p.title}</h3>
                                                    <div class="price-container">
                                                        <p class="price">$${discountedPrice || p.price}</p>
                                                        ${discountPercentage > 0 ? `
                                                            <p class="original-price">$${p.price}</p>
                                                            <span class="discount-badge">${discountPercentage}% OFF</span>
                                                        ` : ''}
                                                    </div>
                                                    <span class="category">${categoryName}</span>
                                                    <a href="/product/${p.id}" class="btn-view">View Product</a>
                                                </div>
                                            `;
                                        }).join('')}
                                </div>
                            `;
                        });
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