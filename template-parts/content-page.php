<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package haaja
 */

?>
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
      <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->

    <?php if(has_post_thumbnail()): ?>
      <?php the_post_thumbnail('page-img'); ?>
    <?php endif; ?>

    <div class="entry-content">
      <?php
        the_content();

        wp_link_pages( array(
          'before' => '<div class="page-links">' . esc_html__( 'Sivut:', 'haaja' ),
          'after'  => '</div>',
        ) );
      ?>
    </div><!-- .entry-content -->

    <?php if ( get_edit_post_link() ) : ?>
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
  	<?php endif; ?>
  </article><!-- #post-## -->