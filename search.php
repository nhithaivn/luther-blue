<?php
get_header();
?>

<main id="primary" class="site-main">
  <?php if (have_posts()) : ?>
    <header class="page-header">
      <h1 class="page-title">
        <?php
        printf(
          esc_html__('Résultats de recherche pour : %s', 'wp-luther-blue'),
          '<span>' . get_search_query() . '</span>'
        );
        ?>
      </h1>
    </header>

  <?php
    while (have_posts()) :
      the_post();
      get_template_part('template-parts/content', 'search');
    endwhile;

    the_posts_navigation();
  else :
    get_template_part('template-parts/content', 'none');
  endif;
  ?>
</main>

<?php
get_sidebar();
get_footer();
