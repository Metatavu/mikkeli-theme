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

				<div class="posts-list">
					<?php while ( have_posts() ) : the_post(); ?>
					<div class="item">
						<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php if(has_post_thumbnail()) { the_post_thumbnail('thumb'); } else { ?><img src="<?php echo IMAGES; ?>/mikkeli-logo.png" alt="<?php the_title(); ?>" /><?php } ?></a>
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

			</div><!-- .container -->

			<?php endif; ?>

			</main>
		</div>
	</div>

<?php
get_footer();
