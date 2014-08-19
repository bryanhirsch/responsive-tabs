<?php
/*
* This file sets up theme, loading necessary scripts, styles and includes.
*
*/
	// this file assembles css for wp_head from theme_customization selections
	include get_template_directory() . '/includes/responsive-tabs-customization-css.php';

	// include the theme customizer function which handles most options
	// note: it is apparently necessary to include this call outside is_admin() condition to allow refresh to work in customizer
	include get_template_directory() . '/includes/responsive-tabs-customization.php';
	// this file includes widget code
	include get_template_directory() . '/includes/responsive-tabs-widgets.php';
   
	
	$responsive_tabs_theme_options_array = get_option( 'responsive_tabs_theme_options_array' );		

/*
* admin 
*
*/
$theme_options_tabs = array (
   	array ('tabs', 'Tabs'),
   	array ('accordion', 'Accordion'),
   	array ('scripts', 'CSS/Scripts'),
   	array ('breadcrumbs', 'Breadcrumbs'),
);

/* http://stackoverflow.com/questions/5266945/wordpress-how-detect-if-current-page-is-the-login-page */
function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}


if ( is_admin())
{
	global $theme_options_tabs;

	// include and construct the theme options page for tabs and accordions
	include get_template_directory() . '/includes/class-responsive-tabs-theme-options.php';



	// construct the tabs
	foreach ($theme_options_tabs as $tab)
	{
		include get_template_directory() . '/includes/class-responsive-tabs-' .  $tab[0] . '-tab.php';
	}
}

/*
* non admin style/script loads
*
*/
function responsive_tabs_theme_setup() {

	if ( !is_admin() ) {

		wp_register_script(
		  'resize',
		 get_template_directory_uri() . '/js/resize.js'
		 );
		 
		wp_enqueue_script('resize');
	}// !is_admin()items		
}// responsive_tabs_theme_setup

add_action('wp_enqueue_scripts', 'responsive_tabs_theme_setup');


/*
*  suppress bbpress bread crumbs on bbp template forms -- since loading broader breadcrumb plugins
*    recommend breadcrumb NavXT plugin (should handle options explicitly in admin UI
*/
add_filter( 'bbp_no_breadcrumb', '__return_true' );

/*
* set up menues
*
*/

function responsive_tabs_register_menus() 
{
	register_nav_menu('main-menu',__( 'Main Menu' ));
}

add_action( 'init', 'responsive_tabs_register_menus' );

/**
 * Register widgetized areas.
 *
 */
