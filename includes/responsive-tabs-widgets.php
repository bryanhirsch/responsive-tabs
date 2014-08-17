<?php
/*
* Category widget
* http://code.tutsplus.com/articles/building-custom-wordpress-widgets--wp-25241
* http://codex.wordpress.org/Widgets_API
*/


add_action( 'widgets_init', 'register_twcc_widgets' );

function register_twcc_widgets() {
	register_widget ('rich_category_list');
	register_widget ('rich_comment_list');
	register_widget ('front_page_post_summary');
	register_widget ('front_page_new_topic');
	}

class rich_category_list extends WP_Widget {


	function __construct() {
		parent::__construct(
			'rich-category-widget', // Base ID
			__('Front Page Category List'), // Name
			array( 'description' => __( 'Top and second level categories', 'text_domain' ), ) // Args
		);
	}


	function widget( $args, $instance ) {
	extract( $args );
	$title = apply_filters('widget_title', $instance['title'] );
 
echo $before_widget;
 
// Display the widget title
if ( $title )
    echo $before_title . $title . $after_title;
 
$args = array(
  'orderby' => 'name',
  'order' => 'ASC',
  'hide_empty' => 0,
  'pad_counts' => 1
  );
echo  '<ul class = "rcw-category-list">' .

     	'<li class = "rcw-odd"><ul class = "rcw-category-headers"><li class="rcw-category-name">Category (post count)</li><li class = "rcw-subcategory-list">Subcategories</li></ul></li>';
     	
		$categories = get_categories($args);
		$categories = wp_list_filter($categories,array('parent'=>0));
		$count = 1;
		foreach($categories as $category) {
		  	$count = $count+1;
		  	if($count % 2 == 0){$row_class = "rcw-even";} else {$row_class = "rcw-odd";} 
		   echo '<li class = '. $row_class .' >
		   	<ul class = "rcw-category-list-item">' .
					'<li class="rcw-category-name">
						<a href="' . get_category_link( $category->term_id ) . 
		   	 			'" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . strtolower ( $category->name ) . ' (' .  $category->count . ')
		   	 			</a>
		   	 	 </li>';
			   $subargs = array(
				  'orderby' => 'name',
				  'order' => 'ASC',
				  'hide_empty' => 0,
				  'parent'=>$category->cat_ID,
  				  'pad_counts'  => 1
				  );	 
			   $subcategories = get_categories($subargs);
			  /*  $subcategories = wp_list_filter($subcategories,array('parent'=>$category->cat_ID)); */
					 echo '<li class = "rcw-subcategory-list">';
					 $sc_count = 0;		 
					 foreach($subcategories as $subcategory) {
					 	  if ($sc_count > 0) {echo ', ' . '&nbsp;';} 
				        echo '<a href="' . get_category_link( $subcategory->term_id ) . '" 
				        title="' . sprintf( __( "View all posts in %s" ), $subcategory->name ) . '" ' . '>' . strtolower ( $subcategory->name ) /* .' ('.$subcategory->count.') */. '</a>';
					 	  $sc_count = $sc_count+1; 
					    }
					 echo '</li>'; // rcw-subcategory-list
			 echo '</ul></li>'; // rcw-category-list-item    
		    }

echo "</ul>"; // rcw-category-list

echo $after_widget;
}

function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
 
    //Strip tags from title and name to remove HTML
    $instance['title'] = strip_tags( $new_instance['title'] );
    return $instance;
}

function form($instance) {
			if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Rich Category List' );
		}

	// Widget Title: Text Input
	?>
	<p>
	    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
	    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
	</p>

	<?php
}
}


/**
 * Recent_Comments widget class derived from WP_widget_comment_list in default-widgets.php
 *
 * @since 2.8.0
 */
