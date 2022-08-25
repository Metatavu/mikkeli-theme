<?php

/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_unique_id/
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package Mikkeli
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label
 * if one was passed to get_search_form() in the args array.
 */
$mikkeli_unique_id = wp_unique_id( 'search-form-' );

$mikkeli_aria_label = ! empty( $args['aria_label'] ) ? 'aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';
?>
<form role="search" <?php echo $mikkeli_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?> method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $mikkeli_unique_id ); ?>"><?php _e( 'Etsi sivustolta', 'mikkeli' ); // phpcs:ignore: WordPress.Security.EscapeOutput.UnsafePrintingFunction -- core trusts translations ?></label>
	<input type="search" id="<?php echo esc_attr( $mikkeli_unique_id ); ?>" class="search-field" value="<?php echo get_search_query(); ?>" name="s" />
	<button class="fa fa-search" aria-hidden="true" value="<?php echo esc_attr_x( 'Hae', 'submit button', 'mikkeli' ); ?>"><?php echo esc_attr_x( 'Hae', 'submit button', 'mikkeli' ); ?></button>
</form>
