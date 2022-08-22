<?php

/**
 * News by tag Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'text-articles-' . $block['id'];
if( !empty($block['anchor']) ) {
  $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'text-articles';
if( !empty($block['className']) ) {
  $className .= ' ' . $block['className'];
}

$title = get_field('news_title');
$post_tag = get_field('tag');

?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
  <?php if($title): ?><h3><?php echo $title; ?></h3><?php endif; ?>
  <?php if( $post_tag ):
    $args = array(
      'post_type' => 'post',
      'numberposts' => 5,
      'category' => $post_tag
    );
    $postslist = get_posts( $args ); ?>
    <?php foreach( $postslist as $post ): ?>
    <div class="text-article">
      <div class="date">
        <time datetime="<?php echo get_the_time('c', $post->ID); ?>">
          <?php echo get_the_time('j.n.Y', $post->ID); ?>
        </time>
      </div>
      <div class="title"><a title="<?php echo get_the_title($post->ID); ?>" href="<?php echo get_the_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></div>
    </div>
  <?php 
    endforeach; 
    wp_reset_postdata();          
    endif; 
  ?>
</div>