class rich_comment_list extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_comment_list', 'description' => __( 'List with excerpts -- most recent comments.' ) );
		parent::__construct('recent-comments', __('Front Page Comment List'), $widget_ops);
		$this->alt_option_name = 'widget_comment_list';
	}

	function widget( $args, $instance ) {
		global $comments, $comment;

 		extract($args, EXTR_SKIP);
 		$output = '';

		$title = $instance['title'];
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
 			$number = 5;


		$args = array( 
			'comment_type' => '', 
			'number' => $number, 
			'status' => 'approve', 
			'post_status' => 'publish',
			'orderby' => 'post_ID',
			'order' => 'desc', 
			);
				
		// The Query
		$comments_query = new WP_Comment_Query;
		$comments = $comments_query->query( $args );


		/* $comments = get_comments( apply_filters( 'widget_comments_args', array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish' ) ) );*/
		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<ul class = "cwe-list">';
		if ( $comments ) {
			// Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
			$post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
			_prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );
				$output .= '<li class="cwe-odd"><ul class="cwe-list-headers"><li class="cwe-author">Commenter</li><li class="cwe-post">Commenting on<li class="cwe-date-time">Date, time</li></ul></li>';		
			$count = 1; 			
			foreach ( (array) $comments as $comment) {
				$editor = FALSE;
				if($comment->user_id > 0) {$editor = user_can($comment->user_id, 'delete_others_posts');} 
				if(!$editor) {
			  	$count = $count+1;
			  	if($count % 2 == 0){$row_class = "cwe-even";} else {$row_class = "cwe-odd";} 
			   $comment_date_time = new DateTime($comment->comment_date);
			   $output .=  '<li class="' . $row_class . '"><ul class="cwe-list-item">' . 
					'<li class="cwe-author">'. get_comment_author_link() .
					'</li><li class="cwe-post"><a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' .	get_the_title($comment->comment_post_ID) . 
					'</a></li><li class="cwe-date-time">' . $comment_date_time->format('M-d-Y, H:i:s') . 
					'</li></ul><div class = "cwe-excerpt">' . $this->get_long_comment_excerpt($comment->comment_ID) . 
					'</br> <span class="comment-in-context"><a href="'. esc_url( get_comment_link($comment->comment_ID) ) . '">View Comment in Context &raquo;' . '</a></span></div></li>';
            }
			}
 		}
		$output .= '</ul>';  // .cwe-list
		$output .= $after_widget;

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		/* $this->flush_widget_cache(); */

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_comment_list']) )
			delete_option('widget_comment_list');

		return $instance;
	}
// http://developer.wordpress.org/reference/functions/get_comment_excerpt/
function get_long_comment_excerpt( $comment_ID = 0 ) {
    $comment = get_comment( $comment_ID );
    $comment_text = strip_tags($comment->comment_content);
    $blah = explode(' ', $comment_text);
    if (count($blah) > 100) {
        $k = 100;
        $use_dotdotdot = 1;
    } else {
        $k = count($blah);
        $use_dotdotdot = 0;
    }
    $excerpt = '';
    for ($i=0; $i<$k; $i++) {
        $excerpt .= $blah[$i] . ' ';
    }
     $excerpt .= ($use_dotdotdot) ? '&hellip;' : '';
      
    /**
     * Filter the retrieved comment excerpt.
     *
     * @since 1.5.0
     *
     * @param string $excerpt The comment excerpt text.
     */
    return apply_filters( 'get_comment_excerpt', $excerpt );
}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of comments to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}

/* author drop down
	https://core.trac.wordpress.org/browser/tags/3.9.1/src/wp-includes/author-template.php#L0
	http://codex.wordpress.org/Template_Tags/wp_list_authors

*/


