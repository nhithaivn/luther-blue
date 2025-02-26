<?php

/**
 * Template part for displaying a message when no content is found
 */
?>

<section class="no-results not-found">
  <header class="page-header">
    <h1 class="page-title">
      <?php esc_html_e('Rien n\'a été trouvé', 'wp-luther-blue'); ?>
    </h1>
  </header>

  <div class="page-content">
    <?php if (is_home() && current_user_can('publish_posts')) :
      printf(
        '<p>' . wp_kses(
          __('Prêt à publier votre premier article ? <a href="%1$s">Commencez ici</a>.', 'wp-luther-blue'),
          array(
            'a' => array(
              'href' => array(),
            ),
          )
        ) . '</p>',
        esc_url(admin_url('post-new.php'))
      );
    elseif (is_search()) : ?>
      <p>
        <?php esc_html_e('Désolé, mais rien ne correspond à vos critères de recherche. Veuillez réessayer avec d\'autres mots-clés.', 'wp-luther-blue'); ?>
      </p>
    <?php get_search_form();
    else : ?>
      <p>
        <?php esc_html_e('Il semble que nous ne trouvions pas ce que vous cherchez. Essayez peut-être une recherche ?', 'wp-luther-blue'); ?>
      </p>
    <?php get_search_form();
    endif; ?>
  </div>
</section>