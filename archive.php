<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package haaja
 */

get_header(); ?>

	<div class="content-area">
		<main class="site-main">

			<?php
			if ( have_posts() ) : ?>

			<div class="container">
				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->
			</div>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

				<?php endwhile;

				kriesi_pagination();

				else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

			</div><!-- .container -->

			<?php endif; ?>

		</main>
	</div>

<?php
get_sidebar();
get_footer();
