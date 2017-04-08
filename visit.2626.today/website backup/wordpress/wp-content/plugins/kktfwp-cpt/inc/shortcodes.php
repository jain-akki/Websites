<?php 
/* --- Buttons --- */

if (!function_exists('kk_button')) {
	function kk_button($atts, $content = null) {
		$args = array(
			'title' => '',
			'link'  => '',
			'size'  => ''
		);
			
		extract(shortcode_atts($args, $atts)); 
		
		$link = vc_build_link( $link );
		$target = $link['target'];
		
		if ($target == '') {
			$target = '_self';
		}		
		
		return '<a class="more-link kk-vc-button '. $size.'" title="'. esc_html($link['title']) .'" target="'. $target .'" href="'. esc_url($link['url']) . '">'. esc_html($title) .'</a>';		
	}	
}
add_shortcode( 'kk_button', 'kk_button' );

		