<?php
/**
 * Essu functions and definitions
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 */

/*-----------------------------------------------------------------------------------*/
/* SETS UP THEME DEFAULTS AND REGISTERS SUPPORT FOR VARIOUS WORDPRESS FEATURES
/*-----------------------------------------------------------------------------------*/
 
if ( ! function_exists( 'kktfwp_setup' ) ) {
	function kktfwp_setup() {

		// Make theme available for translation
		
		load_theme_textdomain( 'essu', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		 
		add_theme_support( 'title-tag' );


		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		//set_post_thumbnail_size( 1200, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'essu' ),
		) );
		
		// Woocommerce support
		
		add_theme_support( 'woocommerce' );	

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'css/editor-style.css', kktfwp_fonts_url() ) );

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
}

add_action( 'after_setup_theme', 'kktfwp_setup' );


/*-----------------------------------------------------------------------------------*/
/* POSTS ID HELPER
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'kktfwp_postid' ) ) {
	function kktfwp_postid() {

	if (is_home() || is_search() || is_category() || is_tag() || is_date() || is_author() || is_404()) {
			$postid = get_option( 'page_for_posts' );
		}  else if( function_exists('is_shop') && is_shop() ) {
			$postid = get_option( 'woocommerce_shop_page_id' );
		} else {
			$postid = get_the_ID();
		}
		
		return $postid;
	}
}

/*-----------------------------------------------------------------------------------*/
/* INSTALLS REQUIRED PLUGINS
/*-----------------------------------------------------------------------------------*/

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'kktfwp_register_required_plugins' );

function kktfwp_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'               => esc_html__( 'Essu Meta Boxes', 'essu' ), // The plugin name.
			'slug'               => 'meta-box', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/inc/plugins/meta-box.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '11.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		
		array(
			'name'               => esc_html__( 'Essu Custom Post Types', 'essu' ), // The plugin name.
			'slug'               => 'kktfwp-cpt', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/inc/plugins/kktfwp-cpt.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		
		array(
			'name'               => esc_html__( 'Responsive WordPress Gallery - Envira Gallery Lite', 'essu' ), // The plugin name.
			'slug'               => 'envira-gallery-lite', // The plugin slug (typically the folder name).
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		),
		array(
			'name'               => esc_html__( 'Contact Form 7', 'essu' ), // The plugin name.
			'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		),
		array(
			'name'          		=> esc_html__( 'Visual Composer', 'essu' ), // The plugin name
			'slug'          		=> 'js_composer', // The plugin slug (typically the folder name)
			'source'           		=> get_template_directory() . '/inc/plugins/js_composer.zip', // The plugin source
			'required'         		=> false, // If false, the plugin is only 'recommended' instead of required
			'version'               => '5.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '' // If set, overrides default API URL and points to an external URL
		),

	);

	$config = array(
		'id'           => 'kktfwp',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}


/*-----------------------------------------------------------------------------------*/
/* SETS THE CONTENT WIDTH IN PIXELS
/*-----------------------------------------------------------------------------------*/

function kktfwp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'kktfwp_content_width', 1200 );
}

add_action( 'after_setup_theme', 'kktfwp_content_width', 0 );


/*-----------------------------------------------------------------------------------*/
/* REGISTERS A WIDGET AREA
/*-----------------------------------------------------------------------------------*/




/*-----------------------------------------------------------------------------------*/
/* REGISTER GOOGLE FONTS
/* Create your own kktfwp_fonts_url() function to override in a child theme
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'kktfwp_fonts_url' ) ) {
	function kktfwp_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		$fonts[] = 'Roboto:400,500,700';
		$fonts[] = 'Roboto Slab:300,400,700';

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return esc_url( $fonts_url );
	}
}


/*-----------------------------------------------------------------------------------*/
/* GET THEME INFO
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'kktfwp_themeData' ) ) {  

	function kktfwp_themeData ( $arg='Version' ) {
		$themeData = wp_get_theme(get_template());
		
		return $themeData->get( $arg );
	}
}


/*-----------------------------------------------------------------------------------*/
/* DEFAULT COMMENT FORM FIELDS
/*-----------------------------------------------------------------------------------*/

