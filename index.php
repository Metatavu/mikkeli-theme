<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package mikkeli
 */

get_header(); ?>

	<div class="page-hero">

	</div>

	<?php mikkeli_breadcrumbs(); ?>

	<div id="content" class="site-content full-width cf">
		<div class="container">
			<main class="site-main">

			<h1><?php _e('Uutiset', 'mikkeli'); ?></h1>

			<?php
			if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>

				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php endif; ?>
			<div class="posts-list">
				<?php while ( have_posts() ) : the_post(); ?>
				<div class="item">
					<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb') ?></a>
					<div>
						<p><?php the_time('j.n.Y'); ?> - <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
						<p><?php the_excerpt(); ?></p>
					</div>
				</div>
				<?php endwhile; ?>
			</div>

			<?php kriesi_pagination();

			else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

			</main>
		</div>
	</div>

<?php
get_footer();
