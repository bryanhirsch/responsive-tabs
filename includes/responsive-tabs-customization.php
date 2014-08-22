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

							
function responsive_tabs_theme_customizer( $wp_customize ) {

	global $font_family_array;
	global $font_size_array;

	/* create custom call back for text area */
	class Responsive_Tabs_Textarea_Control extends WP_Customize_Control { // http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer/
		public $type = 'textarea';
	 
		public function render_content() { ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
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
	
	/* login links in sidemenu bar */
	
	$wp_customize->add_section( 'login_links' , array(
	    'title'      => __( 'Login Links in Side Menu', 'responsive-tabs' ),
	    'priority'   => 95,
	) );
	
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
	    'section'  => 'login_links',
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