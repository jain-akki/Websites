<?php
/**
 * The template part for displaying results in search pages
 *
 * @package WordPress
 * 
 * @since Essu 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h3><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
	</header><!-- .entry-header -->

	<?php kktfwp_excerpt(); ?>

</article><!-- #post-## -->