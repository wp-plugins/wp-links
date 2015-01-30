<?php
/*  
Copyright 2012  Jorge A. Gonzalez  (email : adnasium@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Plugin Name: WP Links
Plugin URI: http://wordpress.org/extend/plugins/wp-links/
Description: External link handler for Wordpress
Version: 1.9.1
Author: Jorge A. Gonzalez
Author URI: https://twitter.com/TheRealJAG
License: GPL2
*/

define('PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('PLUGIN_URL', plugin_dir_url( __FILE__ )); 
define('HTTP_HOST', $_SERVER["HTTP_HOST"] ); 

define('WPLINKS_EXCERPT', get_option("WPLINKS-excerpt") );  
define('WPLINKS_COMMENTS', get_option("WPLINKS-comments") );  
define('WPLINKS_IMAGE', get_option("WPLINKS-image") ); 
define('WPLINKS_IMAGE_PATH', plugins_url( 'icons/'.WPLINKS_IMAGE, __FILE__ ) );  
define('WPLINKS_TITLE', get_option("WPLINKS-title") );  
define('WPLINKS_OPEN', get_option("WPLINKS-open") );  
define('WPLINKS_NOFOLLOW', get_option("WPLINKS-nofollow") );  
define('WPLINKS_EXTERNAL_IMAGE', get_option("WPLINKS-external-image") );   

include_once(PLUGIN_DIR.'wp-links-settings.php');

add_filter('the_content', 'WPLINKS_parse_copy', 9);
if( WPLINKS_EXCERPT ) add_filter('the_excerpt', 'WPLINKS_parse_copy', 9);
if( WPLINKS_COMMENTS )add_filter('comment_text', 'WPLINKS_parse_copy', 9);

/**
 * WPLINKS_create_menu()
 * Adds a link in the settings tab
 */
 
 add_action('admin_menu', 'WPLINKS_create_menu');
 
    function WPLINKS_create_menu() { 
        add_options_page('WP Links Options', 'WP Links', 'manage_options', 'WPLINKS_menu', 'WPLINKS_settings_page'); 
    	add_action( 'admin_init', 'WPLINKS_register' );
    }
 
/**
 * WPLINKS_register()
 */
    function WPLINKS_register() { 
        add_option("WPLINKS-title", ""); 
        add_option("WPLINKS-image", ""); 
        add_option("WPLINKS-nofollow", ""); 
        add_option("WPLINKS-comments", ""); 
        add_option("WPLINKS-excerpt", ""); 
        add_option("WPLINKS-open", ""); 
        add_option("WPLINKS-external-image", ""); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-title' ); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-image' ); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-nofollow' ); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-comments' ); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-excerpt' ); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-open' ); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-external-image' ); 
    } 

/**
 * WPLINKS_is_external($uri)
 * Is this link eternal
 */
    function WPLINKS_is_external($uri){
    	preg_match("/^(http:\/\/)?([^\/]+)/i", $uri, $matches);
    	$host = $matches[2];
    	preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
    	return $matches[0];	   
    }

/**
 * WPLINKS_parse_matches($matches)
 * Returns the link 
 */
    function WPLINKS_parse_matches($matches){  
        
        if (WPLINKS_IMAGE) {
            $style = ' class="wp-links-icon"';
            add_action('wp_head','WPLINKS_add_css');
        } 
                
        if (WPLINKS_TITLE && WPLINKS_is_image($matches[5]) == false) $wplinks_title = ' title="' . $matches[5] . '"';    
        
        if (WPLINKS_OPEN) $wplinks_open = ' target="' . WPLINKS_OPEN . '"';   
        else  $wplinks_open = ' target="_blank"'; 
               
        $url = $matches[2].'//'.$matches[3];
     
        /**
        * Build the link
        * Should not add external link to icon
        */
        
        	if ( WPLINKS_is_external($matches[3]) != WPLINKS_is_external(HTTP_HOST) ) {
        	   if (WPLINKS_is_image($matches[5])) $style = '';
        	   
        		if (WPLINKS_NOFOLLOW) return '<a href="'.$url.'" '.$wplinks_open.' rel="external nofollow" '.$wplinks_title.' '.$style.'>' . $matches[5] . '</a>'.$wplinks_image;	 
                else return '<a href="'.$url.'" '.$wplinks_open.' '.$wplinks_title.' '.$style.'>' . $matches[5] . '</a>'.$wplinks_image;	
                
                
        	} else {
        		return '<a href="'.$url.'" '.$wplinks_title.'>' . $matches[5] . '</a>';
        	} 
        
    }
 
 /**
  * WPLINKS_parse_copy($text)
  * Get the text of the link
  */
    function WPLINKS_parse_copy($text) {	
    	$pattern = '/<a (.*?)href="(.*?)\/\/(.*?)"(.*?)>(.*?)<\/a>/i';
    	$text = preg_replace_callback($pattern,'WPLINKS_parse_matches',$text);	 
    	return $text;
    }
 
 /**
  * WPLINKS_is_image($text)
  * Is there an image in the $text
  */
    function WPLINKS_is_image($text) {	
    	preg_match('#(<img.*?>)#', $text, $results);
        if ($results[1]) return true;
         else return false;
    }
  
/**
* WPLINKS_add_css()
* Add css to the head if required
*/  
function WPLINKS_add_css() { 
?>
</style><style type="text/css" media="screen">
/* WP Links Plugin */
<? 
    if (WPLINKS_EXTERNAL_IMAGE == 'on') { 
        echo '.wp-links-icon { background:url("'.WPLINKS_get_external(WPLINKS_IMAGE).'") no-repeat 100% 50%; padding-right:15px; margin-right: 2px;};';
    } else { 
        echo '.wp-links-icon { background:url("'.WPLINKS_IMAGE_PATH.'") no-repeat 100% 50%; padding-right:15px; margin-right: 2px;};';
    }
?>
</style>
<?php } ?> 