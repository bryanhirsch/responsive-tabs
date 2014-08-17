<?php
/*
*
* date.php
*
*/
get_header();

echo '<!-- date.php -->';
/* set up title for date search */

  $m = get_query_var('m');
  $year = get_query_var('year');
  $monthnum = get_query_var('monthnum');
  $day = get_query_var('day');

$display_month = $monthnum ? $wp_locale->get_month($monthnum) . ' ' : ''; 
$display_day = $day ? $day . ', ' : '';
$display_date = $display_month . $display_day . $year;



// division wraps the non-sidebar, non-footer content
?>
<div id = "content-header">
<?php get_template_part('breadcrumbs'); ?> 
 <h1><?php 
echo 'Posts from ' . $display_date; ?> </h1>
	

<?php $args = array(
	'type'            => 'monthly',
	'limit'           => '',
	'format'          => 'option', 
	'before'          => '',
	'after'           => '',
	'show_post_count' => 1,
	'echo'            => 1,
	'order'           => 'DESC'
); 
?>


<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
  <option value=""><?php echo esc_attr( __( 'Select Month' ) ); ?></option> 
<?php wp_get_archives ($args); ?>
</select>
</div>
<?php echo 	'<div id = "post-list-wrapper">';

// multiple post handler 
get_template_part('post','list');
echo '</div>';
?> 

	
 <!-- empty bar to clear formatting -->
<div class="horbar_clear_fix"></div><?php 
 
get_footer();