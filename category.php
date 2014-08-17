<?php
/*
*
* category.php
*
*/
defined('ABSPATH') or die("No script kiddies please!");
get_header();

echo '<!-- category.php -->';

echo '<div id = "content-header">';  
 get_template_part('breadcrumbs'); 
 echo '<h1>'; 
		single_cat_title();
		echo '</h1>'; 
 echo '<h4>'; 		
		$subargs = array(
				  'orderby' => 'name',
				  'order' => 'ASC',
                                  'hide_empty' => 0,
				  'parent' => $cat 
				  );	 
		$subcategories = get_categories($subargs);
		if ($subcategories) {		
		$sc_count = 0;		 
			 foreach($subcategories as $subcategory) {
			 	  if ($sc_count > 0) {echo ', ' . '&nbsp;';} 
		        echo '<a href="' . get_category_link( $subcategory->term_id ) . '" 
		        title="' . sprintf( __( "View all posts in %s" ), $subcategory->name ) . '" ' . '>' . strtolower($subcategory->name) .'</a>';
			 	  $sc_count = $sc_count+1; 
			    }		
		}
		
		echo "</h4></div>";   
	  

echo 	'<div id = "post-list-wrapper">';

// multiple post handler 
get_template_part('post','list');
echo '</div>';
?> 

	
 <!-- empty bar to clear formatting -->
<div class="horbar_clear_fix"></div><?php 
 
get_footer();