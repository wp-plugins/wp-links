<?php
/*  
Copyright 2012  Jorge A. Gonzalez  (email : jorge@zeropaid.com)

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
Version: 1.5
Author: Jorge A. Gonzalez
Author URI: https://twitter.com/TheRealJAG
License: GPL2
*/
 
add_action('admin_menu', 'WPLINKS_create_menu');

add_filter('the_content', 'WPLINKS_parse_copy', 423);
if( get_option("WPLINKS-excerpt") ) add_filter('the_excerpt', 'WPLINKS_parse_copy', 423);
if( get_option("WPLINKS-comments") )add_filter('comment_text', 'WPLINKS_parse_copy', 423);

function WPLINKS_create_menu() { 
    add_options_page('WP Links Options', 'WP Links', 'manage_options', 'WPLINKS_menu', 'WPLINKS_settings_page'); 
	add_action( 'admin_init', 'WPLINKS_register' );
}
 
function WPLINKS_register() { 
    add_option("WPLINKS-nofollow", ""); 
    add_option("WPLINKS-comments", ""); 
    add_option("WPLINKS-excerpt", ""); 
	register_setting( 'WPLINKS-settings', 'WPLINKS-nofollow' ); 
	register_setting( 'WPLINKS-settings', 'WPLINKS-comments' ); 
	register_setting( 'WPLINKS-settings', 'WPLINKS-excerpt' ); 
}


function WPLINKS_is_external($uri){
	preg_match("/^(http:\/\/)?([^\/]+)/i", $uri, $matches);
	$host = $matches[2];
	preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
	return $matches[0];	   
}

function WPLINKS_parse_matches($matches){ 

	if ( WPLINKS_is_external($matches[3]) != WPLINKS_is_external($_SERVER["HTTP_HOST"]) ) {
		if (get_option("WPLINKS-nofollow")) return '<a href="' . $matches[2] . '//' . $matches[3] . '" ' . $matches[1] . $matches[4] . ' target="_blank" rel="external nofollow">' . $matches[5] . '</a>';	 
        else return '<a href="' . $matches[2] . '//' . $matches[3] . '"' . $matches[1] . $matches[4] . ' target="_blank">' . $matches[5] . '</a>';	 
	} else {
		return '<a href="' . $matches[2] . '//' . $matches[3] . '"' . $matches[1] . $matches[4] . '>' . $matches[5] . '</a>';
	}
}
 
function WPLINKS_parse_copy($text) {	
	$pattern = '/<a (.*?)href="(.*?)\/\/(.*?)"(.*?)>(.*?)<\/a>/i';
	$text = preg_replace_callback($pattern,'WPLINKS_parse_matches',$text);	 
	return $text;
}

function WPLINKS_settings_page() { ?>
    <div class="wrap">
        <div id="icon-link-manager" class="icon32"></div> 
        <h2>WP Links Options</h2>  
        
                    <div class="metabox-holder"> 
                        <div class="postbox gdrgrid frontleft"> 
                            <h3 class="hndle"><span>About WP Links </span></h3>
                            <div class="gdsrclear"></div>
                                <div class="inside">
                                      <p>Out of the box <strong><a href="https://wordpress.org/plugins/wp-links/" target="_blank">WP Links</a></strong> will open all external links in a new tab. This plugin was created to improve the length of time a visitor spends on your webpage by not allowing them to leave your site once they click on an external link.</p>
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
                            <h3 class="hndle"><span>Advanced Options</span></h3>
                            <div class="gdsrclear"></div>
                                <div class="inside">
                                      
                                       <form method="post" action="options.php"> 
                                            <?php
                                            settings_fields('WPLINKS-settings'); 
                                            if( get_option("WPLINKS-nofollow") ){ $checked1 = "checked=\"checked\""; }  else { $checked1 = ""; }   
                                            if( get_option("WPLINKS-comments") ){ $checked2 = "checked=\"checked\""; }  else { $checked2 = ""; }   
                                            if( get_option("WPLINKS-excerpt") ){ $checked3 = "checked=\"checked\""; }  else { $checked3 = ""; }   
                                            ?>
                                            <table class="form-table">  
                                                <tr>
                                                <td valign="top" align="center"><input type="checkbox" name="WPLINKS-nofollow" <?=$checked1;?>/> </td>
                                                <td width="100%" /><strong>Add rel="external nofollow" to external links?</strong><br />Nofollow is a co-ordinated effort from Google, Yahoo, MSN to stop crawling links that are considered not trustworthy or spammy. If you want to rank better in search engines, check this box.</td>
                                                </tr>   
                                                <tr>
                                                <td valign="top" align="center"><input type="checkbox" name="WPLINKS-comments" <?=$checked2;?>/> </td>
                                                <td nowrap /><strong>Add target="_blank" to comments?</strong><br />Checking this box will open a new tab for external links in comments.</td>
                                                </tr>     
                                                <tr>
                                                <td valign="top" align="center"><input type="checkbox" name="WPLINKS-excerpt" <?=$checked3;?>/> </td>
                                                <td nowrap /><strong>Add target="_blank" excerpts?</strong><br />Checking this box will open a new tab for external links in excerpts.</td>
                                                </tr>     
                                                <tr>
                                                <td><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td>
                                                <td><input type="button" class="button tagadd" value="Rate WP Links" tabindex="3" onclick="window.open('http://wordpress.org/extend/plugins/wp-links/')"> &nbsp;&nbsp; &nbsp;<input type="button" class="button tagadd" value="Support Page" tabindex="3" onclick="window.open('http://wordpress.org/support/plugin/wp-links')"></td>
                                                </tr> 
                                            </table>
                                            
                                            
                                        </form> 
                                      
                                      
                                </div>
                        </div>
                    </div>  
    </div> 
    
<?php } ?>