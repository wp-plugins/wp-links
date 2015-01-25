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
Version: 1.8
Author: Jorge A. Gonzalez
Author URI: https://twitter.com/TheRealJAG
License: GPL2
*/

define( 'PLUGIN_DIR', dirname(__FILE__).'/' );  

include_once(PLUGIN_DIR.'wp-links-settings.php');

add_filter('the_content', 'WPLINKS_parse_copy', 9);
if( get_option("WPLINKS-excerpt") ) add_filter('the_excerpt', 'WPLINKS_parse_copy', 9);
if( get_option("WPLINKS-comments") )add_filter('comment_text', 'WPLINKS_parse_copy', 9);

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
    	register_setting( 'WPLINKS-settings', 'WPLINKS-title' ); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-image' ); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-nofollow' ); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-comments' ); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-excerpt' ); 
    	register_setting( 'WPLINKS-settings', 'WPLINKS-open' ); 
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
        $host = $_SERVER["HTTP_HOST"];
        
        if (get_option("WPLINKS-image")) {
            $style = ' class="wp-links-icon"';
            add_action('wp_head','WPLINKS_add_css');
        } 
                
        if (get_option("WPLINKS-title")) $wplinks_title = ' title="' . $matches[5] . '"';    
        
        if (get_option("WPLINKS-open")) $wplinks_open = ' target="' . get_option("WPLINKS-open") . '"';   
        else  $wplinks_open = ' target="_blank"'; 
               
        $url = $matches[2].'//'.$matches[3];
     
        /**
        * Build the link
        */
        
        	if ( WPLINKS_is_external($matches[3]) != WPLINKS_is_external($host) ) {
        		if (get_option("WPLINKS-nofollow")) return '<a href="'.$url.'" '.$wplinks_open.' rel="external nofollow" '.$wplinks_title.' '.$style.'>' . $matches[5] . '</a>'.$wplinks_image;	 
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
* WPLINKS_add_css()
* Add css to the head if required
*/  
function WPLINKS_add_css() { ?>
</style><style type="text/css" media="screen">
/* WP Links Plugin */
    .wp-links-icon { background:url("<?=plugin_dir_url( __FILE__ );?>icons/<?=get_option("WPLINKS-image");?>") no-repeat 100% 50%; padding-right:15px; margin-right: 2px;};
</style>
<?php } ?>