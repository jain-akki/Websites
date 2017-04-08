<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * 
 * @since Essu 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix post-in-list'); ?>>

	<?php kktfwp_post_thumbnail(); ?>

	<div class="entry-content">
		<header class="entry-header">

			<?php kktfwp_entry_date() ?>
			
			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<span class="sticky-post"><?php esc_html_e( 'Featured', 'essu' ); ?></span>
			<?php endif; ?>
			
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header><!-- .entry-header -->
		
		<?php		
			printf( '<p class="kktfwp-excerpt">%s</p>', wp_trim_words( get_the_content(), 50, '...' ) );

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
</article><!-- #post-## -->