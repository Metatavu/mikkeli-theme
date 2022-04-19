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
  <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
