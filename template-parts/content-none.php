<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package haaja
 */

?>

  <section class="no-results not-found">
  <header class="page-header">
    <h1 class="page-title"><?php esc_html_e( 'Mitään ei löytynyt', 'haaja' ); ?></h1>
  </header><!-- .page-header -->

  <div class="page-content">
    <?php
    if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

      <p><?php printf( wp_kses( __( 'Valmiina julkaisemaan ensimmäinen artikkeli? <a href="%1$s">Aloita täältä</a>.', 'haaja' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

    <?php elseif ( is_search() ) : ?>

      <p><?php esc_html_e( 'Valitettavasti hakusanallasi ei löytynyt tuloksia, kokeile toista hakusanaa.', 'haaja' ); ?></p>
      <?php
        get_search_form();

    else : ?>

      <p><?php esc_html_e( 'Näyttää siltä, ettei sivuiltamme löydy hakemaasi sivua, kokeile hakua uudelleen.', 'haaja' ); ?></p>
      <?php
        get_search_form();

    endif; ?>
  </div><!-- .page-content -->
  </section><!-- .no-results -->
