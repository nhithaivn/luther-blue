jQuery(document).ready(function ($) {
  $('.product-slider').imagesLoaded(function () {
    $('.product-slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      adaptiveHeight: false,
      asNavFor: '.product-thumbs' // Link to thumbnail slider
    });

    $('.product-thumbs').slick({
      slidesToShow: 4, // Adjust the number of thumbnails shown
      slidesToScroll: 1,
      asNavFor: '.product-slider', // Link to main slider
      dots: false,
      centerMode: false,
      focusOnSelect: true,
      arrows: false,
      vertical: true, // Make it vertical
      verticalSwiping: true // Enable vertical swiping
    });
  });
});

jQuery(document).ready(function ($) {
  $(".relate-product-slider").slick({
    slidesToShow: 3, // Number of slides visible at a time
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
    dots: true,
    arrows: false,
    responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 3
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1
      }
    }
    ]
  });
});