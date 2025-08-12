jQuery(document).ready(function ($) {
  // Load categories into the dropdown
  function loadCategories() {
    $.get("https://dummyjson.com/products/categories", function (categories) {
      if (Array.isArray(categories) && categories.length > 0) {
        let options = `<option value="">All Categories</option>`;
        categories.forEach((cat) => {
          options += `<option value="${cat}">${cat}</option>`;
        });
        $("#pg-category").html(options);
      }
    }).fail(function () {
      $("#pg-category").html(
        '<option value="">Error loading categories</option>'
      );
    });
  }

  // Load products from DummyJSON
  function loadProducts(category = "") {
    $(".pg-loading").show();
    $(".pg-grid").empty();

    let apiUrl = "https://dummyjson.com/products";
    if (category) {
      apiUrl += `/category/${encodeURIComponent(category)}`;
    }

    $.get(apiUrl, function (response) {
      $(".pg-loading").hide();
      if (response && response.products && response.products.length > 0) {
        let html = "";
        response.products.forEach((p) => {
          html += `<div class="pg-item">
                      <img src="${p.thumbnail}" alt="${p.title}">
                      <h3>${p.title}</h3>
                      <p class="price">$${p.price}</p>
                      <span class="category">${p.category}</span>
                      <a href="${window.location.origin}/product/${p.id}" class="btn-view">View Details</a>
                  </div>`;
        });
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

  // Handle category change
  $("#pg-category").on("change", function () {
    loadProducts($(this).val());
  });
});
