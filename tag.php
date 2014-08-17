<?php
/*
*
* date.php
*
*/
get_header();

echo '<!-- tag.php -->';
/* set up title for tag search */

  $t = get_query_var('tag');
  



// division wraps the non-sidebar, non-footer content
?>
<div id = "content-header">
<?php get_template_part('breadcrumbs'); ?> 
 <h1><?php 
echo 'Posts tagged "' . $tag; ?>"</h1>

</div>
<?php echo 	'<div id = "post-list-wrapper">';

// multiple post handler 
get_template_part('post','list');
echo '</div>';
?> 

	
 <!-- empty bar to clear formatting -->
<div class="horbar_clear_fix"></div><?php 
 
get_footer();