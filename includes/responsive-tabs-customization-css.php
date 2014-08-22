<?php
/*
* File: class-responsive-tabs-customization-css.php
*			
* Description: outputs css from theme customizer and any custom css or scripts from front page options
*  
* @package responsive-tabs
*/
/* assure that will die if accessed directly */ 
defined( 'ABSPATH' ) or die( "No script kiddies please!" );

add_action( 'customize_register', 'responsive_tabs_theme_customizer' );

function responsive_tabs_customize_css() { ?>   
	<!-- theme customizer css output via responsive-tabs-customization-css.php-->
	<style type="text/css">
	
		body {
			color: <?php echo get_theme_mod( 'body_text_color' ); ?>;
	  		font-size: <?php echo get_theme_mod( 'body_text_font_size' ); ?>;
	  	}
	  	
		#bbpress-forums .bbp-reply-content {
	  		font-size: <?php echo get_theme_mod( 'body_text_font_size' ); ?>;
	  	}
	  	
		a {
			color: <?php echo get_theme_mod( 'body_link_color' ); ?>;
		}
		
		a:hover {
			color: <?php echo get_theme_mod( 'body_link_hover_color' ); ?>;
		}
	  
		h1, 
		h2, 
		h3, 
		h4, 
		h5, 
		h6  {
			color: <?php echo get_theme_mod( 'body_header_color' ); ?>;
		}
	  
		.site-title a,
		.site-description,
		#main-tabs .main-tabs-headers li a,
	  	#home_bulk_widgets .home-bulk-widget-wrapper h2.widgettitle	{
	 			color: <?php echo get_theme_mod( 'home_widgets_title_color' ); ?>;
	 	}
	
		#front-page-mobile-color-splash,     			
		#highlight-text-area,
		#color-splash { 
			background: <?php echo get_theme_mod( 'highlight_color' ); ?>; 
		}
	  			
		#highlight-headline,
		#highlight-subhead	{
			color: <?php echo get_theme_mod( 'highlight_headline_color' ); ?>;
			font-family: <?php echo get_theme_mod( 'highlight_headline_font_family' ); ?>;
		}
	
		#highlight-headline	{
			font-size: <?php echo get_theme_mod( 'highlight_headline_font_size' ); ?>;
		}
	
	 	div#side-menu.sidebar-menu {
	 		background-image: url("<?php header_image(); ?>");
	 	}
	  
	 	.site-title a,
		.site-description,
		.site-title-short a {
			font-family: <?php echo get_theme_mod( 'site_info_font_family' ); ?>;
		}
	
		@media only screen and (max-width: 840px) {
			#highlight-headline	{
				font-size: <?php echo get_theme_mod( 'highlight_headline_font_size_small_screen' ); ?>;
			}
		}
	
		<?php global $responsive_tabs_theme_options_array; 	
		echo '<!-- responsive-tab css directly input in admin>appearance>front page options (echoed in responsive-tabs-customization-css.php)-->
		' . esc_html( $responsive_tabs_theme_options_array['css_header']) ; ?>
	  
	</style>
 <?php
}
add_action( 'wp_head', 'responsive_tabs_customize_css' );

function responsive_tabs_output_header_scripts()
{
	if (!is_user_logged_in()) 
	{
		global $responsive_tabs_theme_options_array;
		echo  '<!-- responsive-tab script directly input in admin>appearance>front page options (echoed in responsive-tabs-customization-css.php)-->
		' .  $responsive_tabs_theme_options_array['scripts_header'] ;
	}
}
add_action( 'wp_head', 'responsive_tabs_output_header_scripts', 999 );


function responsive_tabs_output_footer_scripts()
{  
	if (!is_user_logged_in()) 
	{     
		global $responsive_tabs_theme_options_array;
		echo '<!-- responsive-tab script directly input in admin>appearance>front page options (echoed in responsive-tabs-customization-css.php)-->
		' . $responsive_tabs_theme_options_array['scripts_footer'];
	}
}
add_action( 'wp_footer', 'responsive_tabs_output_footer_scripts' );