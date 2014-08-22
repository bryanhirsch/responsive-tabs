<?php
/*
* File: class-responsive-tabs-accordion-tab.php
*			
* Description: sets up settings fields for Accordion tab in the admin section
*
* @package responsive-tabs
*/

class Responsive_Tabs_Accordion_Tab{

	public function __construct()	{	
		add_action( 'admin_init', array( $this, 'accordion_tab_init' ) );
		global $responsive_tabs_theme_options;
		$this->options = $responsive_tabs_theme_options->theme_options;
   }

 	public function accordion_tab_init() { // register section and fields

		add_settings_section(
			'accordion_settings', // ID
			__( 'Accordion settings', 'responsive-tabs' ), // Title
			array( $this, 'accordion_settings_info' ), // Callback
			'responsive_tabs_accordion_options' // Page
		); 
		
		add_settings_field(
			'front_page_accordion_posts', 
			__( 'Front page accordion:', 'responsive-tabs' ), 
			array( $this, 'front_page_accordion_posts_callback' ), 
			'responsive_tabs_accordion_options', 
			'accordion_settings'
		); 
		
		add_settings_field(
			'post_accordion_posts', 
			__( 'Posts accordion:', 'responsive-tabs' ), 
			array( $this, 'post_accordion_posts_callback' ), 
			'responsive_tabs_accordion_options', 
			'accordion_settings'
		); 
		
		add_settings_field(
			'page_accordion_posts', 
			__( 'Non-front pages accordion:', 'responsive-tabs' ), 
			array( $this, 'page_accordion_posts_callback' ), 
			'responsive_tabs_accordion_options', 
			'accordion_settings'
		); 

		add_settings_field(
			'archive_accordion_posts', 
			__( 'Archive listings accordion:', 'responsive-tabs' ), 
			array( $this, 'archive_accordion_posts_callback' ), 
			'responsive_tabs_accordion_options', 
			'accordion_settings'
		);		
		
	} // accordion_tab_init()
 
	public function sanitize( $input ) {
		
		global $responsive_tabs_theme_options;    /* note -- have to reference this explicitly here b/c accessing through :: operator */
		$new_input = $responsive_tabs_theme_options->theme_options;
	
	   if( isset( $input['front_page_accordion_posts'] ) ) {
	   	$new_input['front_page_accordion_posts'] 	= responsive_tabs_clean_post_list( $input['front_page_accordion_posts'] );
	   }
	   if( isset( $input['post_accordion_posts'] ) ) {
	     	$new_input['post_accordion_posts'] 			= responsive_tabs_clean_post_list( $input['post_accordion_posts'] );
		}		
		if( isset( $input['page_accordion_posts'] ) ) {
	   	$new_input['page_accordion_posts'] 			= responsive_tabs_clean_post_list( $input['page_accordion_posts'] );
	   }
  		if( isset( $input['archive_accordion_posts'] ) ) {
	   	$new_input['archive_accordion_posts'] 		= responsive_tabs_clean_post_list( $input['archive_accordion_posts'] );
	   }
		return $new_input; 
	
	}
 

	public function accordion_settings_info() {
		_e( '<h4>Setting up content accordions</h4>' .
			'<p>You can set up an accordion of content at the bottom of the front page, all posts, all archive listings or all non-front pages.  This is a compact way to deliver brief reference content.</p>' . 
			'<p>Just enter the ID numbers for the posts whose content you want to appear in the accordion, like so: <code>325, 11, 98</code>.</p>' . 
			'<p>The accordion will show the titles for the listed posts and the user can expose the post content by clicking the post title.</p> '  .
			'<p>To get the id # for a post, just look at the edit link at the bottom of the content in front end view.  If you are editing the content, the ID number appears in the URL of your browser.</p>' .
			'<p>Note that you can use pages and bbPress topics as well as posts by referring to their ID number in the same way.</p>', 
			'responsive-tabs'
		);	
	}

/*
* individual field callbacks
*
*/

	public function front_page_accordion_posts_callback() {
		printf('<textarea type="text" cols="80" rows="1"  id="front_page_accordion_posts" name="responsive_tabs_theme_options_array[front_page_accordion_posts]">%s </textarea>',
			isset( $this->options['front_page_accordion_posts'] ) ? esc_textarea( $this->options['front_page_accordion_posts']) : ''
		);
	}

	public function post_accordion_posts_callback() {
		printf('<textarea type="text" cols="80" rows="1"  id="post_accordion_posts" name="responsive_tabs_theme_options_array[post_accordion_posts]">%s </textarea>',
			isset( $this->options['post_accordion_posts'] ) ? esc_textarea( $this->options['post_accordion_posts']) : ''
		);
	}

	public function page_accordion_posts_callback() {
		printf('<textarea type="text" cols="80" rows="1"  id="page_accordion_posts" name="responsive_tabs_theme_options_array[page_accordion_posts]">%s </textarea>',
			isset( $this->options['page_accordion_posts'] ) ? esc_textarea( $this->options['page_accordion_posts']) : ''
		);
	} 
	
	public function archive_accordion_posts_callback() {
		printf('<textarea type="text" cols="80" rows="1"  id="archive_accordion_posts" name="responsive_tabs_theme_options_array[archive_accordion_posts]">%s </textarea>',
			isset( $this->options['archive_accordion_posts'] ) ? esc_textarea( $this->options['archive_accordion_posts']) : ''
		);	
	}

} // close class

if ( is_admin() ) {
	$responsive_tabs_accordion_tab = new Responsive_Tabs_Accordion_Tab();
}