<?php
/*
* front-page.php
*
* Note: this will get invoked regardless of choices made at Settings>Reading>Front page displays 
* See: https://codex.wordpress.org/Creating_a_Static_Front_Page
* The display settings are, in fact, followed, however, by the core before it gets to invoking the theme
*  -- a WP-query object is created for latest posts or the page retrieved (no obvious difference in 
* 
*/
if ( 'posts' != get_option( 'show_on_front' ) ) {
    include( get_page_template() );
} else {
 

get_header();
?>

<?php
$responsive_tabs_theme_options_array = get_option( 'responsive_tabs_theme_options_array' ); 


/*
* Highlighted message
*
*/


$highlight_headline = get_theme_mod('highlight_headline');
$highlight_subhead =  get_theme_mod('highlight_subhead');
$highlight_headline_small_screen = get_theme_mod('highlight_headline_small_screen');

if ($highlight_headline > '    ' || $highlight_subhead > '    ' )
{
  	echo '<div id = "highlight_text_area">';
		if($highlight_headline > '    ')
		{
		          echo '<div  id="highlight_headline">'
 		          	. $highlight_headline. '  
		          </div>';
		}
		if($highlight_subhead > '    ')
		{          
		          echo '<div  id="highlight_subhead"> '
		          	. $highlight_subhead  . ' 
		          </div>';
		} 
		if($highlight_headline_small_screen > '    ')
		{          
		          echo '<div  id="highlight_headline_small_screen"> '
		          	. $highlight_headline_small_screen  . ' 
		          </div>';
		}        
	echo '</div>
	<div class = "horbar_clear_fix"></div>'; 
}
	
echo '<div id="front-page-mobile-color-splash"></div>';

/*
* tabs area
*
*/
if (isset($responsive_tabs_theme_options_array['tab_titles']) && isset($responsive_tabs_theme_options_array['tab_content'])  )
{
/*
* here make tabs work
*
*/

        $default_active_tab =  $responsive_tabs_theme_options_array['tab_active'];
	$active_tab = isset( $_GET[ 'frontpagetab' ] )  ? $_GET[ 'frontpagetab' ] : $default_active_tab;

	$tab_titles = $responsive_tabs_theme_options_array['tab_titles'];
	$tab_content =  $responsive_tabs_theme_options_array['tab_content'];
	$user_cannot_edit_topics = $responsive_tabs_theme_options_array['user_cannot_edit_topics'];

        
	$tab_titles_array = explode(',',$tab_titles);
	$tab_content_array = explode(',',$tab_content);
	$tab_content_raw = $tab_content_array[$active_tab];
	$tab_content = trim($tab_content_raw);    

        echo '<div id = "main-tabs-wrapper"><div id="main-tabs"><ul class = "main-tabs-headers">';
        $tab_title_count = 0;
    	foreach ($tab_titles_array as $tab_title) {
    		$nav_tab_active = $active_tab == $tab_title_count ? 'nav-tab-active' : 'nav-tab-inactive';
		echo '<li class="' . $nav_tab_active . '"><a href="/?frontpagetab=' . $tab_title_count .'"> '. $tab_title  .'</a></li>';
		$tab_title_count = $tab_title_count + 1;    			
	} 
        echo '</ul>';
        
        
        /* mobile tabs */
        
        echo '<div id = "main-tabs-dropdown-wrapper">
        	<select id = "main-tabs-dropdown-id" name = "main-tabs-dropdown" 
        		onchange="document.location.href=this.options[this.selectedIndex].value;">';
        $tab_title_count = 0;
    	 foreach ($tab_titles_array as $tab_title) {
    		if($active_tab == $tab_title_count)
		{echo '<option value="">'. $tab_title  .'</option>';}
		$tab_title_count = $tab_title_count + 1;   
	} 

        $tab_title_count = 0;
    	foreach ($tab_titles_array as $tab_title) {
    		if($active_tab != $tab_title_count)    		
		echo '<option value="/?frontpagetab=' . $tab_title_count .'"> '. $tab_title . '</option>';
		$tab_title_count = $tab_title_count + 1;    			
	} 
        echo '</select></div>';
        
        /* mobil tabs*/

	echo '<div class="main-tab-content">';
	if ($tab_content == "latest_posts")
	{
   echo '<div id = "front-page-post-list">';
	   get_template_part('post','list');
	echo '</div>';
	}
	if ($tab_content == "latest_clippings")
	{
   echo '<div id = "front-page-post-list">';
	   if($responsive_tabs_theme_options_array['show_publications']) show_latest_news_clips();
	echo '</div>';
	}
	if ($tab_content == "archive_search")
	{
   		twcc_output_archive_searches();
	}
	else if ($tab_content == "home_widgets") 
	{
		echo '<div id = "home_widget_area">';
	
			echo '<div id = "home_bulk_widgets">';
				if ( dynamic_sidebar('home_bulk_widget') ) : else : endif;
			echo '</div>';
			
		echo '<div class="horbar_clear_fix"></div>' .
		'</div>'; // close home_widget_area
	}
	else if($tab_content == "home_widget_2")
	{
				if ( dynamic_sidebar('home_widget_2') ) : else : endif;
		
	}
	else if($tab_content == "home_widget_3")
	{
				if ( dynamic_sidebar('home_widget_3') ) : else : endif;
		
	}
	else if($tab_content == "home_widget_4")
	{
				if ( dynamic_sidebar('home_widget_4') ) : else : endif;
		
	}
	else if(is_numeric($tab_content)) {
		$post_f = get_post($tab_content);
		$post_content = apply_filters( 'the_content', $post_f->post_content );
		echo  '<div id="front-page-post-entry">' . $post_content . '</div>'; 		
		}
	else {
		if(strpos($tab_content, 'bbp-topic-form') && (!is_user_logged_in() || !current_user_can('edit_topics'))) 
			{echo $user_cannot_edit_topics; } 
		else {
       			$tab_content_return = do_shortcode('[' . trim($tab_content) . ']');
					if ($tab_content_return != '[' . trim($tab_content) . ']')
						{echo $tab_content_return;}
					else { echo the_widget(trim($tab_content));}
		}
	}


echo "</div></div></div>";

} // close tabs 
else
{
	echo 'Please visit Front Page Options under the Appearance menu in Admin view to set up your front page!';
}


get_footer();

}