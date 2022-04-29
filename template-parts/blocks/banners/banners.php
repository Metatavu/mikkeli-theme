<?php

/**
 * Banners Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'banners-' . $block['id'];
if( !empty($block['anchor']) ) {
  $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'banners';
if( !empty($block['className']) ) {
  $className .= ' ' . $block['className'];
}

?>

<?php if ( have_rows( 'banners_list' ) ) : ?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
  <?php while ( have_rows( 'banners_list' ) ) : the_row(); 
    $bgcolor = get_sub_field('background');
    $link = get_sub_field('link');
    if($link):
      $link_url = $link['url'];
      $link_title = $link['title'];
    endif;
    ?>
    <?php if($link): ?><a title="<?php echo esc_html( $link_title ); ?>" href="<?php echo esc_url( $link_url ); ?>"><?php endif; ?>
      <div class="banner <?php echo $bgcolor; ?>">
        <div class="small-page-banner-title">
          <span><?php echo esc_html( $link_title ); ?></span>
          <span class="fa fa-angle-right"></span>
        </div>
      </div>
    <?php if($link): ?></a><?php endif; ?>
  <?php endwhile; ?>
</div>
<?php endif; ?>