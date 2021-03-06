<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * 
 * @since Essu 1.0
 */

get_header(); ?>

<div class="kktfwp-content-area">

		<main class="kktfwp-site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<!-- start title -->
				<div class="kktfwp-title clearfix">
					<div class="kktfwp-title-wrapper">
						<h1 class="entry-title">
							<?php echo get_the_title(get_option( 'page_for_posts' )); ?>
						</h1>
					</div>
					<div class="kktfwp-description-wrapper">
						<?php echo rwmb_meta( '_kktfwp_description', '',get_option( 'page_for_posts' ) ); ?>
					</div>
				</div>
				<!-- end title -->
			<?php endif; ?>

		<div class="posts-wrapper clearfix">
			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

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
		</div>
		
		</main><!-- .site-main -->

	</div><!-- .content-area -->

<?php get_footer(); ?>
