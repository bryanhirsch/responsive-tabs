<?php
/*
* File: responsive-tabs-customization.php
*			
* Handles all theme options through theme customizer interface (excepting structural options -- tabs, accordions, custom css/scripts and breadcrumbs)
*
* @package responsive-tabs
*/

$font_family_array = array (  
	'Arial, "Helvetica Neue", Helvetica, sans-serif' 														=> 'Arial',
	'"Arial Black", "Arial Bold", Gadget, sans-serif'														=> 'Arial Black',
	'"Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace' 			=> 'Courier',
	'Copperplate, "Copperplate Gothic Light", fantasy' 													=> 'Copperplate',
	'Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif' => 'Garamond',
	'Georgia, Times, "Times New Roman", serif' 																=> 'Georgia',
	'"Lucida Bright", Georgia, serif' 																			=> 'Lucida Bright',
	'Rockwell, "Courier Bold", Courier, Georgia, Times, "Times New Roman", serif' 				=> 'Rockwell',
	'"Brush Script MT", cursive' 																					=> 'Script',
	'TimesNewRoman, "Times New Roman", Times, Baskerville, Georgia, serif' 							=> 'Times New Roman',
	'Verdana, Geneva, sans-serif' 																				=> 'Verdana'
);

$font_size_array = array (
	'12px'	=> '12px',
	'14px'	=> '14px',
	'16px'	=> '16px',
	'17px'	=> '17px',
	'18px'	=> '18px',
	'24px'	=> '24px',
	'32px'	=> '32px',
	'40px'	=> '40px',
	'44px'	=> '44px',
	'52px'	=> '52px',
	'60px'	=> '60px',
);

$landing_tab_options_array = array (
	'1'		=> '1',
	'2'		=> '2',	
	'3'		=> '3',
	'4'		=> '4',
	'5'		=> '5',
	'6'		=> '6',
	'7'		=> '7',
	'8'		=> '8',
	'9'		=> '9',
	'10'		=> '10',
	'11'		=> '11',
	'12'		=> '12',
	'13'		=> '13',
	'14'		=> '14',
	'15'		=> '15',
);