function twcc_list_author_dropdown($args = '') {
	
	
	        global $wpdb;
	
	        $defaults = array(
	                'orderby' => 'name', 'order' => 'ASC', 'number' => '',
	                'optioncount' => false, 'exclude_admin' => true,
	        );
	
	        $args = wp_parse_args( $args, $defaults );
	        extract( $args, EXTR_SKIP );
	        
	        $return = '';
	
	        $query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number', 'exclude', 'include' ) );
	        $query_args['fields'] = 'ids';
		
	        $authors = get_users( $query_args );

	        $author_count = array();
	        foreach ( (array) $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author") as $row )
	                $author_count[$row->post_author] = $row->count;
	
	        foreach ( $authors as $author_id ) {
	                $author = get_userdata( $author_id );
	
	                if ( $exclude_admin && 'admin' == $author->display_name )
	                        continue;
	
	                $posts = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;
	
	                if ( !$posts )
	                        continue;
	
	               $link = '';
	
                  $name = $author->display_name;
	
                  $return .= '<option value = "';

                  $link =  get_author_posts_url( $author->ID, $author->user_nicename ) . '"> ' . $name . ' ('. $posts . ')';

                  $return .= $link;
                 $return .= '</option>';
	        }
		        echo $return;
	        
	}
	
/* function puts all archive searches out in one line */
function twcc_output_archive_searches(){
	
	
$argsm = array(
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




<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<input type="search" class="search-field" placeholder="Search …" value="<?php echo $query_vars['s']; ?>" name="s"  />
	</label>
	<input type="submit" class="search-submit" value="search text" /></h1>
<?php echo strtolower(wp_dropdown_categories('echo=0&orderby=NAME&hierarchical=1&hide_if_empty=1&show_count=1&show_option_none=Select category')); ?>

<script type="text/javascript"><!--
    var dropdown = document.getElementById("cat");
    function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
			location.href = "<?php echo get_option('home');
?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
		}
    }
    dropdown.onchange = onCatChange;
--></script>
<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
  <option value=""><?php echo esc_attr( __( 'select month' ) ); ?></option> 
<?php wp_get_archives ($argsm); ?>
</select>

<select name="author-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
  <option value=""><?php echo esc_attr( __( 'select author' ) ); ?></option> 
<?php twcc_list_author_dropdown (); ?>
</select>






</form>
<?php
} // end archive search

/*
* Widget to ease population of front page
*
*/

