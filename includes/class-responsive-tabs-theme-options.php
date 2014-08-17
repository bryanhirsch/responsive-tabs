<?php
/*
* set up options page for site front page
*
* Considered multiple options for how to do the option page.
*  (1) First, can't integrate into Responsive's Theme Options page -- Responsive sets only one option which is an array defined in its own code,
*      so can't get into that framework without modifying that option array through that code.  Want to leave that intact.
*  (2) Don't want to add to an existing settings page, although this would be easy through the settings API to add a section and fields to it.
*      Very clean: http://codex.wordpress.org/Settings_API
*  (3) Considered theme customizer, but making my java front page items work with that is undoubtedly ugly.  
       http://ottopress.com/2012/theme-customizer-part-deux-getting-rid-of-options-pages/
*  (4) So goal is adding a new page under appearance.  Where the page goes is just determined by the add_xxxx_page function.  Theme puts it under appearance.
*      Considered just using http://themeshaper.com/2010/06/03/sample-theme-options/, but this was deprecated as old and does seem a little clunky.
*          (cf. also, http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/)
*  (5) So, finally opted for the class based approach implemented below derived from   
*      http://codex.wordpress.org/Creating_Options_Pages -- the second example.
*      (Slowly migrating settings to this page one by one as clean up code.
*  
* (6)  Tabs via: http://code.tutsplus.com/tutorials/the-complete-guide-to-the-wordpress-settings-api-part-5-tabbed-navigation-for-your-settings-page--wp-24971 
*  Steps to add a field: (1) add_settings_field; (2) define callback function; (3) add to validation function (must at least pass it through!).
*
*
*/


/*
* include tab class definitions and instantiation statements
*
*/

 

class responsive_tabs_theme_options
{
    /**
     * Start up
     */

	public $theme_options;
     
   	public function __construct()
    	{
		add_action ( 'admin_init', array( $this, 'register_theme_options_setting' ) );
	        add_action ( 'admin_menu', array( $this, 'add_theme_page' ) );
	        add_action ( 'admin_enqueue_scripts', array( $this, 'setup_color_picker') ) ;

	        $this->theme_options = get_option('responsive_tabs_theme_options_array');

	}

      	public function register_theme_options_setting()
    	{
		register_setting(
	            'responsive_tabs_theme_options', // Option group
	            'responsive_tabs_theme_options_array', // Option name
	             array( $this, 'sanitize' ) // Sanitize
        	);
	}

	public function setup_color_picker() 
	{
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'responsive_tabs_login_bar',  get_stylesheet_directory_uri() . '/js/color_picker.js', array( 'wp-color-picker' ), false, true );
	}	

	/**
	* Add options page
	*/
	
	public function add_theme_page()
    	{  
        // This page will be under "Appearance"
        add_theme_page(
            'Theme Front Page Options', 
            'Front Page Options', 
            'manage_options', 
            'responsive_tabs_child_theme_options', 
            array( $this, 'create_admin_page' )
        );
	}

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
    	// reference $theme_options_tabs declared in functions.php
    	global $theme_options_tabs;
    	
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>BBPress Responsive Front Page Options</h2>
           	<?php settings_errors(); ?>
           	<?php
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'tabs';
		// note that if change initial tab default, must also change in line 133
		?>
  		<h2 class="nav-tab-wrapper">
		<?php foreach ($theme_options_tabs as $tab)
			{
			$nav_tab_active = $active_tab == $tab[0] ? 'nav-tab-active' : '';
			echo '<a href="?page=responsive_tabs_child_theme_options&tab=' . $tab[0] . '" class = "nav-tab ' . $nav_tab_active . '">' . $tab[1] . '</a>';
			} 
			?>
             	</h2> 	
            <form method="post" action="options.php">
            
            <?php
            
		/* here invoking options fields from included class corresponding to active tab;
		*  attractive concept , but too late to include or instantiate class here 
		*  because admin_init hook has apparently already fired 
		*/

		settings_fields ( 'responsive_tabs_theme_options') ;   
		do_settings_sections( 'responsive_tabs_' . $active_tab . '_options' );

                submit_button('Save Changes (this tab only)'); 
 
            ?>
            </form>
        </div>
        <?php
    }
	
	public function sanitize($input)
	{

		// find out which tab we are getting sent from (sets variable $tab)
		$referrer = parse_url ($_POST['_wp_http_referer']);
		parse_str ($referrer['query']);
		$active_tab = isset( $tab ) ? $tab : 'tabs';
		// call the validation function from the class for that tab
		$current_class = 'responsive_tabs_' . $active_tab . '_tab'; 

		$options_to_be_saved = $current_class  :: sanitize($input);
//		echo '<br> in final sanitize </br>';
//		var_dump ($options_to_be_saved);
//		return $current_class  :: sanitize($input);
		return $options_to_be_saved;
	}
}

// construct the class!
	$responsive_tabs_theme_options = new responsive_tabs_theme_options ();