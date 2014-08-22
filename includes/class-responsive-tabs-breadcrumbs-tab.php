<?php
/*
* File: class-responsive-tabs-breadcrumbs-tab.php
*			
* Description: sets up settings fields for Breadcrumbs tab in the admin section
*
* @package responsive-tabs
*/

class Responsive_Tabs_Breadcrumbs_Tab {

	public function __construct()	{	
    	add_action( 'admin_init', array( $this, 'breadcrumbs_tab_init' ) );
		global $responsive_tabs_theme_options;
		$this->options = $responsive_tabs_theme_options->theme_options;
  	}

  	public function breadcrumbs_tab_init()	{ // register sections and fields

		add_settings_section(
			'breadcrumbs_settings', // ID
			__( 'Breadcrumbs Settings',  'responsive-tabs' ), // Title
			array( $this, 'breadcrumb_settings_info' ), // Callback
			'responsive_tabs_breadcrumbs_options' // Page
		); 
		  
		add_settings_field(
			'show_breadcrumbs', 
			__( 'Show breadcrumbs?', 'responsive-tabs' ),
			array( $this, 'show_breadcrumbs_callback' ),
			'responsive_tabs_breadcrumbs_options', 
			'breadcrumbs_settings'
		); 
		
		add_settings_field(
			'suppress_bbpress_breadcrumbs', 
			__( 'Suppress bbPress breadcrumbs?', 'responsive-tabs' ),
			array( $this, 'suppress_bbpress_breadcrumbs_callback' ),
			'responsive_tabs_breadcrumbs_options', 
			'breadcrumbs_settings'
		); 
		
		add_settings_field(
			'category_home', 
			__( 'Tab serving as top of category hierarchy:',  'responsive-tabs' ),
			array( $this, 'category_home_callback' ), 
			'responsive_tabs_breadcrumbs_options', 
			'breadcrumbs_settings'
		);
		  
		add_settings_field(
			'date_home', 
			__( 'Tab serving as top of date hierarchy:',  'responsive-tabs' ),
			array( $this, 'date_home_callback' ), 
			'responsive_tabs_breadcrumbs_options', 
			'breadcrumbs_settings'
		 );
		  	
		add_settings_field(
			'author_home', 
			__( 'Tab serving as home link for author listing:',  'responsive-tabs' ),
			array( $this, 'author_home_callback' ), 
			'responsive_tabs_breadcrumbs_options', 
			'breadcrumbs_settings'
		);
		  	
		add_settings_field(
			'search_home', 
			__( 'Tab serving as home link for search listing:', 'responsive-tabs' ), 
			array( $this, 'search_home_callback' ), 
			'responsive_tabs_breadcrumbs_options', 
			'breadcrumbs_settings'
		);
		  
		add_settings_field(
			'tag_home', 
			__( 'Tab serving as home link for tag listing:',  'responsive-tabs' ),
			array( $this, 'tag_home_callback' ), 
			'responsive_tabs_breadcrumbs_options', 
			'breadcrumbs_settings'
		);
		
		add_settings_field(
			'page_home', 
			__( 'Tab serving as home link for page listing:', 'responsive-tabs' ), 
			array( $this, 'page_home_callback' ), 
			'responsive_tabs_breadcrumbs_options', 
			'breadcrumbs_settings'
		);
		
	} // breadcrumbs_tab_init()
 
	public function sanitize( $input ) {

		global $responsive_tabs_theme_options; /* note -- have to reference this explicitly here b/c accessing through :: operator */
		$new_input = $responsive_tabs_theme_options->theme_options;

		$new_input['show_breadcrumbs'] = absint( $input['show_breadcrumbs'] );
		$new_input['suppress_bbpress_breadcrumbs'] = absint( $input['suppress_bbpress_breadcrumbs'] );  

		if( isset( $input['category_home'] ) ) {
			$new_input['category_home'] = absint( $input['category_home'] );
		}       
		if( isset( $input['date_home'] ) ) {
			$new_input['date_home'] = absint( $input['date_home'] );
		}       
		if( isset( $input['author_home'] ) ) {
			$new_input['author_home'] = absint( $input['author_home'] );
		}  
		if( isset( $input['search_home'] ) ) {
			$new_input['search_home'] = absint( $input['search_home'] );
		} 
		if( isset( $input['tag_home'] ) ) {
			$new_input['tag_home'] = absint( $input['tag_home'] );
		} 
		if( isset( $input['page_home'] ) ) {
			$new_input['page_home'] = absint( $input['page_home'] );
		}

		return $new_input; 

	}
   	
