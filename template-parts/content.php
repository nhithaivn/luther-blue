<?php

/**
 * Template part for displaying articles
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
  <div class="post-card__inner">
    <?php if (has_post_thumbnail()) : ?>
      <div class="post-card__media">
        <a href="<?php the_permalink(); ?>" class="post-card__media-link">
          <?php the_post_thumbnail('post-thumbnail', array(
            'class' => 'post-card__image',
            'alt' => get_the_title()
          )); ?>
        </a>
        <?php if ('post' === get_post_type()) : ?>
          <div class="post-card__categories">
            <?php
            $categories = get_the_category();
            if ($categories) :
              foreach ($categories as $category) : ?>
                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="post-card__category">
                  <?php echo esc_html($category->name); ?>
                </a>
            <?php endforeach;
            endif; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="post-card__content">
      <header class="post-card__header">
        <?php if ('post' === get_post_type()) : ?>
          <div class="post-card__meta">
            <time class="post-card__date" datetime="<?php echo get_the_date('c'); ?>">
              <?php echo get_the_date(); ?>
            </time>
            <span class="post-card__author">
              <?php esc_html_e('par', 'wp-luther-blue'); ?>
              <?php the_author_posts_link(); ?>
            </span>
          </div>
        <?php endif; ?>

        <?php
        if (is_singular()) :
          the_title('<h1 class="post-card__title">', '</h1>');
        else :
          the_title('<h2 class="post-card__title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;
        ?>
      </header>

      <div class="post-card__excerpt">
        <?php
        if (is_singular()) :
          the_content();
        else :
          the_excerpt();
        endif;
        ?>
      </div>

      <?php if (!is_singular()) : ?>
        <div class="post-card__footer">
          <a href="<?php the_permalink(); ?>" class="post-card__read-more">
            <?php esc_html_e('Read more', 'wp-luther-blue'); ?>
            <svg class="icon" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"
              fill="#000000">
              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
              <g id="SVGRepo_iconCarrier">
                <title>arrow-right-square</title>
                <desc>Created with Sketch Beta.</desc>
                <defs> </defs>
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                  <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-464.000000, -983.000000)"
                    fill="#000000">
                    <path
                      d="M494,1011 C494,1012.1 493.104,1013 492,1013 L468,1013 C466.896,1013 466,1012.1 466,1011 L466,987 C466,985.896 466.896,985 468,985 L492,985 C493.104,985 494,985.896 494,987 L494,1011 L494,1011 Z M492,983 L468,983 C465.791,983 464,984.791 464,987 L464,1011 C464,1013.21 465.791,1015 468,1015 L492,1015 C494.209,1015 496,1013.21 496,1011 L496,987 C496,984.791 494.209,983 492,983 L492,983 Z M487.535,998.121 L481.879,992.465 C481.488,992.074 480.855,992.074 480.465,992.465 C480.074,992.854 480.074,993.488 480.465,993.879 L484.586,998 L474,998 C473.447,998 473,998.447 473,999 C473,999.552 473.447,1000 474,1000 L484.586,1000 L480.465,1004.12 C480.074,1004.51 480.074,1005.14 480.465,1005.54 C480.855,1005.93 481.488,1005.93 481.879,1005.54 L487.535,999.879 C487.775,999.639 487.85,999.311 487.795,999 C487.85,998.689 487.775,998.361 487.535,998.121 L487.535,998.121 Z"
                      id="arrow-right-square" sketch:type="MSShapeGroup"> </path>
                  </g>
                </g>
              </g>
            </svg>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</article>