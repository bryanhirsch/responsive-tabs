<?php
/*
* Retina header file, following: http://codex.wordpress.org/Theme_Development#Document_Head_.28header.php.29
*
* omits  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
* so allows screen to be resized by retina device user
*
*/ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
        <?php wp_head(); ?>
    </head>
<body <?php body_class($class); ?>> 
<?php
/*
* Now construct special login bar and banner area.
*
*/      
	get_template_part('retina_header_bar');

	?>

	<div id = "wrapper"><!-- sets boundaries on sidebar expansion -->
	<div id="retina-view-frame"> <!-- will be closed by view frame close -->
	<div id="color-splash"></div>