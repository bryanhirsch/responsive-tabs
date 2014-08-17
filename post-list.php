<?php
// multiple post list handler 
if ( have_posts() ) { 

echo '<ul class="post-list">' . 
	  '<li class = "pl-odd"><ul class = "pl-headers"><li class="pl-post-title">Topic (comment count)</li><li class = "pl-post-author">Started by</li><li class = "pl-post-date-time">Date</li></ul></li>';
	
$count = 1; 
while (have_posts()) : the_post();	
	$count = $count+1;
	if($count % 2 == 0){$row_class = "pl-even";} else {$row_class = "pl-odd";} 
			$post_type = get_post_type();	
         // note that clippings are note excluded from searches.			
			if($post_type == "post" || $post_type == "page") 
			  { 
				  $link = get_permalink();
	  			  $title = get_the_title();
	  			  $excerpt = get_the_excerpt(); 
				}
				elseif ($post_type == 'twcc_clipping') 
				{
					$link = get_post_meta(get_the_id(), '_clipping_link',true);
					$title = 'News Item: '. get_the_title(); 
					$excerpt = get_the_content();
				}
				
			$guest_author = get_post_meta(get_the_ID(), 'twcc_post_guest_author',true );
			if ($guest_author === '') 
				{
					$author_entry = 	'<li class="pl-post-author"><a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) )  . '" title = "View all posts by '. get_the_author_meta('display_name')  .'">' . get_the_author_meta('display_name') . '</a></li>';
				}
			else 
				{
					$author_entry = '<li class="pl-post-author">'. $guest_author . '</li>'; 
				}
				  
			echo '<li class ="' . $row_class . '"><ul class="pl-post-item">' . 			
			'<li class="pl-post-title"><a href="'. $link .'" rel="bookmark" title="View item">' . $title . ' ('. get_comments_number().')' . '</a></li>' .
			$author_entry .
			'<li class="pl-post-date-time"><a href="'.get_month_link(get_post_time('Y'), get_post_time('m')).'" title = "View all posts from '. get_post_time('F') . ' ' . get_post_time('Y') .'">'. get_post_time('F') . '</a> ' .
			'<a href="'.get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')).'" title = "View posts from same day">'. get_post_time('jS') . '</a>, ' .
	      '<a href="'.get_year_link(get_post_time('Y')). '" title = "View all posts from '. get_post_time('Y')  .'">' . get_post_time('Y') . '</a></li>'.
         '</ul>' .
			'<div class="pl-post-excerpt">' . $excerpt . ' <br /> <a href="' . $link .'" rel="bookmark" title="Read the rest of this post">Read More &raquo; </a></div>'.         
         '</li>';

 	endwhile; 

	echo '</ul>'; // post-list

	// show multipost pagination links

	?> 
	<div id = "next-previous-links">
	<div id="previous-posts-link"> <?php
	previous_posts_link('<strong>&laquo; Newer Entries </strong>');
	?> </div> <?php
	
	?> <div id="next-posts-link">  <?php
	next_posts_link('<strong>Older Entries &raquo; </strong>');
	?> </div>
	</div> <?php
	}	
	// handle not found conditions		
	else{   
			?>
	<div id="not-found">
	<h3>No posts found matching your search.</h3>
	</div>
	<?php
	}
