<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package haaja
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
					<span class="entry-time">
            <time datetime="<?php the_time('c'); ?>">
              <?php the_time('d.m.Y'); ?>
            </time>
          </span>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

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
