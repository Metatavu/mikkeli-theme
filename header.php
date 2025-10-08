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
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-WQBLF7BB');</script>
<!-- End Google Tag Manager -->
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

<script type="module" language="javascript">
  var baseUrl = "https://mikkeli.mainio.app";

  import(baseUrl + "/embeddable-chat/embed.js")
    .then(() => {
      try {
        if (window.mainioChat) {
          window.mainioChat.init({
            tenantId: "cm7kiqkzy0002oa01d2ufis62",
            agentId: "cm8fq8fmi0001ov0157xg3r85",
            baseUrl: baseUrl,
            floating: true,
            initiallyOpen: false,
            initialLanguage: "fi",
          });
          return;
        }
        console.error("No chat loader found");
      } catch (error) {
        console.error(error);
      }
    })
    .catch((error) => {
      console.error("Failed to load the chat module:", error);
    });
</script>

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
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="ns "height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

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
						<a href="https://www.facebook.com/mikkelinkaupunki" title="Facebook - Mikkelikaupunki" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="16" height="16">
								<path fill="white" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/>
							</svg>
						</a>
						<a href="https://www.instagram.com/mikkelinkaupunki/" title="Instagram - Mikkelikaupunki" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16">
								<path fill="white" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
							</svg>
						</a>
						<a href="https://www.linkedin.com/company/mikkelin-kaupunki" title="Linkedin - Mikkelikaupunki" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16">
								<path fill="white" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/>
							</svg>
						</a>
						<a href="https://www.youtube.com/mikkelikaupunki" title="Youtube - Mikkelikaupunki" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16">
								<path fill="white" d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/>
							</svg>
						</a>
				</div>
					<div class="nav-quick-icons">
						<a class="map-link" href="https://mikkeli.asiointi.fi/IMS" title="Mikkeli kartta" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16">
								<path fill="white" d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"/>
							</svg>
						</a>						
						<div class="locale-menu">
							<button class="current-locale" title="<?php _e('Vaihda kieli', 'mikkeli'); ?>"><?php if (function_exists('pll_current_language')) { echo pll_current_language( 'slug' ); } ?></button>
							<a title="<?php _e('Vaihda kieli', 'mikkeli'); ?> fi" href="<?php if (function_exists('pll_home_url')) { echo pll_home_url( 'fi' ); } ?>">fi</a>
							<a title="<?php _e('Vaihda kieli', 'mikkeli'); ?> sv" href="<?php if (function_exists('pll_home_url')) { echo pll_home_url( 'sv' ); } ?>">sv</a>
							<a title="<?php _e('Vaihda kieli', 'mikkeli'); ?> en" href="<?php if (function_exists('pll_home_url')) { echo pll_home_url( 'en' ); } ?>">en</a>
						</div>
					</div>
					<div id="readspeaker_button1" class="rs_skip rsbtn rs_preserve"><a rel="nofollow" class="rsbtn_play" accesskey="L" title="Kuuntele ReadSpeaker webReaderilla" href="//app-eu.readspeaker.com/cgi-bin/rsent?customerid=8419&amp;readclass=entry-content&amp;lang=fi_FI&amp;url="><span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span><?php if (function_exists('pll_e')) { pll_e('Kuuntele', 'mikkeli'); } ?></span></span></span><span class="rsbtn_right rsimg rsplay rspart"></span></a></div>
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
				<a href="https://www.facebook.com/mikkelinkaupunki" title="Facebook - Mikkelikaupunki" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="16" height="16">
						<path fill="white" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/>
					</svg>
				</a>
				<a href="https://www.instagram.com/mikkelinkaupunki/" title="Instagram - Mikkelikaupunki" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16">
						<path fill="white" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
					</svg>
				</a>
				<a href="https://www.linkedin.com/company/mikkelin-kaupunki" title="Linkedin - Mikkelikaupunki" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16">
						<path fill="white" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/>
					</svg>
				</a>
				<a href="https://www.youtube.com/mikkelikaupunki" title="Youtube - Mikkelikaupunki" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16">
						<path fill="white" d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/>
					</svg>
				</a>
				</div>
				<div class="nav-quick-icons">
					<a class="map-link" href="https://mikkeli.asiointi.fi/IMS" title="Mikkeli kartta" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16">
							<path fill="white" d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"/>
						</svg>
					</a>							
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
