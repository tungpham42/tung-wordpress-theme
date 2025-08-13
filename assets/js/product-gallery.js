jQuery(document).ready(function ($) {
  let categoryMap = {}; // store slug -> name mapping

  function loadCategories() {
    $.get("https://dummyjson.com/products/categories", function (categories) {
      if (Array.isArray(categories) && categories.length > 0) {
        let options = `<option value="">All Categories</option>`;
        categories.forEach((cat) => {
          categoryMap[cat.slug] = cat.name;
          options += `<option value="${cat.slug}">${cat.name}</option>`;
        });
        $("#pg-category").html(options);
      }
    }).fail(function () {
      $("#pg-category").html(
        '<option value="">Error loading categories</option>'
      );
    });
  }

  function getCategoryName(slug) {
    return (
      categoryMap[slug] ||
      slug.replace(/-/g, " ").replace(/\b\w/g, (l) => l.toUpperCase())
    );
  }

  function loadProducts(category = "", sortBy = "") {
    $(".pg-loading").show();
    $(".pg-grid").empty();

    let apiUrl = "https://dummyjson.com/products";
    if (category) {
      apiUrl += `/category/${encodeURIComponent(category)}`;
    }

    $.get(apiUrl, function (response) {
      $(".pg-loading").hide();
      if (response && response.products && response.products.length > 0) {
        let products = response.products;

        if (sortBy === "title_asc")
          products.sort((a, b) => a.title.localeCompare(b.title));
        else if (sortBy === "title_desc")
          products.sort((a, b) => b.title.localeCompare(b.title));
        else if (sortBy === "price_asc")
          products.sort((a, b) => a.price - b.price);
        else if (sortBy === "price_desc")
          products.sort((a, b) => b.price - a.price);
        else if (sortBy === "discount_asc")
          products.sort(
            (a, b) => (a.discountPercentage || 0) - (b.discountPercentage || 0)
          );
        else if (sortBy === "discount_desc")
          products.sort(
            (a, b) => (b.discountPercentage || 0) - (a.discountPercentage || 0)
          );

        let html = products
          .map((p) => {
            const discount = p.discountPercentage ? p.discountPercentage : 0;
            const discountedPrice = discount
              ? (p.price * (1 - discount / 100)).toFixed(2)
              : p.price;
            return `
                <div class="pg-item">
                  <img src="${p.thumbnail}" alt="${p.title}">
                  <h3>${p.title}</h3>
                  <div class="price-container">
                    <p class="price">$${discountedPrice}</p>
                    ${
                      discount
                        ? `<p class="original-price">$${p.price.toFixed(2)}</p>`
                        : ""
                    }
                    ${
                      discount
                        ? `<span class="discount">${discount}% OFF</span>`
                        : ""
                    }
                  </div>
                  <span class="category">${getCategoryName(p.category)}</span>
                  <a href="${window.location.origin}/product/${
              p.id
            }" class="btn-view">View Details</a>
                </div>
              `;
          })
          .join("");
        $(".pg-grid").html(html);
      } else {
        $(".pg-grid").html("<p>No products found</p>");
      }
    }).fail(function () {
      $(".pg-loading").hide();
      $(".pg-grid").html("<p>Error loading products</p>");
    });
  }

  // Initial setup
  loadCategories();
  loadProducts();

  // Category change
  $("#pg-category").on("change", function () {
    loadProducts($(this).val(), $("#pg-sort").val());
  });

  // Sort change
  $("#pg-sort").on("change", function () {
    loadProducts($("#pg-category").val(), $(this).val());
  });
});
