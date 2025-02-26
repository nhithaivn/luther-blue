<?php

/**
 * Theme Customization Features
 */

function wp_starter_basic_customize_register($wp_customize)
{
  // Add a section for theme options
  $wp_customize->add_section('wp_starter_basic_theme_options', array(
    'title'    => __('Theme Options', 'wp-luther-blue'),
    'priority' => 130,
  ));

  // Main color
  $wp_customize->add_setting('wp_starter_basic_primary_color', array(
    'default'           => '#007bff',
    'sanitize_callback' => 'sanitize_hex_color',
  ));

  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'wp_starter_basic_primary_color', array(
    'label'    => __('Main color', 'wp-luther-blue'),
    'section'  => 'wp_starter_basic_theme_options',
    'settings' => 'wp_starter_basic_primary_color',
  )));

  // Footer copyright
  $wp_customize->add_setting('wp_starter_basic_footer_copyright', array(
    'default'           => '',
    'sanitize_callback' => 'wp_kses_post',
  ));

  $wp_customize->add_control('wp_starter_basic_footer_copyright', array(
    'label'    => __('Copyright text', 'wp-luther-blue'),
    'section'  => 'wp_starter_basic_theme_options',
    'settings' => 'wp_starter_basic_footer_copyright',
    'type'     => 'textarea',
  ));

  //Add option for site
  $wp_customize->add_setting('wp_starter_basic_logo', array(
    'default'           => '',
    'sanitize_callback' => 'esc_url_raw',
  ));

  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'wp_starter_basic_logo', array(
    'label'    => __('Site logo', 'wp-luther-blue'),
    'section'  => 'wp_starter_basic_theme_options',
    'settings' => 'wp_starter_basic_logo',
  )));
}
add_action('customize_register', 'wp_starter_basic_customize_register');

/**
 * Generate custom CSS
 */
function wp_starter_basic_customize_css()
{
  $primary_color = get_theme_mod('wp_starter_basic_primary_color', '#007bff'); ?>
  <style type="text/css">
    a {
      color: <?php echo esc_attr($primary_color);
              ?>;
    }

    .main-navigation {
      background-color: <?php echo esc_attr($primary_color);
                        ?>;
    }

    .button,
    button,
    input[type="button"],
    input[type="reset"],
    input[type="submit"] {
      background-color: <?php echo esc_attr($primary_color);
                        ?>;
    }
  </style>
<?php }
add_action('wp_head', 'wp_starter_basic_customize_css');
