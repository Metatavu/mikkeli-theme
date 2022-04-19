<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mikkeli
 */

?>

	<footer class="site-footer">
		<div class="container">
			<?php dynamic_sidebar( 'footer-widgets' ); ?>
		</div>
	</footer>

	<div class="horizontal-line"></div>


<?php wp_footer(); ?>

</body>
</html>
