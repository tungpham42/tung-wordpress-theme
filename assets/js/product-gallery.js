jQuery(document).ready(function ($) {
  function loadProducts(category = "") {
    $(".pg-loading").show();
    $(".pg-grid").empty();
    $.post(
      tungtheme_pg.ajax_url,
      { action: "fetch_products", category },
      function (response) {
        $(".pg-loading").hide();
        if (response.success) {
          let html = "";
          response.data.products.forEach((p) => {
            html += `<div class="pg-item">
                        <img src="${p.thumbnail}" alt="${p.title}">
                        <h3>${p.title}</h3>
                        <p class="price">$${p.price}</p>
                        <span class="category">${p.category}</span>
                        <a href="${p.permalink}" class="btn-view">View Details</a>
                    </div>`;
          });
          $(".pg-grid").html(html);
        } else {
          $(".pg-grid").html("<p>Error loading products</p>");
        }
      }
    );
  }
  loadProducts();
  $("#pg-category").on("change", function () {
    loadProducts($(this).val());
  });
});
