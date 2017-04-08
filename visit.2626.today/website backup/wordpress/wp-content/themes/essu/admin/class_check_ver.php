<?php
/**
* Title		: Theme Version Checker
* Description	: Checks for new version of installed theme
* Version	: 1.0
* Author	: Constantine K.
* Author URI	: http://themes.easysite.by/
* License	: WTFPL - http://sam.zoy.org/wtfpl/
**/

if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'kkCheckThemeVer' ) ) {

	class kkCheckThemeVer {

		public $url = 'http://easysite.by/API/check_ver.json';
		public $sign_url = 'https://themeforest.net/sign_in?ref=kotofey';
		public $version;
		public $themeName;
		public $themeId;
		public $logUrl;
		public $interval = 21600; // How often check for new version ( in seconds )

		public function get_HTTP_data() {
		
			$response = wp_remote_get( $this->url );

			if ( ! is_wp_error( $response ) && 200 === $response['response']['code'] ) {			
				$response_body = wp_remote_retrieve_body( $response );	
				$arr = json_decode( $response_body, true );	

				if ( !isset( $arr['themes'][$this->themeName] ) ) return;				
				return $arr;			
			} 
			
			return;

		}
		
		public function __construct() {
		
			if ( !is_admin() ) return;
		
			$themeData = wp_get_theme(get_template());
			$this->version = $themeData->get( 'Version' );
			$this->themeName = $themeData->get( 'Name' );
			
			if ( !apply_filters( 'kkHideUpdateNotice', false ) ) {
			
				add_action( 'admin_notices', array($this, 'print_notice' ));				
			}			
		}
		
		public function print_notice() {		
					
			if ( false === ( $setV = get_transient( 'kkRemoteVersion'.$this->themeName ) ) ) {
			
				 // this code runs when there is no valid transient set					 
				$arr = $this->get_HTTP_data();
				$remoteVer = $arr['themes'][$this->themeName]['ver'];				
				$interval = isset( $arr['interval'] ) ? $arr['interval'] : $this->interval;
				$this->logUrl = isset( $arr['themes'][$this->themeName]['logurl'] ) ? esc_url( $arr['themes'][$this->themeName]['logurl'] ) : $this->logUrl;
				$this->themeId = isset( $arr['themes'][$this->themeName]['id'] ) ? esc_attr( $arr['themes'][$this->themeName]['id'] ) : $this->themeId;
						
				if ( $arr === NULL ) {
				
					$interval = 1200;
					
				}
				
				set_transient( 'kkRemoteVersion'.$this->themeName, $remoteVer, $interval );
				
				if ( $this->logUrl !== NULL ) {				
					set_transient( 'kkLogUrl'.$this->themeName, $this->logUrl, $interval );					
				}
				
				if ( $this->themeId !== NULL ) {				
					set_transient( 'kkthemeId'.$this->themeName, $this->themeId, $interval );					
				}
				
			} else {	
			
				$remoteVer = $setV;
				$this->logUrl = get_transient( 'kkLogUrl'.$this->themeName );
				$this->themeId = get_transient( 'kkthemeId'.$this->themeName );
				
			}	

			// text strings in the code below should not be translatable.
			
			if ( version_compare( $remoteVer, $this->version, '>' ) ) { 
				echo '<div class="updated notice is-dismissible">
						<p><strong>New version of your '. $this->themeName .' theme is available for download.</strong></p>
						<p>Installed version: '.$this->version.'<br>
						Available version: '.$remoteVer. ( !empty( $this->logUrl ) ? ' ( <a href="'.$this->logUrl.'" target="_blank">Changelog</a> )' : '' ).'</p>
						<p>Please,'. ( empty( $this->themeId ) ? ' login to your <a href="'. $this->sign_url .' " target="_blank" >ThemeForest account</a>' : 'go to the <a href="https://themeforest.net/item/i/'.$this->themeId.'?ref=kotofey&utm_source=wordpress%20dashboard&utm_medium=notice" target="_blank"> item\'s page</a>' ) .'  and download latest version. Don\'t forget to renew support if needed.</p>
					  </div>';			
			}	
		}
	}
	
	new kkCheckThemeVer;
}
?>