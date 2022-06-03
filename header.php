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
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600;900&family=Titillium+Web:wght@400;700&display=swap" rel="stylesheet">

<!-- GOOGLE
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-97616829-1', 'auto');
	ga('send', 'pageview');
</script>

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
							<button class="current-locale" title="Vaihda kieli">fi</button>
							<a title="Vaihda kieli fi" href="/?locale=fi">fi</a>
							<a title="Vaihda kieli sv" href="/sisalto/pa-svenska?locale=sv">sv</a>
							<a title="Vaihda kieli en" href="/sisalto/in-english?locale=en">en</a>
						</div>
					</div>
				</div>
				<div class="logo">
					<button class="hamburger hamburger--slider" type="button">
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
			</div>

		</div><!-- .container -->
	</header>

	
