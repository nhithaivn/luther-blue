<?php
if (post_password_required()) {
  return;
}
?>

<div id="comments" class="comments-area">
  <?php if (have_comments()) : ?>
    <h2 class="comments-title">
      <?php
      $wp_starter_basic_comment_count = get_comments_number();
      if ('1' === $wp_starter_basic_comment_count) {
        printf(
          esc_html__('Un commentaire sur &ldquo;%1$s&rdquo;', 'wp-luther-blue'),
          '<span>' . wp_kses_post(get_the_title()) . '</span>'
        );
      } else {
        printf(
          esc_html(_n('%1$s commentaire sur &ldquo;%2$s&rdquo;', '%1$s commentaires sur &ldquo;%2$s&rdquo;', $wp_starter_basic_comment_count, 'wp-luther-blue')),
          number_format_i18n($wp_starter_basic_comment_count),
          '<span>' . wp_kses_post(get_the_title()) . '</span>'
        );
      }
      ?>
    </h2>

    <?php the_comments_navigation(); ?>

    <ol class="comment-list">
      <?php
      wp_list_comments(
        array(
          'style'      => 'ol',
          'short_ping' => true,
        )
      );
      ?>
    </ol>

    <?php
    the_comments_navigation();

    if (!comments_open()) :
    ?>
      <p class="no-comments"><?php esc_html_e('Les commentaires sont fermés.', 'wp-luther-blue'); ?></p>
  <?php
    endif;
  endif;

  comment_form();
  ?>
</div>