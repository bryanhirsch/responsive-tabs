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
defined( 'ABSPATH' ) or die( "Unauthorized direct script access." );

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
	  	echo '<div id = "highlight-text-area">';
			if( $highlight_headline > '    ' )	{
		      echo '<div  id="highlight-headline">' .
		 		  	$highlight_headline .  
		      '</div>';
			}
			if( $highlight_subhead > '    ' ) {          
				echo '<div  id="highlight-subhead">' .
					$highlight_subhead  .  
				'</div>';
			} 
			if( $highlight_headline_small_screen > '    ' ) {          
		      echo '<div  id="highlight-headline-small-screen">' .
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
	$mods = get_theme_mods();
		
	$default_active_tab 	=  max ( get_theme_mod( 'landing_tab' ) - 1 , 0 ); // admin shows tabs starting from 1

	$active_tab 			= isset( $_GET[ 'frontpagetab' ] )  ? $_GET[ 'frontpagetab' ] : $default_active_tab;

	$tab_titles 			= get_theme_mod( 'tab_titles' );
	
	if ( ! $tab_titles > '' ) {
		$tab_titles 		= 'getting started, latest posts';
	}
	$tab_titles_array 	= explode( ',', $tab_titles );
	
	?>
	
   <div id = "main-tabs-wrapper">
		
		<!-- desktop tabs -->   	
   	<div id="main-tabs">
   		<ul class = "main-tabs-headers"><?php
		   	$tab_title_count = 0;
		    	foreach ( $tab_titles_array as $tab_title ) {
		    		$nav_tab_active = $active_tab == $tab_title_count ? 'nav-tab-active' : 'nav-tab-inactive';
					echo '<li class="' . $nav_tab_active . '"><a href="/?frontpagetab=' . $tab_title_count . '"> '. esc_html( trim( $tab_title ) )  .'</a></li>';
					$tab_title_count = $tab_title_count + 1;    			
				} ?> 
        </ul>
                
        <!-- mobile tabs -->
        <div id = "main-tabs-dropdown-wrapper">
				<select id = "main-tabs-dropdown-id" name = "main-tabs-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
        			<?php $tab_title_count = 0;
					foreach ( $tab_titles_array as $tab_title ) {
 						if( $active_tab == $tab_title_count ) {
							echo '<option value="">' . esc_html( $tab_title )  . '</option>';
						}
						$tab_title_count = $tab_title_count + 1;   
					} 
					$tab_title_count = 0;
					foreach ( $tab_titles_array as $tab_title ) {
    					if( $active_tab != $tab_title_count ) {    		
							echo '<option value="/?frontpagetab=' . $tab_title_count . '"> ' . esc_html( $tab_title ) . '</option>';
						}
						$tab_title_count = $tab_title_count + 1;    			
					}?> 
        		</select>
        	</div>
    
		<!-- display content for active tab-->
			<div class="main-tab-content"><?php
				if( is_active_sidebar( 'home_widget_' . ( $active_tab + 1 ) ) ) { 
					// display sidebar
					dynamic_sidebar( 'home_widget_' . ( $active_tab + 1 ) );
					echo '<div class="horbar-clear-fix"></div>'; 
				} else { 
					if ( strtolower( trim( $tab_titles_array[$active_tab] ) ) == "getting started" ) { ?>
						<div class = "responsive-tabs-notice">
							<h1> <?php _e('Welcome to Responsive Tabs!', 'responsive-tabs' ); ?> </h1> 
							<?php 	_e( 	'<h4>Overview of Responsive Tabs</h4>
    			<p>The Responsive Tabs theme gives you great structural flexibility in defining and redefining your front page content. 
    			Visit <a href="http://twowayconstituentcommunication.com">twowayconstituentcommunication.com</a> for a simple example of this theme in action.  
    			Visit <a href = "http://WillBrownsberger.com">WillBrownsberger.com</a> for a more fully-developed implementation of this theme.  
    			Please feel free to email <a href="mailto: will@twowayconstituentcommunication.com">will@twowayconstituentcommunication.com</a> with any questions.</a></p>
				<h4>Basic Setup</h4>    		  	
    		  	<ol>
    		  		<li>Enter the titles you want, separated by commas, in Appearance>Customize>Tab Titles, like so: <br />
    		  		<code>Favorites, Latest Posts, Latest Comments</code></li>
    		  		<li>You will see your new tabs momentarily in the customizer.  Click on one and the Widget area for that Tab will show as a section in the customizer. </li>
    		  		<li>Populate the widget and repeat for each tab.</li>
    		  		<li>If you want people to land on something other than the left most tab (Tab 1), enter the number for that tab.</li>
    		  		<li><em>Save Changes</em></li>
    		  		<li>You can set all other theme options in  Appearance>Customize.</li>
    		  	</ol>'   , 'responsive-tabs');
    	_e( 	'<h4>More about Content Options in Front Page Tabs</h4>
    			<ul>
    		  		<li>For a newspaper look, populate your landing tab widget area with 10 or 15 copies of the Front Page Post Summary widget.  The summary widgets will show as rows of tiles in desktop view but will reshuffle into a column in mobile view.</strong></em></li>
					<li>For a category list or comment list formatted consistently with this theme, use the included widgets.</li>     		  		
    		  		<li>To show the standard latest posts list, just use Latest Posts as a tab title and leave the widget area for the tab empty.</li>
    		  		<li>To show plugin content with a shortcode in a tab, drop a text widget in the tab and put the shortcode in the text widget. Short codes that can look good in tabs include <a href="http://www.nextgen-gallery.com/nextgen-gallery-shortcodes/" target = "_blank">NextGen Gallery</a>,  
    		  			a <a href="http://tablepress.org/documentation/"  target = "_blank">TablePress table</a>, or 
  						a <a href="http://codex.bbpress.org/shortcodes/"  target = "_blank">bbPress forum</a>.</li> 
    		  		<li>You can enter any text or images you wish into a text widget and many plugins are available for importing individual post or page content into a widget.</li>
    		  	</ul>'   , 'responsive-tabs');   	
    	_e(	'<h4>Note: This page will disappear when you change this tab\'s title or content, but you can always get help in Appearance>Customize>Tab Titles or at ', 'responsive-tabs' );
   	echo '<a href="http://twowayconstituentcommunication.com/setup-notes-for-responsive-tabs-theme/" target = "_blank" >TwoWayConstituentCommunication.Com</a>.';
					?>	</div>	
					<br />
					<?php } else if ( strtolower( trim( $tab_titles_array[$active_tab] ) ) == "latest posts" ) { 				
					// display standard latest posts list
					   get_template_part('post','list'); 
					} else { ?>
						<div class = "responsive-tabs-notice">
							<h3> <?php printf ( __( 'Nothing yet in the widget area for tab %d.', 'responsive-tabs' ), $active_tab + 1 ); ?> </h3> 
							<h4> <?php printf ( __( 'To populate, please go to Dashboard>Appearance>Customize>Widgets: Tab %d.', 'responsive-tabs' ), $active_tab + 1 ); ?> </h4>
							<h4> <?php printf ( __( 'Note: When viewing the front page in Customize, to see Widgets: Tab %d, click on this tab, titled "%s."', 'responsive-tabs' ), $active_tab + 1, trim( $tab_titles_array[$active_tab] ) ); ?> </h4>						
						</div>							
					<?php }							
				}
				?>
			<div><!-- close main-tab-content -->
		<div><!-- close main-tabs -->
	<div><!-- close main-tabs-wrapper --><?php


	get_footer();
} // close use this template condition