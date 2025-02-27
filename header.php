<?php

/**
 * Theme header
 *
 * @package wp_luther_blue
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
      <?php esc_html_e('Aller au contenu', 'wp-luther-blue'); ?>
    </a>

    <header class="site-header" id="masthead">
      <div class="site-header__container container">
        <nav class="left-menu">
          <?php
          wp_nav_menu(array(
            'theme_location' => 'right-menu',
            'menu_class'     => 'site-nav__menu',
            'container'      => 'ul'
          ));
          ?>
        </nav>
        <div class="site-header__branding">
          <?php if ($logo = get_theme_mod('wp_luther_blue_logo')) : ?>
            <div class="site-header__logo">
              <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>" width="150" height="50"
                  loading="eager">
              </a>
            </div>
          <?php endif; ?>
        </div>

        <button class="site-nav__toggle" aria-controls="primary-menu" aria-expanded="false">
          <span class="site-nav__toggle-icon">
            <span class="site-nav__toggle-line"></span>
            <span class="site-nav__toggle-line"></span>
            <span class="site-nav__toggle-line"></span>
          </span>
          <span class="screen-reader-text">
            <?php esc_html_e('Menu', 'wp-luther-blue'); ?>
          </span>
        </button>
        <div class="header-right">
          <nav class="site-nav" id="site-navigation"
            aria-label="<?php esc_attr_e('Menu principal', 'wp-luther-blue'); ?>">
            <?php if (has_nav_menu('primary')) : ?>
              <?php
              wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'right-menu',
                'container'      => false,
                'menu_class'     => 'site-nav__menu',
                'fallback_cb'    => false,
                'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
              ));
              ?>
            <?php else : ?>
              <ul class="site-nav__menu">
                <?php wp_list_pages(array(
                  'title_li' => false,
                  'depth'    => 1,
                )); ?>
              </ul>
            <?php endif; ?>
          </nav>
          <div class="header-cart">
            <a href="#" class="cart-icon">
              Cart <span class="cart-count">(<?php echo WC()->cart->get_cart_contents_count(); ?>)</span>
            </a>
          </div>
        </div>
      </div>

      <!-- /CART POPUP CONTENT/ -->
      <div id="popup-cart" class="popup-cart">
        <div class="popup-cart-content">
          <span class="close-popup">&times;</span>
          <h3>Your Cart (<?php echo WC()->cart->get_cart_contents_count(); ?>)</h3>
          <div class="cart-content">
            <?php woocommerce_mini_cart(); ?>
          </div>
          <a href="<?php echo wc_get_checkout_url(); ?>" class="button checkout">Go to Checkout</a>
          <p>Free standard shipping Worldwide with orders over $80.</p>
        </div>
      </div>
    </header>

    <div id="content" class="site-content">