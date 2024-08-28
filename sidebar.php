<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mikkeli
 */

?>

<aside class="sidebar widget-area">
  <button class="btn-menu collapsed" title="Näytä valikko" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-menu"><span class="fa fa-bars"></span></button>
  <?php
  if ($post->post_parent) {
    $ancestors=get_post_ancestors($post->ID);
    $root=count($ancestors)-1;
    $parent = $ancestors[$root];
  } else {
    $parent = $post->ID;
  }

  $children = wp_list_pages(array(
    'title_li' => '',
    'child_of' => $parent,
    'echo' => false
  ));

  if ($children): ?>
  <p class="title"><?php echo get_the_title($parent); ?></p>
  <nav class="sub-navigation" aria-label="<?php echo get_the_title($parent); ?>-sivun alasivut">
    <ul class="side-menu">
      <?php echo $children; ?>
    </ul>
  </nav>
  <?php endif; ?>
  <?php if(is_single()): ?>
  <?php
  global $post;
  $myposts = get_posts( array(
      'posts_per_page' => 10,
      'post_type' => 'post'
  ) );
  
  if ( $myposts ) {
  $current_page = get_the_ID();
  echo '<nav>';
    echo '<ul>';
    foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
      <li class="page-nav-item<?php if($current_page == $post->ID): ?> active<?php endif; ?>"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
  <?php
      endforeach;
      echo '</ul>';
      echo '</nav>';
      wp_reset_postdata();
    }
  ?>

  <!-- Render link only when page language is Finnish -->
    <?php if (function_exists( 'pll_current_language' ) && pll_current_language() == "fi") { ?>
      <p><a title="<?php _e('Katso kaikki uutiset', 'mikkeli'); ?>" class="all-news-link" href="<?php echo get_permalink( get_option('page_for_posts') ); ?>"><?php _e('Katso kaikki uutiset', 'mikkeli'); ?></a></p>
		<?php } ?>

  <!-- Render link only when page language is English -->
    <?php if (function_exists( 'pll_current_language' ) && pll_current_language() == "en") { ?>
      <p><a title="<?php _e('All news', 'mikkeli'); ?>" class="all-news-link" href="<?php echo get_permalink( get_option('page_for_posts') ); ?>"><?php _e('All news', 'mikkeli'); ?></a></p>
		<?php } ?>
 
  <?php endif; ?>
  <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
