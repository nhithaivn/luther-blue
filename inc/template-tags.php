<?php

/**
 * Fonctions de template personnalisées pour ce thème
 */

if (!function_exists('wp_luther_blue_posted_on')) :
  /**
   * Affiche la date de publication d'un article
   */
  function wp_luther_blue_posted_on()
  {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
      $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf(
      $time_string,
      esc_attr(get_the_date(DATE_W3C)),
      esc_html(get_the_date()),
      esc_attr(get_the_modified_date(DATE_W3C)),
      esc_html(get_the_modified_date())
    );

    echo '<span class="posted-on">' . sprintf(
      /* translators: %s: post date */
      esc_html_x('Publié le %s', 'post date', 'wp-luther-blue'),
      '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
    ) . '</span>';
  }
endif;

if (!function_exists('wp_luther_blue_posted_by')) :
  /**
   * Affiche le nom de l'auteur de l'article
   */
  function wp_luther_blue_posted_by()
  {
    echo '<span class="byline">' . sprintf(
      /* translators: %s: post author */
      esc_html_x('par %s', 'post author', 'wp-luther-blue'),
      '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
    ) . '</span>';
  }
endif;

if (!function_exists('wp_luther_blue_entry_footer')) :
  /**
   * Affiche les catégories, tags et liens de commentaires
   */
  function wp_luther_blue_entry_footer()
  {
    // Masquer les tags pour les pages
    if ('post' === get_post_type()) {
      $categories_list = get_the_category_list(esc_html__(', ', 'wp-luther-blue'));
      if ($categories_list) {
        printf('<span class="cat-links">' . esc_html__('Catégories : %1$s', 'wp-luther-blue') . '</span>', $categories_list);
      }

      $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'wp-luther-blue'));
      if ($tags_list) {
        printf('<span class="tags-links">' . esc_html__('Tags : %1$s', 'wp-luther-blue') . '</span>', $tags_list);
      }
    }

    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
      echo '<span class="comments-link">';
      comments_popup_link(
        sprintf(
          wp_kses(
            __('Laisser un commentaire<span class="screen-reader-text"> sur %s</span>', 'wp-luther-blue'),
            array(
              'span' => array(
                'class' => array(),
              ),
            )
          ),
          wp_kses_post(get_the_title())
        )
      );
      echo '</span>';
    }
  }
endif;

if (!function_exists('wp_luther_blue_post_thumbnail')) :
  /**
   * Affiche l'image à la une
   */
  function wp_luther_blue_post_thumbnail()
  {
    if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
      return;
    }

    if (is_singular()) :
?>
      <div class="post-thumbnail">
        <?php the_post_thumbnail(); ?>
      </div>
    <?php else : ?>
      <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
        <?php
        the_post_thumbnail(
          'post-thumbnail',
          array(
            'alt' => the_title_attribute(
              array(
                'echo' => false,
              )
            ),
          )
        );
        ?>
      </a>
<?php
    endif;
  }
endif;
