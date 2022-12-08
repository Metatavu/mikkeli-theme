<?php
/**
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mikkeli
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="stylesheet" href="https://use.typekit.net/jyx1iep.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600;900&family=Titillium+Web:wght@400;600;700&display=swap" rel="stylesheet">

<?php
	$ga_code = get_option('mikkeli_google_analytics');
  if($ga_code): ?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga_code; ?>"></script>
<script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '<?php echo $ga_code; ?>'); </script>
<?php endif; ?>
<!--
<script type="text/javascript">window.__lc = window.__lc || {};
window.__lc.license = 9105520;
(function() {
var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
})();</script>-->

<script src="https://cdn-eu.readspeaker.com/script/8419/webReader/webReader.js?pids=wr" type="text/javascript" id="rs_req_Init"></script>

<?php wp_head(); ?>
</head>
<?php
$sivu = '';
if(!is_front_page()) {
	$sivu = 'alasivu';
}
$mikkeli_unique_id = wp_unique_id( 'search-form-' );
$mikkeli_aria_label = ! empty( $args['aria_label'] ) ? 'aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';
?>
<body <?php body_class($sivu); ?>>

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Siirry sisältöön', 'mikkeli' ); ?></a>

	<div class="horizontal-line"></div>

	<header class="site-header cf">

		<div class="container cf">

			<div class="site-branding">
				<div class="right-side">
					<div class="site-search">
						<?php get_search_form(); ?>
					</div>
					<div class="nav-some-icons">
						<a href="https://www.facebook.com/mikkelinkaupunki" title="Facebook - Mikkelikaupunki" target="_blank"><span class="fa fa-facebook-square" aria-hidden="true"></span></a>
						<a href="https://twitter.com/MikkelinK" title="Twitter - Mikkelikaupunki" target="_blank"><span class="fa fa-twitter" aria-hidden="true"></span></a>
						<a href="https://www.instagram.com/mikkelinkaupunki/" title="Instagram - Mikkelikaupunki" target="_blank"><span class="fa fa-instagram" aria-hidden="true"></span></a>
						<a href="https://www.linkedin.com/company/mikkelin-kaupunki" title="Linkedin - Mikkelikaupunki" target="_blank"><span class="fa fa-linkedin" aria-hidden="true"></span></a>
					</div>
					<div class="nav-quick-icons">
						<a class="map-link" href="https://kartta.mikkeli.fi/kartta/" title="Mikkeli kartta" target="_blank"><span class="fa fa-map-marker" aria-hidden="true"></span></a>
						<div class="locale-menu">
							<button class="current-locale" title="<?php _e('Vaihda kieli', 'mikkeli'); ?>"><?php if (function_exists('pll_current_language')) { echo pll_current_language( 'slug' ); } ?></button>
							<a title="<?php _e('Vaihda kieli', 'mikkeli'); ?> fi" href="<?php if (function_exists('pll_home_url')) { echo pll_home_url( 'fi' ); } ?>">fi</a>
							<a title="<?php _e('Vaihda kieli', 'mikkeli'); ?> sv" href="<?php if (function_exists('pll_home_url')) { echo pll_home_url( 'sv' ); } ?>">sv</a>
							<a title="<?php _e('Vaihda kieli', 'mikkeli'); ?> en" href="<?php if (function_exists('pll_home_url')) { echo pll_home_url( 'en' ); } ?>">en</a>
						</div>
					</div>
					<div id="readspeaker_button1" class="rs_skip rsbtn rs_preserve"><a rel="nofollow" class="rsbtn_play" accesskey="L" title="Kuuntele ReadSpeaker webReaderilla" href="//app-eu.readspeaker.com/cgi-bin/rsent?customerid=8419&amp;readclass=entry-content&amp;lang=fi_FI&amp;url="><span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span><?php pll_e('Kuuntele', 'mikkeli'); ?></span></span></span><span class="rsbtn_right rsimg rsplay rspart"></span></a></div>
				</div>
				<div class="logo">
					<button class="hamburger hamburger--slider" type="button" aria-label="Avaa valikko">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</div>
			</div><!-- .site-branding -->

			<nav class="primary cf" role="navigation">
				<?php
					wp_nav_menu( array(
						'theme_location'    => 'primary',
						'container'       	=> false,
						'depth'             => 1,
						'menu_class'        => 'menu-items',
						'menu_id' 					=> '',
						'echo'            	=> true
						)
					);
				?>
			</nav><!-- #site-navigation -->

			<div class="responsive-nav">
				<?php
					wp_nav_menu( array(
						'theme_location'    => 'primary',
						'container'       	=> false,
						'depth'             => 4,
						'menu_class'        => 'menu-items',
						'menu_id' 					=> '',
						'echo'            	=> true
						)
					);
				?>
				<div class="nav-some-icons">
					<a href="https://www.facebook.com/mikkelinkaupunki" title="Facebook - Mikkelikaupunki" target="_blank"><span class="fa fa-facebook-square" aria-hidden="true"></span></a>
					<a href="https://twitter.com/MikkelinK" title="Twitter - Mikkelikaupunki" target="_blank"><span class="fa fa-twitter" aria-hidden="true"></span></a>
					<a href="https://www.instagram.com/mikkelinkaupunki/" title="Instagram - Mikkelikaupunki" target="_blank"><span class="fa fa-instagram" aria-hidden="true"></span></a>
					<a href="https://www.linkedin.com/company/mikkelin-kaupunki" title="Linkedin - Mikkelikaupunki" target="_blank"><span class="fa fa-linkedin" aria-hidden="true"></span></a>
				</div>
				<div class="nav-quick-icons">
					<a class="map-link" href="https://kartta.mikkeli.fi/kartta/" title="Mikkeli kartta" target="_blank"><span class="fa fa-map-marker" aria-hidden="true"></span></a>
					<div class="locale-menu">
						<button class="current-locale" title="<?php _e('Vaihda kieli', 'mikkeli'); ?>"><?php if (function_exists('pll_current_language')) { echo pll_current_language( 'slug' ); } ?></button>
						<a title="<?php _e('Vaihda kieli', 'mikkeli'); ?> fi" href="<?php if (function_exists('pll_home_url')) { echo pll_home_url( 'fi' ); } ?>">fi</a>
						<a title="<?php _e('Vaihda kieli', 'mikkeli'); ?> sv" href="<?php if (function_exists('pll_home_url')) { echo pll_home_url( 'sv' ); } ?>">sv</a>
						<a title="<?php _e('Vaihda kieli', 'mikkeli'); ?> en" href="<?php if (function_exists('pll_home_url')) { echo pll_home_url( 'en' ); } ?>">en</a>
					</div>
				</div>
			</div>

		</div><!-- .container -->
	</header>
