<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * 
 * @since Essu 1.0
 */

get_header(); ?>

	<div class="kktfwp-content-area">
		<main class="kktfwp-site-main" role="main">

			<section class="error-404 not-found">
				<div class="kktfwp-404-wrapper">
					<span class="num-1 kktfwp404num1">4</span>
					<span class="num-2 kktfwp404num2">0</span>
					<span class="num-3 kktfwp404num3">4</span>
				</div>
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'essu' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( "It's looking like you may have taken a wrong way. Don't worry... it happens to the best of us.", 'essu' ); ?></p>

					<a class="button" href="<?php echo esc_url( get_home_url() ) ?>"><?php esc_html_e( 'Go to Homepage', 'essu') ?></a>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- .site-main -->

	</div><!-- .content-area -->

<?php get_footer(); ?>