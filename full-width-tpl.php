<?php
/**
 Template Name: Full Width
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package mikkeli
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

	<div id="content" class="site-content full-width cf">
		<div class="container">
			<main class="site-main"> 

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
