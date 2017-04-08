<?php
add_filter( 'rwmb_meta_boxes', 'kktfwp_meta_boxes');


function kktfwp_get_envira_galleries() {

	if ( class_exists( 'Envira_Gallery' ) || class_exists( 'Envira_Gallery_Lite' ) ) {				
			
	$class = ( class_exists( 'Envira_Gallery' ) ? new Envira_Gallery() : new Envira_Gallery_Lite() );
	
	$instance = $class::get_instance();
	$galleries = $instance->get_galleries( false, true );
	$results = array();
	 foreach ( ( array ) $galleries as $gallery ) {
			// Add gallery to results
			$results[esc_attr($gallery['id'])] = $gallery['config']['title'];
		}		
		return $results;
		
	} else {
	
		return array('null' => 'Envira Gallery is not installed or activated');	
		
	}
}

function kktfwp_meta_boxes( $meta_boxes )
{
	/**
	 * Prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = '_kktfwp_';

	$meta_boxes[] = array(
		'title' => esc_html__( 'Page Settings', 'essu' ),
		'pages'  => array ( 'page' ),
		'id' => 'kktfwp-page-settings',
		'context' => 'normal',
		'priority' => 'high',

		'fields' => array(
			array(
				'name'             => esc_html__( 'Title description', 'essu' ),
				'id'               => "{$prefix}description",
				'type'             => 'wysiwyg',
				'options'          => array (
										'media_buttons' => false,
										'textarea_rows' => 6,	
									)
			),
			array(
				'name'             => esc_html__( 'Filter settings', 'essu' ),
				'desc'             => esc_html__( 'Check this option to disable filtering.', 'essu' ),
				'id'               => "{$prefix}filter",
				'class'			   => 'kktfwp-filter-wrapper',
				'type'             => 'checkbox',
				'std'			   => 0
			),			
			array(
				'name'             => esc_html__( 'Portfolio Columns', 'essu' ),
				'desc'             => esc_html__( 'Set the number of columns', 'essu' ),
				'id'               => "{$prefix}portfolio_columns",
				'class'			   => 'kktfwp-columns-wrapper',
				'type'             => 'select',
				'options'          => array (
										'2' => esc_html__( 'Two columns', 'essu' ),
										'3' => esc_html__( 'Three columns', 'essu' ),
										'4' => esc_html__( 'Four columns', 'essu' ),
									),
				'std'			   => '3'
			),	
			array(
				'name'             => esc_html__( 'Gaps between columns', 'essu' ),
				'desc'             => esc_html__( 'Check this option to add spaces between projects.', 'essu' ),
				'id'               => "{$prefix}gaps",
				'class'			   => 'kktfwp-gaps-wrapper',
				'type'             => 'checkbox',
				'std'			   => 0
			),	
			array(
				'name'             => esc_html__( 'Page Preloading Effect', 'essu' ),
				'id'               => "{$prefix}preloader",
				'class'			   => 'kktfwp-preloader',
				'type'             => 'select',
				'options'			=> array (				
										'global' => esc_html__( 'Use global setting', 'essu' ),
										'enable' => esc_html__( 'Enable on this page', 'essu' ),
										'disable' => esc_html__( 'Disable on this page', 'essu' ),
									),
				'std'			   => 'global'
			),			
		)			
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Project Settings', 'essu' ),
		'pages'  => array ( 'kktfwp_portfolio' ),
		'id' => 'kktfwp-project-settings',
		'context' => 'normal',
		'priority' => 'high',

		'fields' => array(
			array(
				'name'             => esc_html__( 'Mark this project as featured', 'essu' ),
				'desc'             => esc_html__( 'By enabling this option your project will be displayed on the homepage', 'essu' ),
				'id'               => "{$prefix}featured",
				'type'             => 'checkbox',
				'std'			   => 0
			),			
						
			array(
					'name'             => esc_html__( 'Back button', 'essu' ),
					'desc'			   => esc_html__( 'The back button (in navigation) will be linked to this page', 'essu' ),
					'id'               => "{$prefix}backBtn",
					'class'			   => 'back_wrapper',
					'type'             => 'post',
					'post_type' => 'page',
					'field_type' => 'select',
					'query_args' => array(
						'post_status' => 'publish',
						'posts_per_page' => '-1',
						'meta_query' => array(
							array(
								'key' => '_wp_page_template',
								'value' => 'template-portfolio.php', // template name as stored in the dB
							)
						)
					),
					'std' => ''
			),			
									
			array(
				'name'             => esc_html__( 'Project description position', 'essu' ),
				'desc'             => esc_html__( 'Select where the project description will appear. Enter the project description to the WordPress editor area (on top of the page)', 'essu' ),
				'id'               => "{$prefix}layout",
				'type'             => 'select',
				'options'			=> array (				
										'left' => esc_html__( 'Left', 'essu' ),
										'right' => esc_html__( 'Right', 'essu' ),
										'top' => esc_html__( 'Top', 'essu' ),
										'top-halfs' => esc_html__( 'Top (2 columns)', 'essu' ),
									),
				'std'			   => 'left'
				
			),
			
			array(
				'name'             => esc_html__( 'Visibility of the description', 'essu' ),
				'id'               => "{$prefix}visibility",
				'type'             => 'select',
				'class'			   => 'kktfwp-visibility-wrapper',
				'options'			=> array (				
										'is-sticky' => esc_html__( 'Sticky', 'essu' ),
										'is-inview' => esc_html__( "Hide if isn't in viewport", 'essu' ),
										'default' => esc_html__( 'Default', 'essu' )
									),
				'std'			   => 'is-inview'
				
			),
			
			array(
				'name'             => esc_html__( 'Project type', 'essu' ),
				'desc'             => esc_html__( 'Set the type of the portfolio item.', 'essu' ),
				'id'               => "{$prefix}type",
				'type'             => 'select',
				'options'			=> array (				
										'images' => esc_html__( 'Plain images', 'essu' ),
										'videos' => esc_html__( 'Videos', 'essu' ),
										'gallery' => esc_html__( 'Gallery', 'essu' ),
									),
				'std'			   => 'images'
				
			),
			
			array(
				'name'             => esc_html__( 'Number of columns', 'essu' ),
				'desc'             => esc_html__( 'Determines the images columns number.', 'essu' ),
				'id'               => "{$prefix}img_layout",
				'type'             => 'select',
				'class'			   => 'kktfwp-img-layout',
				'options'			=> array (				
										'1' => esc_html__( 'One column', 'essu' ),
										'2' => esc_html__( 'Masonry two columns', 'essu' ),
										'3' => esc_html__( 'Masonry three columns', 'essu' ),
									),
				'std'			   => '1'
				
			),
			
			array(
				'name'             => esc_html__( 'Select a gallery', 'essu' ),
				'desc'             => esc_html__( 'Choose one of your Envira galleries.', 'essu' ),
				'id'               => "{$prefix}envira",
				'class'			   => 'kktfwp-envira-wrapper',
				'type'             => 'select',
				'options'			=> kktfwp_get_envira_galleries(),
				'std'			   => ''
				
			),
			
			array(
				'name'             => esc_html__( 'Video link', 'essu' ),
				'desc'             => esc_html__( 'Enter or paste the link to video.', 'essu' ),
				'id'               => "{$prefix}projvideo",
				'class'			   => 'kktfwp-video-wrapper',
				'type'             => 'oembed',
				'clone'			   => true
				
			),
			
			array(
					'name'             => esc_html__( 'Project images', 'essu' ),
					'desc'			   => esc_html__( 'Select or upload images. Use drag and drop if you need to reorder. Use Cmd/Ctrl/Shift to select multiple images.', 'essu' ),
					'id'               => "{$prefix}projimg",
					'class'			   => 'projimg_wrapper',
					'type'             => 'image_advanced',
					'max_file_uploads' => 0
			),
			
			array(
				'name'             => esc_html__( 'Page Preloading Effect', 'essu' ),
				'id'               => "{$prefix}preloader",
				'class'			   => 'kktfwp-preloader',
				'type'             => 'select',
				'options'			=> array (				
										'global' => esc_html__( 'Use global setting', 'essu' ),
										'enable' => esc_html__( 'Enable on this page', 'essu' ),
										'disable' => esc_html__( 'Disable on this page', 'essu' ),
									),
				'std'			   => 'global'
			),	
		)
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Portfolio Attributes', 'essu' ),
		'pages'  => array ( 'page' ),
		'id' => 'kktfwp-homepage-settings',
		'context' => 'side',
		'priority' => 'low',

		'fields' => array(
			array(
				'name'             => esc_html__( 'Portfolio displays', 'essu' ),
				'id'               => "{$prefix}homeStyle",
				'type'             => 'select',
				'options'          => array (
									'featured' => esc_html__( 'Featured Projects', 'essu' ),
									'latest' => esc_html__( 'Latest Projects', 'essu' ),
								),
				'std'              => 'latest'
			),
		)
	);

	return $meta_boxes;
}