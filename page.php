<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package haaja
 */
if ($post->post_parent) {
	$ancestors=get_post_ancestors($post->ID);
	$root=count($ancestors)-1;
	$parent = $ancestors[$root];
} else {
	$parent = $post->ID;
}

get_header(); ?>

	<div class="page-hero">
		<div class="left"></div>
		<div class="title" <?php if(get_field('bgcolor', $parent)): ?>style="background-color: <?php echo get_field('bgcolor', $parent); ?>;"<?php endif; ?>><span><?php if(get_field('page_title', $parent)) { the_field('page_title', $parent); } else { echo get_the_title($parent); } ?></span></div>
		<div class="right"></div>
	</div>

	<?php mikkeli_breadcrumbs(); ?>

	<div id="content" class="site-content cf">
		<div class="container">
			<?php get_sidebar(); ?>
			<main class="site-main <?php if(wpdocs_enhanced_has_block('core/columns')): echo 'with-sidebar-column'; endif; ?>"> 

				<?php
				while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php endwhile; // End of the loop.
				?>

			</main>
		</div>
	</div>

<?php
get_footer();
