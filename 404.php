<?php
get_header();
?>

<main id="primary" class="site-main">
  <section class="error-404 not-found">
    <header class="page-header">
      <h1 class="page-title"><?php esc_html_e('Oops! This page could not be found.', 'wp-luther-blue'); ?></h1>
    </header>

    <div class="page-content">
      <p>
        <?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'wp-luther-blue'); ?>
      </p>

      <?php get_search_form(); ?>

      <div class="widget-area">
        <?php
        the_widget('WP_Widget_Recent_Posts');
        ?>

        <div class="widget widget_categories">
          <h2 class="widget-title"><?php esc_html_e('Catégories les plus utilisées', 'wp-luther-blue'); ?></h2>
          <ul>
            <?php
            wp_list_categories(
              array(
                'orderby'    => 'count',
                'order'      => 'DESC',
                'show_count' => 1,
                'title_li'   => '',
                'number'     => 10,
              )
            );
            ?>
          </ul>
        </div>

        <?php
        $archive_content = '<p>' . sprintf(esc_html__('Try looking in the monthly archives. %1$s', 'wp-luther-blue'), convert_smilies(':)')) . '</p>';
        the_widget('WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content");
        ?>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
