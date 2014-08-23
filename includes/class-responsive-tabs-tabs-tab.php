<?php
/*
* File: class-responsive-tabs-tabs-tab.php
*			
* Description: sets up settings fields for Tabs tab in the admin section
*
* @package responsive-tabs
*/

/* assure that will die if accessed directly */ 
defined( 'ABSPATH' ) or die( "Unauthorized direct script access." );

class Responsive_Tabs_Tabs_Tab {

	public function __construct()	{	
		add_action( 'admin_init', array( $this, 'tabs_tab_init' ) );
		global $responsive_tabs_theme_options; // class 
		$this->options = $responsive_tabs_theme_options->theme_options;
	}

	public function tabs_tab_init() { // register sections and fields

		add_settings_section(
			'tabs_settings', // ID
			__( 'Front Page Tabs Settings', 'responsive-tabs' ), // Title
			array( $this, 'tab_settings_info' ), // Callback
			'responsive_tabs_tabs_options' // Page
		); 
		
		add_settings_field(
			'tab_titles', 
			__( 'Titles for tabs:', 'responsive-tabs' ), 
			array( $this, 'tab_titles_callback' ), 
			'responsive_tabs_tabs_options', 
			'tabs_settings'
		); 
		 
		add_settings_field(
			'tab_content', 
			__( 'Content for tabs:', 'responsive-tabs' ), 
			array( $this, 'tab_content_callback' ), 
			'responsive_tabs_tabs_options', 
			'tabs_settings'
		); 
		
		add_settings_field(
			'tab_active', 
			__( 'Initially active tab:', 'responsive-tabs' ), 
			array( $this, 'tab_active_callback' ), 
			'responsive_tabs_tabs_options', 
			'tabs_settings'
		); 
	
	} // tabs_tab_init()
 
	
	public function sanitize( $input ) {

   	/* note -- have to reference this explicitly here b/c accessing through :: operator */
   	global $responsive_tabs_theme_options;
		$new_input = $responsive_tabs_theme_options->theme_options;

      if( isset( $input['tab_titles'] ) ) {
            $new_input['tab_titles'] = strip_tags( $input['tab_titles'] );
      }
      if( isset( $input['tab_content'] ) ) {
            $new_input['tab_content'] = strip_tags( $input['tab_content'] );
      }                    
      if( isset( $input['tab_active'] ) ) {
            $new_input['tab_active'] = absint( $input['tab_active'] );
      } 

		return $new_input; 
        
	}
   	
