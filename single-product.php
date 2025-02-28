<?php

/**
 * Custom Single Product Template with Selectable Sizes
 */

get_header(); ?>

<?php while (have_posts()) : the_post();
  global $product;
?>

  <div class="product-container">
    <!-- Left Section: Product Images (Slick Slider) -->
    <div class="product-slider-wrap">
      <div class="product-slider">
        <?php
        global $product;
        $product_id = $product->get_id();

        // Get main product image
        $thumbnail_id = get_post_thumbnail_id($product_id);
        $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'large');

        // Display main product image
        if ($thumbnail_url) {
          echo '<div class="slide"><img src="' . esc_url($thumbnail_url) . '" alt="Main Image"></div>';
        }

        // Get WooCommerce product gallery images
        $attachment_ids = $product->get_gallery_image_ids();

        if (!empty($attachment_ids)) {
          foreach ($attachment_ids as $attachment_id) {
            // Skip if the gallery image is the same as the main image
            if ($attachment_id == $thumbnail_id) {
              continue;
            }

            $image_url = wp_get_attachment_image_url($attachment_id, 'large');
            echo '<div class="slide"><img src="' . esc_url($image_url) . '" alt="Gallery Image"></div>';
          }
        }
        ?>
      </div>
      <!-- /SHOW ON MOBILE/ -->
      <div class="product-top-info">
        <?php
        woocommerce_breadcrumb()
        ?>
        <h1 class="product-title"><?php the_title(); ?></h1>
        <p class="product-description"><?php echo $product->get_description();  ?></p>
      </div>
      <!-- /SHOW ON MOBILE/ -->
      <div class="product-thumbs">
        <?php
        // Add main product thumbnail
        if ($thumbnail_url) {
          echo '<div class="thumb"><img src="' . esc_url($thumbnail_url) . '" alt="Thumbnail"></div>';
        }

        // Add gallery thumbnails, skipping the main image
        if (!empty($attachment_ids)) {
          foreach ($attachment_ids as $attachment_id) {
            if ($attachment_id == $thumbnail_id) {
              continue; // Skip duplicate
            }

            $image_thumb_url = wp_get_attachment_image_url($attachment_id, 'thumbnail');
            echo '<div class="thumb"><img src="' . esc_url($image_thumb_url) . '" alt="Thumbnail"></div>';
          }
        }
        ?>
      </div>
    </div>

    <!-- Right Section: Product Information -->
    <div class="product-info-wrap">
      <!-- /SHOW ON DESKTOP/ -->
      <div class="product-top-info">
        <?php
        woocommerce_breadcrumb()
        ?>
        <h1 class="product-title"><?php the_title(); ?></h1>
        <p class="product-description"><?php echo $product->get_description();  ?></p>
      </div>
      <!-- /SHOW ON DESKTOP/ -->

      <p class="sub-title">Features</p>
      <?php
      $features = get_field('features', $product->get_id());
      if ($features) {
        echo '<p class="product-text">' . wp_kses_post($features) . '</p>'; // Safely output textarea with formatting
      } else {
        echo '<p class="product-text">No features available.</p>';
      }
      ?>
      <p class="sub-title">Aroma</p>
      <?php
      $aroma = get_field('aroma', $product->get_id());
      if ($aroma) {
        echo '<p class="product-text">' . wp_kses_post($aroma) . '</p>'; // Safely output textarea with formatting
      } else {
        echo '<p class="product-text">No aroma available.</p>';
      }
      ?>
      <div class="sub-title-icon">
        <p class="sub-title">Key Ingredients</p>
        <button class="read-more-btn">+</button>
      </div>
      <?php
      $ingredients = get_field('ingredients', $product->get_id());
      if ($ingredients):
      ?>
        <div class="product-text-container">
          <p class="product-text short-text"><?php echo wp_kses_post($ingredients); ?></p>
        </div>
      <?php
      else:
        echo '<p class="product-text">No ingredients available.</p>';
      endif;
      ?>


      <?php if ($product->is_type('variable')) : ?>
        <form class="cart" method="post" enctype="multipart/form-data">
          <p class="sub-title">Select Size</p>
          <div class="product-sizes">
            <?php
            $available_variations = $product->get_available_variations();
            $default_variation = reset($available_variations);
            $default_variation_id = $default_variation['variation_id'] ?? null;

            foreach ($available_variations as $variation) {
              $variation_id = $variation['variation_id'];
              $size = $variation['attributes']['attribute_sizes'] ?? '';
              $price = $variation['display_price'];

              if (!empty($size)) {
                echo '<label class="size-option">
                <input type="radio" name="variation_id" value="' . esc_attr($variation_id) . '" data-price="' . esc_attr($price) . '" required> 
                <span>' . esc_html($size) . '</span>
              </label>';
              }
            }
            ?>
          </div>

          <!-- ✅ Required WooCommerce Hidden Fields -->
          <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>">
          <input type="hidden" name="quantity" value="1">
          <button type="submit" class="submit-button">Add To Your Cart -
            <span id="dynamic-price" class="product-prize"><?php echo wc_price($product->get_price()); ?></span>
          </button>
        </form>


      <?php endif; ?>

      <p class="note">Pay With Afterpay</p>
      <?php
      $note = get_field('note', $product->get_id());
      if ($note) {
        echo '<p class="product-text last">' . wp_kses_post($note) . '</p>'; // Safely output textarea with formatting
      }
      ?>
    </div>
  </div>

  <!-- Benefits && how to use -->
  <div class="more-info">
    <div class="odd-card">
      <div class="card-text">
        <p class="sub-title">The Benefits</p>
        <?php
        $benefits = get_field('benefits', $product->get_id());
        if ($benefits) {
          echo '<p class="product-text">' . wp_kses_post($benefits) . '</p>'; // Safely output textarea with formatting
        }
        ?>
      </div>
      <?php
      $benefit_image = get_field('benefit_image');

      if ($benefit_image) {
        echo '<img src="' . esc_url($benefit_image) . '" alt="how to use">';
      }
      ?>
    </div>
    <div class="even-card">
      <div class="card-text">
        <p><strong>How To Use It</strong></p>
        <?php
        $howtouse = get_field('how_to_use', $product->get_id());
        if ($howtouse) {
          echo '<p class="product-text">' . wp_kses_post($howtouse) . '</p>'; // Safely output textarea with formatting
        }
        ?>
      </div>
      <?php
      $howtouseimge = get_field('how_to_use_image');

      if ($howtouseimge) {
        echo '<img src="' . esc_url($howtouseimge) . '" alt="how to use">';
      }
      ?>
    </div>

  </div>

