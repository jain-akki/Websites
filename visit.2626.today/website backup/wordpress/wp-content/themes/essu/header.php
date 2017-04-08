<?php
/**
 * The template for displaying the header
 * Displays all of the head element and everything up until the "site-content" div.
 *
 */

?>
<!DOCTYPE html>

<html <?php language_attributes(); ?> class="no-js">

<head>
	
	<!-- start meta -->	
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	
	<!-- start wp_head hook -->	
	<?php wp_head(); ?>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100" rel="stylesheet">
</head>

<body <?php body_class(); ?>>

<!-- start main wrapper -->	
<div id="kktfwp-page" class="kktfwp-page-wrapper">

	<div class="preloader-overlay">
		<div class="dot-wrapper">
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
		</div>
	</div>

	<!-- start inner wrapper -->	
	<div class="kktfwp-page-inner">

		<!-- site-header -->
		<header id="kktfwp-masthead" class="kktfwp-header" role="banner">			
			<?php get_template_part( 'inc/menu/default' ) ?>			
		</header>
		<!-- end site-header -->

		<div class="kktfwp-site-content clearfix">