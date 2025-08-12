<?php
/**
 * Template Name: Single Product (DummyJSON)
 */
get_header();
?>

<div id="single-product" class="container" style="padding:20px;">
    <div class="pg-loading" style="display:none;">Loading product...</div>
    <div class="product-details"></div>
    <div class="related-products"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const productContainer = document.querySelector(".product-details");
    const relatedContainer = document.querySelector(".related-products");
    const loader = document.querySelector(".pg-loading");

    // Get product ID from URL
    const pathParts = window.location.pathname.split('/');
    const productId = pathParts[pathParts.length - 1] || pathParts[pathParts.length - 2];

    if (!productId) {
        productContainer.innerHTML = "<p>Invalid product ID.</p>";
        return;
    }

    loader.style.display = "block";

    // Fetch product details
    fetch(`https://dummyjson.com/products/${productId}`)
        .then(res => res.json())
        .then(product => {
            loader.style.display = "none";
            productContainer.innerHTML = `
                <div style="display:flex;gap:20px;flex-wrap:wrap;">
                    <div style="flex:1;min-width:300px;">
                        <img src="${product.thumbnail}" alt="${product.title}" style="max-width:100%;border-radius:8px;">
                        <div style="display:flex;gap:10px;margin-top:10px;flex-wrap:wrap;">
                            ${product.images.map(img => `<img src="${img}" style="width:80px;height:80px;object-fit:cover;border-radius:4px;">`).join('')}
                        </div>
                    </div>
                    <div style="flex:1;min-width:300px;">
                        <h1>${product.title}</h1>
                        <p><strong>Category:</strong> ${product.category}</p>
                        <p><strong>Price:</strong> $${product.price}</p>
                        <p>${product.description}</p>
                    </div>
                </div>
            `;

            // Fetch related products
            fetch(`https://dummyjson.com/products/category/${encodeURIComponent(product.category)}`)
                .then(res => res.json())
                .then(data => {
                    relatedContainer.innerHTML = `
                        <h2 style="margin-top:40px;">Related Products</h2>
                        <div style="display:flex;gap:20px;flex-wrap:wrap;">
                            ${data.products.filter(p => p.id !== product.id).map(p => `
                                <div style="flex:1;min-width:200px;max-width:200px;border:1px solid #ddd;border-radius:8px;padding:10px;text-align:center;">
                                    <img src="${p.thumbnail}" style="width:100%;border-radius:4px;">
                                    <h4>${p.title}</h4>
                                    <p>$${p.price}</p>
                                    <a href="/product/${p.id}" class="btn-view">View</a>
                                </div>
                            `).join('')}
                        </div>
                    `;
                });
        })
        .catch(() => {
            loader.style.display = "none";
            productContainer.innerHTML = "<p>Error loading product.</p>";
        });
});
</script>

<?php get_footer(); ?>
