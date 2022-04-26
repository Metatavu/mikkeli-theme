<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package haaja
 */

get_header(); ?>

	<div class="page-hero">

	</div>

	<?php mikkeli_breadcrumbs(); ?>

	<div id="content" class="site-content full-width cf">
		<div class="container">
			<main class="site-main">

			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>

				<?php endwhile;

				kriesi_pagination();

				else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

			</div><!-- .container -->

			<?php endif; ?>

			</main>
		</div>
	</div>

<?php
get_footer();