add_filter( 'comment_form_default_fields', 'kktfwp_form_default_fields' );

if ( ! function_exists( 'kktfwp_form_default_fields' ) ) {
	function kktfwp_form_default_fields($fields) {
	
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
			
		$fields['author'] = '<p class="comment-form-author">' .
		'<input placeholder="' . esc_html__( 'Name', 'essu' ) . ( $req ? ' *' : '' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		'" size="30"' . $aria_req . ' /></p>';

		$fields['email'] = '<p class="comment-form-email">' .
			'<input placeholder="' . esc_html__( 'Email', 'essu' ) . ( $req ? ' *' : '' ) . '" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
			'" size="30"' . $aria_req . ' /></p>';

		$fields['url'] = '<p class="comment-form-url">' .
			'<input placeholder="' . esc_html__( 'Website', 'essu' ) . '" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="30" /></p>';
		
		return $fields;
	}
}


/*-----------------------------------------------------------------------------------*/
/* CHECK IF META PLUGIN INSTALLED
/*-----------------------------------------------------------------------------------*/

if ( !function_exists('rwmb_meta') ) {
	function rwmb_meta() {
		return false;
	}
} else {
	function kktfwp_meta_style() {
		wp_enqueue_style( 'kktfwp-meta-style', get_template_directory_uri() .'/css/meta-style.css', '', kktfwp_themeData() );
	}	
	add_action('admin_enqueue_scripts', 'kktfwp_meta_style');
}


/*-----------------------------------------------------------------------------------*/
/* GET FILTER CATEGORIES
/*-----------------------------------------------------------------------------------*/
  
if ( !function_exists( 'kktfwp_filter' ) ) {  
	function kktfwp_filter ( $args ) {
	
		$i = 0;
		$homeStyle = rwmb_meta( '_kktfwp_homeStyle' );
		$query = new WP_Query( $args );
									
		while ( $query->have_posts() ) : $query->the_post();
		
		$isFeatured = rwmb_meta( '_kktfwp_featured', get_the_id() );
			
		if ( ( $homeStyle === 'featured' ) & ( $isFeatured === '1' ) ) {		
			$terms =  get_the_terms( get_the_id(), 'portfolio-type' );
			$i+=1;			
			$ids[] = get_the_id();
		
		} elseif ( $homeStyle === 'latest' ) {
			$terms =  get_the_terms( get_the_id(), 'portfolio-type' );
			$i+=1;
			$ids = '';
		} else {
			unset($terms);
		}
		
		if( isset( $terms ) ) {
			if( is_array( $terms ) ) {		
				foreach( $terms as $term ) {
					$termsArr[] = array (
							'slug' => $term->slug,
							'name' => $term->name,
							);
				}
			}	
		}	

		endwhile; wp_reset_postdata();
		
		if( isset( $termsArr ) ) {	
		
			$num = array_count_values(array_map(function($item) {
				return $item['slug'];
			}, $termsArr));
			
			$termsArr = array_map("unserialize", array_unique(array_map("serialize", $termsArr)));
		
			return array( $termsArr, $i, $num, $ids );
		}
		
		return;	
	}
}


/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Essu 1.0
 */
function kktfwp_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'kktfwp_javascript_detection', 0 );

 
/*-----------------------------------------------------------------------------------*/
/* ENQUEUES SCRIPTS AND STYLES
/*-----------------------------------------------------------------------------------*/ 
 
