<?php
/*
*
* date.php
*
*/
get_header();

echo '<!-- search.php -->';
/* set up title for author search */

global $wp_query;
$total_results = $wp_query->found_posts;
$query_vars = $wp_query->query_vars;

?><?

?>
<div id = "content-header">
<?php get_template_part('breadcrumbs'); ?> 
 <h1>Search for "<?php echo $query_vars['s']; ?>" found <?php echo $total_results; ?> posts.</h1>
<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<input type="search" class="search-field" placeholder="Search …" value="<?php echo $query_vars['s']; ?>" name="s"  />
	</label>
	<input type="submit" class="search-submit" value="Redo Search" /></h1>
</form>

</div>
<?php  echo 	'<div id = "post-list-wrapper">';

// multiple post handler 
get_template_part('post','list');
echo '</div>'; 
?> 

	
 <!-- empty bar to clear formatting -->
<div class="horbar_clear_fix"></div><?php 
 
get_footer();