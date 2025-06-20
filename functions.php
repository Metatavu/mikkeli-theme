<?php
/**
 * Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mikkeli
 *
 * The current version of the theme.
 */
define( 'MIKKELI_VERSION', '2.2.31' );
define('THEMEROOT', get_stylesheet_directory_uri());
define('IMAGES', THEMEROOT . '/images');

use Metatavu\Mikkeli\Theme\Elastic\ResultLoader;

/**
 * Enable theme support for essential features
 */
load_theme_textdomain( 'mikkeli', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
add_post_type_support( 'page', 'excerpt' );
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
require_once( __DIR__ . '/elastic-pages-loader.php');

/**
 * Register sidebars
 */
register_sidebar( array(
  'name' => __( 'Sivupalkki', 'mikkeli' ),
  'id' => 'sidebar-1',
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => "</aside>",
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>',
  )
);
register_sidebar( array(
  'name' => __( 'Alaosa', 'mikkeli' ),
  'id' => 'footer-widgets',
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => "</aside>",
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>',
  )
);

/**
 * Disable emojicons introduced with WP 4.2
 * @link http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
 */
function disable_wp_emojicons() {
  // All actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  // Remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );
// Disable TinyMCE emojicons
function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

/**
 * Image sizes
 */
add_image_size( 'thumb', 304, 231, true );
add_image_size( 'post', 694, 416, true );
add_image_size( 'page-img', 670, 447, true );

/**
 * Navigation menus.
 */
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'mikkeli' )
) );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function mikkeli_pingback_header() {
	if ( is_singular() && pings_open() ) :
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	endif;
}
add_action( 'wp_head', 'mikkeli_pingback_header' );

/**
 * Enqueue scripts and styles.
 */
function mikkeli_scripts() {
  wp_enqueue_style( 'styles', THEMEROOT . '/css/layout.css', array(), MIKKELI_VERSION );
	wp_enqueue_style( 'incidents', 'https://cdn.metatavu.io/libs/kunta-api-incidents/0.0.4/incidents.min.css' );
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', array(), false, true); // Load jQuery @ Footer
  wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'incidents-script', 'https://cdn.metatavu.io/libs/kunta-api-incidents/0.0.4/incidents.min.js');
	wp_enqueue_script( 'slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array(), false, true );
	wp_enqueue_script( 'scripts', THEMEROOT . '/js/all.js', array(), MIKKELI_VERSION, true );
	//wp_enqueue_script( 'jquery-ui-autocomplete' );
	//wp_register_style( 'jquery-ui-styles','https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' );
	//wp_enqueue_style( 'jquery-ui-styles' );
	//wp_register_script( 'mikkeli-autocomplete', get_template_directory_uri() . '/js/mikkeli-autocomplete.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', false );
	//wp_localize_script( 'mikkeli-autocomplete', 'MyAutocomplete', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	//wp_enqueue_script( 'mikkeli-autocomplete' );
	global $wp_query;
	wp_localize_script( 'scripts', 'ajaxpagination', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'query_vars' => json_encode( $wp_query->query )
	));
}
add_action( 'wp_enqueue_scripts', 'mikkeli_scripts' );