  	public function tab_settings_info()	{
    	_e( 	'<h4>Overview of Responsive Tabs</h4>
    			<p>The Responsive Tabs theme gives you great structural flexibility in defining and redefining your front page content. 
    			Visit <a href="http://twowayconstituentcommunication.com">twowayconstituentcommunication.com</a> for a simple example of this theme in action.  
    			Visit <a href = "http://WillBrownsberger.com">WillBrownsberger.com</a> for a more fully-developed implementation of this theme.  
    			Please feel free to email <a href="mailto: will@twowayconstituentcommunication.com">will@twowayconstituentcommunication.com</a> with any questions.</a></p>
				<h4>Basic Setup</h4>    		  	
    		  	<p>The basic steps in setting up your front page are straightforward if you are familiar with using Wordpress widgets and creating Wordpress posts and pages:</p>
    		  	<ol>
    		  		<li>Choose some logical titles for tabs on your front page. You can have as many tabs as you want, but if you have too many, the tab line will look cluttered.</li>
    		  		<li>Enter the titles you want, separated by commas, in the "Titles for tabs" field below, like so: <br />
    		  		<code>My Favorites, My Latest Posts, My Special Post</code></li>
    		  		<li>Then, in the same order, separated by commas, in "Content for tabs", enter the content you want to correspond to each tab, like so:<br /> 
    		  		<code>home_widget_1, latest_posts, 523 <br /></code>
    		  		Using the example entries, you would have a first tab called My Favorites that would show what you put into the Widgets area called home_widget_1, a second tab showing latest posts, and a third tab titled My Special Post showing the content of post #523. </li>
    		  		<li>Decide which tab you want people to land on initially and enter the number for that tab.  The numbers run from left to right.  The left-most tab is number 0 and that is the default.  The numbers only show in the URL that you go to when you click a tab.</li>
    		  		<li><em>Save Changes</em></li>
    		  		<li>Once you have your basic structure in place here, you can choose header images, header text, colors, fonts, etc. under Appearance>Customize.</li>
    		  	</ol>'   , 'responsive-tabs');
    	_e( 	'<h4>More about Content Options in Responsive Tabs</h4>
    	<p>For the content, you have the following options:</p>
    		  	<ol>
    		  		<li><code>latest_posts</code> -- the tab will display your latest posts -- the classic Wordpress starting point.</li>
    		  		<li><em>any</em> widget area.  We recommend using one or more of the seven home widgets -- refer to them like so: <code>home_widget_x</code>, where x is a number from 1 to 7.  Under Appearance>Widgets, you can populate these areas with widgets that will show under tabs as you choose.<br />
    		  			 <em><strong>home_widget_1 is special -- widgets in home widget area 1 will show as rows of tiles in desktop view but will reshuffle into a column in mobile view. Populate it with 10 or 15 copies of the Front Page Post Summary widget to create a newspaper front page look that features your favorite posts.</strong></em></li>
    		  		<li><em>any</em> post or page -- just type the id number (<code>123</code>) of the post or page and the content will show under the tab.  To get the id # for any post or page, just look at the edit link at the bottom of the content in front end view.  If you are editing the content, the ID number appears in the URL of your browser.</li>
    		  		<li><em>any</em> shortcode from any installed Wordpress plugin -- for example, the shortcode for<br /> 
    		  			&raquo; a <a href="http://www.nextgen-gallery.com/nextgen-gallery-shortcodes/" target = "_blank">NextGen Gallery</a> -- <code>ngg_images gallery_ids="1" display_type="photocrati-nextgen_basic_slideshow" exclusions="4,6" gallery_width="600" gallery_height="400"</code>,<br /> 
    		  			&raquo; a <a href="http://tablepress.org/documentation/"  target = "_blank">TablePress table</a> -- <code>table id=1 alternating_row_colors=false column_widths="40px|50px|30px|40px" /"</code>or<br />
    		  			&raquo; a <a href="http://codex.bbpress.org/shortcodes/"  target = "_blank">bbPress forum</a> -- <code>bbp-single-forum id=32</code>.</br>
    		  		    <em><strong>Do not put brackets around the shortcode!  We will bracket the shortcode automatically. Spaces and quotes are OK within a shortcode tab definition, but commas may not appear in a shortcode -- they are reserved for separating entries. </strong></em></li>
    		  	</ol>'   , 'responsive-tabs');
   }
	
	/*
	* individual field callbacks
	*
	*/
	
	public function tab_titles_callback()	{
     printf(
         '<textarea type="text" cols="80" rows="3"  id="tab_titles" name="responsive_tabs_theme_options_array[tab_titles]">%s </textarea>',
         isset( $this->options['tab_titles'] ) ? esc_textarea( $this->options['tab_titles'] ) : ''
     );
   }
        
	public function tab_content_callback()	{  
     printf(
         '<textarea type="text" cols="80" rows="3"  id="tab_content" name="responsive_tabs_theme_options_array[tab_content]">%s </textarea>',
         isset( $this->options['tab_content'] ) ? esc_textarea( $this->options['tab_content'] ) : ''
     );
	}
	
	public function tab_active_callback() {  
     printf(
         '<textarea type="text" cols="1" rows="1"  id="tab_active" name="responsive_tabs_theme_options_array[tab_active]">%s </textarea>',
         isset( $this->options['tab_active'] ) ? esc_textarea( $this->options['tab_active'] ) : ''

     );
	}
	
} // close class

if ( is_admin() ) {
	$responsive_tabs_tabs_tab = new Responsive_Tabs_Tabs_Tab();
}