<?php endwhile; ?>

<!-- You may also like -->
<div class="relate-products">
  <div class="container">
    <h3 class="block-title">You may also like</h3>

    <div class="relate-product-slider">
      <?php
      $args = array(
        'limit'   => 10,
        'orderby' => 'date',
        'order'   => 'DESC',
        'status'  => 'publish',
      );

      $products = wc_get_products($args);

      if (!empty($products)) :
        foreach ($products as $product) {
          $product_id = $product->get_id();
          $image_url = wp_get_attachment_image_url($product->get_image_id(), 'medium') ?: wc_placeholder_img_src();
          $categories = wc_get_product_category_list($product_id, ', '); // Get categories

          $default_variation = reset($available_variations);
          $default_variation_id = $default_variation['variation_id'] ?? null;

          // Default price variables
          $regular_price = null;
          $sale_price = null;
          $currency_symbol = get_woocommerce_currency_symbol();

          // Check if product is variable
          if ($product->is_type('variable')) {
            $variations = $product->get_available_variations();
            $smallest_price = null;

            foreach ($variations as $variation) {
              $variation_id = $variation['variation_id'];
              $variation_obj = wc_get_product($variation_id);

              $variation_regular_price = $variation_obj->get_regular_price();
              $variation_sale_price = $variation_obj->get_sale_price();
              // Find the lowest priced variation
              if ($smallest_price === null || $variation_regular_price < $smallest_price) {
                $smallest_price = $variation_regular_price;
                $regular_price = $variation_regular_price;
                $sale_price = $variation_sale_price;
              }
            }
          } else {
            // For simple products
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
          }

          // Format price output
          if ($sale_price && $sale_price < $regular_price) {
            $price_html = $currency_symbol . '' . $sale_price;
          } else {
            $price_html = $currency_symbol . '' . $regular_price;
          }
      ?>
          <div class="product-item">
            <a class="product-image" href="<?php echo esc_url(get_permalink($product_id)); ?>">
              <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" loading="lazy">
            </a>
            <p class="category">
              </php><?php echo wp_kses_post($categories); ?>
            </p>
            <div class="product-title-price">
              <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                <h2 class="product-title"><?php echo esc_html($product->get_name()); ?></h2>
              </a>
              <div class="product-price">
                <p class="regular-price"><?php echo $currency_symbol . '' . $regular_price; ?></p>
                <?php if ($sale_price) : ?>
                  <p class="current-price"><?php echo $currency_symbol . '' . $sale_price; ?></p>
                <?php endif; ?>
              </div>
            </div>
            <p class="product-description"><?php echo $product->get_description();  ?></p>

            <form class="cart" method="post" enctype="multipart/form-data">
              <?php
              $available_variations = $product->get_available_variations();
              $default_variation = reset($available_variations);
              $default_variation_id = $default_variation['variation_id'] ?? null;
              ?>

              <!-- ✅ Required WooCommerce Hidden Fields -->
              <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>">
              <input type="hidden" name="quantity" value="1">
              <input type="hidden" name="variation_id" value="<?php echo esc_attr($default_variation_id); ?>">
              <button type="submit" class="submit-button">Add To Your Cart - <span id="dynamic-price" class="product-prize"> <?php echo wp_kses_post($price_html); ?></span></button>
            </form>
          </div>
      <?php
        }
      else :
        echo '<p>No new products found.</p>';
      endif;
      ?>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const sizeRadios = document.querySelectorAll(".size-option input");
    const priceElement = document.getElementById("dynamic-price");

    if (sizeRadios.length > 0) {
      // Select first available size by default
      sizeRadios[0].checked = true;
      updatePrice(sizeRadios[0]);
    }

    // Update price and variation ID when a size is selected
    sizeRadios.forEach(radio => {
      radio.addEventListener("change", function() {
        updatePrice(this);
      });
    });

    function updatePrice(selectedRadio) {
      const price = selectedRadio.getAttribute("data-price");

      if (price) {
        priceElement.innerHTML = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: '<?php echo get_woocommerce_currency(); ?>'
        }).format(price);
      }
    }
  });
</script>

<!-- // -->
<?php get_footer(); ?>