jQuery(document).ready(function ($) {
  let categoryMap = {}; // store slug -> name mapping
  const itemsPerPage = 30; // Number of items per page
  let currentPage = 1; // Track current page
  let allProducts = []; // Store all products
  let totalProducts = 0; // Track total number of products

  // Get URL parameters
  function getUrlParams() {
    const params = new URLSearchParams(window.location.search);
    return {
      category: params.get("category") || "",
      sort: params.get("sort") || "",
      page: parseInt(params.get("page")) || 1,
    };
  }

  // Update URL parameters
  function updateUrlParams(category, sort, page) {
    const params = new URLSearchParams();
    if (category) params.set("category", category);
    if (sort) params.set("sort", sort);
    if (page && page !== 1) params.set("page", page);
    const newUrl = `${window.location.pathname}${
      params.toString() ? "?" + params.toString() : ""
    }`;
    window.history.pushState({}, "", newUrl);
  }

  function loadCategories() {
    $.get("https://dummyjson.com/products/categories", function (categories) {
      if (Array.isArray(categories) && categories.length > 0) {
        let options = `<option value="">All Categories</option>`;
        categories.forEach((cat) => {
          categoryMap[cat.slug] = cat.name;
          options += `<option value="${cat.slug}">${cat.name}</option>`;
        });
        $("#pg-category").html(options);
        // Set initial category from URL
        const params = getUrlParams();
        $("#pg-category").val(params.category);
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

  function renderPagination(totalItems, category, sort) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    let paginationHtml = '<div class="pg-pagination">';

    // Previous button
    paginationHtml += `<button class="pg-page-btn" ${
      currentPage === 1 ? "disabled" : ""
    } data-page="${currentPage - 1}">Prev</button>`;

    // Calculate the range of page numbers to display (up to 3 pages)
    const maxPagesToShow = 3;
    let startPage = Math.max(1, currentPage - 1);
    let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);

    // Adjust startPage if near the end to ensure we show up to 3 pages
    if (endPage - startPage + 1 < maxPagesToShow) {
      startPage = Math.max(1, endPage - maxPagesToShow + 1);
    }

    // Page numbers (up to 3)
    for (let i = startPage; i <= endPage; i++) {
      paginationHtml += `<button class="pg-page-btn${
        i === currentPage ? " active" : ""
      }" data-page="${i}">${i}</button>`;
    }

    // Next button
    paginationHtml += `<button class="pg-page-btn" ${
      currentPage === totalPages ? "disabled" : ""
    } data-page="${currentPage + 1}">Next</button>`;

    paginationHtml += "</div>";
    $(".pg-grid").after(paginationHtml);

    // Bind click events to pagination buttons
    $(".pg-page-btn").on("click", function () {
      if (!$(this).is("[disabled]")) {
        currentPage = parseInt($(this).data("page"));
        updateUrlParams(category, sort, currentPage);
        renderProducts(category, sort);
      }
    });
  }

  function sortProducts(products, sortBy) {
    if (sortBy === "title_asc")
      return products.sort((a, b) => a.title.localeCompare(b.title));
    else if (sortBy === "title_desc")
      return products.sort((a, b) => b.title.localeCompare(b.title));
    else if (sortBy === "price_asc")
      return products.sort((a, b) => a.price - b.price);
    else if (sortBy === "price_desc")
      return products.sort((a, b) => b.price - b.price);
    else if (sortBy === "discount_price_asc")
      return products.sort((a, b) => {
        const aPrice = a.discountPercentage
          ? a.price * (1 - a.discountPercentage / 100)
          : a.price;
        const bPrice = b.discountPercentage
          ? b.price * (1 - b.discountPercentage / 100)
          : b.price;
        return aPrice - bPrice;
      });
    else if (sortBy === "discount_price_desc")
      return products.sort((a, b) => {
        const aPrice = a.discountPercentage
          ? a.price * (1 - a.discountPercentage / 100)
          : a.price;
        const bPrice = b.discountPercentage
          ? b.price * (1 - b.discountPercentage / 100)
          : b.price;
        return bPrice - aPrice;
      });
    return products;
  }

  function renderProducts(category = "", sortBy = "") {
    $(".pg-loading").show();
    $(".pg-grid").empty();
    $(".pg-pagination").remove(); // Remove existing pagination

    // Filter products by category
    let filteredProducts = category
      ? allProducts.filter((p) => p.category === category)
      : [...allProducts];

    // Sort products
    filteredProducts = sortProducts(filteredProducts, sortBy);
    totalProducts = filteredProducts.length;

    // Paginate products
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paginatedProducts = filteredProducts.slice(startIndex, endIndex);

    $(".pg-loading").hide();
    if (paginatedProducts.length > 0) {
      let html = paginatedProducts
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

      // Render pagination controls
      renderPagination(totalProducts, category, sortBy);
    } else {
      $(".pg-grid").html("<p>No products found</p>");
    }
  }

  function loadProducts(category = "", sortBy = "") {
    $(".pg-loading").show();
    let apiUrl = "https://dummyjson.com/products?limit=0";
    if (category) {
      apiUrl = `https://dummyjson.com/products/category/${encodeURIComponent(
        category
      )}?limit=0`;
    }

    $.get(apiUrl, function (response) {
      if (response && response.products && response.products.length > 0) {
        allProducts = response.products;
        renderProducts(category, sortBy);
      } else {
        $(".pg-loading").hide();
        $(".pg-grid").html("<p>No products found</p>");
      }
    }).fail(function () {
      $(".pg-loading").hide();
      $(".pg-grid").html("<p>Error loading products</p>");
    });
  }

  // Initial setup
  const params = getUrlParams();
  currentPage = params.page;
  $("#pg-sort").val(params.sort);
  loadCategories();
  loadProducts(params.category, params.sort);

  // Category change
  $("#pg-category").on("change", function () {
    currentPage = 1; // Reset to first page on category change
    const category = $(this).val();
    const sort = $("#pg-sort").val();
    updateUrlParams(category, sort, currentPage);
    loadProducts(category, sort);
  });

  // Sort change
  $("#pg-sort").on("change", function () {
    currentPage = 1; // Reset to first page on sort change
    const category = $("#pg-category").val();
    const sort = $(this).val();
    updateUrlParams(category, sort, currentPage);
    renderProducts(category, sort);
  });

  // Handle browser back/forward navigation
  $(window).on("popstate", function () {
    const params = getUrlParams();
    currentPage = params.page;
    $("#pg-category").val(params.category);
    $("#pg-sort").val(params.sort);
    renderProducts(params.category, params.sort);
  });
});
