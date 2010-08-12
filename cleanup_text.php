<?php
/*
Plugin Name: Cleanup Text
Description: Remove special characters such as smartquotes and double spaces from text. Makes a Wordpress post suitable for sending by email.
Author: Roger Howorth
Author URI: http://www.thehypervisor.com
Plugin URI: http://www.thehypervisor.com/cleanup-text/
Version: 2.0.1

License: GPL2

    Copyright 2009-2010  Roger Howorth  (email : roger@rogerh.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2, 
    as published by the Free Software Foundation. 
    
    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    The license for this software can likely be found here: 
    http://www.gnu.org/licenses/gpl-2.0.html
*/

function cleanup_text() {
   $num_args = func_num_args();
   if ( $num_args == '0' )
      wp_die('You must pass some text to cleanup_text when you invoke the function. E.g. cleanup_text($string_to_clean)');
   $text = func_get_arg(0);
   if ( $num_args > 1) $remove_html = func_get_arg(1);
   if ( $remove_html ) $text = preg_replace('/<(.|\n)*?>/', '', $text);


   // This list converts things like smartquotes into normal quotes, emdashes to minus sign etc.
   // It wil catch things like emdash not handled by above code
   $phase1_array = array(
                '&#8220;' => '&quot;',
                '&#8221;' => '&quot;',
                '‘' => '\'',
                '’' => '\'',
                '&#8216;' => '\'',
                '&#8217;' => '\'',
                '&#38;' => '&amp;',
                '&#8230;' => '...',
                '&#8211;' => '-',
                '&#8212;' => '-');
   foreach ($phase1_array as $target => $replacement ) {
     $text = str_replace($target, $replacement, $text);
     }


	$text = strip_shortcodes( $text );
	remove_filter( 'the_content', 'wptexturize' );
	$text = apply_filters('the_content', $text);
	add_filter( 'the_content', 'wptexturize' );
	$text = str_replace(']]>', ']]&gt;', $text);
	$text = wp_strip_all_tags($text);
	$text = str_replace(array("\r\n","\r","\n"),"\n\n",$text);
/*	$excerpt_length = apply_filters('excerpt_length', 1000);
	$excerpt_more = apply_filters('excerpt_more', '[...]');
	$words = explode(' ', $text, $excerpt_length + 1);
	if (count($words) > $excerpt_length) {
		array_pop($words);
		array_push($words, $excerpt_more);
		$text = implode(' ', $words);
	}
*/

	$text = html_entity_decode($text); // added to try to fix annoying &entity; stuff

	return $text;
}
?>