function prefix_add_footer_styles() {
	wp_enqueue_style( 'slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );
};
add_action( 'get_footer', 'prefix_add_footer_styles' );

/**
 * Pagination
 */
function kriesi_pagination($pages = '', $range = 2)
{  
 $showitems = ($range * 2)+1;  

 global $paged;
 if(empty($paged)) $paged = 1;

 if($pages == '')
 {
     global $wp_query;
     $pages = $wp_query->max_num_pages;
     if(!$pages)
     {
         $pages = 1;
     }
 }   

 if(1 != $pages)
 {
     echo "<div class='pagination'>";
     if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
     if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

     for ($i=1; $i <= $pages; $i++)
     {
         if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
         {
             echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
         }
     }

     if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
     if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
     echo "</div>\n";
 }
}

/* MURUPOLKU */
function mikkeli_breadcrumbs() {

	/* === OPTIONS === */
	$text['home']     = pll__('Etusivu', 'mikkeli'); // text for the 'Home' link
	$text['category'] = __('Arkisto "%s"', 'mikkeli'); // text for a category page
	$text['search']   = __('Hakutulokset hakusanalle "%s"', 'mikkeli'); // text for a search results page
	$text['tag']      = __('Kirjoitukset avainsanalla "%s"', 'mikkeli'); // text for a tag page
	$text['author']   = __('Kirjoittajan %s julkaisut', 'mikkeli'); // text for an author page
	$text['404']      = __('Virhe 404', 'mikkeli'); // text for the 404 page
	$text['page']     = __('Sivu %s', 'mikkeli'); // text 'Page N'
	$text['cpage']    = __('Kommenttisivu %s', 'mikkeli'); // text 'Comment Page N'

	$wrap_before    = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList"><div class="navigation">'; // the opening wrapper tag
	$wrap_after     = '</div></div><!-- .breadcrumbs -->'; // the closing wrapper tag
	$sep            = '<span class="sep">&raquo;</span>'; // separator between crumbs
	$before         = '<span class="breadcrumbs__current">'; // tag before the current crumb
	$after          = '</span>'; // tag after the current crumb

	$show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
	$show_current   = 1; // 1 - show current page title, 0 - don't show
	$show_last_sep  = 1; // 1 - show last separator, when current page title is not displayed, 0 - don't show
	/* === END OF OPTIONS === */

	global $post;
	$home_url       = home_url('/');
	$link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	$link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
	$link          .= '<meta itemprop="position" content="%3$s" />';
	$link          .= '</span>';
	$parent_id      = ( $post ) ? $post->post_parent : '';
	$home_link      = sprintf( $link, $home_url, $text['home'], 1 );

	if ( is_home() || is_front_page() ) {

		if ( $show_on_home ) echo $wrap_before . $home_link . '<span class="sep">&raquo;</span>' . __('Ajankohtaista', 'mikkeli') . $wrap_after;

	} else {

		$position = 0;

		echo $wrap_before;

		if ( $show_home_link && !is_single() ) {
			$position += 1;
			echo $home_link;
		}

		if ( is_category() ) {
			$parents = get_ancestors( get_query_var('cat'), 'category' );
			foreach ( array_reverse( $parents ) as $cat ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$cat = get_query_var('cat');
				echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) echo $sep;
					echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
				} elseif ( $show_last_sep ) echo $sep;
			}

		} elseif ( is_search() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $show_home_link ) echo $sep;
				echo sprintf( $link, $home_url . '?s=' . get_search_query(), sprintf( $text['search'], get_search_query() ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) echo $sep;
					echo $before . sprintf( $text['search'], get_search_query() ) . $after;
				} elseif ( $show_last_sep ) echo $sep;
			}

		} elseif ( is_year() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . get_the_time('Y') . $after;
			elseif ( $show_home_link && $show_last_sep ) echo $sep;

		} elseif ( is_month() ) {
			if ( $show_home_link ) echo $sep;
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position );
			if ( $show_current ) echo $sep . $before . get_the_time('F') . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_day() ) {
			if ( $show_home_link ) echo $sep;
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position ) . $sep;
			$position += 1;
			echo sprintf( $link, get_month_link( get_the_time('Y'), get_the_time('m') ), get_the_time('F'), $position );
			if ( $show_current ) echo $sep . $before . get_the_time('d') . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_single() && ! is_attachment() ) {
			echo get_the_title();
		} elseif ( is_post_type_archive() ) {
			$post_type = get_post_type_object( get_post_type() );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . $post_type->label . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_attachment() ) {
			$parent = get_post( $parent_id );
			$cat = get_the_category( $parent->ID ); $catID = $cat[0]->cat_ID;
			$parents = get_ancestors( $catID, 'category' );
			$parents = array_reverse( $parents );
			$parents[] = $catID;
			foreach ( $parents as $cat ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			$position += 1;
			echo $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
			if ( $show_current ) echo $sep . $before . get_the_title() . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_page() && ! $parent_id ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . get_the_title() . $after;
			elseif ( $show_home_link && $show_last_sep ) echo $sep;

		} elseif ( is_page() && $parent_id ) {
			$parents = get_post_ancestors( get_the_ID() );
			foreach ( array_reverse( $parents ) as $pageID ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
			}
			if ( $show_current ) echo $sep . $before . get_the_title() . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_tag() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$tagID = get_query_var( 'tag_id' );
				echo $sep . sprintf( $link, get_tag_link( $tagID ), single_tag_title( '', false ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_author() ) {
			$author = get_userdata( get_query_var( 'author' ) );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				echo $sep . sprintf( $link, get_author_posts_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . sprintf( $text['author'], $author->display_name ) . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_404() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . $text['404'] . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( has_post_format() && ! is_singular() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			echo get_post_format_string( get_post_format() );
		}

		echo $wrap_after;

	}
}

// Share
function add_share_buttons() {

  global $post;

  // Get the post's URL that will be shared
  $post_url   = urlencode( esc_url( get_permalink($post->ID) ) );
  
  // Get the post's title
  $post_title = urlencode( $post->post_title );

  // Compose the share links for Facebook, Twitter and LinkedIn
  $facebook_link    = sprintf( 'https://www.facebook.com/sharer/sharer.php?u=%1$s', $post_url );
  $twitter_link     = sprintf( 'https://twitter.com/intent/tweet?text=%2$s&url=%1$s', $post_url, $post_title );
  $whatssapp_link   = sprintf( 'whatsapp://send?text=%2$s %1$s', $post_url, $post_title );
  $linkedin_link       = sprintf( 'https://www.linkedin.com/shareArticle?mini=true&url=%1$s&summary=%2$s&source=mikkeli.fi', $post_url, $post_title );

  // Wrap the buttons
  $output = '<div class="share-buttons">';
			$output .= '<p>'.__('Jaa', 'mikkeli').':</p>';
      // Add the links inside the wrapper
      $output .= '<a title="Jaa Facebookissa" target="_blank" href="' . $facebook_link . '" class="share-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="16" height="16"><path fill="white" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg></a>';
      $output .= '<a title="Jaa Twitterissä" target="_blank" href="' . $twitter_link . '" class="share-button twitter"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16"><path fill="white" d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg></a>';
      $output .= '<a title="Jaa WhatsAppissa" target="_blank" href="' . $whatssapp_link . '" class="share-button whatsapp"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" ><path fill="white" d="M19.05 4.91A9.82 9.82 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01m-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.26 8.26 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24c2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.22 8.23m4.52-6.16c-.25-.12-1.47-.72-1.69-.81c-.23-.08-.39-.12-.56.12c-.17.25-.64.81-.78.97c-.14.17-.29.19-.54.06c-.25-.12-1.05-.39-1.99-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.14-.25-.02-.38.11-.51c.11-.11.25-.29.37-.43s.17-.25.25-.41c.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31c-.22.25-.86.85-.86 2.07s.89 2.4 1.01 2.56c.12.17 1.75 2.67 4.23 3.74c.59.26 1.05.41 1.41.52c.59.19 1.13.16 1.56.1c.48-.07 1.47-.6 1.67-1.18c.21-.58.21-1.07.14-1.18s-.22-.16-.47-.28"/></svg></a>';
      $output .= '<a title="Jaa LinkedInissä" href="' . $linkedin_link . '" class="share-button linkedin"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16"><path fill="white" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg></a>';
      
  $output .= '</div>';

  // Return the buttons and the original content
  return $output;

}

// Incidents Plugin
add_filter('script_loader_tag', function ($tag, $handle, $src) {
  if ('incidents-script' === $handle) {
    $tag = '<script type="text/javascript" src="https://cdn.metatavu.io/libs/kunta-api-incidents/0.0.4/incidents.min.js" id="incidents-script" data-urls="/wp-json/incidents/incidents?area=Mikkelin%20kaupunki,https://espl.fi/incidents?area=Mikkelin%20kaupunki" data-interval="1000"></script>';
  }
  return $tag;
}, 10, 3);

// ACF Custom Blocks
add_action('acf/init', 'mikkeli_acf_init_block_types');
function mikkeli_acf_init_block_types() {
	// Check function exists.
	if( function_exists('acf_register_block_type') ) {
		// register a banner block.
		acf_register_block_type(array(
				'name'              => 'banner',
				'title'             => __('Banneri'),
				'description'       => __('Tekstibanneri taustakuvalla'),
				'render_template'   => 'template-parts/blocks/banners/banners.php',
				'category'          => 'formatting',
				'icon'              => 'columns',
				'mode'							=> 'auto',
				'keywords'          => array( 'banner', 'banneri' ),
		));
		// register news by tag block.
		acf_register_block_type(array(
			'name'              => 'newsblock',
			'title'             => __('Uutiset tagin mukaan'),
			'description'       => __('Uusimmat uutiset tagin perusteella'),
			'render_template'   => 'template-parts/blocks/news/news.php',
			'category'          => 'common',
			'icon'              => 'admin-post',
			'mode'							=> 'auto',
			'keywords'          => array( 'uutiset', 'news' ),
		));
		// register accordion block.
		acf_register_block_type(array(
			'name'              => 'accordion',
			'title'             => __('Näytä/piilota sisältö'),
			'description'       => __('Klikkauksella näkyviin aukeava sisältö'),
			'render_template'   => 'template-parts/blocks/accordion/accordion.php',
			'category'          => 'common',
			'icon'              => 'menu',
			'mode'							=> 'edit',
			'keywords'          => array( 'accordion', 'nayta', 'piilota' ),
		));
	}
}

/* Register Sidebar Page pattern */
register_block_pattern(
	'mikkeli/sivupalkki',
	array(
			'title'       => __( 'Sivupalkki', 'mikkeli' ),
			'description' => _x( 'Sivun lisäksi harmaa sivupalkki', 'Sivupalkillinen sivusisältö.', 'mikkeli' ),
			'content'     => "<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:paragraph -->\n<p>Tekstisisältö</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"className\":\"sidebar-column\"} -->\n<div class=\"wp-block-column sidebar-column\"><!-- wp:paragraph -->\n<p>Sivupalkin sisältö</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->",
	)
);

/**
 * Has block function which searches as well in reusable blocks.
 *
 * @param mixed $block_name Full Block type to look for.
 * @return bool
 */
function wpdocs_enhanced_has_block( $block_name ) {
	if ( has_block( $block_name ) ) {
		return true;
	}

	if ( has_block( 'core/block' ) ) {
		$content = get_post_field( 'post_content' );
		$blocks = parse_blocks( $content );
		return wpdocs_search_reusable_blocks_within_innerblocks( $blocks, $block_name );
	}

	return false;
}

/**
* Search for the selected block within inner blocks.
*
* The helper function for wpdocs_enhanced_has_block() function.
*
* @param array $blocks Blocks to loop through.
* @param string $block_name Full Block type to look for.
* @return bool
*/
function wpdocs_search_reusable_blocks_within_innerblocks( $blocks, $block_name ) {
	foreach ( $blocks as $block ) {
		if ( isset( $block['innerBlocks'] ) && ! empty( $block['innerBlocks'] ) ) {
			wpdocs_search_reusable_blocks_within_innerblocks( $block['innerBlocks'], $block_name );
		} elseif ( 'core/block' === $block['blockName'] && ! empty( $block['attrs']['ref'] ) && has_block( $block_name, $block['attrs']['ref'] ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Settings - Elastic
 */
add_action('admin_menu', function () {
  $title = __('Elastic settings', 'mikkeli-react-theme');
  add_theme_page($title, $title, 'edit_theme_options', 'mikkeli-theme-elastic-options', function () {
		echo '<div class="wrap">';
		echo "<h1>$title</h1>";
		echo '<form method="post" action="options.php">';
		settings_fields("mikkeli-theme-elastic-options");
		do_settings_sections("mikkeli-theme-elastic-options");
		submit_button();
		echo '</form>';
		echo '</div>';
	});
});

add_action('admin_init', function () {
	$elasticUrl = __('Elastic url', 'mikkeli-react-theme');
	add_settings_section('mikkeli-theme-elastic-options', null, null, 'mikkeli-theme-elastic-options');
	add_settings_field('theme_elastic_url', $elasticUrl, function () {
		$url = get_option('theme_elastic_url');
		echo "<input style='width: 600px;' type='url' name='theme_elastic_url' value='$url'/>";
	}, 'mikkeli-theme-elastic-options', 'mikkeli-theme-elastic-options');
	register_setting( 'mikkeli-theme-elastic-options', 'theme_elastic_url');

	$elasticKey = __('Elastic key', 'mikkeli-react-theme');
	add_settings_field('theme_elastic_key', $elasticKey, function () {
		$key = get_option('theme_elastic_key');
		echo "<input style='width: 600px;' type='text' name='theme_elastic_key' value='$key'/>";
	}, 'mikkeli-theme-elastic-options', 'mikkeli-theme-elastic-options');
	register_setting( 'mikkeli-theme-elastic-options', 'theme_elastic_key');

	$mikkeliDomainTitle = __('Mikkeli domain', 'mikkeli-react-theme');
	add_settings_field('theme_mikkeli_domain', $mikkeliDomainTitle, function () {
		$mikkeliDomain = get_option('theme_mikkeli_domain');
		echo "<input style='width: 600px;' type='url' name='theme_mikkeli_domain' value='$mikkeliDomain'/>";
	}, 'mikkeli-theme-elastic-options', 'mikkeli-theme-elastic-options');
	register_setting( 'mikkeli-theme-elastic-options', 'theme_mikkeli_domain');

	$oppiminenDomainTitle = __('Oppiminen domain', 'mikkeli-react-theme');
	add_settings_field('theme_oppiminen_domain', $oppiminenDomainTitle, function () {
		$oppiminenDomain = get_option('theme_oppiminen_domain');
		echo "<input style='width: 600px;' type='url' name='theme_oppiminen_domain' value='$oppiminenDomain'/>";
	}, 'mikkeli-theme-elastic-options', 'mikkeli-theme-elastic-options');
	register_setting( 'mikkeli-theme-elastic-options', 'theme_oppiminen_domain');

	$resultPlaceholderImageTitle = __('Result image placeholder url', 'mikkeli-react-theme');
	add_settings_field('theme_result_placeholder_image', $resultPlaceholderImageTitle, function () {
		$resultPlaceholderImage = get_option('theme_result_placeholder_image');
		echo "<input style='width: 600px;' type='url' name='theme_result_placeholder_image' value='$resultPlaceholderImage'/>";
	}, 'mikkeli-theme-elastic-options', 'mikkeli-theme-elastic-options');
	register_setting( 'mikkeli-theme-elastic-options', 'theme_result_placeholder_image');
});

/**
 * Settings - Google Analytics
 */
add_action('admin_menu', function () {
  $title = __('Google Analytics', 'mikkeli');
  add_theme_page($title, $title, 'edit_theme_options', 'mikkeli-ga-options', function () {
		echo '<div class="wrap">';
		echo "<h1>$title</h1>";
		echo '<form method="post" action="options.php">';
		settings_fields("mikkeli-ga-options");
		do_settings_sections("mikkeli-ga-options");
		submit_button();
		echo '</form>';
		echo '</div>';
	});
});
add_action('admin_init', function () {
	$ga_id = __('Google Analytics ID', 'mikkeli');
	add_settings_section('mikkeli-ga-options', null, null, 'mikkeli-ga-options');
	add_settings_field('mikkeli_google_analytics', $ga_id, function () {
		$analytics_code = get_option('mikkeli_google_analytics');
		echo "<input style='width: 600px;' type='text' name='mikkeli_google_analytics' value='$analytics_code'/>";
	}, 'mikkeli-ga-options', 'mikkeli-ga-options');
	register_setting( 'mikkeli-ga-options', 'mikkeli_google_analytics');
});

/* AJAX pagination */
add_action( 'wp_ajax_nopriv_ajax_pagination', 'pages_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', 'pages_ajax_pagination' );

function pages_ajax_pagination() {
	$resultLoader = new ResultLoader();
	$query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );
	$paged = intval($_POST["page"]);
	$type = $_POST["contentType"];
	$pages = $resultLoader->load_from_elastic($query_vars['s'], $type, $paged);
	//var_dump($type);

	if( $pages ) {
		foreach($pages["results"] as $page): ?>
			<div class="item">
				<a title="<?php echo $page["title"]; ?>" href="<?php echo $page["url"]; ?>"><img src="<?php echo $page["image_url"]; ?>" alt="<?php echo $page["title"]; ?>" width="120" height="60" /></a>
				<div>
					<p><?php echo date('d.m.Y', strtotime($page["date"])); ?> - <a title="<?php echo $page["title"]; ?>" href="<?php echo $page["url"]; ?>"><?php echo $page["title"]; ?></a></p>
					<p><?php echo $page["summary"]; ?></p>
				</div>
			</div>
		<?php endforeach;
	}

	die();
}

function mikkeli_live_search() {
	$term = strtolower( $_GET['s'] );
	$suggestions = array();
	
	$resultLoader = new ResultLoader();
	$pages = $resultLoader->load_from_elastic($term, "page", 1);
	$posts = $resultLoader->load_from_elastic($term, "post", 1);
	$attachments = $resultLoader->load_from_elastic($term, "attachment", 1);
	$oppiminen = $resultLoader->load_from_elastic($term, "oppiminen", 1);

	$res = array_merge($pages["results"], $posts["results"], $attachments["results"], $oppiminen["results"]);

	foreach($res as $page) {
		$suggestions[] = [
			'label' => $page["title"],
			'link' => $page["url"],
		];
	}
	
	echo json_encode($suggestions);
	wp_die();

}

add_action( 'wp_ajax_mikkeli_live_search', 'mikkeli_live_search' );
add_action( 'wp_ajax_nopriv_mikkeli_live_search', 'mikkeli_live_search' );

// Hide pages with no edit permissions
add_action('admin_head', 'mikkeli_custom_css');

function mikkeli_custom_css() {
  echo '<style>
	 .cms_tpv_user_can_edit_page_no {
		 display: none!important;
	 }
  </style>';
}

add_action( 'admin_notices', 'print_button' );
function print_button() {
	// Get the current screen so you only move forward if this is the users.php screen.
	$screen = get_current_screen();
	if ( 'users' == $screen->id ) { ?>
		<div class="print-user-info-btn">
			<button onclick="window.print();return false;">Tulosta tiedot</button>
		</div>
	<?php }
}

/**
 * Register and enqueue a custom print stylesheet in the WordPress admin.
 */
function mikkeli_enqueue_custom_admin_style() {
	wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/css/admin_print.css', false, '1.3.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'mikkeli_enqueue_custom_admin_style' );

/* Polylang String Translations */
add_action('init', function() {
	if (function_exists('pll_register_string')) {
		pll_register_string('mikkeli', 'Etusivu');
		pll_register_string('mikkeli', 'Kuuntele');
	} 
});
