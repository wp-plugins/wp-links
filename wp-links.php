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
Description: Automatically opens a new tab for external links and allows you to set rel="external nofollow" to external links.
Version: 1.7
Author: Jorge A. Gonzalez
Author URI: https://twitter.com/TheRealJAG
License: GPL2
*/
 


add_filter('the_content', 'WPLINKS_parse_copy', 423);
if( get_option("WPLINKS-excerpt") ) add_filter('the_excerpt', 'WPLINKS_parse_copy', 423);
if( get_option("WPLINKS-comments") )add_filter('comment_text', 'WPLINKS_parse_copy', 424);

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
        // Original URL -> $matches[0];
        
        $host = $_SERVER["HTTP_HOST"];
        
        if (get_option("WPLINKS-image")) $wplinks_image = ' <img src="'.plugin_dir_url( __FILE__ ).'icons/'.get_option("WPLINKS-image").'">';  
        if (get_option("WPLINKS-title")) $wplinks_title = ' title="' . $matches[5] . '"';    
        
        if (get_option("WPLINKS-open")) $wplinks_open = ' target="' . get_option("WPLINKS-open") . '"';   
        else  $wplinks_open = ' target="_blank"'; 
               
        $url = $matches[2].'//'.$matches[3];
     
        /**
        * Build the link
        */
        
        	if ( WPLINKS_is_external($matches[3]) != WPLINKS_is_external($host) ) {
        		if (get_option("WPLINKS-nofollow")) return '<a href="'.$url.'" '.$wplinks_open.' rel="external nofollow" '.$wplinks_title.'>' . $matches[5] . '</a>'.$wplinks_image;	 
                else return '<a href="'.$url.'" '.$wplinks_open.' '.$wplinks_title.'>' . $matches[5] . '</a>'.$wplinks_image;	 
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
 * WPLINKS_settings_page()
 * The settings page for the plugin
 */
function WPLINKS_settings_page() { ?>
    <div class="wrap">
        <div id="icon-link-manager" class="icon32"></div> 
        <h2>WP Links Options</h2>  
        
         <form method="post" action="options.php"> 
                    <div class="metabox-holder"> 
                        <div class="postbox gdrgrid frontleft"> 
                            <h3 class="hndle"><span>About WP Links </span></h3>
                            <div class="gdsrclear"></div>
                                <div class="inside">
                                      <p>Out of the box <strong>WP Links</strong> will open all external links in a new tab. This plugin was created to improve the length of time a visitor spends on your webpage by not allowing them to leave your site once they click on an external link.</p>
                                      <h4>How it works?</h4>
                                      <p>This plugin will scan your posts/pages for any external links and force them to open in a new tab.</p>
                                      
                                      <h4>Support the developer</h4>
                                      <p>WP Links is developed and maintained by <a href="https://twitter.com/TheRealJAG" target="_blank" title="@TheRealJAG">Jorge A. Gonzalez</a></p>
                                      <a href="https://twitter.com/TheRealJAG" class="twitter-follow-button" data-show-count="true">Follow @TheRealJAG</a>
                                      <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://wordpress.org/extend/plugins/wp-links/" data-text="Just installed WP Links on my #WordPress site." data-via="TheRealJAG" data-related="TheRealJAG">Tweet</a> 
                                      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                </div>
                        </div>
                    </div> 
           
                    <div class="metabox-holder"> 
                        <div class="postbox gdrgrid frontleft"> 
                            <h3 class="hndle"><span>Link Options</span></h3>
                            <div class="gdsrclear"></div>
                                <div class="inside">
                                            <?php
                                            settings_fields('WPLINKS-settings'); 
                                            if( get_option("WPLINKS-nofollow") ){ $checked1 = "checked=\"checked\""; }  else { $checked1 = ""; }   
                                            if( get_option("WPLINKS-comments") ){ $checked2 = "checked=\"checked\""; }  else { $checked2 = ""; }   
                                            if( get_option("WPLINKS-excerpt") ){ $checked3 = "checked=\"checked\""; }  else { $checked3 = ""; }   
                                            if( get_option("WPLINKS-title") ){ $checked4 = "checked=\"checked\""; }  else { $checked4 = ""; }  
                                            ?>
                                            <table class="form-table">  
                                                <tr>
                                                <td valign="top" colspan="2"><strong>Open External Links In</strong>: &nbsp;&nbsp; 
                                                    <select name="WPLINKS-open">
                                                      <option value="_blank" <? if( get_option("WPLINKS-open") == '_blank') echo ' selected ';?>>New Tab</option>
                                                      <option value="_self" <? if( get_option("WPLINKS-open") == '_self') echo ' selected ';?>>Same Tab</option>
                                                    </select> 
                                                </td> 
                                                <tr><td colspan="2"><hr /></td></tr>
                                                </tr>   
                                                <tr>
                                                <td valign="top" align="center"><input type="checkbox" name="WPLINKS-nofollow" <?=$checked1;?>/> </td>
                                                <td width="100%" /><strong>Add <code>rel="external nofollow"</code> to external links?</strong><br />Nofollow is a co-ordinated effort from Google, Yahoo, MSN to stop crawling links that are considered not trustworthy or spammy. If you want to rank better in search engines, check this box.</td>
                                                </tr>   
                                                <tr>
                                                <td valign="top" align="center"><input type="checkbox" name="WPLINKS-comments" <?=$checked2;?>/> </td>
                                                <td nowrap /><strong>Add <code>target="_blank"</code> to comments?</strong><br />Checking this box will open a new tab for external links in comments.</td>
                                                </tr>     
                                                <tr>
                                                <td valign="top" align="center"><input type="checkbox" name="WPLINKS-excerpt" <?=$checked3;?>/> </td>
                                                <td nowrap /><strong>Add <code>target="_blank"</code> excerpts?</strong><br />Checking this box will open a new tab for external links in excerpts.</td>
                                                </tr>     
                                                <tr>
                                                <td valign="top" align="center"><input type="checkbox" name="WPLINKS-title" <?=$checked4;?>/> </td>
                                                <td nowrap /><strong>Add <code>title</code> attribute to links?</strong><br />Checking this box will add the text of the link to the title attribute of the link.</td>
                                                </tr>     
                                                <tr>
                                                <td><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td>
                                                <td><input type="button" class="button tagadd" value="Rate WP Links" tabindex="3" onclick="window.open('http://wordpress.org/extend/plugins/wp-links/')"> &nbsp;&nbsp; &nbsp;<input type="button" class="button tagadd" value="Support Page" tabindex="3" onclick="window.open('http://wordpress.org/support/plugin/wp-links')"></td>
                                                </tr> 
                                            </table>
                    
                            </div>
                        </div>
                    </div> 
                     
                    <div class="metabox-holder"> 
                        <div class="postbox gdrgrid frontleft"> 
                            <h3 class="hndle"><span>Image Options</span></h3>
                            <div class="gdsrclear"></div>
                                <div class="inside">
                                        <em>If you want to display an image after the link, select an option below. </em>
                                            <table width="600">
                                            <tr>
                                            <td width="50%" valign="top">
                                                <p><input type="radio" name="WPLINKS-image" value="" <? if (get_option("WPLINKS-image") == 'no image' OR get_option("WPLINKS-image") == '') echo 'checked'; ?>> <strong>No Image</strong></p>
                                                 
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-default02.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-default02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-default02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-default03.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-default03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-default03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-default04.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-default04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-default04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-default05.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-default05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-default05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-default06.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-default06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-default06.png"> 
                                                </p>
                                                
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-medium02.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-medium02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-medium02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-medium03.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-medium03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-medium03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-medium04.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-medium04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-medium04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-medium05.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-medium05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-medium05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-medium06.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-medium06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-medium06.png"> 
                                                </p>
                                                
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-light02.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-light02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-light02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-light03.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-light03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-light03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-light04.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-light04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-light04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-light05.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-light05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-light05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-blue-light06.png" <? if (get_option("WPLINKS-image") == 'external-link-blue-light06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-blue-light06.png"> 
                                                </p>
                                                
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-green02.png" <? if (get_option("WPLINKS-image") == 'external-link-green02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-green02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-green03.png" <? if (get_option("WPLINKS-image") == 'external-link-green03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-green03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-green04.png" <? if (get_option("WPLINKS-image") == 'external-link-green04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-green04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-green05.png" <? if (get_option("WPLINKS-image") == 'external-link-green05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-green05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-green06.png" <? if (get_option("WPLINKS-image") == 'external-link-green06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-green06.png"> 
                                                </p>
                                                
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-green-bright02.png" <? if (get_option("WPLINKS-image") == 'external-link-green-bright02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-green-bright02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-green-bright03.png" <? if (get_option("WPLINKS-image") == 'external-link-green-bright03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-green-bright03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-green-bright04.png" <? if (get_option("WPLINKS-image") == 'external-link-green-bright04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-green-bright04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-green-bright05.png" <? if (get_option("WPLINKS-image") == 'external-link-green-bright05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-green-bright05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-green-bright06.png" <? if (get_option("WPLINKS-image") == 'external-link-green-bright06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-green-bright06.png"> 
                                                </p>
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-aqua02.png" <? if (get_option("WPLINKS-image") == 'external-link-aqua02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-aqua02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-aqua03.png" <? if (get_option("WPLINKS-image") == 'external-link-aqua03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-aqua03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-aqua04.png" <? if (get_option("WPLINKS-image") == 'external-link-aqua04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-aqua04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-aqua05.png" <? if (get_option("WPLINKS-image") == 'external-link-aqua05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-aqua05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-aqua06.png" <? if (get_option("WPLINKS-image") == 'external-link-aqua06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-aqua06.png"> 
                                                </p>
                                            
                                            <p>
                                                <input type="radio" name="WPLINKS-image" value="external-link-mint02.png" <? if (get_option("WPLINKS-image") == 'external-link-mint02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-mint02.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-mint03.png" <? if (get_option("WPLINKS-image") == 'external-link-mint03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-mint03.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-mint04.png" <? if (get_option("WPLINKS-image") == 'external-link-mint04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-mint04.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-mint05.png" <? if (get_option("WPLINKS-image") == 'external-link-mint05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-mint05.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-mint06.png" <? if (get_option("WPLINKS-image") == 'external-link-mint06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-mint06.png">
                                            </p> 
                                            
                                            
                                            <p>
                                                <input type="radio" name="WPLINKS-image" value="external-link-orange-dark02.png" <? if (get_option("WPLINKS-image") == 'external-link-orange-dark02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-orange-dark02.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-orange-dark03.png" <? if (get_option("WPLINKS-image") == 'external-link-orange-dark03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-orange-dark03.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-orange-dark04.png" <? if (get_option("WPLINKS-image") == 'external-link-orange-dark04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-orange-dark04.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-orange-dark05.png" <? if (get_option("WPLINKS-image") == 'external-link-orange-dark05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-orange-dark05.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-orange-dark06.png" <? if (get_option("WPLINKS-image") == 'external-link-orange-dark06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-orange-dark06.png"> 
                                            </p>
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-orange-light02.png" <? if (get_option("WPLINKS-image") == 'external-link-orange-light02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-orange-light02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-orange-light03.png" <? if (get_option("WPLINKS-image") == 'external-link-orange-light03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-orange-light03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-orange-light04.png" <? if (get_option("WPLINKS-image") == 'external-link-orange-light04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-orange-light04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-orange-light05.png" <? if (get_option("WPLINKS-image") == 'external-link-orange-light05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-orange-light05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-orange-light06.png" <? if (get_option("WPLINKS-image") == 'external-link-orange-light06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-orange-light06.png"> 
                                                </p>
                                            </td>
                                            <td valign="top">  
                                                
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-pink02.png" <? if (get_option("WPLINKS-image") == 'external-link-pink02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-pink02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-pink03.png" <? if (get_option("WPLINKS-image") == 'external-link-pink03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-pink03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-pink04.png" <? if (get_option("WPLINKS-image") == 'external-link-pink04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-pink04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-pink05.png" <? if (get_option("WPLINKS-image") == 'external-link-pink05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-pink05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-pink06.png" <? if (get_option("WPLINKS-image") == 'external-link-pink06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-pink06.png"> 
                                                </p>
                                                 
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-violet02.png" <? if (get_option("WPLINKS-image") == 'external-link-violet02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-violet02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-violet03.png" <? if (get_option("WPLINKS-image") == 'external-link-violet03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-violet03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-violet04.png" <? if (get_option("WPLINKS-image") == 'external-link-violet04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-violet04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-violet05.png" <? if (get_option("WPLINKS-image") == 'external-link-violet05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-violet05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-violet06.png" <? if (get_option("WPLINKS-image") == 'external-link-violet06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-violet06.png">
                                                </p> 
                                            <p>
                                                <input type="radio" name="WPLINKS-image" value="external-link-lilac02.png" <? if (get_option("WPLINKS-image") == 'external-link-lilac02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-lilac02.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-lilac03.png" <? if (get_option("WPLINKS-image") == 'external-link-lilac03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-lilac03.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-lilac04.png" <? if (get_option("WPLINKS-image") == 'external-link-lilac04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-lilac04.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-lilac05.png" <? if (get_option("WPLINKS-image") == 'external-link-lilac05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-lilac05.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-lilac06.png" <? if (get_option("WPLINKS-image") == 'external-link-lilac06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-lilac06.png"> 
                                            </p>
                                                 
                                                    
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-red-dark02.png" <? if (get_option("WPLINKS-image") == 'external-link-red-dark02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-red-dark02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-red-dark03.png" <? if (get_option("WPLINKS-image") == 'external-link-red-dark03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-red-dark03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-red-dark04.png" <? if (get_option("WPLINKS-image") == 'external-link-red-dark04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-red-dark04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-red-dark05.png" <? if (get_option("WPLINKS-image") == 'external-link-red-dark05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-red-dark05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-red-dark06.png" <? if (get_option("WPLINKS-image") == 'external-link-red-dark06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-red-dark06.png"> 
                                                </p>
                                                
                                                
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-gradient02.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-gradient02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-gradient02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-gradient03.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-gradient03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-gradient03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-gradient04.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-gradient04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-gradient04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-gradient05.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-gradient05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-gradient05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-gradient06.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-gradient06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-gradient06.png"> 
                                                </p>
                                            
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-brown02.png" <? if (get_option("WPLINKS-image") == 'external-link-brown02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-brown02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-brown03.png" <? if (get_option("WPLINKS-image") == 'external-link-brown03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-brown03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-brown04.png" <? if (get_option("WPLINKS-image") == 'external-link-brown04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-brown04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-brown05.png" <? if (get_option("WPLINKS-image") == 'external-link-brown05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-brown05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-brown06.png" <? if (get_option("WPLINKS-image") == 'external-link-brown06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-brown06.png">
                                                </p> 
                                                
                                                
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-beige-dark02.png" <? if (get_option("WPLINKS-image") == 'external-link-beige-dark02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-beige-dark02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-beige-dark03.png" <? if (get_option("WPLINKS-image") == 'external-link-beige-dark03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-beige-dark03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-beige-dark04.png" <? if (get_option("WPLINKS-image") == 'external-link-beige-dark04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-beige-dark04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-beige-dark05.png" <? if (get_option("WPLINKS-image") == 'external-link-beige-dark05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-beige-dark05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-beige-dark06.png" <? if (get_option("WPLINKS-image") == 'external-link-beige-dark06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-beige-dark06.png"> 
                                                </p>
                                                
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-dark02.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-dark02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-dark02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-dark03.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-dark03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-dark03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-dark04.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-dark04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-dark04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-dark05.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-dark05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-dark05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-dark06.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-dark06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-dark06.png"> 
                                                </p>
                                                
                                                <p>
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-medium02.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-medium02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-medium02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-medium03.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-medium03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-medium03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-medium04.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-medium04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-medium04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-medium05.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-medium05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-medium05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-grey-medium06.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-medium06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-medium06.png"> 
                                                </p>
                                            
                                            <p>
                                                <input type="radio" name="WPLINKS-image" value="external-link-grey-light02.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-light02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-light02.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-grey-light03.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-light03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-light03.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-grey-light04.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-light04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-light04.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-grey-light05.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-light05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-light05.png"> 
                                                <input type="radio" name="WPLINKS-image" value="external-link-grey-light06.png" <? if (get_option("WPLINKS-image") == 'external-link-grey-light06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-grey-light06.png"> 
                                            </p>                                            
                                            
                                            
                                            
                                            </td>
                                            </tr>
                                                
                                                <tr>
                                                <td colspan="2"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /> &nbsp;&nbsp; &nbsp;<input type="button" class="button tagadd" value="Rate WP Links" tabindex="3" onclick="window.open('http://wordpress.org/extend/plugins/wp-links/')"> &nbsp;&nbsp; &nbsp;<input type="button" class="button tagadd" value="Support Page" tabindex="3" onclick="window.open('http://wordpress.org/support/plugin/wp-links')"></td>
                                                </tr> 
                                            </table>
                                      
                            </div>
                        </div>
                    </div>  
                    
                    
                    
 
</form>                    
</div> 
    
<?php } ?>