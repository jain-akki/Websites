<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * 
 * @since Essu 1.0
 */
?>
<?php if ( post_password_required( $post ) ) {
				get_template_part( 'template-parts/password' ); 
			} else { ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<?php kktfwp_post_thumbnail(); ?>

	<div class="single-entry-content">
	
		<!-- start title -->
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<!-- end title -->
		
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
	
	<div class="entry-meta">
		<?php kktfwp_entry_meta(); ?>
	</div><!-- .entry-meta -->

</article><!-- #post-## -->
<?php } ?>
