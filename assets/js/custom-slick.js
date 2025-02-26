jQuery(document).ready(function ($) {
  $('.product-slider').imagesLoaded(function () {
    $('.product-slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      fade: true,
      adaptiveHeight: true,
      asNavFor: '.product-thumbs' // Link to thumbnail slider
    });

    $('.product-thumbs').slick({
      slidesToShow: 4, // Adjust the number of thumbnails shown
      slidesToScroll: 1,
      asNavFor: '.product-slider', // Link to main slider
      dots: false,
      centerMode: false,
      focusOnSelect: true,
      arrows: true
    });
  });
});