class front_page_post_summary extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_front_page_summary', 'description' => __( 'Show lead to one or more posts in front page bulk widget.' ) );
		parent::__construct('front_page_summary', __('Front Page Post Summary'), $widget_ops);
		$this->alt_option_name = 'front_page_summary';
	}

	function widget( $args, $instance ) {
		
 		extract($args, EXTR_SKIP);
 		$output = '';
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$output .=  $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;
 			$output .= '<div class ="textwidget">';

//		$title = $instance['title'];
//		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$post_list =  $instance['post_list'];
		$single_display_mode = $instance['single_display_mode'];
		$post_list_array = explode(',',$post_list);
		if (count($post_list_array)>1) {
			$output .= '<ul class="front-page-widget-post-list">';
				foreach ($post_list_array as $post_ID){
				$permalink = get_permalink($post_ID);
				$title = get_the_title ($post_ID);
				if($title){$output .= '<li><a href="'. $permalink . '" title = "Read post' . $title . '">' . $title .'</a></li>';}		
		
				}		
		$output .= '</ul>';  		
		}
		elseif(count($post_list_array) == 1) {
		foreach ($post_list_array as $post_ID){
				$permalink = get_permalink($post_ID);
				$post = get_post($post_ID);
				
				if($single_display_mode == 'excerpt')				
				$output .= apply_filters('the_excerpt', $post->post_excerpt) . '<a href="'. $permalink . '" title = "Read post' . $title . '"> Read More &raquo;</a>';	
				elseif($single_display_mode == 'image')				
				$output .=  '<a href="'. $permalink . '" title = "Read post: ' . apply_filters('the_title', $post->post_title) . '"> '. get_the_post_thumbnail($post_ID, 'front-page-thumb').'</a>';		  
		      elseif($single_display_mode == 'both')
		      $output .=  '<div class = "bulk-image-float-left"><a href="'. $permalink . '" title = "Read post: ' . apply_filters('the_title', $post->post_title) . '"> '. get_the_post_thumbnail($post_ID, 'front-page-half-thumb').'</a></div>' .
		      strip_tags($post->post_excerpt) . '<a href="'. $permalink . '" title = "Read post' . $title . '"> Read More &raquo;</a>';	
		  }     
		} 

		$output .= '</div>';
		$output .= $after_widget ;

		echo $output;
	}




	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
      $post_list_raw = $new_instance['post_list'];
      $post_list_array = explode(',', $post_list_raw );
		$post_list_clean = '';      
      foreach($post_list_array as $post_list_entry){
      $post_list_addition = is_numeric(trim($post_list_entry))?trim($post_list_entry).',':'';
      $post_list_clean .= $post_list_addition;
      }		
		if($post_list_clean > '') {$post_list_clean= rtrim($post_list_clean,',');}
		$instance['post_list'] =  $post_list_clean;
		$instance['single_display_mode'] = strip_tags($new_instance['single_display_mode']);
		return $instance;
	}


	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$post_list = isset( $instance['post_list'] ) ? strip_tags( $instance['post_list'] ) : '';
		$single_display_mode = isset( $instance['single_display_mode'] ) ? strip_tags( $instance['single_display_mode'] ) : '';
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'post_list' ); ?>"><?php _e( 'ID numbers of posts to show (single or multiple separated by commas):<br />' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'post_list' ); ?>" name="<?php echo $this->get_field_name( 'post_list' ); ?>" type="text" value="<?php echo $post_list; ?>" size="30" /></p>
<?php
       $single_display_options = array(
		'0' => array(
			'value' =>	'excerpt',
			'label' =>      'Show excerpt for single '
		),
		'1' => array(
			'value' =>	'image',
			'label' =>  	'Show image for single' 
		),
		'2' => array(
			'value' => 'both',
			'label' => 'Show image and excerpt for single'
		),
			);
	$selected = $single_display_mode; 	 
    ?><label for="single_display_mode">Display mode for single posts (if multiple, will only show titles):<br /> </label>
		<select id="<?php echo $this->get_field_id( 'single_display_mode' ); ?>" name="<?php echo $this->get_field_name( 'single_display_mode' ); ?>">   	
<?php
	$p = '';
	$r = '';
	foreach (  $single_display_options as $option ) {
	    	$label = $option['label'];
		if ( $selected == $option['value'] ) // Make selected first in list
		     $p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
		else $r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
               	}
 	echo $p . $r. '</select>';
	}
}



/*
* Widget for new topic
*
*
*
***********************************************************************************************************/



