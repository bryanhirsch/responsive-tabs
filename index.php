<?php
/*
*
* date.php
*
*/
get_header();

echo '<!-- index.php this template should never actually be accessed-->';

?>
<div id = "content-header">
<?php get_template_part('breadcrumbs'); ?> 
 <h1><?php 
echo 'Displaying Posts'; </h1>
</div>
<?php echo 	'<div id = "post-list-wrapper">';

// multiple post handler 
get_template_part('post','list');
echo '</div>';
?> 

	
 <!-- empty bar to clear formatting -->
<div class="horbar_clear_fix"></div><?php 
 
get_footer();