function responsive_tabs_widgets_init() {

	register_sidebar( array(
		'name' => 'Header Bar Widget',
		'description' => 'Widget on Header Bar (recommended for a search widget ) ',
		'id' => 'header_bar_widget',
		'class' => '',
		'before_widget' => '<div class = "header_bar_widget_wrapper"> ',
		'after_widget' => '</div>',
		'before_title' => '<h2 class = widgettitle>',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Side Menu Widget',
		'description' => 'Widget on Side Menu Bar',
		'id' => 'side_menu_widget',
		'class' => '',
		'before_widget' => '<div class = "side_menu_widget_wrapper"> ',
		'after_widget' => '</div>',
		'before_title' => '<h2 class = widgettitle>',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Home Widget Bulk',
		'description' => 'Free form widget area for subject matter pebbles',
		'id' => 'home_bulk_widget',
		'class' => '',
		'before_widget' => '<div class = "home_bulk_widget_wrapper"> ',
		'after_widget' => '</div>',
		'before_title' => '<h2 class = widgettitle>',
		'after_title' => '</h2>',
	) );
	
	register_sidebar( array(
		'name' => 'Home Widget Two',
		'description' => 'Second Widget Option for Front Page Tabs',
		'id' => 'home_widget_2',
		'class' => '',
		'before_widget' => '<div class = "general_home_widget_wrapper"> ',
		'after_widget' => '</div>',
		'before_title' => '<h2 class = widgettitle>',
		'after_title' => '</h2>',
	) );
	
	register_sidebar( array(
		'name' => 'Home Widget Three',
		'description' => 'Third Widget Option for Front Page Tabs',
		'id' => 'home_widget_3',
		'class' => '',
		'before_widget' => '<div class = "general_home_widget_wrapper"> ',
		'after_widget' => '</div>',
		'before_title' => '<h2 class = widgettitle>',
		'after_title' => '</h2>',
	) );

register_sidebar( array(
		'name' => 'Home Widget Four',
		'description' => 'Fourth Widget Option for Front Page Tabs',
		'id' => 'home_widget_4',
		'class' => '',
		'before_widget' => '<div class = "general_home_widget_wrapper"> ',
		'after_widget' => '</div>',
		'before_title' => '<h2 class = widgettitle>',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Post Sidebar',
		'description' => 'Displayed with Posts',
		'id' => 'post_sidebar',
		'before_widget' => '<div class = "sidebar_widget_wrapper"> ',
		'after_widget' => '</div>',
		'before_title' => '<h2 class = widgettitle>',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Page Sidebar',
		'description' => 'Displayed with Pages (except full-width pages)',
		'id' => 'page_sidebar',
		'before_widget' => '<div class = "sidebar_widget_wrapper"> ',
		'after_widget' => '</div>',
		'before_title' => '<h2 class = widgettitle>',
		'after_title' => '</h2>',
	) );


	register_sidebar( array(
		'name' => 'BBPress Sidebar',
		'description' => 'Displayed with BBPress Topics and Posts',
		'id' => 'bbpress_sidebar',
		'before_widget' => '<div class = "sidebar_widget_wrapper"> ',
		'after_widget' => '</div>',
		'before_title' => '<h2 class = widgettitle>',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Fine Print Bottom Widget',
		'description' => 'Site credit, copyrights, etc.',
		'id' => 'bottom_sidebar',
		'before_widget' => '<div class = "bottom_widget_wrapper"> ',
		'after_widget' => '</div>',
		'before_title' => '<h3 class = widgettitle>',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'responsive_tabs_widgets_init' );


/*
* theme support -- custom-header, custom-background
*
*/

$header_default = array(
	'width'         => 300,
	'height'        => 325,
	'header-text'   => false,
//	'default-image' => get_template_directory_uri() . '/images/wb_logo_web.png',
//https://core.trac.wordpress.org/ticket/27850
	'uploads'       => true,
);
add_theme_support( 'custom-header', $header_default ); // note -- installed as background image in theme customizer
// https://codex.wordpress.org/Custom_Headers


$background_default = array(
	'default-color'          => 'C6C2BA',
	'default-image'          => '',
	'wp-head-callback'       => '_custom_background_cb',
	'admin-head-callback'    => '',
	'admin-preview-callback' => ''
);
add_theme_support( 'custom-background', $background_default );
add_theme_support( 'post-thumbnails', array ( 'post', 'page'));
add_theme_support( 'html5', array( 'search-form' ) );

add_image_size( 'front-page-thumb', 270, 9999 ); //270 pixels wide (and unlimited height)
add_image_size( 'front-page-half-thumb', 135, 9999 ); //135 pixels wide (and unlimited height)

/*
* add metabox for post width, following 
*  http://www.wproots.com/complex-meta-boxes-in-wordpress/
*
*/

function twcc_call_meta_box($post_type, $post)
{
   add_meta_box(
       'twcc_post_width_setting_box',
       'Post Display Width',
       'twcc_post_width_meta_box',
       'post',
       'side',
       'high'
   );
}
add_action('add_meta_boxes', 'twcc_call_meta_box', 10, 2);

function twcc_post_width_meta_box($post, $args)
{
   wp_nonce_field(site_url(__FILE__), 'twcc_metabox_noncename');

               
       $post_width_options = array(
		'0' => array(
			'value' =>	'normal',
			'label' =>      'Normal (show sidebar)'
		),
		'1' => array(
			'value' =>	'wide',
			'label' =>  	'Wide (hide sidebar)' 
		),
		'2' => array(
			'value' => 'extra_wide',
			'label' => 'Extra Wide (maximize content)'
		),
			);	 
    
    $selected = ( null !== get_post_meta($post->ID, '_twcc_post_width', true) ) ? esc_attr( get_post_meta($post->ID, '_twcc_post_width', true)) : '';
     echo '<select id = "_twcc_post_width" name = "_twcc_post_width">';
   	

	$p = '';
	$r = '';
	foreach ( $post_width_options as $option ) {
	    	$label = $option['label'];
		if ( $selected == $option['value'] ) // Make selected first in list
		     $p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
		else $r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
               	}
 	echo $p . $r. '</select>';
?>


   </p>
<?php
}




add_action('save_post', 'twcc_save_meta_box',10,2);
function twcc_save_meta_box($post_id, $post)
{
   if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
       return;

   if('page' == $_POST['post_type']) /************** notice error undefined index on this line ********/
   {
       if(!current_user_can('edit_page', $post_id))
           return;
   }
   else
       if(!current_user_can('edit_post', $post_id))
           return;

   if(isset($_POST['twcc_metabox_noncename']) && wp_verify_nonce($_POST['twcc_metabox_noncename'], site_url(__FILE__)) && check_admin_referer(site_url(__FILE__), 'twcc_metabox_noncename'))
   {
           update_post_meta($post_id, '_twcc_post_width', wp_kses_data(strip_tags($_POST['_twcc_post_width'])));
   }
   return;
}
// Register Custom Status -- does not work in admin panel to create new columns as advertised.
 function new_post_spam_register() {

	$args = array(
		'label'                     => _x( 'new_post_spam', 'Status General Name', 'text_domain' ),
		'label_count'               => _n_noop( 'Spam Post (%s)',  'Spam Posts (%s)', 'text_domain' ), 
		'public'                    => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'exclude_from_search'       => true,
	);
	register_post_status( 'new_post_spam', $args );

}

// Hook into the 'init' action
add_action( 'init', 'new_post_spam_register', 0 ); 