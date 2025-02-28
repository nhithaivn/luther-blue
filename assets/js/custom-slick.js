jQuery(document).ready(function ($) {
  $('.product-slider').imagesLoaded(function () {
    $('.product-slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      adaptiveHeight: false,
      asNavFor: '.product-thumbs'
    });

    $('.product-thumbs').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: '.product-slider',
      dots: false,
      centerMode: false,
      focusOnSelect: true,
      arrows: false,
      vertical: true,
      verticalSwiping: true
    });
  });
});

jQuery(document).ready(function ($) {
  $(".relate-product-slider").slick({
    slidesToShow: 3,
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