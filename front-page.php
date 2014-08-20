<?php
/*
* File: front-page.php
*
* Description: this template will be invoked as the front page if Admin>Settings>Reading>Front page displays is set to "Your Latest Posts" 
* 
* @package responsive-tabs 
* 
*/ 

/* assure that will die if accessed directly */ 
defined( 'ABSPATH' ) or die( "No script kiddies please!" );

// support settings>reading>front page displays -- see http://codex.wordpress.org/Creating_a_Static_Front_Page#Configuration_of_front-page.php
if ( 'posts' != get_option( 'show_on_front' ) ) { // use page template
    include( get_page_template() );
} else { // use this template
 
	get_header();
	
	/* 
	*
	* Highlighted message 
	*
	*/
	$highlight_headline = get_theme_mod( 'highlight_headline' );
	$highlight_subhead =  get_theme_mod( 'highlight_subhead' );
	$highlight_headline_small_screen = get_theme_mod( 'highlight_headline_small_screen' );
	
	if ( $highlight_headline > '  ' || $highlight_subhead > '  ' ) {
	  	echo '<div id = "highlight_text_area">';
			if( $highlight_headline > '    ' )	{
		      echo '<div  id="highlight_headline">' .
		 		  	$highlight_headline .  
		      '</div>';
			}
			if( $highlight_subhead > '    ' ) {          
				echo '<div  id="highlight_subhead">' .
					$highlight_subhead  .  
				'</div>';
			} 
			if( $highlight_headline_small_screen > '    ' ) {          
		      echo '<div  id="highlight_headline_small_screen">' .
		      	$highlight_headline_small_screen  .  
		      '</div>';
			}        
		echo '</div>
		<div class = "horbar-clear-fix"></div>'; 
	}
		
	echo '<div id="front-page-mobile-color-splash"></div>'; // displays only in mobile mode (not show highlighted message in mobile)
	
	/*
	* tabs area
	*
	*/
	$responsive_tabs_theme_options_array = get_option( 'responsive_tabs_theme_options_array' ); 
	if ( $responsive_tabs_theme_options_array['tab_titles'] > ' ' && $responsive_tabs_theme_options_array['tab_content'] > '  '  )
	{
	
	   $default_active_tab =  $responsive_tabs_theme_options_array['tab_active'];
		$active_tab = isset( $_GET[ 'frontpagetab' ] )  ? $_GET[ 'frontpagetab' ] : $default_active_tab;
	
		$tab_titles = $responsive_tabs_theme_options_array['tab_titles'];
		$tab_content =  $responsive_tabs_theme_options_array['tab_content'];
		        
		$tab_titles_array = explode( ',', $tab_titles );
		$tab_content_array = explode( ',', $tab_content );
		$tab_content_raw = $tab_content_array[$active_tab];
		$tab_content = trim( $tab_content_raw );    
		?>
		
	   <div id = "main-tabs-wrapper">
			
			<!-- desktop tabs -->   	
	   	<div id="main-tabs">
	   		<ul class = "main-tabs-headers"><?php
			   	$tab_title_count = 0;
			    	foreach ( $tab_titles_array as $tab_title ) {
			    		$nav_tab_active = $active_tab == $tab_title_count ? 'nav-tab-active' : 'nav-tab-inactive';
						echo '<li class="' . $nav_tab_active . '"><a href="/?frontpagetab=' . $tab_title_count .'"> '. $tab_title  .'</a></li>';
						$tab_title_count = $tab_title_count + 1;    			
					} ?> 
	        </ul>
	                
	        <!-- mobile tabs -->
	        <div id = "main-tabs-dropdown-wrapper">
					<select id = "main-tabs-dropdown-id" name = "main-tabs-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
	        			<?php $tab_title_count = 0;
						foreach ( $tab_titles_array as $tab_title ) {
	 						if( $active_tab == $tab_title_count ) {
								echo '<option value="">'. $tab_title  .'</option>';
							}
							$tab_title_count = $tab_title_count + 1;   
						} 
						$tab_title_count = 0;
						foreach ( $tab_titles_array as $tab_title ) {
	    					if( $active_tab != $tab_title_count ) {    		
								echo '<option value="/?frontpagetab=' . $tab_title_count .'"> '. $tab_title . '</option>';
							}
							$tab_title_count = $tab_title_count + 1;    			
						}?> 
	        		</select>
	        	</div>
	    
			<!-- display content for active tab-->
				<div class="main-tab-content"><?php
					
					if ($tab_content == "latest_posts") { 				
					// display standard latest posts list
					   get_template_part('post','list'); 
					} elseif( is_active_sidebar( $tab_content ) ) { 
					// display sidebar
						dynamic_sidebar( $tab_content );
						echo '<div class="horbar-clear-fix"></div>'; 
					} elseif( is_numeric( $tab_content ) ) { 			
					// display post or page and display content
						$post_f = get_post( $tab_content );
						$post_content = apply_filters( 'the_content', $post_f->post_content );
						echo  '<div id="front-page-post-entry">' . $post_content . '</div>'; 		
					}	else { 													
					// do shortcode
		     			$tab_content_return = do_shortcode( '[' . trim( $tab_content ) . ']' );
						if ( $tab_content_return != '[' . trim( $tab_content ) . ']' ) { // shortcode worked
							if( strpos ( $tab_content, 'bbp-topic-form' ) && ( !is_user_logged_in() || !current_user_can( 'edit_topics' ) ) ) { // close bbpress new topic form vulnerability
								_e( 'Please login to create new topic', 'responsive-tabs' );  
							} else {
								echo $tab_content_return;
							}
						} else { 
					// do direct widget call
							$tab_content_return = the_widget( trim( $tab_content ) );
							if ( $tab_content_return > '' ) { // widget worked
								echo $tab_content_return;
							} else { 
					// supported content options exhausted -- show error message
								_e( 'Check your setting corresponding to this tab under Dashboard>Appearance>Front Page Options>Tabs>Content for tabs', 'responsive-tabs');							
							}
						}
					} ?>
				<div><!-- main-tab-content -->
			<div><!-- main-tabs -->
		<div><!-- main-tabs-wrapper --><?php
	} // close tabs 
	else
	{
		echo '<h3>' .__( 'Please visit Dashboard>Appearance>Front Page Options>Tabs to set up your front page tabs.', 'responsive-tabs' ) . '</h3>';
	}

	get_footer();
} // close use this template condition