function kktfwp_scripts() {

	$template_url = esc_url( get_template_directory_uri() );
	$postid = kktfwp_postid();
	
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'kktfwp-fonts', kktfwp_fonts_url(), array(), kktfwp_themeData() );


	// Theme stylesheet.
	wp_enqueue_style( 'kktfwp-style', get_stylesheet_uri(), array(), kktfwp_themeData() );
	
	/* Scripts */

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_enqueue_script( 'kktfwp-plugins', $template_url .'/js/jquery.plugins.js', array( 'jquery' ), kktfwp_themeData(), true );		
	wp_enqueue_script( 'kktfwp-script', $template_url .'/js/jquery.scripts.js', array( 'jquery' ), kktfwp_themeData(), true );
	
	
	if ( in_array( rwmb_meta( '_kktfwp_layout' ), array( 'top', 'top-halfs' ) ) & rwmb_meta( '_kktfwp_type' ) != 'gallery' ) {
		wp_enqueue_script( 'jquery-masonry' );
	}
	
	$kktfwp_args = array();

	$kktfwp_args['postlove'] = array(
		'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
		'ajax_nonce' => wp_create_nonce( 'love-nonce' ),
	);
	
	$kktfwp_args['rightClick'] = array(
		'click' => esc_js( get_option('essu_theme_content_protection') ),
		'message' => esc_js( get_option('essu_theme_protection_message') )
	);
	
	$kktfwp_args['preloader'] = array(
		'state' => esc_js( ( get_option('essu_theme_global_preloading') === 'true' && rwmb_meta( '_kktfwp_preloader', 'type=select', $postid ) !== 'disable' || rwmb_meta( '_kktfwp_preloader', 'type=select', $postid ) === 'enable' ) ? true : false )
	);
	
	$kktfwp_args['layoutVis'] = array(
		'style' => esc_js( rwmb_meta( '_kktfwp_visibility' ) )
	);

	wp_localize_script( 'kktfwp-script', 'kktfwp', $kktfwp_args );
}

add_action( 'wp_enqueue_scripts', 'kktfwp_scripts' );


function remove_api () {
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
}
add_action( 'after_setup_theme', 'remove_api' );


/*-----------------------------------------------------------------------------------*/
/* GETS FEATURED IMAGE COLOR
/*-----------------------------------------------------------------------------------*/
  
if ( !function_exists( 'kktfwp_setImageBg' ) ) {  

	function kktfwp_setImageBg() {
	
		check_ajax_referer( 'bg-nonce', '_wpnonce' );
	
		$color = array(
			'r' => $_POST['r'],
			'g' => $_POST['g'],
			'b' => $_POST['b'],
			't' => $_POST['t']
		);
		
		if ( ! add_post_meta( $_POST['post_id'], 'kktfwp_ImageBg', $color, true ) ) {
			update_post_meta( $_POST['post_id'], 'kktfwp_ImageBg', $color );
		}

		wp_send_json_success(get_post_meta( $_POST['post_id'], 'kktfwp_ImageBg'));
		//wp_die(); 
	}
}

add_action('wp_ajax_kktfwp_setImageBg', 'kktfwp_setImageBg');
  
  
function kktfwp_enqueue_scripts_back_end() {
	wp_enqueue_script( 'kktfwp-admin-script', get_template_directory_uri() .'/js/jquery.admin-scripts.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'kktfwp-color-thief', get_template_directory_uri() .'/js/jquery.color-thief.min.js', array( 'jquery' ), '1.0', true );

	wp_localize_script( 'kktfwp-admin-script', 'kktfwp_ajax_object', 
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'id' => get_the_ID(), 'ajax_nonce' => wp_create_nonce( 'bg-nonce' ) ) );
	
}

add_action('admin_enqueue_scripts','kktfwp_enqueue_scripts_back_end');


