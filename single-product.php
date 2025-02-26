<?php

/**
 * Custom Single Product Template with Selectable Sizes
 */

get_header(); ?>

<?php while (have_posts()) : the_post();
  global $product; ?>

  <div class="product-container">

    <!-- Left Section: Product Images (Slick Slider) -->
    <div class="product-slider-container">
      <!-- Main Image Slider -->
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

      <!-- Thumbnail Slider -->
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
    <div class="product-info">
      <h1 class="product-title"><?php the_title(); ?></h1>
      <!-- Short description -->
      <p class="excerpt"><?php echo get_the_excerpt(); ?></p>
      <!-- Features -->
      <p><strong>Features</strong></p>
      <?php
      $features = get_field('features', $product->get_id());
      if ($features) {
        echo '<p>' . wp_kses_post($features) . '</p>'; // Safely output textarea with formatting
      } else {
        echo '<p>No features available.</p>';
      }
      ?>
      <!-- Aroma -->
      <p><strong>Aroma</strong></p>
      <?php
      $aroma = get_field('aroma', $product->get_id());
      if ($aroma) {
        echo '<p>' . wp_kses_post($aroma) . '</p>'; // Safely output textarea with formatting
      } else {
        echo '<p>No aroma available.</p>';
      }
      ?>
      <!-- Ingredients -->
      <p><strong>Ingredients</strong></p>
      <?php
      $ingredients = get_field('ingredients', $product->get_id());
      if ($ingredients) {
        echo '<p>' . wp_kses_post($ingredients) . '</p>'; // Safely output textarea with formatting
      } else {
        echo '<p>No ingredients available.</p>';
      }
      ?>

      <!-- Size Selection -->
      <?php
      $sizes = get_field('sizes'); // Get sizes from ACF (Checkbox or Repeater Field)
      if ($sizes) : ?>
        <form class="cart" method="post" enctype="multipart/form-data">
          <div class="product-sizes">
            <p><strong>Select Size:</strong></p>
            <?php foreach ($sizes as $size) : ?>
              <label class="size-option">
                <input type="radio" name="selected_size" value="<?php echo esc_attr($size); ?>" required>
                <span><?php echo esc_html($size); ?></span>
              </label>
            <?php endforeach; ?>
          </div>

          <!-- Hidden input for product ID -->
          <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>">

          <!-- Add to Cart Button -->
          <button type="submit" class="button alt">Add to Cart</button>
        </form>
      <?php else: ?>
        <p><strong>Sizes:</strong> Not Available</p>
      <?php endif; ?>
      <!-- Price -->
      <p class="price"><?php echo $product->get_price_html(); ?></p>
    </div>
    <!-- Full Product Description -->
    <?php
    $full_description = $product->get_description();
    if ($full_description) : ?>
      <div class="product-description">
        <h3>Product Description</h3>
        <p><?php echo wp_kses_post($full_description); ?></p>
      </div>
    <?php endif; ?>
  </div>

<?php endwhile; ?>

<!-- You may also like -->
<h3>You may also like </h3>
<?php
$args = array(
  'limit'   => 10, // Number of products to display
  'orderby' => 'date', // Sort by newest
  'order'   => 'DESC',
  'status'  => 'publish'
);

$products = wc_get_products($args);

if (!empty($products)) :
  echo '<ul class="new-products-list">';
  foreach ($products as $product) {
    $product_id = $product->get_id();
    $image_url = wp_get_attachment_image_url($product->get_image_id(), 'medium'); // Get product image

?>
    <li class="product-item">
      <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
        <div class="product-image">
          <?php if ($image_url) : ?>
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>">
          <?php else : ?>
            <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" alt="Placeholder Image">
          <?php endif; ?>
        </div>
        <h2 class="product-title"><?php echo esc_html($product->get_name()); ?></h2>
        <p class="price"><?php echo $product->get_price_html(); ?></p>
      </a>
    </li>
<?php
  }
  echo '</ul>';
else :
  echo '<p>No new products found.</p>';
endif;
?>

<!-- // -->
<?php get_footer(); ?>