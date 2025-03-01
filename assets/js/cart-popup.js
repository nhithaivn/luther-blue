
jQuery(document).ready(function ($) {
  function isDesktop() {
    return $(window).width() > 1024; // Adjust breakpoint as needed
  }
  // Open cart
  $('.cart-icon').click(function () {
    $('#cart-popup, #cart-overlay').fadeIn();
    $('body').addClass('no-scroll');
  });

  // Close cart
  $('.close-popup, #cart-overlay').click(function () {
    $('#cart-popup, #cart-overlay').fadeOut();
    $('body').removeClass('no-scroll');
  });

  // Close Cart if clicking outside cart content  (only for desktop)
  $(document).mouseup(function (e) {
    if (!isDesktop()) return; // Exit function if not on desktop

    if (!$("#cart-popup .cart-popup-content").is(e.target) && $("#cart-popup .cart-popup-content").has(e.target).length === 0) {
      $("#cart-popup, #cart-overlay").fadeOut();
      $('body').removeClass('no-scroll');
    }
  });
});


jQuery(document).ready(function ($) {
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
    $('.cart-count').text(response.cart_count); // Update cart count
    $('.cart-total-price').html(response.cart_total); // Update total price

    if (response.cart_item_key) {
      let itemSelector = '.mini-cart-item[data-cart-item-key="' + response.cart_item_key + '"]';

      if (response.cart_qty > 0) {
        $(itemSelector + ' .cart-item-qty').html(response.cart_qty);
        $(itemSelector + ' .cart-item-price').html(response.item_total);
      } else {
        $(itemSelector).fadeOut(300, function () {
          $(this).remove();
        });
      }
    }

    refreshCartFragments();
  }

  // Increase or Decrease Quantity
  $(document).on('click', '.qty-btn', function () {
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

  // Remove Item
  $(document).on('click', '.delete-cart-item', function () {
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

  function refreshCartFragments() {
    $.ajax({
      type: 'POST',
      url: custom_cart_ajax.ajax_url,
      data: { action: 'refresh_cart_fragments' },
      success: function (response) {
        if (response.success) {
          $('.cart-count').html(response.cart_count_html);
          $('.cart-content').html(response.mini_cart_html);
        }
      }
    });
  }
});
