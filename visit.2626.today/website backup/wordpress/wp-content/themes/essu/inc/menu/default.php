<div class="kktfwp-site-header-main kktfwp-row">

	<div class="kktfwp-logo-menu-wrapper">

	<div class="kktfwp-logo">
		<?php kktfwp_the_custom_logo(); ?>
	</div>

	<div id="kktfwp-site-header-menu" class="kktfwp-site-header-menu">
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="kktfwp-main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'essu' ); ?>">
				<?php
					wp_nav_menu( array(
						'container'		 => '',
						'theme_location' => 'primary',
						'menu_class'     => 'kktfwp-primary-menu',
						'depth'          => 0,
						'fallback_cb'    => false,
					 ) );
				?>
				
				<div id="close-sb-menu">
					<span></span>
				</div>
			</nav><!-- .main-navigation -->
		<?php else: ?>

		<span class="kktfwp-nomenu">
			<?php esc_html_e( 'No menu assigned', 'essu' ) ?>
		</span>
		
		<?php endif; ?>

	</div><!-- .site-header-menu -->	
		
	<div class="kktfwp-mobile">
		<span class="kktfwp-ham ham-left"></span>
		<span class="kktfwp-ham ham-right"></span>
	</div>

	</div>
</div><!-- .site-header-main -->