/*-----------------------------------------------------------------------------------*/
/* ADDS INLINE STYLE FOR PROJECTS OVERLAYS
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'kktfwp_inline_css' ) ) {  
	function kktfwp_inline_css() {
	
		if ( is_page_template( 'template-portfolio.php' ) || is_tax( 'portfolio-type' ) ) {
	
			$args = array(
				'post_type' => 'kktfwp_portfolio',
				'posts_per_page' => -1,
			);
			
			$inline_style = '';
			
			$query = new WP_Query( $args );
			
			while ( $query->have_posts() ) : $query->the_post();
			
			$id = get_the_id();	
			
			$overlay_color = get_post_meta ( $id, 'kktfwp_ImageBg', true );		
			$inline_style .= ( isset($overlay_color['t']) ) ? '#overlay_' .$id. ' .proj-content .proj-title, #overlay_'. $id .' .proj-terms {color:'.$overlay_color['t'].';}' : '#overlay_'. $id .' .proj-content .proj-title, #overlay_'. $id .' .proj-terms {color: #444;}';
			
			if ( is_array( $overlay_color ) ) {
				$inline_style .= '#overlay_'. $id .':after{
					background-color: rgb('.$overlay_color['r'].','.$overlay_color['g'].','.$overlay_color['b'].');
				}';
			}
			
			endwhile; wp_reset_postdata();
			
			// Remove space after colons
			$inline_style = str_replace(': ', ':', $inline_style);
			// Remove whitespace
			$inline_style = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $inline_style);
			
			wp_add_inline_style( 'kktfwp-style', $inline_style );
		}
		
		return;
	}
}

if ( get_option('essu_theme_dominant_color') === 'true' ) {
	add_action( 'wp_enqueue_scripts', 'kktfwp_inline_css', 15 );
}

/*-----------------------------------------------------------------------------------*/
/* ADDS CUSTOM CLASSES TO THE ARRAY OF BODY CLASSES
 * @param array $classes Classes for the body element.
/*-----------------------------------------------------------------------------------*/  

if ( !function_exists( 'kktfwp_body_classes' ) ) {  
	function kktfwp_body_classes( $classes ) {
	
		$postid = kktfwp_postid();

		// Adds a class of group-blog to sites with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}
		
		if ( is_singular( 'kktfwp_portfolio' ) ) {
			$classes[] = 'portfolio-content-'.rwmb_meta( '_kktfwp_layout' );
		}
		
		if ( is_page_template( 'template-portfolio.php' ) & rwmb_meta( '_kktfwp_gaps' ) === '1' ) {
			$classes[] = 'portfolio-gaps';
		}
		
		if ( is_page_template( 'template-portfolio.php' ) ) {
			$classes[] = 'portfolio-columns-'.rwmb_meta( '_kktfwp_portfolio_columns' );
		}

		if ( in_array( rwmb_meta( '_kktfwp_layout' ), array( 'top', 'top-halfs' ) ) & !in_array( rwmb_meta( '_kktfwp_type' ), array( 'gallery', 'videos' ) ) ) {
			$classes[] = 'kktfwp-masonry';
		}
		
		if ( in_array( rwmb_meta( '_kktfwp_type' ), array( 'videos' ) ) ) {
			$classes[] = 'kktfwp-video-project';
		}
		
		if ( get_option('essu_theme_global_preloading') === 'true' && rwmb_meta( '_kktfwp_preloader', 'type=select', $postid ) !== 'disable' || rwmb_meta( '_kktfwp_preloader', 'type=select', $postid ) === 'enable' ) {
			$classes[] = 'kktfwp-preloader';
		}		
		
		if ( function_exists( 'envira_gallery' ) ) { 
			$classes[] = 'kktfwp-envira';
		}
		
		$menuStyle = get_option('essu_theme_menu_style');
		
		switch($menuStyle) {	
			case 'minimal':
				$classes[] = 'menu-ch';
				break;
			case 'side':
				$classes[] = 'menu-sb';
				break;	
		}
		
		return $classes;
	}
}
add_filter( 'body_class', 'kktfwp_body_classes' );


/*-----------------------------------------------------------------------------------*/
/* ENVIRA GALLERY HOOKS AND FILTERS
/*-----------------------------------------------------------------------------------*/  

if ( function_exists( 'envira_gallery' ) ) { 

	add_filter( 'envira_gallery_enviratope_throttle', 'tgm_envira_set_envira_throttle', 10, 2 );

	function kktfwp_envira_set_envira_throttle( $time, $data ) {    
		// We are going to set the throttle to 200 instead of 500. Change it to whatever you see fit.
		return 200;    
	}
	
	add_filter( 'envira_gallery_title_displays', 'kktfwp_title_displays' );
	
	function kktfwp_title_displays( $displays ) {    
		// We are going to set the throttle to 200 instead of 500. Change it to whatever you see fit.
		
		$displays[0] = array
        (
            'value' => 'float',
            'name' => 'Default'
        );
			return $displays;
	}
	
	function kktfwp_envira_image_quality( $args ) {
	
		// Either set the value explicitly, or call your custom function which returns the quality value
		$args['quality'] = 95;
		
		return $args;		
	}
	add_filter( 'envira_gallery_crop_image_args', 'kktfwp_envira_image_quality' );
}

