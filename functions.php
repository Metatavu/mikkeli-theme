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
define( 'MIKKELI_VERSION', '2.0.0' );
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
	'primary' => __( 'Primary Menu', 'mikkeli' ),
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
  wp_enqueue_style( 'styles', THEMEROOT . '/css/layout.css' );
	wp_enqueue_style( 'incidents', 'https://cdn.metatavu.io/libs/kunta-api-incidents/0.0.4/incidents.min.css' );
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', array(), false, true); // Load jQuery @ Footer
  wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'incidents-script', 'https://cdn.metatavu.io/libs/kunta-api-incidents/0.0.4/incidents.min.js');
  wp_register_script( 'fontawesome', 'https://kit.fontawesome.com/2d8150fc9c.js', array(), false, true); // Load jQuery @ Footer
  wp_enqueue_script( 'fontawesome' );
	wp_enqueue_script( 'scripts', THEMEROOT . '/js/all.js', array(), MIKKELI_VERSION, true );
	global $wp_query;
	wp_localize_script( 'scripts', 'ajaxpagination', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'query_vars' => json_encode( $wp_query->query )
	));
}
add_action( 'wp_enqueue_scripts', 'mikkeli_scripts' );

/**
 * Remove Query Strings
 */
function _remove_script_version( $src ){
  $parts = explode( '?', $src );
  return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

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
	$text['home']     = 'Etusivu'; // text for the 'Home' link
	$text['category'] = 'Arkisto "%s"'; // text for a category page
	$text['search']   = 'Hakutulokset hakusanalle "%s"'; // text for a search results page
	$text['tag']      = 'Kirjoitukset avainsanalla "%s"'; // text for a tag page
	$text['author']   = 'Kirjoittajan %s julkaisut'; // text for an author page
	$text['404']      = 'Virhe 404'; // text for the 404 page
	$text['page']     = 'Sivu %s'; // text 'Page N'
	$text['cpage']    = 'Kommenttisivu %s'; // text 'Comment Page N'

	$wrap_before    = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList"><div class="navigation">'; // the opening wrapper tag
	$wrap_after     = '</div><div id="readspeaker_button1" class="rs_skip rsbtn rs_preserve"><a rel="nofollow" class="rsbtn_play" accesskey="L" title="Kuuntele ReadSpeaker webReaderilla" href="//app-eu.readspeaker.com/cgi-bin/rsent?customerid=8419&amp;readclass=entry-content&amp;lang=fi_FI&amp;url='.get_permalink( get_the_ID() ).'"><span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span>Kuuntele</span></span></span><span class="rsbtn_right rsimg rsplay rspart"></span></a></div></div><!-- .breadcrumbs -->'; // the closing wrapper tag
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

		if ( $show_home_link ) {
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
			if ( get_post_type() != 'post' ) {
				$position += 1;
				$post_type = get_post_type_object( get_post_type() );
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->labels->name, $position );
				if ( $show_current ) echo $sep . $before . get_the_title() . $after;
				elseif ( $show_last_sep ) echo $sep;
			} else {
				$cat = get_the_category(); $catID = $cat[0]->cat_ID;
				$parents = get_ancestors( $catID, 'category' );
				$parents = array_reverse( $parents );
				$parents[] = $catID;
				foreach ( $parents as $cat ) {
					$position += 1;
					if ( $position > 1 ) echo $sep;
					echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				}
				if ( get_query_var( 'cpage' ) ) {
					$position += 1;
					echo $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
					echo $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
				} else {
					if ( $show_current ) echo $sep . $before . get_the_title() . $after;
					elseif ( $show_last_sep ) echo $sep;
				}
			}

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
      $output .= '<a title="Jaa Facebookissa" target="_blank" href="' . $facebook_link . '" class="share-button"><i class="fa fa-facebook-official"></i></a>';
      $output .= '<a title="Jaa Twitterissä" target="_blank" href="' . $twitter_link . '" class="share-button twitter"><i class="fa fa-twitter-square"></i></a>';
      $output .= '<a title="Jaa WhatsAppissa" target="_blank" href="' . $whatssapp_link . '" class="share-button whatsapp"><i class="fa fa-whatsapp"></i></a>';
      $output .= '<a title="Jaa LinkedInissä" href="' . $linkedin_link . '" class="share-button linkedin"><i class="fa fa-linkedin-square"></i></a>';
      
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
 * Settings
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