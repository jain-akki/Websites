<?php
/**
 * Template for displaying search forms
 *
 * @package WordPress
 * 
 * @since Essu 1.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'essu' ); ?></span>
		<input type="search" class="search-field" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit"><span><?php echo esc_html_x( 'Search', 'submit button', 'essu' ); ?></span></button>
</form>
