<?php
/*
 * Template Name: Full Width Page
 * Description: A Page Template that uses full 1280 px of view frame -- no sidebar.
 *
 * page.php -- note, all calls to bbpress are intercepted first by forum.php
 * 
 * http://codex.wordpress.org/Page_Templates
 *
 */
get_header();
echo '<!--page.php -->';

$new_link = str_replace('/forums/topic', '', $_SERVER[REQUEST_URI]); 

// division wraps the non-sidebar, non-footer content
?> 

<div id="full-width-content-wrapper" > 
	
	<h1>Sorry!</h1>
	
	<h2>We've moved some links around.<h2>

	<h3>If you need help, please don't hesitate to <a href="/connect/contact">contact us directly</a>.</h3>

<?php if(strpos('xxx'. $_SERVER[REQUEST_URI],'/forums/topic')>0)  { ?>  
	<h3><a href = "<?php echo $new_link; ?>">Click here for a good guess on the correct URL</a></h3>
	<?php } ?>
	<h3><a href="<?php  echo( home_url( '/' ) ) ?>" title="Go to front page">Click here to return home at 
					 <?php bloginfo( 'name' ) ?> </a>

</div>
<div class="horbar_clear_fix"></div><?php 
 
get_footer();