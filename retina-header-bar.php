<?php 
/*
*  retina_header_bar.php
*  displays menu/identity header bar for full-width retina pages
*
*/
?>
	<div id="bbp-resp-header-bar-spacer"></div>
 	<div id="bbp-resp-header-bar-wrapper"> 	
 	<div id="bbp-resp-header-bar">

			<a href = "<?php echo (home_url ( '/')); ?>"><button  id = "home-button">HOME</button></a>
			<ul id = "bbp-site-info-wrapper">
				<li class = "site-title">
					 <a href="<?php  echo( home_url( '/' ) ) ?>" title="Go to front page">
					 <?php echo get_theme_mod('site_short_title'); ?> -- Full Width View </a>
				</li>
			</ul>
			 <div class="horbar_clear_fix"></div>  
       </div></div><!-- bbp-resp-header-bar and wrapper-->