<?php
/*
* included in child theme settings within responsive_tabs_child_theme_settings class definition
*
*/

class responsive_tabs_tabs_tab {

	public function __construct()
	{	
    		add_action( 'admin_init', array( $this, 'tabs_tab_init' ) );

		global $responsive_tabs_theme_options;
		$this->options = $responsive_tabs_theme_options->theme_options;
     	}


    	public function tabs_tab_init()
    	{

/*
	* register sections and fields
	*
	*/

        add_settings_section(
            'tabs_settings', // ID
            'Front Page Tabs Settings', // Title
            array( $this, 'tab_settings_info' ), // Callback
            'responsive_tabs_tabs_options' // Page
        ); 

      add_settings_field(
            'tab_titles', 
            'Titles for tabs:', 
            array( $this, 'tab_titles_callback' ), 
            'responsive_tabs_tabs_options', 
            'tabs_settings'
        ); 
       
        add_settings_field(
            'tab_content', 
            'Content for tabs:', 
            array( $this, 'tab_content_callback' ), 
            'responsive_tabs_tabs_options', 
            'tabs_settings'
        ); 

        add_settings_field(
            'tab_active', 
            'Initially active tab:', 
            array( $this, 'tab_active_callback' ), 
            'responsive_tabs_tabs_options', 
            'tabs_settings'
        ); 
        

	
	} // tabs_tab_init()
 
 public function sanitize( $input )
{

       /* note -- have to reference this explicitly here b/c accessing through :: operator */
       global $responsive_tabs_theme_options;
       $new_input = $responsive_tabs_theme_options->theme_options;

      if( isset( $input['tab_titles'] ) )
            $new_input['tab_titles'] = wp_kses_data( $input['tab_titles'] );
      if( isset( $input['tab_content'] ) )
            $new_input['tab_content'] = wp_kses_data( $input['tab_content'] );                    
      if( isset( $input['tab_active'] ) )
            $new_input['tab_active'] = absint( $input['tab_active'] ); 

return $new_input; 
        
}
 

   	
  	public function tab_settings_info()
    	{
    	print "tab_settings_info!";
	}
	
	/*
	* individual field callbacks
	*
	*/
	
	public function tab_titles_callback()
	{
	        printf(
	            '<textarea type="text" cols="80" rows="3"  id="tab_titles" name="responsive_tabs_theme_options_array[tab_titles]">%s </textarea>',
	            isset( $this->options['tab_titles'] ) ? esc_textarea( $this->options['tab_titles']) : ''
	        );
        }
        
	public function tab_content_callback()
	{  
	        printf(
	            '<textarea type="text" cols="80" rows="3"  id="tab_content" name="responsive_tabs_theme_options_array[tab_content]">%s </textarea>',
	            isset( $this->options['tab_content'] ) ? esc_textarea( $this->options['tab_content']) : ''
	        );
	}
	
	public function tab_active_callback()
	{  
	        printf(
	            '<textarea type="text" cols="1" rows="1"  id="tab_active" name="responsive_tabs_theme_options_array[tab_active]">%s </textarea>',
	            isset( $this->options['tab_active'] ) ? esc_textarea( $this->options['tab_active']) : ''

	        );
	}
	



} // close class
if (is_admin())
$responsive_tabs_tabs_tab = new responsive_tabs_tabs_tab();