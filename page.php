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

$hero_img = get_field('yksi_iso_kuva');
$left_img = get_field('vasen_kuva');
$right_img = get_field('oikea_kuva');

get_header(); ?>

	<div class="page-hero"<?php if($hero_img): ?> style="background-image: url(<?php echo $hero_img; ?>);"<?php endif; ?>>
		<?php if(!$hero_img): ?>
		<div class="left"<?php if($left_img): ?> style="background-image: url(<?php echo $left_img; ?>);"<?php endif; ?>></div>
		<div class="title" <?php if(get_field('bgcolor', $parent)): ?>style="background-color: <?php echo get_field('bgcolor', $parent); ?>;"<?php endif; ?>><span><?php if(get_field('page_title', $parent)) { the_field('page_title', $parent); } else { echo get_the_title($parent); } ?></span></div>
		<div class="right"<?php if($right_img): ?> style="background-image: url(<?php echo $right_img; ?>);"<?php endif; ?>></div>
		<?php endif; ?>
	</div>

	<?php mikkeli_breadcrumbs(); ?>

	<div id="content" class="site-content cf">
		<div class="container <?php if(get_field('custom_sidebar')): echo 'with-sidebar-column'; endif; ?>">
			<?php get_sidebar(); ?>
			<main class="site-main"> 

				<?php
				while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php endwhile; // End of the loop.
				?>

			</main>
			<?php if(get_field('custom_sidebar')): ?>
			<div class="sidebar-column">
				<?php the_field('custom_sidebar'); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>

<?php
get_footer();
