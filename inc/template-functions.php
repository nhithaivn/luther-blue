<?php

/**
 * Fonctions qui améliorent le thème par des hooks WordPress
 */

/**
 * Ajoute des classes personnalisées au tableau des classes body
 */
function wp_starter_basic_body_classes($classes)
{
  // Ajoute une classe si JS est activé
  if (!is_admin()) {
    $classes[] = 'no-js';
  }

  // Ajoute une classe si c'est une page unique sans sidebar
  if (!is_active_sidebar('sidebar-1')) {
    $classes[] = 'no-sidebar';
  }

  // Ajoute une classe pour le type de contenu
  if (is_single()) {
    $classes[] = 'single-post';
  } elseif (is_page()) {
    $classes[] = 'single-page';
  } elseif (is_archive()) {
    $classes[] = 'archive-page';
  } elseif (is_search()) {
    $classes[] = 'search-page';
  }

  return $classes;
}
add_filter('body_class', 'wp_starter_basic_body_classes');

/**
 * Ajoute un script pour remplacer no-js par js dans la classe body
 */
function wp_starter_basic_javascript_detection()
{
  echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action('wp_head', 'wp_starter_basic_javascript_detection', 0);

/**
 * Ajoute des attributs rel appropriés aux liens
 */
function wp_starter_basic_pingback_header()
{
  if (is_singular() && pings_open()) {
    printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
  }
}
add_action('wp_head', 'wp_starter_basic_pingback_header');