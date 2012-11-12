<?php
/******************************************************************
Plugin Name: Embedded Menu and Online Ordering
Plugin URI: http://www.restaurantappengines.com/wordpress-plugin/
Description: Embed your restaurant menu and ordering into your WordPress site with a Short Code for Page or Post: [EmbedMenu site_url 750 2000]
Author: Mobile App Engines Ltd
Version: 1.0
Author URI: http://www.restaurantappengines.com/
******************************************************************/

function embedded_menu_replace($matches){
	$matches[1] = preg_replace('/\s+/', ' ', $matches[1]);
	$matches[1] = preg_replace('/^\s+|\s+$/', '', $matches[1]);
	$temp = explode(' ', $matches[1]);
   	
    $width 	= isset($temp[1]) ? $temp[1] : '';
	if (preg_match("#(\d+)#s", $width, $wmatches)){
		$width=$wmatches[0];
	}
	else{
		$width=600;
	}
    $req_width 	= $width-20;

    $height 	= isset($temp[2]) ? $temp[2] : '';
	if (preg_match("#(\d+)#s", $height, $hmatches)){
		$height=$hmatches[0];
	}
	else{
		$height=2000;
	}

	$url 	= "http://" . $temp[0] . "/embed/menu?width=" . $req_width;

		$w = (int) $width;
		$h = (int) $height;
		$width = str_replace($w, $w + $x, $width);
		$height = str_replace($h, $h + $x, $height);
	
    return sprintf(	'<iframe id="menuIframe" frameborder="0" scrolling="no" class="%s" src="%s" style="width: %spx; height: %spx; ' .
					'border: 0px; %s"></iframe>',
					get_option('embedder_class'),
					$url, $width, $height,
					get_option('embedder_style')
					);			 			
}

function embed_menu_function($text){
	return preg_replace_callback("@(?:<p>\s*)?\[EmbedMenu\s+(.*?)\](?:\s*</p>)?@", 'embedded_menu_replace', $text);
}

add_filter('the_excerpt', 'embed_menu_function');
add_filter('the_content', 'embed_menu_function');

?>
