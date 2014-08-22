<?php
/*
* File: class-responsive-tabs-scripts-tab.php
*			
* Description: sets up settings fields for CSS/Scripts tab in the admin section
*
* @package responsive-tabs
*/

class Responsive_Tabs_Scripts_Tab {

	public function __construct()	{	
    	add_action( 'admin_init', array( $this, 'scripts_tab_init' ) );
		global $responsive_tabs_theme_options;
		$this->options = $responsive_tabs_theme_options->theme_options;
	}

  	public function scripts_tab_init() 	{ // register sections and fields
	
		add_settings_section(
		   'scripts_settings', // ID
		   'CSS/Scripts', // Title
		   array( $this, 'script_settings_info' ), // Callback
		   'responsive_tabs_scripts_options' // Page
		); 
		
		add_settings_field(
		   'css_header', 
		   __( 'CSS for Header:', 'responsive-tabs' ), 
		   array( $this, 'css_header_callback' ), 
		   'responsive_tabs_scripts_options', 
		   'scripts_settings'
		); 
		
		add_settings_field(
		   'scripts_header', 
		   __( 'Scripts for Header:', 'responsive-tabs' ),
		   array( $this, 'scripts_header_callback' ), 
		   'responsive_tabs_scripts_options', 
		   'scripts_settings'
		); 
		 
		add_settings_field(
		   'scripts_footer', 
		   __( 'Scripts for Footer:', 'responsive-tabs' ),
		   array( $this, 'scripts_footer_callback' ), 
		   'responsive_tabs_scripts_options', 
		   'scripts_settings'
		); 

	} // tabs_tab_init()
 
	public function sanitize( $input ) {
        
		global $responsive_tabs_theme_options; /* note -- have to reference this explicitly here b/c accessing through :: operator */
		$new_input = $responsive_tabs_theme_options->theme_options;
	
	   if( isset( $input['css_header'] ) ) {
			$new_input['css_header'] = strip_tags( $input['css_header'] );
		}
		/* note -- not sanitizing this admin input */
	   if( isset( $input['scripts_header'] ) ) {
	      $new_input['scripts_header'] = $input['scripts_header'] ;
		}
		if( isset( $input['scripts_footer'] ) ) {
			$new_input['scripts_footer'] = $input['scripts_footer'];                    
		}
		
		return $new_input;         
	}

  	public function script_settings_info() {
		_e( 	'</p>If you are comfortable with CSS, you can enter styles to override the built-in styles or even the customized styles of the theme. Styles entered here will be echoed in the website header below the theme customization styles.</p>' .
				'<p>You can also enter javascript to be echoed in either the website header or website footer.  These fields are not sanitized in any way, so take care what you put into them.  One good use of the footer script area is to install <a href="http://analytics.google.com">google analytics</a> tracking code.  Just paste the tracking code right in (and save).</p> ' .
				'<p><em><strong>Note: Javacript entered here is not executed for logged-in users.</strong></em> CSS overrides are, however, executed for all users.</p>',
				'responsive-tabs' 
		);	
	}
	
	/*
	* individual field callbacks
	*/

	public function css_header_callback()
	{
	        printf(
	            '<textarea type="text" cols="80" rows="10"  id="css_header" name="responsive_tabs_theme_options_array[css_header]">%s </textarea>',
	            isset( $this->options['css_header'] ) ? esc_textarea( $this->options['css_header']) : ''
	        );
        }

	
	public function scripts_header_callback()
	{
	        printf(
	            '<textarea type="text" cols="80" rows="10"  id="scripts_header" name="responsive_tabs_theme_options_array[scripts_header]">%s </textarea>',
	            isset( $this->options['scripts_header'] ) ? esc_textarea( $this->options['scripts_header']) : ''
	        );
        }
        
	public function scripts_footer_callback()
	{  
	        printf(
	            '<textarea type="text" cols="80" rows="10"  id="scripts_footer" name="responsive_tabs_theme_options_array[scripts_footer]">%s </textarea>',
	            isset( $this->options['scripts_footer'] ) ? esc_textarea( $this->options['scripts_footer']) : ''
	        );
	}
} // close class

if (is_admin()) {
	$responsive_tabs_scripts_tab = new Responsive_Tabs_Scripts_Tab();
}