<?php
/*
Plugin Name: Cleanup Text
Description: Remove special characters such as smartquotes and double spaces from text. Makes a Wordpress post suitable for sending by email.
Author: Roger Howorth
Author URI: http://www.thehypervisor.com
Plugin URI: http://www.thehypervisor.com/cleanup-text/
Version: 1.0

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
   $rh_content = func_get_arg(0);
   if ( $num_args > 1) $remove_html = func_get_arg(1);
   
   if ( $remove_html ) 
   $rh_content = preg_replace('/<(.|\n)*?>/', '', $rh_content);

   // This list converts things like smartquotes into normal quotes, emdashes to minus sign etc.
   $phase1_array = array(
                '&#8220;' => '&quot;',
                '&#8221;' => '&quot;',
                '&#8216;' => '\'',
                '&#8217;' => '\'',
                '&#38;' => '&amp;',
                '&#8230;' => '...',
                '&#8211;' => '-',
                '’' => '\'',
                '–' => '-',
                '&#8212;' => '-');
   foreach ($phase1_array as $target => $replacement ) {
     $rh_content = str_replace($target, $replacement, $rh_content);
     }
   // This converts characters we want to preserve into _TAGS_
   $phase2_array = array(
                '/\s\s/m' => '_NEWLN_',
                '/\s/m' => '_SPACE_',
                '/>/m' => '_GREATER_',
                '/</m' => '_LESS_',
                '/=/m' => '_EQ_',
                '/\+/m' => '_PLUS_',
                '/\&/m' => '_AMPERSAND_',
                '/\//m' => '_BACKSL_',
                '/:/m' => '_COLON_',
                '/\)/m' => '_CBRACKET_',
                '/\(/m' => '_OBRACKET_',
                '/\'/m' => '_APOST_',
                '/\"/m' => '_QUOTE_',
                '/-/m' => '_DASH_',
                '/@/m' => '_AT_',
                '/,/m' => '_COMMA_',
                '/\?/m' => '_QUIZ_',
                '/\!/m' => '_PLING_',
                '/\./m' => '_STOP_',
                '/£/m' => '_POUND_',
                '/€/m' => '_EURO_',
   // Keep the last element as the last one, it does a special job
                '/\W/m' => '');
   foreach ($phase2_array as $target => $replacement ) {
     $rh_content = preg_replace($target, $replacement, $rh_content);
     }
   // Now we restore the original text using the _TAGS_
   $phase3_array = array(
                '/_POUND_/m' => 'Pounds:',
                '/_EURO_/m' => 'Euro:',
                '/_SPACE__SPACE_/' => '_SPACE_',
                '/_SPACE_/m' => ' ',
                '/_COMMA_/m' => ',',
                '/_STOP_/m' => '.',
                '/_CBRACKET_/m' => ')',
                '/_OBRACKET_/m' => '(',
                '/_GREATER_/m' => '>',
                '/_LESS_/m' => '<',
                '/_EQ_/m' => '=',
                '/_PLUS_/m' => '+',
                '/_AMPERSAND_/m' => '&',
                '/_COLON_/m' => ':',
                '/_AT_/m' => '@',
                '/_PLING_/m' => '!',
                '/_QUIZ_/m' => '?',
                '/_BACKSL_/m' => '/',
                '/_DASH_/m' => '-',
                '/_APOST_/m' => '\'',
                '/_QUOTE_/m' => '"',
                '/_NEWLN_/m' => "\n");

   foreach ($phase3_array as $target => $replacement ) {
     $rh_content = preg_replace($target, $replacement, $rh_content);
     }
   return $rh_content;
}
?>