add_filter( 'jpeg_quality', create_function( '', 'return 95;' ) );

/*-----------------------------------------------------------------------------------*/
/* SHARE AND LOVE BUTTONS
/*-----------------------------------------------------------------------------------*/ 

add_filter( 'the_content', 'kktfwp_share', 99 ); 
 
if ( !function_exists( 'kktfwp_share' ) ) {
	function kktfwp_share( $content ) { 
		if ( (is_singular('kktfwp_portfolio') || is_singular('post') ) & $content == true) {
		
			$love = get_post_meta( get_the_ID(), '_post_love', true );
			$love = ( empty( $love ) ) ? 0 : $love;
			$cookie = (!isset( $_COOKIE['lovepost_'.get_the_ID()] )) ? 'kktfwp-i-heart-empty' : 'kktfwp-i-heart';
			$url = urlencode(get_the_permalink());
			$title = esc_html(get_the_title());
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		
			$share = '<div class="kktfwp-proj-meta clearfix">
						<div class="kktfwp-share">
							<a href="#">
								<i class="kktfwp-i-share"></i>
								<span class="share-txt">Share</span>
							</a>
							<div class="kktfwp-share-icons">
								<a href="https://www.facebook.com/sharer/sharer.php?u='. $url .'" class="kktfwp-i-facebook sh-btn" title="Facebook" target="_blank"></a>
								<a href="https://twitter.com/share?text='. $title .'&amp;url='. $url .'" class="kktfwp-i-twitter sh-btn" title="Twitter" target="_blank"></a>
								<a href="https://plus.google.com/share?url='. $url .'" class="kktfwp-i-gplus sh-btn" title="Google+" target="_blank"></a>
								<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url='. $url .'" class="kktfwp-i-linkedin sh-btn" title="LinkedIn" target="_blank"></a>
								<a href="https://www.pinterest.com/pin/create/button/?url='. $url .'&amp;media='. urlencode($thumbnail_src[0]) .'&amp;description='. $title .'" class="kktfwp-i-pinterest sh-btn" title="Pinterest" target="_blank"></a>
								<a href="mailto:?Subject='. $title .'&amp;body='. $url .'" class="kktfwp-i-email sh-btn" title="Email"></a>
							</div>
						</div>
						
						<div class="kktfwp-love">
							<a data-loveid="'.get_the_ID().'" href="#">
								<i class="'. $cookie .'"></i>
								<span class="love-count">'. $love .'</span>
							</a>
						</div>
					</div>';

			$content = $content . $share ;
			
			}

		return $content;
	}
}

// ajax handler for post_love

add_action( 'wp_ajax_nopriv_kktfwp_post_love', 'kktfwp_post_love' );
add_action( 'wp_ajax_kktfwp_post_love', 'kktfwp_post_love' );

if ( !function_exists( 'kktfwp_post_love' ) ) {
	function kktfwp_post_love() {

		check_ajax_referer( 'love-nonce', '_wpnonce' );
		
		if( !isset( $_COOKIE['lovepost_'.$_POST['post_id']] ) ) {
			setcookie( 'lovepost_'.$_POST['post_id'], $_POST['post_id'], time()+31104000, COOKIEPATH, COOKIE_DOMAIN );	
		
			$love = get_post_meta( $_POST['post_id'], '_post_love', true );
			$love++;
			
			update_post_meta( $_POST['post_id'], '_post_love', $love );	
			wp_send_json_success( $love );
			
		} else {		
			wp_send_json_error( get_post_meta( $_POST['post_id'], '_post_love', true ) );		
		}			
	}
}


