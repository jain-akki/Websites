<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
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

				<div class="entry-content page-content">
					<?php
					the_content();

					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'essu' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'essu' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					) );
					?>
				</div><!-- .entry-content -->

			</article>
			<!-- end page entry -->

			<!-- If comments are open or we have at least one comment, load up the comment template -->
			<?php if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			// End of the loop.
			}
		endwhile;
		?>

	</main><!-- .site-main -->

</div><!-- .content-area -->

<?php get_footer(); ?>