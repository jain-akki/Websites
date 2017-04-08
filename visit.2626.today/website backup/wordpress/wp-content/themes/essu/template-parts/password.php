<?php
/**
 * The template part for displaying password form
 *
 * @package WordPress
 * 
 * @since Essu 1.0
 */
?>

<div class="pass-wr">
	<span class="kktfwp-i-lock-1"></span>
	
	<header class="page-header">
		<h1 class="page-title"><?php do_action( 'kktfwp_protected_title' ); ?></h1>
	</header><!-- .page-header -->
	
	<div class="page-content">
		<?php echo get_the_password_form(); ?>
	</div><!-- .page-content -->

</div>