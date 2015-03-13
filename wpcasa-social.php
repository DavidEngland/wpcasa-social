<?php
/**
 * Plugin Name: wpCasa Social
 * Plugin URI: http://support.RealEstate-Huntsville.com
 * Description: Social svg icons and links with Microdata for wpCasa theme
 * Author: <a href="http://about.me/DavidEngland">David England</a>
 * Author URI: http://about.me/DavidEngland
 * Version: 1.0
 */
 
add_shortcode( 'social_links', 'custom_social_links_shortcode' );

function custom_social_links_shortcode( $atts ) {

	$defaults = array( 
	    'before' => '',
	    'after'  => '',
	    'first'  => '',
	    'wrap'	 => 'svg'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );

	// Loop through social icons

	$nr = apply_filters( 'wpcasa_social_icons_nr', 5 );
	
	$social_icons = array();
	
	for( $i = 1; $i <= $nr; $i++ ) {				    
		$social_icons[] = wpsight_get_social_icon( wpcasa_get_option( 'icon_' . $i ) );				    
	}
	
	// Remove empty elements
	$social_icons = array_filter( $social_icons );
	
  $output = '<div class="' . $wrap . '">';
	
	if( ! empty( $social_icons ) ) {					
		$i = 1;														
		foreach( $social_icons as $k => $v ) {
		    $social_icon_class = $v['id'];
		    if ( $social_icon_class == 'gplus' ) $social_icon_class = 'googleplus';
		    $social_link = wpcasa_get_option( 'icon_' . $i . '_link' );	
			$output .= '<a href="' . $social_link . '" target="_blank" title="' . $v['title'] . '" class="webicon ' . $social_icon_class . '">' . $v['title'] . '</a>' . "\n";				    		
			$i++;				    		
		}				    
	} else {
		$social_icon = wpcasa_get_social_icon( 'rss' );
		$output .= '<a href="' . get_bloginfo_rss( 'rss2_url' ) . '" target="_blank" title="' . $social_icon['title'] . '" class="social-icon social-icon-' . $social_icon['id'] . '"><img src="' . $social_icon['icon'] . '" alt="" /></a>' . "\n";
	}
	
	$output .= '</div><!-- .social-icons -->';
	
	$output = sprintf( '%1$s%3$s%2$s', $before, $after, apply_filters( 'loginout', $output ) );

	return apply_filters( 'custom_social_links_shortcode', $output, $atts );
				
}
