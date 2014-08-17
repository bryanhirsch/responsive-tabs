<?php
/*
*
* forum.php
* using only for bbpress listings -- full width
* http://bbpress.org/forums/topic/understanding-templating/
*
* bbpress template hierarch per http://bbpress.org/forums/topic/understanding-templating/
*  1. bbpress.php
*  2. forum.php
*  3. page.php
*  4. single.php
*  5. index.php
*
*/

// use this template for lists, otherwise, go to single (note, this allows page.php to serve only non-bbpress pages)
if ( !(

	bbp_is_forum_archive() || 
	bbp_is_topic_archive() ||
	bbp_is_topic_tag() || 
	bbp_is_single_forum() || 
	bbp_is_topics_created() || 
	bbp_is_replies_created()||
	bbp_is_single_user_edit() ||
	bbp_is_single_user() ||
	bbp_is_favorites() || 
	bbp_is_subscriptions() || 
	bbp_is_search_results() ) )

 	{      	
		get_template_part('single');
	}
else
	{
	get_header();
	
	echo '<!-- forum.PHP -->';
	


	// division wraps the non-sidebar, non-footer content
	?> <div id="bbpress-list-wrapper"> <?php

	get_template_part('breadcrumbs');
	
	// single simple post handler for multiple and single;
	if ( have_posts() ) : while (have_posts()) : the_post();	
	
		// display title as plain text for single as link for all links	
	
			the_title(' <h1> ', ' </h1> ');
		
		// display content for bbpress archive
			the_content();
	
	
		// close the main loop		
		endwhile; 
		
			
		// handle not found conditions		
		else:   
				?>
		<h1>No posts found matching your search.<h1>
		<?php
		
	endif;
	
	?> </div><?php // note start immediately to create space in inline-block series
	
	// no sidebar for archives -- use full width
	
	?><?php  
	
	 // empty bar to clear formatting -->
	?><div class="horbar_clear_fix"></div><?php 
	 
	get_footer();
	
}