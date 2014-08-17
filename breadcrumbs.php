<?php
   	$bbp_resp_theme_options_array = get_option( 'bbp_resp_theme_options_array' );		
		$home_link =  '<a href="/">home </a>&raquo; ';
		global $wp_locale; 
		$taxonomy = get_query_var('taxonomy');
		  
		

	echo '<div id="breadcrumbs">';
	// display breadcrumbs at top of all non-front pages if a common breadcrumbs plugin is installed.
	if ( function_exists( 'bcn_display' ) ) {  // credit for these lines to Cyberchimps Responsive
		bcn_display();
	} elseif ( function_exists( 'breadcrumb_trail' ) ) {
		breadcrumb_trail();
	} elseif ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
	}
	// display category breadcrumbs in single post view
   elseif(is_page()) {
		$home_link =  '<a href="/?frontpagetab=' . $bbp_resp_theme_options_array['page_home'] .'">home </a>&raquo; ';
		echo $home_link;   	
   	$id = get_queried_object_id();
   	$ancestors = get_ancestors($id, 'page');
     	krsort($ancestors);
   	foreach($ancestors as $ancestor){
   		$ancestor_title = get_the_title($ancestor);
		 	echo '<a href=' . get_permalink($ancestor)
    			. ' ' . 'title=' . $ancestor_title . '>' . strtolower($ancestor_title)
    			. '</a> » ';   	
   	}
   		}
	elseif(is_single()){
		$categories = get_the_category();
		if($categories){
		$home_link =  '<a href="/?frontpagetab=' . $bbp_resp_theme_options_array['category_home'] .'">home </a>&raquo; ';
		echo $home_link;
		foreach($categories as $category)
		{echo strtolower(get_category_parents( $category->term_id, true, ' &raquo; ' ));
		break;}
		}
		else {echo $home_link;} 
	}
	elseif(is_category()){
		$home_link =  '<a href="/?frontpagetab=' . $bbp_resp_theme_options_array['category_home'] .'">home </a>&raquo; ';
		echo $home_link;
		echo strtolower(get_category_parents( $cat, true, ' &raquo; ' )); 	
	}
	elseif(is_date()){
		$home_link =  '<a href="/?frontpagetab=' . $bbp_resp_theme_options_array['date_home'] .'">home</a> &raquo; ';
		$year=get_query_var('year');
		$year_link = '<a href="'. get_year_link($year) . '">'. $year . '</a> &raquo; ' ;
		$monthnum = get_query_var('monthnum');
		if ($monthnum > 0) {
			$month_link = '<a href="'. get_month_link($year, $monthnum).'">'. $wp_locale->get_month($monthnum)   . '</a> &raquo; ';
			}
		$day = get_query_var('day');
		if ($day > 0){
		$day_link = ' <a href="'. get_day_link($year, $monthnum, $day).'">'. $day. '</a>  &raquo;  '; 		
		}
		
				
		echo $home_link. $year_link . $month_link . $day_link;		
		 		}
	elseif(is_author()) {
				$home_link =  '<a href="/?frontpagetab=' . $bbp_resp_theme_options_array['author_home'] .'">home</a> &raquo; ';
		
		echo $home_link . 'posts by author &raquo; '; 	
	}
	elseif(is_search()) {
				$home_link =  '<a href="/?frontpagetab=' . $bbp_resp_theme_options_array['search_home'] .'">home</a> &raquo; ';
		echo $home_link . 'string search of titles and content &raquo; '; 	
	}
	elseif(is_tag()) {
				$home_link =  '<a href="/?frontpagetab=' . $bbp_resp_theme_options_array['tag_home'] .'">home</a> &raquo; ';
		echo $home_link . 'search by tag &raquo; '; 	
	}
	elseif($taxonomy == 'publications') {
				$home_link =  '<a href="/?frontpagetab=' . $bbp_resp_theme_options_array['publications_home'] .'">home</a> &raquo; ';
		echo $home_link . 'search by publication &raquo; '; 	
      	
	}



	?>
	</div> <!-- close breadcrumbs -->
	