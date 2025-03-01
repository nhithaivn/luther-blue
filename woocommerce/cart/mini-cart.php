<?php
do_action('woocommerce_before_mini_cart'); ?>

<ul class="cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
  <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    $_product = $cart_item['data'];
    $product_id = $_product->get_id();
    $product_permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';
  ?>
    <li class="mini-cart-item" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">

      <!-- Product Image -->
      <div class="col-start cart-item-image">
        <a href="<?php echo esc_url($product_permalink); ?>">
          <?php echo $_product->get_image('medium'); ?>
        </a>
      </div>

      <div class="col-last">
        <div class="row-top">
          <!-- Product Name -->
          <span class="cart-item-name">
            <a href="<?php echo esc_url($product_permalink); ?>">
              <?php echo esc_html($_product->get_name()); ?>
            </a>
          </span>
          <!-- Product Description -->
          <p class="cart-item-description">
            <?php echo esc_html(wp_trim_words($_product->get_short_description(), 10)); ?>
            Himalayan Sea Salt & Cocoa Butter
          </p>

          <?php
          $product_size = isset($cart_item['variation']['attribute_pa_size']) ? $cart_item['variation']['attribute_pa_size'] : '';
          if (!empty($product_size)) :
          ?>
            <p class="cart-item-size"><?php echo esc_html__('Size:', 'your-text-domain') . ' ' . esc_html($product_size); ?></p>
          <?php endif; ?>
          <button class="delete-cart-item" data-cart-item="<?php echo esc_attr($cart_item_key); ?>">×</button>
        </div>

        <div class="row-bottom">
          <span class="cart-item-price"><?php echo wc_price($cart_item['line_total']); ?></span>

          <div class="add-minus-item">
            <button class="qty-btn decrease" data-cart-item="<?php echo esc_attr($cart_item_key); ?>">−</button>
            <span class="cart-item-qty" data-cart-item="<?php echo esc_attr($cart_item_key); ?>">
              <?php echo esc_html($cart_item['quantity']); ?>
            </span>
            <button class="qty-btn increase" data-cart-item="<?php echo esc_attr($cart_item_key); ?>">+</button>

          </div>
        </div>
      </div>
    </li>
  <?php } ?>
</ul>
<div class="checkout-note">
  <p class="total">
    <?php esc_html_e('Total', 'woocommerce'); ?>
    <span class="cart-total-price"><?php echo WC()->cart->get_cart_total(); ?></span>
  </p>
  <a href="<?php echo wc_get_checkout_url(); ?>" class="button checkout">Go to Checkout
    <span class="dot"> &sdot; </span>
    <span class="cart-total-price"><?php echo WC()->cart->get_cart_total(); ?>
    </span>
  </a>
  <p class="note">Free standard shipping Worldwide with orders over $80.</p>

</div>

<?php do_action('woocommerce_after_mini_cart'); ?>