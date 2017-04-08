<?php get_header()?>

<div class="kktfwp-content-area">
	<main class="kktfwp-site-main kktfwp-woocommerce" role="main">
	
	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix post-in-list'); ?>>
	
	<?php if (is_shop() || is_product_category() || is_product_tag()): ?>
	<!-- start title -->
				<div class="kktfwp-title clearfix">
					<div class="kktfwp-title-wrapper">
						<?php printf( '<h1 class="entry-title"> %s</h1>', (is_shop() ? get_the_title( get_option( 'woocommerce_shop_page_id' ) ) : get_the_archive_title() )) ?>
					</div>
					<div class="kktfwp-description-wrapper">
						<?php 
						if ( is_shop() ) {
							echo rwmb_meta( '_kktfwp_description', '', get_option( 'woocommerce_shop_page_id' ) ); 
						} else { 
							the_archive_description(); 
						}; ?>
					</div>
				</div>
				<!-- end title -->
	<?php endif; ?>
	
		<?php woocommerce_content(); ?>
	
	</article>
	
	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer()?>