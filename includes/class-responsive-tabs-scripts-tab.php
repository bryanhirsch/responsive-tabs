<?php
/*
* included in child theme settings within responsive_tabs_child_theme_settings class definition
*
*/

class responsive_tabs_scripts_tab {

	public function __construct()
	{	
    		add_action( 'admin_init', array( $this, 'scripts_tab_init' ) );

		global $responsive_tabs_theme_options;
		$this->options = $responsive_tabs_theme_options->theme_options;
     	}


    	public function scripts_tab_init()
    	{

/*
	* register sections and fields
	*
	*/

        add_settings_section(
            'scripts_settings', // ID
            'CSS/Scripts', // Title
            array( $this, 'script_settings_info' ), // Callback
            'responsive_tabs_scripts_options' // Page
        ); 

      add_settings_field(
            'css_header', 
            'CSS for Header:', 
            array( $this, 'css_header_callback' ), 
            'responsive_tabs_scripts_options', 
            'scripts_settings'
        ); 

      add_settings_field(
            'scripts_header', 
            'CSS/Scripts for Header:', 
            array( $this, 'scripts_header_callback' ), 
            'responsive_tabs_scripts_options', 
            'scripts_settings'
        ); 
       
        add_settings_field(
            'scripts_footer', 
            'Scripts for Footer:', 
            array( $this, 'scripts_footer_callback' ), 
            'responsive_tabs_scripts_options', 
            'scripts_settings'
        ); 
	
	} // tabs_tab_init()
 
 public function sanitize( $input )
{
        /* note -- have to reference this explicitly here b/c accessing through :: operator */
	global $responsive_tabs_theme_options;
	$new_input = $responsive_tabs_theme_options->theme_options;

      if( isset( $input['css_header'] ) )
            $new_input['css_header'] = wp_kses_data( $input['css_header'] );

	/* note -- not sanitizing this admin input */

      if( isset( $input['scripts_header'] ) )
            $new_input['scripts_header'] = $input['scripts_header'] ;

      if( isset( $input['scripts_footer'] ) )
            $new_input['scripts_footer'] = $input['scripts_footer'];                    

	return $new_input;         
}
 

   	
  	public function script_settings_info()
    	{
    	print "Enter Scripts and CSS Here!";
	}
	
	/*
	* individual field callbacks
	*
	*/

	public function css_header_callback()
	{
	        printf(
	            '<textarea type="text" cols="80" rows="20"  id="css_header" name="responsive_tabs_theme_options_array[css_header]">%s </textarea>',
	            isset( $this->options['css_header'] ) ? esc_textarea( $this->options['css_header']) : ''
	        );
        }

	
	public function scripts_header_callback()
	{
	        printf(
	            '<textarea type="text" cols="80" rows="20"  id="scripts_header" name="responsive_tabs_theme_options_array[scripts_header]">%s </textarea>',
	            isset( $this->options['scripts_header'] ) ? esc_textarea( $this->options['scripts_header']) : ''
	        );
        }
        
	public function scripts_footer_callback()
	{  
	        printf(
	            '<textarea type="text" cols="80" rows="20"  id="scripts_footer" name="responsive_tabs_theme_options_array[scripts_footer]">%s </textarea>',
	            isset( $this->options['scripts_footer'] ) ? esc_textarea( $this->options['scripts_footer']) : ''
	        );
	}
	

	

} // close class
if (is_admin())
$responsive_tabs_scripts_tab = new responsive_tabs_scripts_tab();