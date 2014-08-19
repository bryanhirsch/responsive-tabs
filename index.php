<?php
/*
 * File: index.php
 * Description: catchall template -- should never actually be accessed except for new taxonomies without appropriate support
 *
 * @package responsive-tabs
 *
 */

/* assure that will die if accessed directly */ 
defined( 'ABSPATH' ) or die( "No script kiddies please!" );

get_header();

?><!-- responsive-tabs index.php -->;

<div id = "content-header">

	<?php get_template_part('breadcrumbs'); ?> 

 	<h1><?php _e( 'Displaying Posts', 'responsive-tabs' ); ?> </h1>

</div> <!-- content-header -->   

<div id = "post-list-wrapper">

	<?php get_template_part( 'post', 'list' ); ?>
	
</div> <!-- post-list-wrapper-->
	
 <!-- empty bar to clear formatting -->
<div class="horbar-clear-fix"></div>

<?php get_footer();