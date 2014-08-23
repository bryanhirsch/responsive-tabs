<?php
/*
 * File: 404.php
 * Description: Displayed when material not found
 *
 * @package responsive-tabs
 *
 */

/* assure that will die if accessed directly */ 
defined( 'ABSPATH' ) or die( "Unauthorized direct script access." );

get_header();

?>

<!--responsive-tabs/404.php -->

<div id="full-width-content-wrapper" > 
	
	<h1><?php _e( 'Sorry! We cannot find the content you requested.', 'responsive-tabs' )?></h1>
	
	<h3><?php printf( _e( 'Please <a href="javascript: history.go(-1)">go back</a> or start over from <a href="%1$s">front page of %2$s</a>.' ), home_url( '/' ), get_bloginfo( 'name')  ); ?></h3>
					
</div>



<?php get_footer();