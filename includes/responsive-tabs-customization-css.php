<?php
/*
* handle all theme options except tabs and accordions
*
*/


add_action('customize_register', 'responsive_tabs_theme_customizer');

function responsive_tabs_customize_css()
{

    ?>   
<!-- bbp_resp theme customizer css output via theme_customization_css.php-->
         <style type="text/css">

        body 			{color:	<?php echo get_theme_mod('body_text_color'); ?>;
        			font-size: <?php echo get_theme_mod('body_text_font_size'); ?>;}
        #bbpress-forums .bbp-reply-content 
        			{font-size: <?php echo get_theme_mod('body_text_font_size'); ?>;}
        			
        a				{color:	<?php echo get_theme_mod('body_link_color'); ?>;}
        a:hover			{color:	<?php echo get_theme_mod('body_link_hover_color'); ?>;}
        
        h1, h2, h3, h4, h5, h6  {color:	<?php echo get_theme_mod('body_header_color'); ?>;}
        
	.site-title a,
	.site-description,
	#main-tabs .main-tabs-headers li a,
        #home_bulk_widgets .home_bulk_widget_wrapper h2.widgettitle 
             			{color: <?php echo get_theme_mod('home_widgets_title_color'); ?>;}

        #front-page-mobile-color-splash,     			
        #highlight_text_area,
        #color-splash
        			{ background: <?php echo get_theme_mod('highlight_color'); ?>; }
        			
        #highlight_headline,
        #highlight_subhead	{color: <?php echo get_theme_mod('highlight_headline_color'); ?>;
				font-family: <?php echo get_theme_mod('highlight_headline_font_family'); ?>;}
				
	 #highlight_headline	{font-size:  <?php echo get_theme_mod('highlight_headline_font_size'); ?>;}
				
        div#side-menu.sidebar-menu {background-image: url("<?php header_image(); ?>");}
        
	.site-title a,
	.site-description,
        .site-title-short a {font-family: <?php echo get_theme_mod('site_info_font_family'); ?>;}

	@media only screen and (max-width: 840px) {
	         #highlight_headline	{font-size:  <?php echo get_theme_mod('highlight_headline_font_size_small_screen'); ?>;}
	}

	<?php $responsive_tabs_theme_options_array = get_option( 'responsive_tabs_theme_options_array' ); 	
	echo '
<!-- bbp_resp theme options css directly input via theme_customization_css.php-->
' . $responsive_tabs_theme_options_array['css_header']; ?>
        
         </style>
    <?php
}



add_action( 'wp_head', 'responsive_tabs_customize_css');

function responsive_tabs_output_header_scripts()
{
	if (!is_user_logged_in()) 
	{
		$responsive_tabs_theme_options_array = get_option( 'responsive_tabs_theme_options_array' );
		echo  $responsive_tabs_theme_options_array['scripts_header'] ;
	}
}

add_action( 'wp_head', 'responsive_tabs_output_header_scripts',999999);


function responsive_tabs_output_footer_scripts()
{       
	$responsive_tabs_theme_options_array = get_option( 'responsive_tabs_theme_options_array' );
	echo $responsive_tabs_theme_options_array['scripts_footer'];
}

add_action( 'wp_footer', 'responsive_tabs_output_footer_scripts');