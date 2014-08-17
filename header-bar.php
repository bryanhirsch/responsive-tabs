<?php 
/*
*  header_bar.php
*  displays menu/identity header bar that carries across all theme pages
*
*/
?>
	<div id="bbp-resp-header-bar-spacer"></div>
 	<div id="bbp-resp-header-bar-wrapper"  class = "
				<?php if (is_admin_bar_showing())
					{echo "admin_bar_showing";}
				      else 
					{echo "no_admin_bar";}
				?>"> 	
 	<div id="bbp-resp-header-bar">
		<div id = "bbp-resp-header-bar-content-spacer"></div>
			<button id = "side-menu-button" onclick = "toggle_side_menu()">MENU</button>

			<div id = "header_bar_widget_wrapper">
			<?php if ( dynamic_sidebar('header_bar_widget') ) : else : endif; ?>
			</div>
			
			<ul id = "bbp-site-info-wrapper">
				<li class="site-title site-title-long">
					 <a href="<?php  echo( home_url( '/' ) ) ?>" title="Go to front page">
					 <?php bloginfo( 'name' ) ?> </a>
				</li>
				<li class = "site-title site-title-short">
					 <a href="<?php  echo( home_url( '/' ) ) ?>" title="Go to front page">
					 <?php echo get_theme_mod('site_short_title'); ?> </a>
				</li>
				<li class="site-description"> 
					<?php bloginfo( 'description' ) ?>
				</li>
			</ul>
			 <div class="horbar_clear_fix"></div>  
       </div></div><!-- bbp-resp-header-bar and wrapper-->