/*-----------------------------------------------------------------------------------*/
/* ADDS ODD/EVEN CLASS TO BLOG POSTS
/*-----------------------------------------------------------------------------------*/

add_filter( 'post_class', 'kktfwp_odd_even' );

if ( !function_exists( 'kktfwp_odd_even' ) ) {
	function kktfwp_odd_even( $classes ) {
	
		global $wp_query;
		
		if ( ! is_singular( 'post' ) ) {		
			if($wp_query->current_post % 2 == 0) {
				$classes[] = 'odd';
			}
			else {
				$classes[] = 'even';
			}		
		}
		return $classes;
	}
}


/*-----------------------------------------------------------------------------------*/
/* ADDS FACEBOOK OPEN GRAPH AND TWITTER CARD META TAGS TO WORDPRESS
/*-----------------------------------------------------------------------------------*/
 
add_action( 'wp_head', 'kktfwp_sharing_meta_head', 10, 2 );

function kktfwp_sharing_meta_head() {

	$shareArr = array();

	// Get desired title, description and url for OG meta
	
	if ( is_feed() || is_search() || is_404() || post_password_required() ) return;
	
	global $post;

	$shareArr['url'] = is_front_page() ? esc_url( home_url( '/' ) ) : get_permalink( $post->ID );
	$shareArr['description'] = wp_trim_words( strip_shortcodes( $post->post_content ) );

	if ( is_archive() ) {
	
		$shareArr['title'] = get_the_archive_title();

		global $wp_query;

		if ( is_author() ) {
			$author_id = get_query_var( 'author' );
			$shareArr['url'] = get_author_posts_url( $author_id );
			$shareArr['description'] = wp_trim_words( strip_tags( get_the_author_meta( 'description', $author_id ) ) );
		} else {
			$shareArr['description'] = wp_trim_words( get_the_archive_description() );
		}

		$queried_object = get_queried_object();

		if ( isset( $queried_object->taxonomy ) ) {
			$shareArr['url'] = get_term_link( $queried_object->slug, $queried_object->taxonomy );
		} elseif ( isset( $queried_object->query_var ) ) {
			$shareArr['url'] = get_post_type_archive_link( $queried_object->query_var );
		} else {
			if ( isset( $wp_query->query_vars['year'] ) ) {
				if ( is_year() ) {
					$shareArr['url'] = get_year_link( $wp_query->query_vars['year'] );
				} elseif ( is_month() ) {
					$shareArr['url'] = get_month_link( $wp_query->query_vars['year'], $wp_query->query_vars['monthnum'] );
				} elseif ( is_day() ) {
					$shareArr['url'] = get_day_link( $wp_query->query_vars['year'], $wp_query->query_vars['monthnum'], $wp_query->query_vars['day'] );
				}
			}
		}
	} elseif ( '' == $shareArr['description'] || is_front_page() ) {
		$shareArr['title'] = get_bloginfo( 'name' );
		$shareArr['description'] = get_bloginfo( 'description' );
	} else {
		$shareArr['title'] = get_the_title( $post->ID );
	}

	$shareArr['title'] = strip_tags( $shareArr['title'] );

	// Image

	if ( has_post_thumbnail( $post->ID ) ) {
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		$image = aq_resize ($thumbnail_src[0], 600, 600);
		
		printf( '<link rel="image_src" href="%s" />',
			esc_url( $image )
		);
	} else {
		$image = '';
	}

	// Markup

	if ( is_single() ) {
		echo '<meta property="og:type" content="article" />';
	}

	printf( '<meta property="og:title" content="%s" />
		<meta property="og:image" content="%s" />
		<meta property="og:image:width" content="600" />
		<meta property="og:image:height" content="600" />
		<meta property="og:description" content="%s" />
		<meta property="og:url" content="%s" />
		<meta property="og:site_name" content="%s" />',
		esc_attr( $shareArr['title'] ),
		esc_url( $image ),
		esc_attr( strip_tags( $shareArr['description'] ) ),
		esc_url( $shareArr['url'] ),
		esc_attr( get_bloginfo( 'name' ) )
	);

	printf( '<meta name="twitter:card" content="summary">
		<meta name="twitter:url" content="%s">
		<meta name="twitter:title" content="%s">
		<meta name="twitter:description" content="%s">
		<meta name="twitter:image" content="%s">',
		esc_url( $shareArr['url'] ),
		esc_attr( $shareArr['title'] ),
		esc_attr( strip_tags( $shareArr['description'] ) ),
		esc_url( $image )
	);
}



