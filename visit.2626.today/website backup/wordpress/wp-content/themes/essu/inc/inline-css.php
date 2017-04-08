<?php 
if ( ! function_exists( 'kktfwp_sanitize_hex_color' ) ) {
	function kktfwp_sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
		}
	 
		// 3 or 6 hex digits, or the empty string.
		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}
	}
}

if ( ! function_exists( 'kktfwp_custom_skin' ) ) {
	function kktfwp_custom_skin() {
		$color = kktfwp_sanitize_hex_color( get_option('essu_theme_skin') );
		
		// Don't do anything if the current color is the default.
		
		if ( empty( $color ) || $color === '#0097A7' ) {
			return;
		}
		
		$css = '
		/* Custom Skin Color */

		.kktfwp-description-wrapper a,
		a:hover,
		.kktfwp-footer .kktfwp-site-info a:hover,
		.kktfwp-proj-meta .kktfwp-share > a i.kktfwp-i-heart,
		.kktfwp-proj-meta .kktfwp-love > a i.kktfwp-i-heart,
		.nav-links a:not(span):hover, .nav-links span:not(span):hover,
		.nav-links .current,
		.entry-content.page-content a:hover,
		.entry-meta .vcard .url:hover,
		.comment-list li.comment > article .comment-author .fn a:hover,
		.comment-list li.comment > article .comment-content a,
		.comment-list .reply a,
		.comment-list .comment-respond .comment-reply-title small a:hover,
		.search-results article[class*="type-"] .more-link,
		.woocommerce .kktfwp-woocommerce ul.products li .price,
		.woocommerce .kktfwp-woocommerce .star-rating span,
		.woocommerce .kktfwp-woocommerce .star-rating:before,
		.woocommerce .kktfwp-woocommerce .entry-summary .star-rating span,
		.woocommerce .kktfwp-woocommerce .entry-summary .star-rating:before,
		.woocommerce .kktfwp-woocommerce .entry-summary .price,
		.woocommerce .kktfwp-woocommerce .entry-summary .product_meta a,
		.woocommerce .kktfwp-woocommerce #reviews #respond p.comment-form-rating a,
		.woocommerce .kktfwp-woocommerce .woocommerce-pagination ul li span.current,
		.woocommerce .kktfwp-woocommerce .woocommerce-pagination ul li a:hover,
		.woocommerce-checkout #payment ul.payment_methods li a.about_paypal,
		.pass-wr .kktfwp-i-lock-1
		{
			color: %1$s;
		}
		
		@media (max-width: 1199px) {
			.kktfwp-site-header-main .kktfwp-logo-menu-wrapper .kktfwp-site-header-menu ul.kktfwp-primary-menu ul.sub-menu li a:hover,
			.kktfwp-site-header-main .kktfwp-logo-menu-wrapper .kktfwp-site-header-menu ul.kktfwp-primary-menu a:hover,
			.kktfwp-site-header-main .kktfwp-logo-menu-wrapper .kktfwp-site-header-menu ul.kktfwp-primary-menu .current-menu-item > a, .kktfwp-site-header-main .kktfwp-logo-menu-wrapper .kktfwp-site-header-menu ul.kktfwp-primary-menu .current-menu-parent > a	
			{
				color: %1$s;
			}
		}
		@media (min-width: 1200px) {
			.menu-sb .kktfwp-site-header-menu ul.kktfwp-primary-menu > li.current-menu-item a,
			.menu-sb .kktfwp-site-header-menu ul.kktfwp-primary-menu > li.current-menu-parent a,
			.menu-sb .kktfwp-site-header-menu ul.kktfwp-primary-menu > li a:hover,
			.menu-sb .kktfwp-site-header-menu ul.kktfwp-primary-menu > li ul.sub-menu li.current-menu-item a,
			.menu-sb .kktfwp-site-header-menu ul.kktfwp-primary-menu > li ul.sub-menu li:hover a
			{
				color: %1$s;
			}
		}
		.kktfwp-footer .kktfwp-site-info a:after,
		.entry-content.page-content a:after,
		.comment-list .reply a
		{
			border-color: %1$s;
		}
		
		.post.sticky .sticky-post,
		button, 
		[type="button"], 
		[type="reset"], 
		[type="submit"],
		.kktfwp-envira .envira-gallery-wrap .envira-gallery-public[class*="columns"] .envira-gallery-item .envira-gallery-item-inner:after,
		.kktfwp-404-wrapper span,
		a.button,
		.woocommerce .kktfwp-woocommerce .button.button,
		.woocommerce .kktfwp-woocommerce input#submit,
		.woocommerce .kktfwp-woocommerce input.button,
		.woocommerce .kktfwp-woocommerce .added_to_cart,
		.woocommerce .kktfwp-woocommerce .button.button:hover,
		.woocommerce .kktfwp-woocommerce input#submit:hover,
		.woocommerce .kktfwp-woocommerce input.button:hover,
		.woocommerce .kktfwp-woocommerce .added_to_cart:hover,
		.woocommerce .kktfwp-woocommerce #reviews #respond input#submit,
		.woocommerce .kktfwp-woocommerce #reviews #respond input#submit:hover,
		.woocommerce-cart .button.button,
		.woocommerce-cart input#submit,
		.woocommerce-cart input.button,
		.woocommerce-cart input.button.alt,
		.woocommerce-cart .added_to_cart,
		.woocommerce-cart a.button.alt, .woocommerce-checkout .button.button,
		.woocommerce-checkout input#submit,
		.woocommerce-checkout input.button,
		.woocommerce-checkout input.button.alt,
		.woocommerce-checkout .added_to_cart,
		.woocommerce-checkout a.button.alt,
		.woocommerce-cart .button.button:hover,
		.woocommerce-cart input#submit:hover,
		.woocommerce-cart input.button:hover,
		.woocommerce-cart input.button.alt:hover,
		.woocommerce-cart .added_to_cart:hover,
		.woocommerce-cart a.button.alt:hover, .woocommerce-checkout .button.button:hover,
		.woocommerce-checkout input#submit:hover,
		.woocommerce-checkout input.button:hover,
		.woocommerce-checkout input.button.alt:hover,
		.woocommerce-checkout .added_to_cart:hover,
		.woocommerce-checkout a.button.alt:hover
		{
			background-color: %1$s;
		}
	';
	
	// Remove space after colons
	$css = str_replace(': ', ':', $css);
	// Remove whitespace
	$css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);

	wp_add_inline_style( 'kktfwp-style', sprintf( $css, $color ) );	
		
	}
}
add_action( 'wp_enqueue_scripts', 'kktfwp_custom_skin', 10 );