$contextual_help_links = array (
	'tab_titles'			=> 'http://twowayconstituentcommunication.com/setup-notes-for-responsive-tabs-theme/',
	'front_page_accordion' 	=>'http://twowayconstituentcommunication.com/setup-notes-for-responsive-tabs-theme/#accordion',
);

							
function responsive_tabs_theme_customizer( $wp_customize ) {

	global $font_family_array;
	global $font_size_array;
	global $landing_tab_options_array;


	/* create custom call back for text area */
	class Responsive_Tabs_Textarea_Control extends WP_Customize_Control { // compare http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer/
		
		public $type = 'textarea';
 		public function render_content() { 
 			global $contextual_help_links;?>
 			<?php $help_link = array_key_exists( $this->id, $contextual_help_links ) > '' ? '<a href="' . $contextual_help_links[$this->id] . '" target = "_blank">' . __( '(Help)', 'responsive-tabs' ) . '</a>' : ''; ?>
			<label>
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
					<?php echo $help_link; ?>
				</span>
				<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
 
		<?php }
	}
	
	class Responsive_Tabs_Text_Input_Control extends WP_Customize_Control { 
		
		public $type = 'text';
 		public function render_content() { 
 			global $contextual_help_links;?>
 			<?php $link = $this->id; ?>
			<label>
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
					<a href="<?php echo $contextual_help_links[$link]; ?>" target = "_blank"><?php _e('(Help)', 'responsive-tabs' );?></a>
				</span>
				<input rows="5" style="width:100%;" <?php $this->link(); ?> value = <?php echo esc_textarea( $this->value() ); ?>
			</label>
 
		<?php }
	}	
	
	/* short title and heading font-size added to main site info section*/
	
	$wp_customize->add_setting( 'site_short_title', array(
	    'default' => __( 'Set Initials', 'responsive-tabs' ),
	    'sanitize_callback' => 'sanitize_text_field'
	) );
	
	$wp_customize->add_setting( 'site_info_font_family', array(
	    'default' =>  'Arial, "Helvetica Neue", Helvetica, sans-serif' ,
	    'sanitize_callback' => 'sanitize_text_field'
	) );
	
	/* tab title */
	$wp_customize->add_section( 'tab_titles_section' , array(
	    'title'      => __( 'Tab Titles', 'responsive-tabs' ),
	    'priority'   => 01,
	    'description' => 'Enter tab titles separated by commas, like so:<code>Favorites, Latest Posts, Comments</code>. 
	    	Then enter content for each tab widget.  The widget for a tab shows below in this menu  when you click on the tab title.', 
	) );	
	
	$wp_customize->add_setting( 'tab_titles', array(
	    'default' => __( 'Getting Started, ','responsive-tabs' ),
	    'sanitize_callback' => 'responsive_tabs_title_list'
	) );
	
	$wp_customize->add_setting( 'landing_tab', array(
	    'default' => '1',
	   'sanitize_callback' => 'sanitize_text_field'
	) );
	
	/* accordions */
	$wp_customize->add_section( 'footer_accordions_section' , array(
	    'title'      => __( 'Footer Accordions', 'responsive-tabs' ),
	    'priority'   => 01,
	) );	
		
	$wp_customize->add_setting( 'front_page_accordion', array(
	    'sanitize_callback' => 'responsive_tabs_clean_post_list'
	) );
		
	$wp_customize->add_setting( 'page_accordion', array(
	    'sanitize_callback' => 'responsive_tabs_clean_post_list'
	) );
	
	$wp_customize->add_setting( 'post_accordion', array(
	    'sanitize_callback' => 'responsive_tabs_clean_post_list'
	) );
	
	$wp_customize->add_setting( 'archive_accordion', array(
	    'sanitize_callback' => 'responsive_tabs_clean_post_list'
	) );
	
	/* breadcrumbs control */
	
	
	$wp_customize->add_setting( 'show_breadcrumbs', array(
	    'default' => true,
	) );
	
	$wp_customize->add_setting( 'suppress_bbpress_breadcrumbs', array(
	    'default' => '1'
	) );

	$wp_customize->add_setting( 'category_home' , array(
	    'default' => '1',
	   'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_setting( 'date_home' , array(
	    'default' => '1',
	   'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_setting( 'author_home' , array(
	    'default' => '1',
	   'sanitize_callback' => 'sanitize_text_field'
	) );	

	$wp_customize->add_setting( 'search_home' , array(
	    'default' => '1',
	   'sanitize_callback' => 'sanitize_text_field'
	) );	
	
	$wp_customize->add_setting( 'tag_home' , array(
	    'default' => '1',
	   'sanitize_callback' => 'sanitize_text_field'
	) );	

	$wp_customize->add_setting( 'page_home' , array(
	    'default' => '1',
	   'sanitize_callback' => 'sanitize_text_field'
	) );
			
	$wp_customize->add_setting( 'publications_home' , array(
	    'default' => '1',
	   'sanitize_callback' => 'sanitize_text_field'
	) );	
	
	/* custom css/scripts */
	$wp_customize->add_section( 'css_scripts_section' , array(
	    'title'      => __( 'Custom CSS and Scripts', 'responsive-tabs' ),
	    'priority'   => 99,
	    'description' => 'If you are an experienced user, you can enter custom css or scripts below.  Use caution -- the script entries are not filtered.', 
	) );	
	
	$wp_customize->add_setting( 'custom_css', array(
	    'default' => __( '', 'responsive-tabs' ),
	    'sanitize_callback' => 'responsive_tabs_pass_through'
	) );

	$wp_customize->add_setting( 'header_scripts', array(
	    'default' => __( '', 'responsive-tabs' ),
	    'sanitize_callback' => 'responsive_tabs_pass_through'
	) );

	$wp_customize->add_setting( 'footer_scripts', array(
	    'default' => __( '', 'responsive-tabs' ),
	    'sanitize_callback' => 'responsive_tabs_pass_through'
	) );


	/* login links in sidemenu bar */
	
	$wp_customize->add_setting( 'show_login_links', array(
	    'default' => '1'
	) );
	

	
	
	/* body text font sizes */
	
	$wp_customize->add_section( 'responsive_tabs_body_font_size' , array(
	    'title'      => __( 'Body Font Size', 'responsive-tabs' ),
	    'priority'   => 98,
	) );
	
	$wp_customize->add_setting( 'body_text_font_size', array(
	    'default' => '16px',
	    'sanitize_callback' => 'sanitize_text_field'
	) );
	
	
	/* front page headline */
	
	$wp_customize->add_section( 'responsive_tabs_highlight' , array(
	    'title'      => __( 'Front Page Highlight', 'responsive-tabs' ),
	    'priority'   => 99,
	) );
	
	$wp_customize->add_setting( 'highlight_headline', array(
	    'default' => __( 'Highlight Headline','responsive-tabs' ),
	    'sanitize_callback' => 'wp_kses_post'
	) );
	
	$wp_customize->add_setting( 'highlight_subhead', array(
	    'default' => __( 'Highlight Subhead', 'responsive-tabs' ),
	    'sanitize_callback' => 'wp_kses_post'
	) );
	
	$wp_customize->add_setting( 'highlight_headline_small_screen', array(
	    'default' => __( 'Highlight Headline Small Screen', 'responsive-tabs' ),
	    'sanitize_callback' => 'wp_kses_post'
	) );
	
	$wp_customize->add_setting( 'highlight_headline_font_family', array(
	    'default' =>  'Rockwell, "Courier Bold", Courier, Georgia, Times, "Times New Roman", serif',
	    'sanitize_callback' => 'sanitize_text_field'
	) );
	
	$wp_customize->add_setting( 'highlight_headline_font_size', array(
	    'default' => '52px',
	    'sanitize_callback' => 'sanitize_text_field'
	) );
	
	$wp_customize->add_setting( 'highlight_headline_font_size_small_screen', array(
	    'default' => '24px',
	    'sanitize_callback' => 'sanitize_text_field'
	) );
	
	/* color settings */
	
	$wp_customize->add_setting( 'home_widgets_title_color', array(
	    'default' => '#555',
	    'sanitize_callback' => 'sanitize_hex_color'
	) );
	
	$wp_customize->add_setting( 'highlight_color', array(
	    'default' => '#D10A0A',
	    'sanitize_callback' => 'sanitize_hex_color'
	) );
	
	$wp_customize->add_setting( 'highlight_headline_color', array(
	    'default' => '#fff',
	    'sanitize_callback' => 'sanitize_hex_color'
	) );
	
	$wp_customize->add_setting( 'body_text_color', array(
	    'default' => '#000',
	    'sanitize_callback' => 'sanitize_hex_color'
	) );
	
	$wp_customize->add_setting( 'body_header_color', array(
	    'default' => '#000',
	    'sanitize_callback' => 'sanitize_hex_color'
	) );
	
	$wp_customize->add_setting( 'body_link_color', array(
	    'default' => '#555',
	    'sanitize_callback' => 'sanitize_hex_color'
	) );
	
	$wp_customize->add_setting( 'body_link_hover_color', array(
	    'default' => '#777',
	    'sanitize_callback' => 'sanitize_hex_color'
	) );
	
	/* CONTROLS
	-------------------------------------------------------*/	

	/* tab title control */		
	$wp_customize->add_control( new Responsive_Tabs_Textarea_Control( $wp_customize, 'tab_titles', array(
		'label'        => __( 'Tab Titles', 'responsive-tabs' ),
		'section'    => 'tab_titles_section',
		'settings'   => 'tab_titles',
	   'priority'   => 1
	) ) );
	
	$wp_customize->add_control( 'landing_tab', array(
	    'label'   => __( 'Landing Tab', 'responsive-tabs' ),
	    'section' => 'tab_titles_section',
	    'type'    => 'select',
	    'settings'   => 'landing_tab',
	    'choices'    => $landing_tab_options_array
	) );

	/* footer accordion controls */
	
	$wp_customize->add_control( new Responsive_Tabs_Text_Input_Control( $wp_customize, 'front_page_accordion', array(
		'label'        => __( 'Front Page Accordion', 'responsive-tabs' ),
		'section'    => 'footer_accordions_section',
		'settings'   => 'front_page_accordion',
	   'priority'   => 1
	) ) );	
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'page_accordion', array(
		'label'        => __( 'General Page Accordion', 'responsive-tabs' ),
		'section'    => 'footer_accordions_section',
		'settings'   => 'page_accordion',
	   'priority'   => 2
	) ) );	
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'post_accordion', array(
		'label'        => __( 'Post Accordion', 'responsive-tabs' ),
		'section'    => 'footer_accordions_section',
		'settings'   => 'post_accordion',
	   'priority'   => 2
	) ) );	
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'archive_accordion', array(
		'label'        => __( 'Archive Page Accordion', 'responsive-tabs' ),
		'section'    => 'footer_accordions_section',
		'settings'   => 'archive_accordion',
	   'priority'   => 2
	) ) );
	
	/* short title control*/
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'site_short_title', array(
		'label'        => __( 'Site Short Title', 'responsive-tabs' ),
		'section'    => 'title_tagline',
		'settings'   => 'site_short_title',
	   'priority'   => 1
	) ) );
	
	$wp_customize->add_control( 'site_info_font_family', array(
	    'label'   => __( 'Select Headline Font Family:', 'responsive-tabs' ),
	    'section' => 'title_tagline',
	    'type'    => 'select',
	    'settings'   => 'site_info_font_family',
	    'choices'    => $font_family_array
	) );
	
	/* breadcrumb controls */
	
	$wp_customize->add_control( 'show_breadcrumbs', array(
	    'settings' => 'show_breadcrumbs',
	    'label'    => __( 'Show Theme Breadcrumbs', 'responsive-tabs' ),
	    'section'  => 'nav',
	    'type'     => 'checkbox',
	) );
		
	$wp_customize->add_control( 'suppress_bbpress_breadcrumbs', array(
	    'settings' => 'suppress_bbpress_breadcrumbs',
	    'label'    => __( 'Suppress bbPress Breadcrumbs', 'responsive-tabs' ),
	    'section'  => 'nav',
	    'type'     => 'checkbox',
	) );
		
	$wp_customize->add_control( 'category_home', array(
	    'label'   => __( 'Tab for category home', 'responsive-tabs' ),
	    'section' => 'nav',
	    'type'    => 'select',
	    'settings'   => 'category_home',
	    'choices'    => $landing_tab_options_array
	) );

	$wp_customize->add_control( 'date_home', array(
	    'label'   => __( 'Tab for date home', 'responsive-tabs' ),
	    'section' => 'nav',
	    'type'    => 'select',
	    'settings'   => 'date_home',
	    'choices'    => $landing_tab_options_array
	) );

	$wp_customize->add_control( 'author_home', array(
	    'label'   => __( 'Tab for author home', 'responsive-tabs' ),
	    'section' => 'nav',
	    'type'    => 'select',
	    'settings'   => 'author_home',
	    'choices'    => $landing_tab_options_array
	) );

	$wp_customize->add_control( 'date_home', array(
	    'label'   => __( 'Tab for date home', 'responsive-tabs' ),
	    'section' => 'nav',
	    'type'    => 'select',
	    'settings'   => 'date_home',
	    'choices'    => $landing_tab_options_array
	) );

	$wp_customize->add_control( 'search_home', array(
	    'label'   => __( 'Tab for search home', 'responsive-tabs' ),
	    'section' => 'nav',
	    'type'    => 'select',
	    'settings'   => 'search_home',
	    'choices'    => $landing_tab_options_array
	) );

	$wp_customize->add_control( 'tag_home', array(
	    'label'   => __( 'Tab for tag home', 'responsive-tabs' ),
	    'section' => 'nav',
	    'type'    => 'select',
	    'settings'   => 'tag_home',
	    'choices'    => $landing_tab_options_array
	) );

	$wp_customize->add_control( 'page_home', array(
	    'label'   => __( 'Tab for page home', 'responsive-tabs' ),
	    'section' => 'nav',
	    'type'    => 'select',
	    'settings'   => 'page_home',
	    'choices'    => $landing_tab_options_array
	) );

	$wp_customize->add_control( 'publications_home', array(
	    'label'   => __( 'Tab for publications home', 'responsive-tabs' ),
	    'section' => 'nav',
	    'type'    => 'select',
	    'settings'   => 'publications_home',
	    'choices'    => $landing_tab_options_array
	) );

	/* custom css & scripts controls */
	$wp_customize->add_control( new Responsive_Tabs_Textarea_Control( $wp_customize, 'custom_css', array(
		'label'        => __( 'Custom CSS for Header', 'responsive-tabs' ),
		'section'    => 'css_scripts_section',
		'settings'   => 'custom_css',
	   'priority'   => 1,
	   'description' => 'YAY'
	) ) );

	/* custom css & scripts controls */
	$wp_customize->add_control( new Responsive_Tabs_Textarea_Control( $wp_customize, 'header_scripts', array(
		'label'        => __( 'Header Scripts', 'responsive-tabs' ),
		'section'    => 'css_scripts_section',
		'settings'   => 'header_scripts',
	   'priority'   => 2
	) ) );

	/* custom css & scripts controls */
	$wp_customize->add_control( new Responsive_Tabs_Textarea_Control( $wp_customize, 'footer_scripts', array(
		'label'        => __( 'Footer Scripts', 'responsive-tabs' ),
		'section'    => 'css_scripts_section',
		'settings'   => 'footer_scripts',
	   'priority'   => 3
	) ) );

	/* body text font sizes */
	$wp_customize->add_control( 'body_text_font_size', array(
	    'label'   => __('Select Body Text Font Size: (16px recommended)', 'responsive-tabs' ),
	    'section' => 'responsive_tabs_body_font_size',
	    'type'    => 'select',
	    'settings'   => 'body_text_font_size',
	    'choices'    => $font_size_array
	) );
	/* login link control */
	
	$wp_customize->add_control( 'show_login_links', array(
	    'settings' => 'show_login_links',
	    'label'    => __( 'Show Login Links in Side Menu', 'responsive-tabs' ),
	    'section'  => 'nav',
	    'type'     => 'checkbox',
	) );
	
	/* highlight headlines */
	
	$wp_customize->add_control( new Responsive_Tabs_Textarea_Control( $wp_customize, 'highlight_headline', array(
		'label'        => __( 'Highlight Headline', 'responsive-tabs' ),
		'section'    => 'responsive_tabs_highlight',
		'settings'   => 'highlight_headline',
	   'priority'   => 1
	) ) );
	
	$wp_customize->add_control( new Responsive_Tabs_Textarea_Control( $wp_customize, 'highlight_subhead', array(
		'label'        => __( 'Highlight SubHead', 'responsive-tabs' ),
		'section'    => 'responsive_tabs_highlight',
		'settings'   => 'highlight_subhead',
	   'priority'   => 2
	) ) );
	
	$wp_customize->add_control( new Responsive_Tabs_Textarea_Control( $wp_customize, 'highlight_headline_small_screen', array(
		'label'        => __( 'Highlight Headline Small Screen', 'responsive-tabs' ),
		'section'    => 'responsive_tabs_highlight',
		'settings'   => 'highlight_headline_small_screen',
	   'priority'   => 2
	) ) );
	
	$wp_customize->add_control( 'highlight_headline_font_family', array(
	    'label'   => __( 'Select Headline Font Family:', 'responsive-tabs' ),
	    'section' => 'responsive_tabs_highlight',
	    'type'    => 'select',
	    'settings'   => 'highlight_headline_font_family',
	    'choices'    => $font_family_array
	) );
	
	$wp_customize->add_control( 'highlight_headline_font_size', array(
	    'label'   => __( 'Select Headline Size:', 'responsive-tabs' ),
	    'section' => 'responsive_tabs_highlight',
	    'type'    => 'select',
	    'settings'   => 'highlight_headline_font_size',
	    'choices'    => $font_size_array
	) );
	
	$wp_customize->add_control( 'highlight_headline_font_size_small_screen', array(
	    'label'   => __( 'Select Headline Size:', 'responsive-tabs' ),
	    'section' => 'responsive_tabs_highlight',
	    'type'    => 'select',
	    'settings'   => 'highlight_headline_font_size_small_screen',
	    'choices'    => $font_size_array
	) );
	
	/* color controls */
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'home_widgets_title_color', array(
		'label'        => __( 'Home Titles Color', 'responsive-tabs' ),
		'section'    => 'colors',
		'settings'   => 'home_widgets_title_color'
	) ) );  
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'highlight_color', array(
		'label'        => __( 'Highlight Color', 'responsive-tabs' ),
		'section'    => 'colors',
		'settings'   => 'highlight_color'
	) ) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'highlight_headline_color', array(
		'label'        => __( 'Highlight Headline Color', 'responsive-tabs' ),
		'section'    => 'colors',
		'settings'   => 'highlight_headline_color'
	) ) );
	  
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_text_color', array(
		'label'        => __( 'Body Text Color', 'responsive-tabs' ),
		'section'    => 'colors',
		'settings'   => 'body_text_color'
	) ) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_header_color', array(
		'label'        => __( 'Body Header Color', 'responsive-tabs' ),
		'section'    => 'colors',
		'settings'   => 'body_header_color'
	) ) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_link_color', array(
		'label'        => __( 'Body Link Color', 'responsive-tabs' ),
		'section'    => 'colors',
		'settings'   => 'body_link_color'
	) ) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_link_hover_color', array(
		'label'        => __( 'Body Link Hover Color', 'responsive-tabs' ),
		'section'    => 'colors',
		'settings'   => 'body_link_hover_color'
	) ) );  

}

add_action('customize_register', 'responsive_tabs_theme_customizer');