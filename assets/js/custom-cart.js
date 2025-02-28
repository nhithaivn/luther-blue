
jQuery(document).ready(function ($) {
  console.log("Custom cart script loaded");

  // Increase / Decrease Quantity
  $(document).on("click", ".qty-btn", function (e) {
    e.preventDefault();
    let button = $(this);
    let cartItemKey = button.attr("data-cart-item");
    let action = button.hasClass("increase") ? "increase" : "decrease";

    $.ajax({
      type: "POST",
      url: wc_cart_params.ajax_url,
      data: {
        action: "update_cart_item_quantity",
        cart_item_key: cartItemKey,
        operation: action,
      },
      beforeSend: function () {
        button.prop("disabled", true);
      },
      success: function (response) {
        if (response.success) {
          let itemSelector = "[data-cart-item-key='" + cartItemKey + "']";
          $(itemSelector).find(".cart-item-qty").text(response.quantity);
          $(itemSelector).find(".cart-item-price").html(response.item_total);
          $(itemSelector).find(".cart-item-name").text(response.product_name);
          $(itemSelector).find(".cart-item-description").text(response.product_description);
          $(".cart-total-price").html(response.cart_total);
          $(".cart-count").text(response.cart_count);
        } else {
          console.log(response.message);
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX Error:", error);
      },
      complete: function () {
        button.prop("disabled", false);
      },
    });
  });

  // DELETE CART ITEM
  $(document).on("click", ".delete-cart-item", function (e) {
    e.preventDefault();
    let button = $(this);
    let cartItemKey = button.attr("data-cart-item");

    $.ajax({
      type: "POST",
      url: wc_cart_params.ajax_url,
      data: {
        action: "delete_cart_item",
        cart_item_key: cartItemKey,
      },
      beforeSend: function () {
        button.prop("disabled", true);
      },
      success: function (response) {
        if (response.success) {
          $("[data-cart-item-key='" + cartItemKey + "']").remove();
          $(".cart-total-price").html(response.cart_total);
          $(".cart-count").text(response.cart_count);
        } else {
          console.log("Error:", response.message);
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX Error:", error);
      },
      complete: function () {
        button.prop("disabled", false);
      },
    });
  });
});