class front_page_new_topic extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_front_page_new_topic', 'description' => __( 'Allow front end new topic entry' ) );
		parent::__construct('front_page_new_topic', __('Front Page New Topic Form'), $widget_ops);
		$this->alt_option_name = 'front_page_new_topic_form';
	}

	function widget( $args, $instance ) {
		
 		extract($args, EXTR_SKIP);
 		
/*
*
* code to save new posts on submission 
*
*/

$post_ID = 0;
$post_message = '';
$has_error = false;

/* do nothing unless submitted and passed nonce test */
if(isset($_POST['submitted']) && isset($_POST['twcc_front_page_new_post_nonce_field']) && 
		wp_verify_nonce($_POST['twcc_front_page_new_post_nonce_field'], 'twcc_front_page_new_post')) 
		{
			
      
   	$post_author = get_current_user_id() ? get_current_user_id() : $instance['guest_post_id'];	
		// var_dump($_POST);


		// for anonymous users, check current user id
		if (!get_current_user_id()) { 
				if(strlen(trim($_POST['post_guest_author'])) < 4) {
						$post_message .= '<li>Please enter a name with 4 or more characters.</li>';
						$has_error = true;
					}
						
					if(!filter_var(trim($_POST['post_guest_author_email']), FILTER_VALIDATE_EMAIL)) {
						$post_message .= '<li>Please enter a valid email.</li>';
						$has_error = true;
					} 
				}
		 
		// require some quantum of content to be entered    
		if(strlen(trim($_POST['post_title'])) < 6) {
			$post_message .= '<li>Please enter a title with 6 or more characters.</li>';
			$has_error = true;
		} 
		
		if(strlen(trim($_POST['twcc_new_post_content'])) < 50) {
			$post_message .= '<li>Post content must have at least 50 characters.</li>';
			$has_error = true;
		} 

      if($has_error == true) { 
          	$post_message = 'Your post has errors: <ul id= "new-post-error-list">'  . $post_message . '</ul>';
				$post_id = $_POST['post_id']; // if we are in this branch, form was submitted but had errors -- want to carry post_id whether 0 or already set
		}				
   	else {// if no errors, spam check and save or udpate post

					/* note, need to use generic akismet interface as Wordpress plugin class 
					does not offer functions serving non-comments compare bbpress which writes its own class using elements from 
					the main plugin and the class referenced here */ 
		   
		   $comment = array(
		        'author'    => trim($_POST['post_guest_author']),
		        'email'     => trim($_POST['post_guest_author_email']),
		        'body'      => trim($_POST['post_content']),
		        'permalink' => 'http://localhost/?frontpagetab=4'
		   );
		  
		  $akismet_api_key = apply_filters( 'akismet_get_api_key', defined('WPCOM_API_KEY') ? constant('WPCOM_API_KEY') : get_option('wordpress_api_key') );
		  
		  $akismet = new Akismet_TWCC('http://willbrownsberger.com', $akismet_api_key, $comment);
		 
		  if($akismet->errorsExist()) {
		      echo"Problem with Akismet spam detection.";
		  } else {
		      if($akismet->isSpam()) {
		         // $post_message .= '<li>Your post is activating our spam filters.</li>';
		         // $has_error = true;
		         $new_post_status = 'new_post_spam'; 
		      }
		  }
		 /* end akismet call */
      
	   		
		
		
		
			/* $all_of_it = $_POST['post_title']. $_POST['twcc_new_post_content'] . 
					$_POST['twcc_new_post_cat'] . $_POST['post_guest_author'] . 
						$_POST['post_guest_author_email'];
			$hash_crc32 = hash('crc32', $all_of_it);
			if(isset($_COOKIE[$hash_crc32]))
					echo 'you refreshed chump';
					else setcookie ($hash_crc32); */
			 /* possible TODO: provide protection against refresh dupe post.  This approach doesn't work because headers already sent */
			
			if (!$new_post_status=='new_post_spam')  $new_post_status = $instance['initial_post_status'];			
			
			$default_comment_status = get_option('default_comment_status');
			
			$post_information = array(
				'post_title' => stripslashes($_POST['post_title']),
				'post_content' => $_POST['twcc_new_post_content'],
				'post_type' => 'post',
				'post_status' => $new_post_status,
				'post_author' => $post_author,
				'post_category' => array($_POST['twcc_new_post_cat']),
				'comment_status' => $default_comment_status, //(take the default value)
				'ID' =>$_POST['post_id']
			);
		
			$post_id = wp_insert_post($post_information);
		
		   if (!get_current_user_id()) {
	
					if ( ! update_post_meta ($post_id, 'twcc_post_guest_author', $_POST['post_guest_author']) ) { 
					add_post_meta($post_id, 'twcc_post_guest_author', $_POST['post_guest_author'], true );
						}	
					if ( ! update_post_meta ($post_id, 'twcc_post_guest_author_email', $_POST['post_guest_author_email']) ) { 
					add_post_meta($post_id, 'twcc_post_guest_author_email', $_POST['post_guest_author_email'], true );
						}
			}; 
			
			if($post_id > 0)	{
			   if ($_POST['post_id']> 0) {	
			 		$post_message .= 'Your post, #' . $post_id . ', has been updated.'; 
			 	}
				else {
					$post_message .= 'Your new post has been submitted as post #'.$post_id . '.';
				}	
				$post_message .= '  You can edit below or ';
				if ($new_post_status =='pending' || $new_post_status == 'new_post_spam')
					{$post_message .= '<a href="/">return to home.</a> Your post is pending review.';}
				elseif ($new_post_status=='publish')
						{	$post_message .= '<a href="/?p='.$post_id.'"> view your finalized post.</a>';	}
			} // close $post_id > 0 i.e., message on successful insert or update
		} // close insert/updates conditional on passing error tests

} // close nonce tested updates



// output widget title
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo  $before_widget;
		if ( $title )	echo $before_title . $title . $after_title;
 		echo '<div id = "new-post-widget">';	
// output before text matter 		
 		echo $instance['before_text'] ;
// output form
?>
<?php if (current_user_can('edit_posts') || get_user_by('id',$instance['guest_post_id']) ) { 
  // only show form if user can edit posts or anonymous users can post to the guest ID;  
  // note that if logged in user cannot edit posts, but anonymous can, the logged in user will be allowed to post  
 
?><form action="" id="front-page-new-topic-form" method="POST">
     
		<?php if ( $post_message != '' ) { 
					$message_class = $has_error ? 'twcc-warning' : 'twcc-update'; ?>
		    <div id="new-post-message-box" class="<?php echo $message_class; ?>"><?php echo $post_message; ?></div>
		    <?php } ?> 
 
 		<?php if(get_current_user_id() == 0) { ?>
    					<p><input type="text" name="post_guest_author" id="post_guest_author" value="<?php if ( isset( $_POST['post_guest_author'] ) ) echo $_POST['post_guest_author']; ?>"/>
						<label for="post_guest_author"><?php _e('Your Name', 'twcc_text_domain') ?></label></p>		       
			        <p><input type="text" name="post_guest_author_email" id="post_guest_author_email" value="<?php if ( isset( $_POST['post_guest_author_email'] ) ) echo $_POST['post_guest_author_email']; ?>"/>
						<label for="post_guest_author_email"><?php _e('Your Email (will not be published)', 'twcc_text_domain') ?></label></p>		
		<?php } ?>
 
      <p><input type="text" name="post_title" id="post_title" value="<?php if ( isset( $_POST['post_title'] ) ) echo stripslashes($_POST['post_title']); ?>"/>
    	<label for="post_title"><?php _e('Post Title', 'twcc_text_domain') ?></label></p>
      
       <textarea name="twcc_new_post_content" id="twcc_new_post_content" rows="15" cols="60" class="required"><?php if ( isset( $_POST['twcc_new_post_content'] ) ) { if ( function_exists( 'stripslashes' ) ) { echo stripslashes( $_POST['twcc_new_post_content'] ); } else { echo $_POST['twcc_new_post_content']; } } ?></textarea>
               <!-- post Category -->
		<br /> <br />       
       <?php if($instance['show_category_select']) { 	            
                        
             	$dropdown_cat_args = array(
             			'show_option_all'    => '',
							'show_option_none'   => '',
							'orderby'            => 'name', 
							'order'              => 'ASC',
							'show_count'         => 0,
							'hide_empty'         => 0, 
							'child_of'           => 0,
							'exclude'            => '',
							'echo'               => 1,
							'selected'           => (int)$_POST['twcc_new_post_cat'],
							'hierarchical'       => 1, 
							'name'               => 'twcc_new_post_cat',
							'id'                 => 'twcc_new_post_cat',
							'class'              => 'postform',
							'depth'              => 0,
							'tab_index'          => 0,
							'taxonomy'           => 'category',
							'hide_if_empty'      => false,
             	);              
             
              wp_dropdown_categories($dropdown_cat_args ); ?>
          		<label for="twcc_new_post_cat">Discussion Category</label>
	             <br/><br />
	   <?php } ?>
	   
		<?php wp_nonce_field('twcc_front_page_new_post', 'twcc_front_page_new_post_nonce_field'); ?>

		<input type="hidden" name="submitted" id="submitted" value="true" />

		<input type="hidden" name="post_id" value="<?php echo $post_id; ?>"> 

		<?php $add_post = ($post_id > 0) ? 'Update' : 'Save'; ?>
		<button id="new_post_submit" type="submit"><?php _e($add_post, 'twcc_text_domain') ?></button>
		<br />
</form>
<?php
 }// end output new topic form
else {
		echo '<h3>New topic form not configured for anonymous input, please login to post. </h3>';
		}

 		echo $instance['after_text'];
		echo '</div>';
		echo $after_widget ;
} // close widget output


