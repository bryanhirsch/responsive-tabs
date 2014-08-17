<?php
/*
*
* date.php
*
*/
get_header();

echo '<!-- author.php -->';
/* set up title for author search */


$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));


?>
<div id = "content-header">
<?php get_template_part('breadcrumbs'); ?> 
 <h1><?php 
echo $curauth->display_name; ?> </h1>

<select name="author-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
  <option value=""><?php echo esc_attr( __( 'Select Author' ) ); ?></option> 
<?php twcc_list_author_dropdown ($args); ?>
</select>
</div>
<?php  echo 	'<div id = "post-list-wrapper">';

// multiple post handler 
get_template_part('post','list');
echo '</div>'; 
?> 

	
 <!-- empty bar to clear formatting -->
<div class="horbar_clear_fix"></div><?php 
 
get_footer();