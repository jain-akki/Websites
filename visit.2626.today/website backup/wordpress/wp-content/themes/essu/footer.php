<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the .site-content div and all content after
 *
 */
?>

		</div><!-- .site-content -->

		<footer class="kktfwp-footer" role="contentinfo" style="text-align:center;">
			<div class="kktfwp-row clearfix">

				<div class="kktfwp-site-info">
					<?php
						/**
						 * Copyrights
						 * @since Essu 1.0
						 */
						do_action( 'kktfwp_copy' );
					?>
				</div><!-- .site-info -->
				
				<div class="kktfwp-social">
					<?php
						/**
						 * Social profiles
						 * @since Essu 1.0
						 */
						do_action( 'kktfwp_social' );
					?>
				</div><!-- .site-info -->
				
			</div>
		</footer><!-- .site-footer -->
		<div class="kktfwp-overlay"></div>
	</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
