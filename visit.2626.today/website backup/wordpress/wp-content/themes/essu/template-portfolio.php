<?php 
/* 
Template Name: Portfolio
*/ 
?>

<?php get_header(); ?>

<div class="kktfwp-content-area">

	<main class="kktfwp-site-main" role="main">
		
		<?php while ( have_posts() ) : the_post(); ?>
			
			<!-- start page entry -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
				<!-- start title -->
				<div class="kktfwp-title clearfix">
					<div class="kktfwp-title-wrapper">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</div>
					<div class="kktfwp-description-wrapper">
						<?php echo rwmb_meta( '_kktfwp_description' ); ?>
					</div>
				</div>
				<!-- end title -->
				
				<?php if( the_content() ) : ?>
				<div class="entry-content">
				
					<?php the_content(); ?>
					
				</div><!-- .entry-content -->
				<?php endif; ?>
					
				<?php if ( current_theme_supports( 'kktfwp-cpt' ) ) : ?>
				<!-- start featured projects -->
				<div class="kktfwp-projects-wrapper">
				
					<!-- start filter -->
					<?php 				
					$kktfwp_args = array(
						'post_type' => 'kktfwp_portfolio',
						'posts_per_page' => -1,
					);
					
					if ( rwmb_meta( '_kktfwp_filter' ) === '0' ) :
					?>
					<div class="p-filter">
						<ul>
						<?php 				
						
						$kktfwp_filter = kktfwp_filter( $kktfwp_args );	

						if( is_array( $kktfwp_filter ) ) {

							echo '<li><a class="kktfwp-filter-btn" href="#" data-filter=".all" >'. esc_html__( 'All', 'essu' ) .'</a><sup>'. esc_html( $kktfwp_filter[1] ) .'</sup></li>';

							foreach ( $kktfwp_filter[0] as $val ) {
								echo '<li><a class="kktfwp-filter-btn" href="#" data-filter=".portfolio-type-'. esc_attr( $val['slug'] ) .'">'. esc_html( $val['name'] ) .'</a><sup>'. $kktfwp_filter[2][$val['slug']].'</sup></li>';
							}						
						}
						?>
						</ul>
					</div>
					<?php endif; ?>
					<!-- end filter -->
											
						<!-- start grid -->
						<div class="kktfwp-projects">
						
							<?php 
							
							if ( rwmb_meta( '_kktfwp_homeStyle' ) === 'featured' ) {
								$kktfwp_args['post__in'] = $kktfwp_filter[3];
							
							};
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
							
							<div id="<?php echo esc_attr( the_ID())?>" <?php post_class( 'all portfolio-project filterable-project' ) ?> >
								<a id="overlay_<?php echo esc_attr( the_ID())?>" class="has-overlay" href="<?php the_permalink(); ?>" >
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

			<!-- If comments are open or we have at least one comment, load up the comment template -->
			<?php if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

</div><!-- .content-area -->

<?php get_footer(); ?>