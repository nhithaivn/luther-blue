
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


