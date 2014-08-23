<?php
/*
* File: class-responsive-tabs-theme-options.php
*			
* Description: sets up options page for site front page
*
* Development resources   
*  http://codex.wordpress.org/Creating_Options_Pages
*  http://code.tutsplus.com/tutorials/the-complete-guide-to-the-wordpress-settings-api-part-5-tabbed-navigation-for-your-settings-page--wp-24971 
*  
* @package responsive-tabs
*/
/* assure that will die if accessed directly */ 
defined( 'ABSPATH' ) or die( "Unauthorized direct script access." );

class Responsive_Tabs_Theme_Options {
   	    
	public function __construct() {
		add_action ( 'admin_init', array( $this, 'register_theme_options_setting' ) );
		add_action ( 'admin_menu', array( $this, 'add_theme_page' ) );
		$this->theme_options = get_option('responsive_tabs_theme_options_array');
	}

   public function register_theme_options_setting() {
		register_setting(
	   	'responsive_tabs_theme_options', // Option group
	      'responsive_tabs_theme_options_array', // Option name
	      array( $this, 'sanitize' ) // Sanitize (calls sanitization function for active tab class)
      );
	}
	
	public function add_theme_page()	{  
		// This page will be under "Appearance"
		add_theme_page(
			__( 'Responsive Tabs Front Page Options', 'responsive-tabs' ), 
			__( 'Front Page Options', 'responsive-tabs' ), 
			'edit_theme_options', 
			'responsive_tabs_front_page_options', 
			array( $this, 'create_admin_page' )
		);
	}

	public function create_admin_page() {

	  	// set up tabs defined in array $theme_options_tabs declared in functions.php
	 	global $theme_options_tabs;
	 	
		echo '<div class="wrap">';
			
			settings_errors();
			
			$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'tabs';
	
			echo '<h2 class="nav-tab-wrapper">';
				foreach ( $theme_options_tabs as $tab ) { 
					$nav_tab_active = $active_tab == $tab[0] ? 'nav-tab-active' : '';
					echo '<a href="?page=responsive_tabs_front_page_options&tab=' . $tab[0] . '" class = "nav-tab ' . $nav_tab_active . '">' . $tab[1] . '</a>';
				} 
			echo '</h2>'; 	
	
			echo '<form method="post" action="options.php">';
	
				settings_fields ( 'responsive_tabs_theme_options') ;   
				do_settings_sections( 'responsive_tabs_' . $active_tab . '_options' ); // (note settings sections are instantiated for all tabs at admin_init)
				submit_button( __( 'Save Changes (this tab only)', 'responsive-tabs' )); 
	 
			echo '</form>'.
	  '</div>';
	}
	
	public function sanitize($input)	{
		
		// find out which tab we are getting sent from (sets variable $tab)
		$referrer = parse_url( $_POST['_wp_http_referer'] );
		parse_str( $referrer['query'] );
		$active_tab = isset( $tab ) ? $tab : 'tabs';

		// call the validation function from the class for that tab
		$current_class = 'responsive_tabs_' . $active_tab . '_tab'; 
		$options_to_be_saved = $current_class  :: sanitize( $input );

		return $options_to_be_saved;
	}
}

// construct the class
if ( is_admin () ) {
	$responsive_tabs_theme_options = new Responsive_Tabs_Theme_Options ();
}