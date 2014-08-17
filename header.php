<?php
/*
* Basic header file, following: http://codex.wordpress.org/Theme_Development#Document_Head_.28header.php.29
*
*/ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>  xmlns="http://www.w3.org/1999/xhtml">
    <head profile="http://gmpg.org/xfn/11">
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
	     <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
        <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" /> 
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
        <?php wp_head(); ?>
    </head>
     
<body <?php body_class($class); ?>> 
<?php
/*
* Now construct login bar and banner area.
*
*/      
	get_template_part('header','bar');
	
	$view_frame_class = (is_front_page()) ? 'front-page-view' : 'back-page-view';
	
	?>

	<div id = "wrapper"><!-- sets boundaries on sidebar expansion -->

	<div id="side-menu" class = "sidebar-menu">

	<div id = "header_bar_widget_wrapper_side_menu_copy" >
		<?php if ( dynamic_sidebar('header_bar_widget') ) : else : endif; ?>
	</div>
	<ul id = "menu-main" class = "menu">
		<?php wp_nav_menu( array(
		 'theme_location' 	=> 'main-menu', 
		 'container_class' 	=> 'my_asd_menu_class',  
		 'items_wrap'		=> '%3$s' 
		 ) ); ?>
		<?php 
		if (get_theme_mod('show_login_links'))
		{
			echo '<li>';
			$redirect_to = is_home() ? home_url() : get_permalink();  // from home, get_permalink() returns latest post   
			
			if ( is_user_logged_in() ) 
			{
	           		$current_user = wp_get_current_user();
	           		if ( current_user_can('edit_others_posts') ) 
	           		{
					echo '<a href="/wp-admin">dashboard</a>';
				}
				else
				{
	           			if (class_exists('bbPress'))
	           				// Note: class_exists('bbPress') should be equivalent to is_plugin_active('bbpress/bbpress.php')) 
					{
	           				$profile_link = '/forums/users/'. $current_user->user_login;
	           			}
	           			else 
	   				{
	   					$profile_link = '/wp-admin/profile.php';
	   				}
	    				echo '<a href="'. $profile_link . '" title="profile for ' . $current_user->display_name . '">view profile</a>';
	    			}
				echo '</li><li><a href="' . wp_logout_url( $redirect_to ) . '">logout</a>';
	 		} 
			else 
			{
				$redirect_to = is_home() ? home_url() : get_permalink();  // from home, get_permalink() returns latest post 
				echo '<a href="'.wp_login_url( $redirect_to ).'">login</a>';
			}
			echo '</li>';
		}
	?></ul>
	<div id = "side-menu-widget-area" >
		<?php if ( dynamic_sidebar('side_menu_widget') ) : else : endif; ?>
	</div>
	</div><!--side-menu-->

	<div id="view-frame" class = "<?php echo $view_frame_class;?>">

	<?php if (!is_front_page()) 
	{
		echo '<div id="color-splash"></div>';
	}
	?>