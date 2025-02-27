
jQuery(document).ready(function ($) {
  // Open/Close popup
  $('.cart-icon').click(function () {
    $('#popup-cart').fadeIn();
  });

  $('.close-popup').click(function () {
    $('#popup-cart').fadeOut();
  });

  $(document).mouseup(function (e) {
    if (!$("#popup-cart .popup-cart-content").is(e.target) && $("#popup-cart .popup-cart-content").has(e.target).length === 0) {
      $("#popup-cart").fadeOut();
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


