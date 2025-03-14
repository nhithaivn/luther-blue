<?php
if (!defined('ABSPATH')) {
  exit;
}

// Theme Configuration
if (!function_exists('wp_luther_blue_setup')):
  function wp_luther_blue_setup()
  {
    // Translation support
    load_theme_textdomain('wp-luther-blue', get_template_directory() . '/languages');

    // WordPress Feature Support
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script'
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');

    // Navigation menu
    register_nav_menus(array(
      'primary' => esc_html__('Menu Principal', 'wp-luther-blue'),
      'footer' => esc_html__('Menu Footer', 'wp-luther-blue')
    ));
  }
endif;
add_action('after_setup_theme', 'wp_luther_blue_setup');

// Support RTL
add_action('after_setup_theme', function () {
  add_theme_support('rtl-language-support');
});

// Saving Scripts and Styles
function wp_luther_blue_scripts()
{
  // Load compiled main style
  wp_enqueue_style(
    'wp-luther-blue-main-style',
    get_template_directory_uri() . '/assets/css/style.css',
    array(),
    wp_get_theme()->get('Version')
  );

  // Load the main script
  wp_enqueue_script(
    'wp-luther-blue-main',
    get_template_directory_uri() . '/assets/js/main.js',
    array(),
    wp_get_theme()->get('Version'),
    true
  );

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'wp_luther_blue_scripts');

// Added after wp_luther_blue_scripts()
function wp_luther_blue_widgets_init()
{
  register_sidebar(array(
    'name'          => esc_html__('Sidebar Principal', 'wp-luther-blue'),
    'id'            => 'sidebar-1',
    'description'   => esc_html__('Add your widgets here.', 'wp-luther-blue'),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ));
}
add_action('widgets_init', 'wp_luther_blue_widgets_init');

// Include additional files
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';

/**
 * Check theme dependencies
 */
function wp_luther_blue_check_dependencies()
{
  $notices = array();

  // Check if ACF is active
  if (!class_exists('ACF') && !function_exists('get_field')) {
    $notices[] = sprintf(
      /* translators: %s: link to plugins pages */
      __('The theme recommends installing the <a href="%s">Advanced Custom Fields</a> plugin for full functionality.', 'wp-luther-blue'),
      admin_url('plugin-install.php?s=advanced-custom-fields&tab=search&type=term')
    );
  }

  // Check if Yoast SEO is active
  if (!function_exists('yoast_breadcrumb')) {
    $notices[] = sprintf(
      /* translators: %s: link to plugins page */
      __('For better navigation, install <a href="%s">Yoast SEO</a> or another breadcrumb plugin.', 'wp-luther-blue'),
      admin_url('plugin-install.php?s=wordpress-seo&tab=search&type=term')
    );
  }

  //Show notices in admin if needed
  if (!empty($notices) && is_admin()) {
    foreach ($notices as $notice) {
      add_action('admin_notices', function () use ($notice) {
        echo '<div class="notice notice-info is-dismissible"><p>' . wp_kses_post($notice) . '</p></div>';
      });
    }
  }
}
add_action('admin_init', 'wp_luther_blue_check_dependencies');


function register_two_menus()
{
  register_nav_menus(
    array(
      'left-menu'   => __('Right Menu', 'wp-luther-blue'),
      'right-menu' => __('Left Menu', 'wp-luther-blue'),
    )
  );
}
add_action('after_setup_theme', 'register_two_menus');

//
function force_shop_template($template)
{
  if (is_shop()) {
    return get_template_directory() . '/archive-product.php';
  }
  return $template;
}
add_filter('template_include', 'force_shop_template');


