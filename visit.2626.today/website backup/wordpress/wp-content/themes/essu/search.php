<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * 
 * @since Essu 1.0
 */

get_header(); ?>

	<div class="kktfwp-content-area">
		<main class="kktfwp-site-main" role="main">

		<?php if ( have_posts() ) : ?>
		
		<!-- start title -->
				<div class="kktfwp-title clearfix">
					<div class="kktfwp-title-wrapper">
						<h1 class="entry-title"><?php esc_html_e( 'Search Results', 'essu' ) ?></h1>
					</div>
					<div class="kktfwp-description-wrapper">	
						<?php printf( esc_html__( 'Search Results for: %s', 'essu' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?>					
					</div>
				</div>
				<!-- end title -->

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => esc_html__( 'Previous', 'essu' ),
				'next_text'          => esc_html__( 'Next', 'essu' ),
				'screen_reader_text' => esc_html__( 'Posts navigation', 'essu' ),
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>