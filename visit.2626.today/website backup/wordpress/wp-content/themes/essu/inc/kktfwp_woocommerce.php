<?php
/*-----------------------------------------------------------------------------------*/
/* WOOCOMMERCE
/*-----------------------------------------------------------------------------------*/

// Default image sizes

if ( ! function_exists( 'kktfwp_default_woo_image_dimensions' ) ) {
	function kktfwp_default_woo_image_dimensions() {
		global $pagenow;
	 
		if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
			return;
		}
		
		$catalog = array(
			'width' => '500', // px
			'height'=> '500', // px
			'crop' => 1 // true
		);

		$single = array(
			'width' => '700', // px
			'height'=> '700', // px
			'crop' => 1 // true
		);

		$thumbnail = array(
			'width' => '300', // px
			'height'=> '300', // px
			'crop' => 1 // true
		);

		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); // Product category thumbs
		update_option( 'shop_single_image_size', $single ); // Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs
	}
}

add_action( 'init', 'kktfwp_default_woo_image_dimensions', 1 );


// Wrap shop loop

if ( ! function_exists( 'kktfwp_woo_before_shop_loop' ) ) {
	function kktfwp_woo_before_shop_loop() {
		echo '<div class="kk-woo-shop-wrapper">';
	}
}

add_action('woocommerce_before_shop_loop', 'kktfwp_woo_before_shop_loop');

if ( ! function_exists( 'kktfwp_woo_after_shop_loop' ) ) {
	function kktfwp_woo_after_shop_loop() {
		echo '</div>';
	}
}

add_action('woocommerce_after_shop_loop', 'kktfwp_woo_after_shop_loop');

// Change number or products per row


if ( ! function_exists( 'kktfwp_loop_columns' ) ) {
	function kktfwp_loop_columns() {
		return 3; // 3 products per row
	}
} 

add_filter('loop_shop_columns', 'kktfwp_loop_columns');


add_filter( 'woocommerce_show_page_title' , 'woo_hide_page_title' );
/**
 * woo_hide_page_title
 *
 * Removes the "shop" title on the main shop page
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
function woo_hide_page_title() {	
	return false;	
}

// remove the woocommerce_archive_description
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10, 2 );

// Remove product description heading (in tabs)

add_filter( 'woocommerce_product_description_heading', '__return_false', 10 );

// Styling single product page

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 45 );

// Redefine woocommerce_output_related_products()

add_filter( 'woocommerce_output_related_products_args', 'kktfwp_related_products_args' );

function kktfwp_related_products_args( $args ) {
   $args['posts_per_page'] = 3; 
   $args['columns'] = 3;
   return $args;
  }


