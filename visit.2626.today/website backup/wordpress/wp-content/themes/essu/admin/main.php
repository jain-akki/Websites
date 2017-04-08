<?php
get_template_part('/admin/options');
load_theme_textdomain( 'essu', get_template_directory() . '/languages' );

global $essu_theme;
$essu_theme = new essu_theme();

class essu_theme{

	var $title;
	var $name;
	var $turl;
	var $options;

	function essu_theme(){
		$this->title = esc_html__( 'Essu Theme Settings','essu' );
		$this->name = get_class( $this );
		$this->turl = esc_url( get_template_directory_uri() );

		$this->options = $this->get_options();
		if(!get_option($this->name)) $this->set_default_options();

		add_action('admin_bar_menu', array(&$this, 'add_toolbar_items'), 100);
		add_action('admin_menu', array(&$this, 'action_add_theme_admin'), 1);
		add_action('wp_ajax_of_ajax_post_action', array(&$this, 'ajax_callback'));
	}

	function action_add_theme_admin(){
	
		$page = add_theme_page($this->title, $this->title, "edit_theme_options", $this->name, array(&$this, "admin_page_main"), 59);
		add_action("admin_print_styles-$page", array(&$this, "admin_styles"));
		
		foreach($this->options as $slug=>$v) if($slug!="main"){
			$title=isset($v['title']) ? $v['title'] : $slug;
			add_theme_page($this->name, $title, $title, "edit_theme_options", $this->name."_".$slug, array(&$this, "admin_page_".$slug));
		}
	}
	
	function add_toolbar_items($admin_bar){
		$admin_bar->add_menu( array(
			'id'    => $this->name,
			'parent' => 'site-name',
			'title' => $this->title,
			'href'  => esc_url(admin_url('themes.php?page='.$this->name.'')),
		));
	}
	
	function admin_page_main(){
		$page='main'; 
		require_once get_template_directory() . '/admin/interface.php';
	}
	
	function admin_styles(){
	
		$ver = kktfwp_themeData();
	
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_style('kk-admin-style', $this->turl."/admin/css/style.css");
		wp_enqueue_style('kk-color-picker', $this->turl."/admin/css/colorpicker.css");
		wp_enqueue_style('kk-simple-slider', $this->turl."/admin/css/simple-slider.css");		
		
		wp_enqueue_script('kk-theme-js', $this->turl.'/admin/js/jquery.admin.js', false, $ver, false);
		wp_enqueue_script('kk-jquery-input-mask', $this->turl.'/admin/js/jquery.maskedinput-1.2.2.js', false, $ver, false);
		wp_enqueue_script('kk-color-picker', $this->turl.'/admin/js/jquery.colorpicker.js', false, $ver, false);
		wp_enqueue_script('kk-ajaxupload', $this->turl.'/admin/js/jquery.ajaxupload.js', false, $ver, false);
		wp_enqueue_script('kk-simle-slider', $this->turl.'/admin/js/jquery.simpleslider.min.js', false, $ver, false);
		
		$kk_data = array(
		  'ajaxurl' => admin_url('admin-ajax.php'),
		);		
		
		wp_localize_script( 'kk-theme-js', 'kk_ajax_data', $kk_data );
		
	}


	function get_options(){
	
		$options=theme_options_array();

		foreach($options as $page=>$pdata) if(is_array($pdata))
		
		foreach($pdata as $group=>$gdata) if(is_array($gdata))
		
		foreach($gdata as $section=>$sdata) if(is_array($sdata))
		
		foreach($sdata as $id=>$v) if(is_array($v))
			
		$options[$page][$group][$section][$id]['val']=get_option($this->name."_".$id);

		return $options;
	}
  
	function set_default_options(){
	
		update_option($this->name, $this->title);

		foreach($this->options as $page=>$pdata) if(is_array($pdata))
		
		foreach($pdata as $group=>$gdata) if(is_array($gdata))
		
		foreach($gdata as $section=>$sdata) if(is_array($sdata))
		
		foreach($sdata as $id=>$v) if(is_array($v)) if (isset($v['std']))

		update_option( $this->name."_".$id, $v['std'] );
	}
		
	function validate_options($opts=null){
		if(!isset($opts)) $opts=$this->options;
		return $opts;
	}

	function ajax_callback() {
	
		if( current_user_can( 'edit_theme_options' ) ) {
			global $wpdb;

			switch($_POST['type']){
			
				case 'upload':
				$clickedID = $_POST['data'];
				$filename = $_FILES[$clickedID];
				$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 

				$override['test_form'] = false;
				$override['action'] = 'wp_handle_upload';
				$uploaded_file = wp_handle_upload($filename,$override);

				$upload_tracking[] = $clickedID;
				update_option($clickedID, $uploaded_file['url']);

				if(!empty($uploaded_file['error'])){			
					echo 'Upload Error: '.$uploaded_file['error'];				
				}else{			
					echo $uploaded_file['url'];				
				}
				
				break;

				case 'image_reset':			
				$wpdb->query( 
					$wpdb->prepare( 
						"
						DELETE FROM $wpdb->options
						WHERE option_name LIKE %s
						",
						$_POST['data'] 
						)
				);
				break;

				case 'reset':
				$this->set_default_options();
				break;

				case 'save':
				foreach(wp_parse_args($_POST['data']) as $id=>$v) update_option($id, $v);
				//$this->options = $this->set_options();
				break;
			}			
		}
		
		die();
	}
}

function siteoptions_uploader_function( $id, $std, $mod ){
	$uploader = '';
	$upload = get_option($id);

	if($mod != 'min') { 
		$val = $std;
		if(get_option($id) != "") $val=get_option($id);
		$uploader .= '<input class="of-input" name="'.$id.'" id="'.$id.'_upload" type="text" value="'.$val.'" />';
	}

	$uploader .= '<div class="upload_button_div"><span class="button image_upload_button" id="'.$id.'">Upload Image</span>';

	if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}

	$uploader .= '<span class="button image_reset_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
	$uploader .='</div>';
	$uploader .= '<div class="clear"></div>';
	
	if(!empty($upload)){
		$uploader .= '<a class="of-uploaded-image" href="'. $upload . '">';
		$uploader .= '<img class="of-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
		$uploader .= '</a>';
	}
	
	$uploader .= '<div class="clear"></div>';
	
	echo $uploader;
}

?>
