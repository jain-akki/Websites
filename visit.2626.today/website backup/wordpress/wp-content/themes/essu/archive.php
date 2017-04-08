<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>

<div class="kktfwp-content-area">

	<main class="kktfwp-site-main" role="main">

		<?php if ( have_posts() ) : ?>
			
			<!-- start title -->
			<div class="kktfwp-title clearfix">
				
					<?php the_archive_title( '<div class="kktfwp-title-wrapper"><h1 class="entry-title">', '</h1></div>' ); ?>
				
					<?php the_archive_description( '<div class="kktfwp-description-wrapper">', '</div>' ) ?>
			</div>
			<!-- end title -->

			<?php
			// Start the Loop.
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

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>