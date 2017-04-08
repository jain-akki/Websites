<?php
/**
* Plugin Name: Kotofey Custom Post Types
* Plugin URI: http://themeforest.net/user/kotofey
* Description: Adds a custom post types needed for correct functionality in Kotofey's themes.
* Version: 1.0.1
* Author: Kotofey
* Author URI: http://themeforest.net/user/kotofey
* License: Regular License
* License URI: http://themeforest.net/licenses
*/

add_theme_support( 'kktfwp-cpt' );

/*-----------------------------------------------------------------------------------*/
/* ADD PORTFOLIO POST TYPE
/*-----------------------------------------------------------------------------------*/

function kktfwp_create_portfolio_post_type() 
{
	$labels = array(
		'name' => __( 'Portfolios','kktfwp' ),
		'singular_name' => __( 'Portfolio','kktfwp' ),
		'add_new' => __( 'Add Project','kktfwp'),
		'add_new_item' => __( 'Add New project','kktfwp' ),
		'edit_item' => __( 'Edit Project','kktfwp' ),
		'new_item' => __( 'New Project','kktfwp' ),
		'view_item' => __( 'View Project','kktfwp' ),
		'search_items' => __( 'Search Project','kktfwp' ),
		'not_found' =>  __( 'No project found','kktfwp' ),
		'not_found_in_trash' => __( 'No project found in Trash','kktfwp' ), 
	);

	$args = array(
		'labels' => $labels, 
		'public' => true,
		'menu_position' => 5,
		'rewrite' => array( 'slug' => apply_filters( 'kktfwp_portfolio_slug', 'portfolio' ) ),
		'supports' => array('title','editor','excerpt','thumbnail','custom-fields','comments'),
		'query_var' => true,
		'show_in_nav_menus' => true,
		'capability_type' => 'post'
		);
		
	register_post_type('kktfwp_portfolio',$args);

}

add_action( 'init', 'kktfwp_create_portfolio_post_type' );


// Register taxonomy

function kktfwp_register_portfolio_taxonomy() 
{
	$tax_labels = array(
		'name' => 'Portfolio Category',
		'singular_name' => 'Portfolio Category',
		'search_items' =>  'Search Portfolio Categories',
		'popular_items' => 'Popular Portfolio Categories',
		'all_items' => 'All Portfolio Categories',
		'parent_item' => 'Parent Portfolio Category',
		'parent_item_colon' => 'Parent Portfolio Category',
		'edit_item' => 'Edit Portfolio Category', 
		'update_item' => 'Update Portfolio Category',
		'add_new_item' => 'Add New Portfolio Category',
		'new_item_name' => 'New Portfolio Category Name',
		'separate_items_with_commas' => 'Separate portfolio ctegories with commas',
		'add_or_remove_items' => 'Add or remove portfolio categories',
		'choose_from_most_used' => 'Choose from the most used portfolio categories',
		'menu_name' => 'Portfolio Categories'
	);

	register_taxonomy('portfolio-type',
		array('kktfwp_portfolio'), 
			array(
				'hierarchical'=>true,
				'show_ui'=>true,
				'labels' => $tax_labels,
				'public' => true,
				'query_var'=> true,
				'label' => 'Portfolio Categories',
				'rewrite' => array('slug' => 'portfolio-type', 'hierarchical' => true)

				)
	);
}

add_action( 'init', 'kktfwp_register_portfolio_taxonomy' );


/*-----------------------------------------------------------------------------------*/
/* INITIALIZE VISUAL COMPOSER CUSTOM SHORTCODES
/*-----------------------------------------------------------------------------------*/

add_action( 'vc_before_init', 'kktfwp_cpt_vcSetAsTheme' );

function kktfwp_cpt_vcSetAsTheme() {
	require_once dirname(__FILE__)."/inc/shortcodes.php";
}