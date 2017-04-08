<?php
/**
 * The template for displaying single portfolio posts
 *
 */

get_header(); ?>

<div class="kktfwp-content-area">

	<main class="kktfwp-site-main" role="main">
		
		<?php while ( have_posts() ) : the_post(); ?>
		
		<?php if ( post_password_required( $post ) ) {
				get_template_part( 'template-parts/password' ); 
			} else { ?>
			
			<!-- start page entry -->
			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
			
				<?php 
				if ( in_array( rwmb_meta( '_kktfwp_layout' ), array( 'top', 'top-halfs' ) ) ) {
					$kktfwp_inview = '';
				} else {
					$kktfwp_inview = ( rwmb_meta( '_kktfwp_visibility' ) ) ? rwmb_meta( '_kktfwp_visibility' )  : 'is-inview';
				}
				?>
			
				<div class="kktfwp-firstCol clearfix <?php echo esc_attr( $kktfwp_inview ) ?>">
						<div class="kktfwp-title-wr">
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>	
						</div>
						
						<div class="kktfwp-entry-wr">
							<?php the_content(); ?>
						</div>
				</div>

				<div class="kktfwp-secondCol">
					<?php
					$kktfwp_type = rwmb_meta( '_kktfwp_type' );
					
					switch ( $kktfwp_type ) {	
					
						case 'images':
							$kktfwp_projImages = rwmb_meta( '_kktfwp_projimg' );
												
							foreach ( $kktfwp_projImages as $kktfwp_image ) { 
							
								$kktfwp_img_url = aq_resize( $kktfwp_image['full_url'], 833, 99999, false, false );
							
								?>
								<div class="img-wr" style="padding-bottom:<?php echo esc_attr( $kktfwp_img_url[2]/$kktfwp_img_url[1] * 100); ?>%">
									<img id="image_<?php echo esc_attr( $kktfwp_image['ID'] ) ?>" class="doLazyLoad" data-original="<?php echo esc_url( $kktfwp_img_url[0] ); ?>" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width="<?php echo esc_attr( $kktfwp_img_url[1] ); ?>" height="<?php echo esc_attr( $kktfwp_img_url[2] ); ?>" title="" alt="" >
								</div>
							<?php }	?>					
					<?php 
						break;
					
						case 'gallery':	
							if ( class_exists( 'Envira_Gallery' ) || class_exists( 'Envira_Gallery_Lite' ) ) {									
								echo do_shortcode( '[envira-gallery id="'.rwmb_meta( '_kktfwp_envira' ).'"]'  );
							}
							break;	
							
						case 'videos':
						
							$kktfwp_projVideos = rwmb_meta( '_kktfwp_projvideo' );
							
							echo do_shortcode ($kktfwp_projVideos );
						
						break;
					}		
					?>
					
				</div>

			</article>
			<!-- end page entry -->
			
			<!-- start navigation -->
			<?php do_action('kktfwp_nav');?>
			<!-- end navigation -->

			<!-- If comments are open or we have at least one comment, load up the comment template -->
			<?php if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
			
			<?php }
			// End of the loop.
			endwhile;
			?>

	</main><!-- .site-main -->

</div><!-- .content-area -->

<?php get_footer(); ?>