/*
* update the widget itself
*/


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['before_text'] = force_balance_tags($new_instance['before_text']);
		$instance['after_text'] = force_balance_tags($new_instance['after_text']);
		$instance['guest_post_id'] = absint($new_instance['guest_post_id']);
		$instance['initial_post_status'] = strip_tags($new_instance['initial_post_status']);
		$instance['show_category_select'] = absint($new_instance['show_category_select']);
		return $instance;
	}

/*
* form for update of new widget
*
*/

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$before_text = isset( $instance['before_text'] ) ?  $instance['before_text']  : '';
		$after_text = isset( $instance['after_text'] ) ?  $instance['after_text']  : '';
		$guest_post_id = isset( $instance['guest_post_id'] ) ?  $instance['guest_post_id']  : 0;
		$initial_post_status = isset( $instance['initial_post_status'] ) ?  $instance['initial_post_status']  : '';
		$show_category_select = isset( $instance['show_category_select'] ) ?  $instance['show_category_select']  : 0;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'before_text' ); ?>"><?php _e( 'Text before form:<br />' ); ?></label>
		 <textarea type="text" cols="40" rows="5"  id="<?php echo $this->get_field_id( 'before_text' ); ?>"  name="<?php echo $this->get_field_name( 'before_text' ); ?>"><?php echo $before_text;?> </textarea>

		<p><label for="<?php echo $this->get_field_id( 'after_text' ); ?>"><?php _e( 'Text after form:<br />' ); ?></label>
		 <textarea type="text" cols="40" rows="5"  id="<?php echo $this->get_field_id( 'after_text' ); ?>"  name="<?php echo $this->get_field_name( 'after_text' ); ?>"><?php echo $after_text;?> </textarea>

		<p><label for="<?php echo $this->get_field_id( 'guest_post_id' ); ?>"><?php _e( 'User ID# for guest posts if to be permitted (adding a valid ID # here will permit them):' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'guest_post_id' ); ?>" name="<?php echo $this->get_field_name( 'guest_post_id' ); ?>" type="text" value="<?php echo $guest_post_id; ?>" size="8" /></p>

<?php
       $post_status_options = array(
		'0' => array(
			'value' =>	'pending',
			'label' =>      'Save new posts as pending '
		),
		'1' => array(
			'value' =>	'publish',
			'label' =>  	'Save new posts as published' 
		),
		
			);
	$selected = $initial_post_status; 	 
    ?><label for="initial_post_status">Choose post status for new posts<br /> </label>
		<select id="<?php echo $this->get_field_id( 'initial_post_status' ); ?>" name="<?php echo $this->get_field_name( 'initial_post_status' ); ?>">   	
<?php
	$p = '';
	$r = '';
	foreach (  $post_status_options as $option ) {
	    	$label = $option['label'];
		if ( $selected == $option['value'] ) // Make selected first in list
		     $p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
		else $r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
               	}
 	echo $p . $r. '</select>';
   ?><p><label for="<?php echo $this->get_field_id( 'show_category_select' ); ?>"><?php _e( 'Allow user to assign category: ' ); ?></label><?php
   echo  '<input type="checkbox" id="'. $this->get_field_id('show_category_select')  .'" name="'. $this->get_field_name('show_category_select')  .'" value="1" ' . checked( '1',  $instance['show_category_select'] , false ) .'/></p>';
   
 
       
	}
}



