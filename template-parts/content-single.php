<?php
/**
 * Template part for displaying single post.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package haaja
 */

?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
      <?php
        if ( is_single() ) {
          the_title( '<h1 class="entry-title">', '</h1>' );
        } else {
          the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        }

      if ( 'post' === get_post_type() ) : ?>
      <div class="entry-meta">
        <span class="entry-time">
          <p>
            <time datetime="<?php the_time('c'); ?>">
              <?php the_time('d.m.Y'); ?>
            </time>
          </p>
        </span>
      </div><!-- .entry-meta -->
      <?php
      endif; ?>
    </header><!-- .entry-header -->

    <?php if(has_post_thumbnail()): ?>
    <div class="page-image">
      <?php the_post_thumbnail('page-img'); ?>
    </div>
    <?php endif; ?>

    <div class="entry-content">
      <?php
        the_content( sprintf(
          /* translators: %s: Name of current post. */
          wp_kses( __( 'Jatka lukemista %s <span class="meta-nav">&rarr;</span>', 'haaja' ), array( 'span' => array( 'class' => array() ) ) ),
          the_title( '<span class="screen-reader-text">"', '"</span>', false )
        ) );

        wp_link_pages( array(
          'before' => '<div class="page-links">' . esc_html__( 'Sivut:', 'haaja' ),
          'after'  => '</div>',
        ) );
      ?>
    </div><!-- .entry-content -->

    <?php
    $categories = get_the_category($post->ID);
    if($categories):
      echo '<div class="tags">';
      foreach($categories as $category) {
        echo '<a title=' . $category->name .' class="tag" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
      }
      echo '</div>';
    endif;

    ?>

    <?php echo add_share_buttons(); ?>

    <?php
      if ( is_single()) {
    ?>
        <div id="disqus_thread"></div>
        <script>
            var disqus_config = function () {
                this.page.url = "https://mikkeli.fi";
                this.page.identifier = "<?php global $post; echo $post->ID;?>";
            };
            (function() {  // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');
                
                s.src = '//mikkeli.disqus.com/embed.js';
                
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <?php      
      }
    ?>

    <footer class="entry-footer">
      <?php
          edit_post_link(
            sprintf(
              /* translators: %s: Name of current post */
              esc_html__( 'Muokkaa %s', 'haaja' ),
              the_title( '<span class="screen-reader-text">"', '"</span>', false )
            ),
            '<span class="edit-link">',
            '</span>'
          );
        ?>
    </footer><!-- .entry-footer -->
  </article><!-- #post-## -->
