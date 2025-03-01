
jQuery(document).ready(function ($) {
  // Open/Close popup
  $('.cart-icon').click(function () {
    $('#cart-popup').fadeIn();
  });

  $('.close-popup').click(function () {
    $('#cart-popup').fadeOut();
  });

  $(document).mouseup(function (e) {
    if (!$("#cart-popup .cart-popup-content").is(e.target) && $("#cart-popup .cart-popup-content").has(e.target).length === 0) {
      $("#cart-popup").fadeOut();
    }
  });

  // Update cart dynamically
  $(document.body).on('added_to_cart removed_from_cart', function () {
    $.ajax({
      url: wc_add_to_cart_params.ajax_url,
      type: 'POST',
      data: { action: 'woocommerce_get_refreshed_fragments' },
      success: function (data) {
        $('.cart-content').html(data.fragments['div.widget_shopping_cart_content']);
        $('.cart-count').html(data.fragments['.cart-count']);
      }
    });
  });
});


jQuery(document).ready(function ($) {
  function updateMiniCart(response) {
    $('.cart-count').text(response.cart_count); // Update cart count in all locations
    $('.cart-total-price').html(response.cart_total); // Update total price

    $('.mini-cart-item[data-cart-item-key="' + response.cart_item_key + '"] .cart-item-qty').html(response.cart_qty);
    $('.mini-cart-item[data-cart-item-key="' + response.cart_item_key + '"] .cart-item-price').html(response.item_total);

    if (response.cart_qty === 0) {
      $('.mini-cart-item[data-cart-item-key="' + response.cart_item_key + '"]').remove();
    }
  }

  $('.qty-btn').on('click', function () {
    let cartItemKey = $(this).data('cart-item');
    let action = $(this).hasClass('increase') ? 'increase' : 'decrease';

    $.ajax({
      type: 'POST',
      url: custom_cart_ajax.ajax_url,
      data: {
        action: 'update_cart_item',
        cart_item_key: cartItemKey,
        operation: action
      },
      success: function (response) {
        if (response.success) {
          updateMiniCart(response.data);
        }
      }
    });
  });

  $('.delete-cart-item').on('click', function () {
    let cartItemKey = $(this).data('cart-item');

    $.ajax({
      type: 'POST',
      url: custom_cart_ajax.ajax_url,
      data: {
        action: 'remove_cart_item',
        cart_item_key: cartItemKey
      },
      success: function (response) {
        if (response.success) {
          updateMiniCart(response.data);
        }
      }
    });
  });
});
