<?php 
/*
*  File: retina-header-bar.php
*  Description: displays abbreviated menu/identity header bar for full-width retina pages
*
*  @package: responsive-tabs
*/

/* assure that will die if accessed directly */ 
defined( 'ABSPATH' ) or die( "Unauthorized direct script access." );

?>
<!-- responsive-tabs retina-header-bar.php -->
<div id="header-bar-spacer"></div>
<div id="header-bar-wrapper"  class = "
	<?php if ( is_admin_bar_showing()) {
		echo 'admin-bar-showing';
	} else { 
		echo 'no-admin-bar';
	}
	?>"> 
	
 	<div id="header-bar">
		<a href = "<?php echo home_url( '/'); ?>"><button  id = "home-button"><?php _e( 'HOME' , 'responsive-tabs' ); ?></button></a>
		<ul id = "site-info-wrapper">
			<li class = "site-title">
				 <a href="<?php  echo home_url( '/' ); ?>" title="<?php _e( 'Go to front page', 'responsive-tabs' ); ?>">
				 	<?php echo esc_html( get_theme_mod( 'site_short_title' ) ); ?> -- <?php _e( 'Full Width View', 'responsive-tabs' ); ?> 
				 </a>
			</li>
		</ul>
		<div class="horbar-clear-fix"></div>  
	</div>
</div><!-- header-bar wrapper-->