/*-----------------------------------------------------------------------------------*/
/* POSTS/PROJECTS NAVIGATION
/*-----------------------------------------------------------------------------------*/  

add_action( 'kktfwp_nav', 'kktfwp_navigation' );

if ( !function_exists( 'kktfwp_navigation' ) ) {
  
function kktfwp_navigation() {

	$prev_next_posts = array( get_previous_post(), get_next_post() );

	foreach ( $prev_next_posts as $post ) {
		$postData[] = array(
			'ID'  => !empty( $post->ID ) ? $post->ID : 0,
			'thumbnail' => '' !== $post ? get_the_post_thumbnail( $post->ID, 'thumbnail' ) : ''
		);
	} 
	
	$backLink = rwmb_meta( '_kktfwp_backBtn' );	
			
	echo '<div class="kktfwp-nav clearfix">
			<div class="kktfwp-prev"><i class="kktfwp-fix">prev</i>'. get_previous_post_link( '%link', '<span class="n-icon"></span><span class="n-img">'.$postData[0]['thumbnail'] .'</span><div class="p-dt"><span class="n-desc" data-delay="0">'. ( ( !is_singular( 'post' ) ) ? esc_html__( 'Previous', 'essu' ) : esc_html__( 'Older entry', 'essu' ) ) .'</span><span class="n-title" data-delay=".035">%title</span></div>' ) .'</div>
			'. ( !is_singular( 'post' ) && $backLink !== '' ? '<div class="kktfwp-back"><a href="' . get_page_link( $backLink ) . '"><span></span></a></div>' : '') .'
			<div class="kktfwp-next"><i class="kktfwp-fix">next</i>'. get_next_post_link( '%link', '<span class="n-icon"></span><span class="n-img">'.$postData[1]['thumbnail'] .'</span><div class="p-dt"><span class="n-desc" data-delay="0">'. ( ( !is_singular( 'post' ) ) ? esc_html__( 'Next', 'essu' ) : esc_html__( 'Newest entry', 'essu' ) ) .'</span><span class="n-title" data-delay=".035">%title</span></div>' ) .'</div>				
	</div>';
			
	}
}


/*-----------------------------------------------------------------------------------*/
/* DISABLING COMMENTS BY DEFAULT
/*-----------------------------------------------------------------------------------*/

add_filter( 'wp_insert_post_data', 'kk_default_page_comments_off' );

if ( ! function_exists( 'kk_default_page_comments_off' ) ) {
	function kk_default_page_comments_off( $data ) {
		if ( in_array( $data['post_type'], array( 'page', 'kktfwp_portfolio' ) ) && $data['post_status'] == 'auto-draft' ) {
			$data['comment_status'] = 0;
			$data['ping_status'] = 0;
		}
		return $data;
	}
}


/*-----------------------------------------------------------------------------------*/
/* INCLUDE NEEDED FILES
/*-----------------------------------------------------------------------------------*/

require_once get_template_directory() . '/admin/main.php';
require_once get_template_directory() . '/inc/theme-meta-boxes.php';
require_once get_template_directory() . '/inc/aq_resizer.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/kktfwp_woocommerce.php';
require_once get_template_directory() . '/admin/class_check_ver.php';


/*-----------------------------------------------------------------------------------*/
/* FOOTER COPYRIGHTS
/*-----------------------------------------------------------------------------------*/ 
if ( ! function_exists( 'kktfwp_copy' ) ) {

	function kktfwp_copy() {
	
	if ( !get_option('essu_theme_copyrights') ) return;
	
	$allowed_html = array(
		'a'      => array(
				'href'  => array(),
				'title' => array(),
				'target'=> array()
		),
		'br'     => array(),
		'em'     => array(),
		'span'   => array(
			'style' => array()
		),
		'strong' => array(),
		'img'    => array(
				'src'   => array(),
				'alt' => array(),
				'style'=> array()
		)
	);
	
	echo wp_kses( stripslashes(get_option('essu_theme_copyrights')), $allowed_html );
	}
}

