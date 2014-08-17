<?php
/*
 * Template Name: breadcrumbs
 * Description: template part used to display theme controlled breadcrumbs (or plugin breadcrumbs if present) on all except front pages
 *
 * @package responsive-tabs
 *
 */

/* assure that will die if accessed directly */ 
defined( 'ABSPATH' ) or die( "No script kiddies please!" );

echo '<div id="breadcrumbs">';
	
	/* test for installed breadcrumb plugins and display them -- credit for these lines to Cyberchimps Responsive */
	if ( function_exists( 'bcn_display' ) ) {  
		bcn_display();
	} elseif ( function_exists( 'breadcrumb_trail' ) ) {
		breadcrumb_trail();
	} elseif ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
	}
	
	else {
	   /* set up variables for theme controlled breadcrumbs */
	  	$responsive_tabs_theme_options_array = get_option( 'responsive_tabs_theme_options_array' );		
		global $wp_locale; 
		$taxonomy = get_query_var('taxonomy');
		/* construct breadcrumbs for templates */	
	   if ( is_page() ) {
			$home_link =  '<a href="/?frontpagetab=' . $responsive_tabs_theme_options_array['page_home'] .'">' . __( 'home', 'responsive-tabs' ) . '</a> &raquo; ';
			echo $home_link;   	
	   	$id = get_queried_object_id();
	   	$ancestors = get_ancestors( $id, 'page' );
	     	krsort( $ancestors );
	   	foreach( $ancestors as $ancestor ){
	   		$ancestor_title = get_the_title( $ancestor );
			 	echo '<a href=' . get_permalink( $ancestor )
	    			. ' ' . 'title=' . $ancestor_title . '>' . strtolower($ancestor_title)
	    			. '</a> &raquo; ';   	
	   	}
	   } elseif ( is_single() ) {
			$categories = get_the_category();
			if( $categories ) {
				$home_link =  '<a href="/?frontpagetab=' . $responsive_tabs_theme_options_array['category_home'] .'">' . __( 'home', 'responsive-tabs' ) . '</a> &raquo; ';
				echo $home_link;
				foreach( $categories as $category )	{
						echo strtolower(get_category_parents( $category->term_id, true, ' &raquo; ' ));
						break; /* selecting only the first found category for breadcrumbs */
				}
			}
			else { 
				echo $home_link;
			} 
		} elseif ( is_category() ) {
			$home_link =  '<a href="/?frontpagetab=' . $responsive_tabs_theme_options_array['category_home'] .'">' . __( 'home', 'responsive-tabs' ) . '</a> &raquo; ';
			echo $home_link;
			echo strtolower( get_category_parents( $cat, true, ' &raquo; ' ) ); 	
		} elseif ( is_date() ) {
			$home_link 	= '<a href="/?frontpagetab=' . $responsive_tabs_theme_options_array['date_home'] .'">' . __( 'home', 'responsive-tabs' ) . '</a> &raquo; ';
			$year = get_query_var( 'year' );
			$year_link = '<a href="'. get_year_link( $year ) . '">'. $year . '</a> &raquo; ' ;
			$monthnum = get_query_var( 'monthnum' );
			if ( $monthnum > 0 ) {
				$month_link = '<a href="'. get_month_link( $year, $monthnum ).'">'. $wp_locale->get_month( $monthnum )   . '</a> &raquo; ';
			}
			$day = get_query_var( 'day');
			if ( $day > 0 ) {
			$	day_link = ' <a href="'. get_day_link($year, $monthnum, $day).'">'. $day. '</a> &raquo;  '; 		
			}
			echo $home_link. $year_link . $month_link . $day_link;		
		} elseif ( is_author() ) {
			$home_link =  '<a href="/?frontpagetab=' . $responsive_tabs_theme_options_array['author_home'] .'">' . __( 'home', 'responsive-tabs' ) . '</a> &raquo; ';
			echo $home_link . __( 'posts by author &raquo; ', 'responsive-tabs'); 	
		} elseif ( is_search() ) {
			$home_link =  '<a href="/?frontpagetab=' . $responsive_tabs_theme_options_array['search_home'] .'">' . __( 'home', 'responsive-tabs' ) . '</a> &raquo; ';
			echo $home_link . __( 'string search of titles and content &raquo;', 'responsive_tabs' ); 	
		} elseif ( is_tag() ) {
			$home_link =  '<a href="/?frontpagetab=' . $responsive_tabs_theme_options_array['tag_home'] .'">' . __( 'home', 'responsive-tabs' ) . '</a> &raquo; ';
			echo $home_link . __( 'search by tag &raquo;', 'responsive_tabs' ); 	
		} elseif ( $taxonomy == 'publications' ) { /* supports TWCC's Clippings Plugin */
			$home_link =  '<a href="/?frontpagetab=' . $responsive_tabs_theme_options_array['publications_home'] .'">' . __( 'home', 'responsive-tabs' ) . '</a> &raquo; ';
			echo $home_link . __( 'search by publication &raquo;', 'responsive_tabs' ); 	
		}
	} /* close else for theme controlled breadcrumbs */
echo '</div> <!-- close breadcrumbs -->';