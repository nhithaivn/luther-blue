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
      initialSlide: 0,
      asNavFor: '.product-slider',
      dots: false,
      focusOnSelect: true,
      arrows: false,
      vertical: true,
      verticalSwiping: true,
      infinite: false, // Ensure first thumbnail is shown
      responsive: [{
        breakpoint: 768,
        settings: {
          vertical: false,
          verticalSwiping: false,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2.7,
          vertical: false,
          verticalSwiping: false,
        }
      }]
    });

  });
});

jQuery(document).ready(function ($) {
  $(".relate-product-slider").slick({
    // slidesToShow: 2.8, // not work with variableWidth
    slidesToScroll: 1,
    initialSlide: false,
    autoplay: true,
    autoplaySpeed: 3000,
    dots: true,
    arrows: false,
    variableWidth: true,
    responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 2.8
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
        slidesToShow: 1.2,
        infinite: false,
      }
    }
    ]
  });
});