<?php

/**
 * Accordion Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'accordion-' . $block['id'];
if( !empty($block['anchor']) ) {
  $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'accessibility-sentences';
if( !empty($block['className']) ) {
  $className .= ' ' . $block['className'];
}

$p_info = get_field('p_info');

?>

<?php if ( have_rows( 'klikattava_sisalto' ) ) : ?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
  <?php if($p_info): ?><p><?php echo $p_info; ?></p><?php endif; ?>
  <?php while ( have_rows( 'klikattava_sisalto' ) ) : the_row(); ?>
    <div class="accessibility-sentence">
      <button type="button" class="button-text closed"><?php the_sub_field('nappiteksti'); ?></button>
      <div class="content"><?php the_sub_field('sisaltoteksti'); ?></div>
    </div>
  <?php endwhile; ?>
</div>
<?php endif; ?>