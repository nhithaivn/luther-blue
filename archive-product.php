<?php

/**
 * The Template for displaying product archives (shop page).
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<main class="custom-shop">

  <?php
  do_action('woocommerce_before_main_content');

  if (woocommerce_product_loop()) {
    do_action('woocommerce_before_shop_loop');

    woocommerce_product_loop_start();

    while (have_posts()) {
      the_post();
      wc_get_template_part('content', 'product');
    }

    woocommerce_product_loop_end();

    do_action('woocommerce_after_shop_loop');
  } else {
    do_action('woocommerce_no_products_found');
  }

  do_action('woocommerce_after_main_content');
  ?>
  <!-- <header class="shop-header">
    <h1><?php woocommerce_page_title(); ?></h1>
  </header>
 -->

  <ul class="product-grid">
    <?php
    $args = array(
      'post_type' => 'product',
      'posts_per_page' => 12
    );
    $loop = new WP_Query($args);

    if ($loop->have_posts()) :
      while ($loop->have_posts()) : $loop->the_post();
        wc_get_template_part('content', 'product');
      endwhile;
      wp_reset_postdata();
    else :
      echo '<p>No products found.</p>';
    endif;
    ?>
  </ul>

</main>

<?php
get_footer('shop');
?>