	public function breadcrumb_settings_info() {
		_e( '<p>If you install and activate a leading breadcrumb plugin (<a href="https://wordpress.org/plugins/breadcrumb-navxt/">NavXT</a>, <a href="https://yoast.com/wordpress/plugins/breadcrumbs/">Yoast</a> or <a href="https://wordpress.org/plugins/breadcrumb-trail/">Trail</a>)  , the Responsive Tabs theme will display it appropriately regardless of the settings below.</p>' .
			 '<p>The breadcrumbs built into this theme, while much less flexible than the plugin breadcrumbs, fit well with the tabbed design of the theme and also with the theme-provided search options in the archive pages.' .
			 '<ol>'.
			 	'<li>Click Show Breadcrumbs if you want to show theme breadcrumbs -- this setting is overriden if you install and activate a breadcrumb plugin.</li>' .
			 	'<li>Suppress bbBpress breadcrumbs if you prefer -- you will probably want to use this setting if you are using a breadcrumb plugin that supports bbPress.</li>' .
			 	'<li>Pick the tabs that you want to serve as the top of each of the Wordpress search hierarchies -- this tab will show as "Home" in the theme breadcrumb trail. ' .  
					'For example, if you put the Front Page Category List widget under tab 0, you would probably wish to set tab 0 (left most tab) as the top of the category hiearchy.' . 
					'The category hierarchy breadcrumb shows on the Category Archive page and on single post pages.' . 			
			'</ol>'.
			'<p> Visit <a href="http://willbrownsberger.com">WillBrownsberger.com</a> to see the theme breadcrumbs implemented.</p>'			    	
    		, 'responsive-tabs' 
		);
	
	}
	
	/*
	* individual field callbacks
	*
	*/
	public function show_breadcrumbs_callback() {  
		printf('<input type="checkbox" id="show_breadcrumbs" name="responsive_tabs_theme_options_array[show_breadcrumbs]" value="%s" %s />',
			1, checked( '1',  $this->options['show_breadcrumbs'], false )
  		);
	}

	public function suppress_bbpress_breadcrumbs_callback() {  
		printf('<input type="checkbox" id="suppress_bbpress_breadcrumbs" name="responsive_tabs_theme_options_array[suppress_bbpress_breadcrumbs]" value="%s" %s />',
			1, checked( '1',  $this->options['suppress_bbpress_breadcrumbs'], false )
  		);
	}

	public function category_home_callback() {  
  		printf('<textarea type="text" cols="1" rows="1"  id="category_home" name="responsive_tabs_theme_options_array[category_home]">%s </textarea>',
			isset( $this->options['category_home'] ) ? esc_textarea( $this->options['category_home']) : ''
	  );
	}

	public function date_home_callback() {  
		printf('<textarea type="text" cols="1" rows="1"  id="date_home" name="responsive_tabs_theme_options_array[date_home]">%s </textarea>',
			isset( $this->options['date_home'] ) ? esc_textarea( $this->options['date_home']) : ''
		);
	}

	public function author_home_callback() {  
		printf('<textarea type="text" cols="1" rows="1"  id="author_home" name="responsive_tabs_theme_options_array[author_home]">%s </textarea>',
			isset( $this->options['author_home'] ) ? esc_textarea( $this->options['author_home']) : ''
		);
	}

	public function search_home_callback() {  
		printf('<textarea type="text" cols="1" rows="1"  id="search_home" name="responsive_tabs_theme_options_array[search_home]">%s </textarea>',
			isset( $this->options['search_home'] ) ? esc_textarea( $this->options['search_home']) : ''
		);
	}
	
	public function tag_home_callback() {  
		printf('<textarea type="text" cols="1" rows="1"  id="tag_home" name="responsive_tabs_theme_options_array[tag_home]">%s </textarea>',
			isset( $this->options['tag_home'] ) ? esc_textarea( $this->options['tag_home']) : ''
	  );
	}
	
	public function page_home_callback() {  
  		printf('<textarea type="text" cols="1" rows="1"  id="page_home" name="responsive_tabs_theme_options_array[page_home]">%s </textarea>',
			isset( $this->options['page_home'] ) ? esc_textarea( $this->options['page_home']) : ''
		);
	}

} // close class

if (is_admin()) {
	$responsive_tabs_breadcrumbs_tab = new Responsive_Tabs_Breadcrumbs_Tab ();
}