  <?php
  /**
   * Theme footer
   */
  ?>

  <footer id="colophon" class="site-footer">
    <div class="site-info">
      <!-- <div class="footer-widgets">
        <?php if (is_active_sidebar('footer-1')) : ?>
        <div class="footer-widget-area">
          <?php dynamic_sidebar('footer-1'); ?>
        </div>
        <?php endif; ?>
      </div> -->

      <div class="footer-bottom">
        <?php
        $copyright = get_theme_mod('wp_starter_basic_footer_copyright');
        if ($copyright) {
          echo wp_kses_post($copyright);
        } else {
          printf(
            esc_html__('© %1$s - Sclimb adventure sports.', 'wp-luther-blue'),
            date('Y'),
            get_bloginfo('name')
          );
        }
        ?>
      </div>

      <!-- <?php
            wp_nav_menu(array(
              'theme_location' => 'footer',
              'menu_id'        => 'footer-menu',
              'container'      => 'nav',
              'container_class' => 'footer-navigation',
              'depth'          => 1,
            ));
            ?> -->
    </div>
  </footer>
  </div><!-- #page -->

  <?php wp_footer(); ?>

  </body>

  </html>