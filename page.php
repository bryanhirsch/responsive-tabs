<?php
/*
*
* page.php -- note, all calls to bbpress are intercepted first by forum.php
* 
* http://bbpress.org/forums/topic/understanding-templating/
*
*/
get_header();
echo '<!--page.php -->';





?><div id="content-header"><?php
get_template_part('breadcrumbs');

if ( have_posts() ) : while (have_posts()) : the_post();	
   	
		the_title(' <h1 class="post-title"> ', ' </h1> ');
	
		?></div>
		<div id="content-wrapper">   <?php

	

		
		global $more;
		$more = 1;  // http://codex.wordpress.org/Template_Tags/the_content (override the more logic to display whole post/topic in this view)
		
		echo '<div id = "wp-single-content">';
		?><div class = "post-info">Posted on <?php the_time('F jS, Y'); ?> by <?php the_author_posts_link();?> </div><?php
			the_content();
			edit_post_link('Edit Page', '<p>', '</p>'); 
		echo '</div>';
		
	
	// close the main loop		
	endwhile; 
	
		
	// handle not found conditions		
	else:   
			?>
	<h1>No posts found matching your search.<h1>
	<?php
	
endif;

?> </div><?php // note start immediately to create space in inline-block series

// show page sidebar
	echo '<div id="right-sidebar-wrapper">';
		if ( dynamic_sidebar('page_sidebar') ) : else : endif;	
	echo '</div>';

 // empty bar to clear formatting -->
?><div class="horbar_clear_fix"></div><?php 
 
get_footer();