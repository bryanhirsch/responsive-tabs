<?php
/*
* included in child theme settings within responsive_tabs_child_theme_settings class definition
*
*/

class responsive_tabs_breadcrumbs_tab {

	public function __construct()
	{	
    		add_action( 'admin_init', array( $this, 'breadcrumbs_tab_init' ) );

		global $responsive_tabs_theme_options;
		$this->options = $responsive_tabs_theme_options->theme_options;
     	}


    	public function breadcrumbs_tab_init()
    	{

/*
	* register sections and fields
	*
	*/

        add_settings_section(
            'breadcrumbs_settings', // ID
            'Breadcrumbs Settings', // Title
            array( $this, 'breadcrumb_settings_info' ), // Callback
            'responsive_tabs_breadcrumbs_options' // Page
        ); 
        
        add_settings_field(
            'show_breadcrumbs', 
            'Show breadcrumbs?', 
            array( $this, 'show_breadcrumbs_callback' ), 
            'responsive_tabs_breadcrumbs_options', 
            'breadcrumbs_settings'
        );     
        add_settings_field(
            'category_home', 
            'Tab serving as top of category hierarchy:', 
            array( $this, 'category_home_callback' ), 
            'responsive_tabs_breadcrumbs_options', 
            'breadcrumbs_settings'
        );
        
       add_settings_field(
            'date_home', 
            'Tab serving as top of date hierarchy:', 
            array( $this, 'date_home_callback' ), 
            'responsive_tabs_breadcrumbs_options', 
            'breadcrumbs_settings'
        );
       add_settings_field(
            'author_home', 
            'Tab serving as home link for author listing:', 
            array( $this, 'author_home_callback' ), 
            'responsive_tabs_breadcrumbs_options', 
            'breadcrumbs_settings'
        );
        add_settings_field(
            'search_home', 
            'Tab serving as home link for search listing:', 
            array( $this, 'search_home_callback' ), 
            'responsive_tabs_breadcrumbs_options', 
            'breadcrumbs_settings'
        );
        add_settings_field(
            'tag_home', 
            'Tab serving as home link for tag listing:', 
            array( $this, 'tag_home_callback' ), 
            'responsive_tabs_breadcrumbs_options', 
            'breadcrumbs_settings'
        );
                add_settings_field(
            'page_home', 
            'Tab serving as home link for page listing:', 
            array( $this, 'page_home_callback' ), 
            'responsive_tabs_breadcrumbs_options', 
            'breadcrumbs_settings'
        );
      
      
	
	} // breadcrumbs_tab_init()
 
 public function sanitize( $input )
{

       /* note -- have to reference this explicitly here b/c accessing through :: operator */
       global $responsive_tabs_theme_options;
       $new_input = $responsive_tabs_theme_options->theme_options;

		$new_input['show_breadcrumbs'] = absint( $input['show_breadcrumbs'] ); 
       if( isset( $input['category_home'] ) )
            $new_input['category_home'] = absint( $input['category_home'] );       
   	 if( isset( $input['date_home'] ) )
            $new_input['date_home'] = absint( $input['date_home'] );       
	    if( isset( $input['author_home'] ) )
            $new_input['author_home'] = absint( $input['author_home'] );  
       if( isset( $input['search_home'] ) )
            $new_input['search_home'] = absint( $input['search_home'] ); 
       if( isset( $input['tag_home'] ) )
            $new_input['tag_home'] = absint( $input['tag_home'] ); 
       if( isset( $input['page_home'] ) )
            $new_input['page_home'] = absint( $input['page_home'] );

return $new_input; 
        
}
 

   	
  	public function breadcrumb_settings_info()
    	{
    	print "breadcrumb settings info!";
	}
	
	/*
	* individual field callbacks
	*
	*/
		public function show_breadcrumbs_callback()
	{  

				printf(
            '<input type="checkbox" id="show_breadcrumbs" name="responsive_tabs_theme_options_array[show_breadcrumbs]" value="%s" %s />',
            1, checked( '1',  $this->options['show_breadcrumbs'], false )
        		);
	        
	}


	public function category_home_callback()
	{  
	        printf(
	            '<textarea type="text" cols="1" rows="1"  id="category_home" name="responsive_tabs_theme_options_array[category_home]">%s </textarea>',
	            isset( $this->options['category_home'] ) ? esc_textarea( $this->options['category_home']) : ''

	        );
	}

	public function date_home_callback()
	{  
	        printf(
	            '<textarea type="text" cols="1" rows="1"  id="date_home" name="responsive_tabs_theme_options_array[date_home]">%s </textarea>',
	            isset( $this->options['date_home'] ) ? esc_textarea( $this->options['date_home']) : ''

	        );
	}

	public function author_home_callback()
	{  
	        printf(
	            '<textarea type="text" cols="1" rows="1"  id="author_home" name="responsive_tabs_theme_options_array[author_home]">%s </textarea>',
	            isset( $this->options['author_home'] ) ? esc_textarea( $this->options['author_home']) : ''

	        );
	}

	public function search_home_callback()
	{  
	        printf(
	            '<textarea type="text" cols="1" rows="1"  id="search_home" name="responsive_tabs_theme_options_array[search_home]">%s </textarea>',
	            isset( $this->options['search_home'] ) ? esc_textarea( $this->options['search_home']) : ''

	        );
	}
	public function tag_home_callback()
	{  
	        printf(
	            '<textarea type="text" cols="1" rows="1"  id="tag_home" name="responsive_tabs_theme_options_array[tag_home]">%s </textarea>',
	            isset( $this->options['tag_home'] ) ? esc_textarea( $this->options['tag_home']) : ''

	        );
	}
	public function page_home_callback()
	{  
	        printf(
	            '<textarea type="text" cols="1" rows="1"  id="page_home" name="responsive_tabs_theme_options_array[page_home]">%s </textarea>',
	            isset( $this->options['page_home'] ) ? esc_textarea( $this->options['page_home']) : ''

	        );
	}


} // close class
if (is_admin())
$responsive_tabs_breadcrumbs_tab = new responsive_tabs_breadcrumbs_tab();