function enqueue_slick_slider()
{
  wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css', array(), '1.8.1');
  wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css', array(), '1.8.1');

  wp_enqueue_script('jquery');
  wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js', array('jquery'), '1.8.1', true);
  wp_enqueue_script('custom-slick', get_template_directory_uri() . '/assets/js/custom-slick.js', array('jquery', 'slick-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_slick_slider');

function enqueue_slick_and_imagesloaded()
{
  wp_enqueue_script('imagesloaded', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_slick_and_imagesloaded');

//BREADCRUMB
function custom_product_breadcrumb()
{
  if (is_product()) {
    global $post;
    $terms = get_the_terms($post->ID, 'product_cat');

    if ($terms && !is_wp_error($terms)) {
      usort($terms, function ($a, $b) {
        return $a->parent - $b->parent;
      });

      $category_chain = [];
      $current_term = end($terms);

      while ($current_term && count($category_chain) < 2) {
        array_unshift($category_chain, $current_term); // Prepend to maintain order
        $current_term = $current_term->parent ? get_term($current_term->parent, 'product_cat') : null;
      }

      echo '<nav class="custom-breadcrumb">';
      foreach ($category_chain as $index => $category) {
        printf(
          '<a href="%s">%s</a>%s',
          esc_url(get_term_link($category)),
          esc_html($category->name),
          ($index < count($category_chain) - 1) ? ' <span class="breadcrumb-separator">⋅</span> ' : ''
        );
      }
      echo '</nav>';
    }
  } elseif (is_shop() || is_product_category() || is_product_tag()) {
    echo '<nav class="custom-breadcrumb">';

    // Add Home link
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'woocommerce') . '</a>';
    echo ' <span class="breadcrumb-separator">⋅</span> ';

    // Add Shop link
    echo '<a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '">' . esc_html__('Shop', 'woocommerce') . '</a>';

    if (is_product_category() || is_product_tag()) {
      $term = get_queried_object();

      if ($term && isset($term->term_id)) {
        $parent_terms = [];
        $current_term = $term;

        while ($current_term->parent) {
          $current_term = get_term($current_term->parent, 'product_cat');
          if ($current_term) {
            array_unshift($parent_terms, $current_term);
          }
        }

        foreach ($parent_terms as $parent) {
          echo ' <span class="breadcrumb-separator">⋅</span> ';
          echo '<a href="' . esc_url(get_term_link($parent)) . '">' . esc_html($parent->name) . '</a>';
        }

        echo ' <span class="breadcrumb-separator">⋅</span> ';
        echo '<span class="current">' . esc_html($term->name) . '</span>';
      }
    }
    echo '</nav>';
  }
}

// Remove WooCommerce default breadcrumb
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// Add custom breadcrumb
add_action('woocommerce_before_main_content', 'custom_product_breadcrumb', 15);

///CUSTOM ADD LOGIN TO MENU
function add_login_logout_register_menu($items, $args)
{
  if ($args->theme_location != 'primary') {
    return $items;
  }

  if (is_user_logged_in()) {
    $items .= '<li><a href="' . wp_logout_url() . '">Log Out</a></li>';
  } else {
    $items .= '<li><a href="' . wp_login_url() . '">Log In</a></li>';
  }

  return $items;
}
add_filter('wp_nav_menu_items', 'add_login_logout_register_menu', 199, 2);


//CUSTOM CART POPUP
function custom_enqueue_scripts()
{
  wp_enqueue_script('custom-mini-cart', get_template_directory_uri() . '/assets/js/cart-popup.js', array('jquery'), null, true);
  wp_localize_script('custom-mini-cart', 'custom_cart_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');

//Cart popup
add_filter('woocommerce_add_to_cart_fragments', 'update_cart_count');
function update_cart_count($fragments)
{
  ob_start();
?>
  <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
<?php
  $fragments['.cart-count'] = ob_get_clean();
  return $fragments;
}

//Increase / Decrease Cart Quantity
function update_cart_item()
{
  if (!isset($_POST['cart_item_key']) || !isset($_POST['operation'])) {
    wp_send_json_error(['message' => 'Invalid request']);
  }

  $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
  $operation = sanitize_text_field($_POST['operation']);
  $cart = WC()->cart->get_cart();

  if (!isset($cart[$cart_item_key])) {
    wp_send_json_error(['message' => 'Item not found']);
  }

  $cart_item = $cart[$cart_item_key];
  $new_qty = ($operation === 'increase') ? $cart_item['quantity'] + 1 : max(0, $cart_item['quantity'] - 1);

  if ($new_qty > 0) {
    WC()->cart->set_quantity($cart_item_key, $new_qty);
  } else {
    WC()->cart->remove_cart_item($cart_item_key);
  }

  WC()->cart->calculate_totals();
  WC()->cart->set_session();
  WC()->cart->maybe_set_cart_cookies();

  wp_send_json_success([
    'cart_item_key' => $cart_item_key,
    'cart_qty' => $new_qty,
    'item_total' => wc_price($cart[$cart_item_key]['line_total'] ?? 0),
    'cart_total' => WC()->cart->get_cart_total(),
    'cart_count' => WC()->cart->get_cart_contents_count()
  ]);
}
add_action('wp_ajax_update_cart_item', 'update_cart_item');
add_action('wp_ajax_nopriv_update_cart_item', 'update_cart_item');


// Remove Item from Cart
function remove_cart_item()
{
  if (!isset($_POST['cart_item_key'])) {
    wp_send_json_error(['message' => 'Invalid request']);
  }

  $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
  WC()->cart->remove_cart_item($cart_item_key);

  WC()->cart->calculate_totals();
  WC()->cart->set_session();
  WC()->cart->maybe_set_cart_cookies();

  wp_send_json_success([
    'cart_item_key' => $cart_item_key,
    'cart_total' => WC()->cart->get_cart_total(),
    'cart_count' => WC()->cart->get_cart_contents_count()
  ]);
}
add_action('wp_ajax_remove_cart_item', 'remove_cart_item');
add_action('wp_ajax_nopriv_remove_cart_item', 'remove_cart_item');

function refresh_cart_fragments()
{
  ob_start();
?>
  <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
<?php
  $cart_count_html = ob_get_clean();

  ob_start();
  woocommerce_mini_cart();
  $mini_cart_html = ob_get_clean();

  wp_send_json_success([
    'cart_count_html' => $cart_count_html,
    'mini_cart_html' => $mini_cart_html
  ]);
}
add_action('wp_ajax_refresh_cart_fragments', 'refresh_cart_fragments');
add_action('wp_ajax_nopriv_refresh_cart_fragments', 'refresh_cart_fragments');

///
function custom_top_bar_settings($wp_customize)
{
  $wp_customize->add_section('custom_top_bar_section', array(
    'title' => 'Top Bar Settings',
    'priority' => 30,
  ));

  $wp_customize->add_setting('custom_top_bar_text', array(
    'default' => 'Welcome to Our Website!',
    'sanitize_callback' => 'sanitize_text_field',
  ));

  $wp_customize->add_control('custom_top_bar_text_control', array(
    'label' => 'Top Bar Text',
    'section' => 'custom_top_bar_section',
    'settings' => 'custom_top_bar_text',
    'type' => 'text',
  ));
}
add_action('customize_register', 'custom_top_bar_settings');

function custom_top_bar_script()
{
?>
  <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
      let topBar = document.getElementById("custom-top-bar");
      let closeBtn = document.getElementById("close-top-bar");

      // Check if the user has closed the top bar before
      if (localStorage.getItem("topBarClosed") === "true") {
        topBar.style.display = "none";
      }

      closeBtn.addEventListener("click", function() {
        topBar.style.display = "none";
        localStorage.setItem("topBarClosed", "true"); // Remember the user's choice
      });
    });
  </script>
<?php
}
add_action('wp_footer', 'custom_top_bar_script');