if ( ! function_exists( 'kktfwp_custom_css' ) ) {
	function kktfwp_custom_css() {
		$css = wp_strip_all_tags( get_option('essu_theme_custom_css') );
		
		if ( empty( $css ) ) {
			return;
		}
		
		wp_add_inline_style( 'kktfwp-style', $css );	
	
	}
}
add_action( 'wp_enqueue_scripts', 'kktfwp_custom_css', 16 );

if ( ! function_exists( 'kktfwp_custom_overlay' ) ) {
	function kktfwp_custom_overlay() {
	
		$color = kktfwp_sanitize_hex_color( get_option('essu_theme_dominant_color_custom') );
		$text_color = kktfwp_sanitize_hex_color( get_option('essu_theme_dominant_color_text') );
				
		if ( empty( $color ) ) {
			return;
		}	

		$css = '
		a.has-overlay:after {
			background-color: %1$s;
		}
		a.has-overlay .proj-content .proj-title,
		a.has-overlay .proj-content .proj-terms {
			color: %2$s;
		}
		';
		
		wp_add_inline_style( 'kktfwp-style', sprintf( $css, $color, $text_color ) );	
	
	}
}

if ( get_option('essu_theme_dominant_color') !== 'true' ) {
	add_action( 'wp_enqueue_scripts', 'kktfwp_custom_overlay', 16 );
}