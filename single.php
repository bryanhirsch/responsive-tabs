<?php
/*
*
* single.php
* picked up for bbpress topics
* http://bbpress.org/forums/topic/understanding-templating/
*
*/

echo '<!--single.php -->';

$responsive_tabs_theme_options_array = get_option( 'responsive_tabs_theme_options_array' ); 

// set bbpress switch
$bbpress_switch = 0;
if(class_exists('bbpress'))
{
	if(is_bbpress()) {$bbpress_switch = 1;} 
}
	$post_width = get_post_meta(get_the_id(), '_twcc_post_width', true);
   if($post_width == 'extra_wide') {get_header('retina');}
   else get_header();
?>


<div id="content-header">
<?php
get_template_part('breadcrumbs');

if ( have_posts() ) : while (have_posts()) : the_post();	

	// the_title(' <h1 class="post-title"> ', ' </h1> ');
	?><h1>
	<?php $comment_count = get_comments_number();
	if($comment_count>0) printf( '%2$s<span class="post-response-count"> (' . _n( 'One Response)', '%1$s Responses)', $comment_count ) . '</span>',
									number_format_i18n( $comment_count ), get_the_title() ); 
	else the_title();?>
	</h1>
	</div>
	
	<?php

	if($post_width == 'wide') {echo '<div id="full-width-content-wrapper">';} 
	elseif ($post_width == 'extra_wide') {echo '<div id="retina-full-width-content-wrapper">';}
	else {echo '<div id="content-wrapper">';};
	echo '<!--division wraps the non-sidebar, non-footer content-->';
	
	// display meta information if not in bbpress

	
	// display content for single or bbpress (which does own list handling); display excerpts for post lists
		global $more;
		$more = 1;  // http://codex.wordpress.org/Template_Tags/the_content (override the more logic to display whole post/topic in this view)
		if (!$bbpress_switch):
			echo '<div id = "wp-single-content">';   
			
   if (!$bbpress_switch)
	{	
		?> <div class = "post-info">By <span class="post-author">
			<?php $guest_author = get_post_meta(get_the_ID(), 'twcc_post_guest_author',true );
				if ($guest_author === '') 
					{
						the_author_posts_link();				
					}
				else 
					{
						echo $guest_author; 
					}
		?></span>, on 
		<?php echo '<a href="'.get_month_link(get_post_time('Y'), get_post_time('m')).'" title = "View all posts from '. get_post_time('F') . ' ' . get_post_time('Y') .'">'. get_post_time('F') . '</a> ' .
			'<a href="'.get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')).'" title = "View posts from same day">'. get_post_time('jS') . '</a>, ' .
	      '<a href="'.get_year_link(get_post_time('Y')). '" title = "View all posts from '. get_post_time('Y')  .'">' . get_post_time('Y') . '</a>.'; ?> 	
		<span class= "post-cats">
			In: <?php the_category(', '); ?>.<?php  
			the_tags(" Tagged: ", ', ','.'); ?></span></div> <?php
	}			
			
			
			the_content();
			
			if ( get_comments_number() > 2 && comments_open() ) :
  				echo '<h4><a href="#comment">Make a comment</a></h4>';
			endif;

			edit_post_link('Edit Post #' . get_the_id(), '<br />', ''); 
			echo '</div>';
		else: the_content();
		endif;

	//display non-bbpress foot matter for posts and pages
   if (!$bbpress_switch)
	{
		comments_template();
		// wp_list_comments();  

		?> <div id="previous-post-link"> <?php
		previous_post_link('<strong>&laquo; %link </strong>', 'previous post');  
		?> </div> <?php

		?> <div id="next-post-link">  <?php
		next_post_link('<strong>%link &raquo; </strong>', 'next post'); 
		?> </div> <?php
		echo '<div class="horbar_clear_fix"></div>';
	}	
	// close the main loop		
	endwhile; 
	
		
	// handle not found conditions		
	else:   
			?>
	<h1>No posts found matching your search.<h1>
	<?php
	
endif;

?> </div><?php // note start immediately to create space in inline-block series

// show post side bar for all forms of post list (no page sidebar)

if(!$bbpress_switch && ($post_width == '' || $post_width == NULL || $post_width == 'normal'))
{	
	echo '<div id="right-sidebar-wrapper">';
	if ( dynamic_sidebar('post_sidebar') ) : else : endif;	
	echo '</div>';
}

// show post side bar for all forms of bbpress
elseif ($bbpress_switch)
{	
	echo '<div id="right-sidebar-wrapper">';
	if ( dynamic_sidebar('bbpress_sidebar') ) : else : endif;	
	echo '</div>';
}

?><?php  

 // empty bar to clear formatting -->
?><div class="horbar_clear_fix"></div><?php 
 
get_footer();