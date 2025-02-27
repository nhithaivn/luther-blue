<?php

/**
 * Template for displaying pages
 *
 * @package wp_luther_blue
 */

get_header();
?>

<main id="primary" class="site-main">
  <div class="container">
    <?php
    // Breadcrumb with improved accessibility management
    if (function_exists('yoast_breadcrumb')) {
      yoast_breadcrumb('<nav class="breadcrumb" aria-label="' . esc_attr__('Fil d\'ariane', 'wp-luther-blue') . '">', '</nav>');
    } elseif (function_exists('bcn_display')) {
      echo '<nav class="breadcrumb" aria-label="' . esc_attr__('Fil d\'ariane', 'wp-luther-blue') . '">';
      bcn_display();
      echo '</nav>';
    } else {
      echo '<nav class="breadcrumb" aria-label="' . esc_attr__('Fil d\'ariane', 'wp-luther-blue') . '">';
      echo '<ol class="breadcrumb__list">';
      echo '<li class="breadcrumb__item">';
      echo '<a href="' . esc_url(home_url('/')) . '" class="breadcrumb__link">' . esc_html__('Accueil', 'wp-luther-blue') . '</a>';
      echo '</li>';
      echo '<li class="breadcrumb__item breadcrumb__item--current" aria-current="page">';
      echo get_the_title();
      echo '</li>';
      echo '</ol>';
      echo '</nav>';
    }

    while (have_posts()) :
      the_post();
      get_template_part('template-parts/content', 'page');

      // Commentaires
      if (comments_open() || get_comments_number()) :
        echo '<div class="comments-wrapper">';
        comments_template();
        echo '</div>';
      endif;

      // Navigation entre les pages
      $next_post = get_next_post();
      $prev_post = get_previous_post();

      if ($next_post || $prev_post) :
    ?>
        <nav class="page-navigation" aria-label="<?php esc_attr_e('Navigation entre les pages', 'wp-luther-blue'); ?>">
          <div class="page-navigation__inner">
            <?php if ($prev_post) : ?>
              <a href="<?php echo get_permalink($prev_post); ?>" class="page-navigation__link page-navigation__link--prev">
                <svg class="page-navigation__icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="19" y1="12" x2="5" y2="12"></line>
                  <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span class="page-navigation__text">
                  <span class="page-navigation__label"><?php esc_html_e('Previous page', 'wp-luther-blue'); ?></span>
                  <span class="page-navigation__title"><?php echo get_the_title($prev_post); ?></span>
                </span>
              </a>
            <?php endif; ?>

            <?php if ($next_post) : ?>
              <a href="<?php echo get_permalink($next_post); ?>" class="page-navigation__link page-navigation__link--next">
                <span class="page-navigation__text">
                  <span class="page-navigation__label"><?php esc_html_e('Next page', 'wp-luther-blue'); ?></span>
                  <span class="page-navigation__title"><?php echo get_the_title($next_post); ?></span>
                </span>
                <svg class="page-navigation__icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </a>
            <?php endif; ?>
          </div>
        </nav>
      <?php endif; ?>
    <?php endwhile; ?>
  </div>
</main>

<?php
get_sidebar();
get_footer();
