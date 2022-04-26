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
          <time datetime="<?php the_time('c'); ?>">
            <?php the_time('d.m.Y'); ?>
          </time>
        </span>
      </div><!-- .entry-meta -->
      <?php
      endif; ?>
    </header><!-- .entry-header -->

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
    $posttags = get_the_tags();
    if ($posttags) {
    echo '<div class="tags">';
      foreach($posttags as $tag) {
        echo '<a title="'.$tag->name.'" class="tag" href="'. esc_attr( get_tag_link( $tag->term_id ) ) .'">'. $tag->name .'</a>'; 
      }
    echo '</div>';
    }
    ?>

    <?php echo add_share_buttons(); ?>

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
