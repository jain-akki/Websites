<?php get_header(); ?>

<?php $kktfwp_term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' )); ?>

<div class="kktfwp-content-area">

	<main class="kktfwp-site-main" role="main">
					
			<!-- start page entry -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
				<!-- start title -->
				<div class="kktfwp-title clearfix">
					<div class="kktfwp-title-wrapper">
						<?php the_archive_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</div>
					<div class="kktfwp-description-wrapper">
						<?php the_archive_description() ?>
					</div>
				</div>
				<!-- end title -->

					
				<?php if ( current_theme_supports( 'kktfwp-cpt' ) ) : ?>
				<!-- start featured projects -->
				<div class="kktfwp-projects-wrapper">
				
					<?php 				
					$kktfwp_args = array(
						'post_type' => 'kktfwp_portfolio',
						'posts_per_page' => -1,
						'portfolio-type' => $kktfwp_term->slug
					);
					?>
											
						<!-- start grid -->
						<div class="kktfwp-projects">
						
							<?php 

							$kktfwp_portfolio_style =  rwmb_meta( '_kktfwp_portfolio_columns' );
							
							$kktfwp_query = new WP_Query( $kktfwp_args );

							while ( $kktfwp_query->have_posts() ) : $kktfwp_query->the_post();
							
								$kktfwp_terms =  get_the_terms( $post->ID, 'portfolio-type' ); 
								$kktfwp_term_list = '';
																
								if( is_array( $kktfwp_terms ) ) {
								
									$size = count( $kktfwp_terms );
								
									for( $i = 0; $size > $i; $i++ ) {
										$kktfwp_term_list .= $kktfwp_terms[$i]->name;
										if ( $size > $i+1 ) {
											$kktfwp_term_list .= ' &#8211; ';
										}
									}
								}									

								$kktfwp_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'featured-image-thumb' );
								
								if ( $kktfwp_portfolio_style === '2' ) {
									$kktfwp_featured_image = aq_resize($kktfwp_image_url[0], '600', '600', true, false );							
								} else {								
									$kktfwp_featured_image = aq_resize($kktfwp_image_url[0], '400', '400', true, false );	
								}
							?>
							
							<div id="<?php echo the_ID()?>" <?php post_class( 'all portfolio-project filterable-project' ) ?> >
								<a id="overlay_<?php echo the_ID()?>" class="has-overlay" href="<?php the_permalink(); ?>" >
									<div class="img-h">
										<img id="image_<?php echo esc_attr( the_ID()) ?>" src="<?php echo esc_url( $kktfwp_featured_image[0] ); ?>" width="<?php echo esc_attr( $kktfwp_featured_image[1] ); ?>" height="<?php echo esc_attr( $kktfwp_featured_image[2] ); ?>" alt="<?php the_title() ?>" >
									</div>
									<div class="proj-content">
										<h2 class="proj-title" ><?php the_title(); ?></h2>
										<p class="proj-terms" ><?php echo esc_html( $kktfwp_term_list ) ?></p>
									</div>
								</a>
							</div>	
							
							<?php endwhile; wp_reset_postdata(); ?>
						<div class="kktfwp-fix"></div>
						<div class="kktfwp-fix"></div>
						<div class="kktfwp-fix"></div>
						</div>
						<!-- end grid -->
				
				</div>
				<!-- end featured projects -->
				<?php endif; ?>

			</article>
			<!-- end page entry -->
			
	</main><!-- .site-main -->

</div><!-- .content-area -->

<?php get_footer(); ?>