add_action( 'kktfwp_copy', 'kktfwp_copy' );


/*-----------------------------------------------------------------------------------*/
/* SOCIAL PROFILES
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'kktfwp_social_profiles' ) ) {

	function kktfwp_social_profiles() {

		$opArray = theme_options_array();
		$output = '';
		
		foreach( $opArray['main']['Social'] as $key ) {
			end( $key );
			$op = key($key);			
			$field = get_option( 'essu_theme_'. $op .''  );				
			$title = $key['options']['title'];			
			
			if ( $field !== '' ) {
				$output .= '<li><a class="kktfwp-'. esc_attr( $op ) .'" title="'. esc_attr( $title ) .'" target="_blank" href="'. ( $title === 'Skype' ? esc_html( $field ) : esc_url( $field ) ) .'"><span>'. esc_html( $title ) .'</span></a></li>';
			}			
		}
		
		if ( $output !== '' ) {
			echo '<span><i class="kktfwp-dash"></i>'.esc_html__(' Get in touch:', 'essu').'</span><ul>' .$output. '</ul>';
		} else {
			return;
		}		
	}
}

add_action( 'kktfwp_social', 'kktfwp_social_profiles' );



/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Essu 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function kktfwp_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'kktfwp_content_image_sizes_attr', 10 , 2 );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Essu 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function kktfwp_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'kktfwp_widget_tag_cloud_args' );


/*-----------------------------------------------------------------------------------*/
/* ARCHIVE PAGE FILTER
/*-----------------------------------------------------------------------------------*/

add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

		$title = single_cat_title( '', false );

	} elseif ( is_tag() ) {

		$title = single_tag_title( '', false );

	} elseif ( is_author() ) {

		$title = get_the_author();

	} elseif ( function_exists('is_shop') && is_product_category() || function_exists('is_shop') && is_product_tag() ) {

		$title = single_cat_title( '', false );

	} elseif ( is_tax( 'portfolio-type' ) ) {
	
		$title = single_cat_title( '', false );
	
	}

    return $title;

});


/*-----------------------------------------------------------------------------------*/
/* FILTER PROTECTED TITLE
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'kktfwp_remove_protected_title' ) ) {
	function kktfwp_remove_protected_title( $title ) {
		return '%s';
	}
}
add_filter('protected_title_format', 'kktfwp_remove_protected_title');


/*-----------------------------------------------------------------------------------*/
/* PROTECTED PAGE TITLE
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'kktfwp_protected' ) ) {
	function kktfwp_protected() {
	
		if ( is_singular( 'post' ) ) {		
			$title = esc_html_e( 'Protected post', 'essu' );
		} else {
			$title = esc_html_e( 'Protected page', 'essu' );
		}
			
		return $title;				
	}
}

add_action( 'kktfwp_protected_title', 'kktfwp_protected' );


/*-----------------------------------------------------------------------------------*/
/* VC SETUP
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'kktfwp_vcSetAsTheme' ) ) {
	function kktfwp_vcSetAsTheme() {
		vc_set_as_theme( $disable_updater = true );
	}
}

add_action( 'vc_before_init', 'kktfwp_vcSetAsTheme' );
 
add_action('admin_init', function()
{
    if(is_admin()) {
        setcookie('vchideactivationmsg', '1', strtotime('+3 years'), '/');
        setcookie('vchideactivationmsg_vc11', (defined('WPB_VC_VERSION') ? WPB_VC_VERSION : '1'), strtotime('+3 years'), '/');
    }
});

/*-----------------------------------------------------------------------------------*/
/* CUSTOM SKIN COLOR
/*-----------------------------------------------------------------------------------*/  

require_once get_template_directory() . '/inc/inline-css.php';
remove_action('wp_head', 'wp_generator');
