<?php
/**
 * WPLINKS_settings_page()
 * The settings page for the plugin
 */
function WPLINKS_settings_page() { 
?>
<script> 
    jQuery(document).ready(function($) {         
        $('#WPLINKS-title-shortcode-wrapper')[$('#WPLINKS-title').is(':checked') ? "show" : "hide"]();        
        $('#WPLINKS-title').live('change', function(){  $('#WPLINKS-title-shortcode-wrapper')[this.checked ? "show" : "hide"]();});
    }); 
</script>
 
    <div class="wrap">
        <div id="icon-link-manager" class="icon32"></div> 
        <h2>WP Links Settings</h2>           
         <form method="post" action="options.php"> 
                     <?
                         settings_fields('WPLINKS-settings'); 
                        if( get_option("WPLINKS-nofollow") ){ $checked1 = "checked=\"checked\""; }  else { $checked1 = ""; }   
                        if( get_option("WPLINKS-comments") ){ $checked2 = "checked=\"checked\""; }  else { $checked2 = ""; }   
                        if( get_option("WPLINKS-excerpt") ){ $checked3 = "checked=\"checked\""; }  else { $checked3 = ""; }   
                        if( get_option("WPLINKS-title") ){ $checked4 = "checked=\"checked\""; }  else { $checked4 = ""; }  
                        if( get_option("WPLINKS-external-image") ){ $checked5 = "checked=\"checked\""; }  else { $checked5 = ""; }   
                    ?>
                    <div class="metabox-holder"> 
                        <div class="postbox gdrgrid frontleft"> 
                            <h3 class="hndle"><span>About WP Links </span></h3>
                            <div class="gdsrclear"></div>
                                <div class="inside">
                                      <p><strong><a href="https://wordpress.org/plugins/wp-links/" target="_blank">WP Links</a></strong> is developed and maintained by <a href="https://www.linkedin.com/in/jorgeagonzalez" target="_blank" title="Jorge A. Gonzalez">Jorge A. Gonzalez</a> <a href="https://twitter.com/TheRealJAG" target="_blank" title="@TheRealJAG">@TheRealJAG</a></p>
                                      <a href="https://twitter.com/TheRealJAG" class="twitter-follow-button" data-show-count="false">Follow @TheRealJAG</a>
                                      <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://wordpress.org/extend/plugins/wp-links/" data-text="Take control of your external links in #WordPress with WP Links" data-related="TheRealJAG" data-count="none">Tweet</a>
                                      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                                </div>
                        </div>
                    </div> 
           
                    <div class="metabox-holder"> 
                        <div class="postbox gdrgrid frontleft"> 
                            <h3 class="hndle"><span>Link Options</span></h3>
                            <div class="gdsrclear"></div>
                                <div class="inside"> 
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
                                                <td valign="top" align="center" width="50"><input type="checkbox" name="WPLINKS-title" id="WPLINKS-title" <?=$checked4;?>/> </td>
                                                <td nowrap />
                                                    <strong>Add <code>title</code> attribute to external links?</strong><br />Checking this box will add the text of the link to the title attribute of the link.
                                                    <span id="WPLINKS-title-shortcode-wrapper" style="display:none"><br /><br /><strong>Custom Structure</strong> <input type="text" name="WPLINKS-title-shortcode" id="WPLINKS-title-shortcode" value="<?=WPLINKS_TITLE_SHORTCODE;?>" size="40" /><br />%TITLE% is shortcode for the title of the link</span>
                                                </td>
                                                </tr>    
                                                <tr>
                                                <td valign="top" align="center"><input type="checkbox" name="WPLINKS-nofollow" <?=$checked1;?>/> </td>
                                                <td width="100%" /><strong>Add <code>rel="external nofollow"</code> to external links?</strong><br />Nofollow is an effort from Google, Yahoo, MSN to stop crawling links that are considered not trustworthy or spammy. If you want to rank better in search engines, check this box.</td>
                                                </tr>    
                                                <tr>
                                                <td><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td>
                                                <td><input type="button" class="button tagadd" value="Rate WP Links" onclick="window.open('http://wordpress.org/extend/plugins/wp-links/')"> &nbsp;&nbsp; &nbsp;<input type="button" class="button tagadd" value="Support Page" tabindex="3" onclick="window.open('http://wordpress.org/support/plugin/wp-links')"></td>
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
                                        <p>If you want to display an image after a link select an option below.</p> 
                                        
                                            <table width="400" border="0">
                                            <tr><td colspan="2"><img src="<?=PLUGIN_URL?>/demo.png"></td></tr>
                                            <tr>
                                            <td width="50%" valign="top">
                                                <input type="radio" name="WPLINKS-image" value="" <? if (get_option("WPLINKS-image") == 'no image' OR get_option("WPLINKS-image") == '') echo 'checked'; ?>> <strong>No Image</strong>
                                                 
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
                                                    <input type="radio" name="WPLINKS-image" value="external-link-pink02.png" <? if (get_option("WPLINKS-image") == 'external-link-pink02.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-pink02.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-pink03.png" <? if (get_option("WPLINKS-image") == 'external-link-pink03.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-pink03.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-pink04.png" <? if (get_option("WPLINKS-image") == 'external-link-pink04.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-pink04.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-pink05.png" <? if (get_option("WPLINKS-image") == 'external-link-pink05.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-pink05.png"> 
                                                    <input type="radio" name="WPLINKS-image" value="external-link-pink06.png" <? if (get_option("WPLINKS-image") == 'external-link-pink06.png') echo 'checked'; ?>><img src="<?=plugin_dir_url( __FILE__ )?>icons/external-link-pink06.png"> 
                                               
                                                 
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
                                                <td colspan="2" /><p><input type="checkbox" name="WPLINKS-external-image" <?=$checked5;?>/>  Use external image hosting service (<code><a href="http://imgur.com/" target="_blank">imgur.com</a></code>) to display icons. This could come in handy for Wordpress multi and/or domain mapping.</p></td>
                                            </tr>  
                                            <tr>
                                                <td colspan="2"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /> &nbsp;&nbsp; &nbsp;<input type="button" class="button tagadd" value="Rate WP Links" tabindex="3" onclick="window.open('http://wordpress.org/extend/plugins/wp-links/')"> &nbsp;&nbsp; &nbsp;<input type="button" class="button tagadd" value="Support Page" tabindex="3" onclick="window.open('http://wordpress.org/support/plugin/wp-links')"></td>
                                            </tr> 
                                            </table>
                                      
                            </div>
                        </div>
                    </div>  
                    
                    
                    <div class="metabox-holder"> 
                        <div class="postbox gdrgrid frontleft"> 
                            <h3 class="hndle"><span>Other Options</span></h3>
                            <div class="gdsrclear"></div>
                                <div class="inside">  
                                    <table class="form-table">
                                        <tr>
                                        <td valign="top" align="center" width="50"><input type="checkbox" name="WPLINKS-comments" <?=$checked2;?>/> </td>
                                        <td nowrap /><strong>Add <code>target="_blank"</code> to comments?</strong><br />Checking this box will open a new tab for external links in comments.</td>
                                        </tr>     
                                        <tr>
                                        <td valign="top" align="center"><input type="checkbox" name="WPLINKS-excerpt" <?=$checked3;?>/> </td>
                                        <td nowrap /><strong>Add <code>target="_blank"</code> excerpts?</strong><br />Checking this box will open a new tab for external links in excerpts.</td>
                                        </tr>     
                                        <tr>
                                        <td><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td>
                                        <td><input type="button" class="button tagadd" value="Rate WP Links"onclick="window.open('http://wordpress.org/extend/plugins/wp-links/')"> &nbsp;&nbsp; &nbsp;<input type="button" class="button tagadd" value="Support Page" tabindex="3" onclick="window.open('http://wordpress.org/support/plugin/wp-links')"></td>
                                        </tr> 
                                    </table> 
                                    
                            </div>
                        </div>
                    </div>  
                    
 
</form>                    
</div> 
<?php } 

function WPLINKS_get_external($image) {
    //http://imgur.com/a/mZFan/all
    $array = array(
        "external-link-aqua02.png" => "http://i.imgur.com/eTuROj3.png",
        "external-link-aqua03.png" => "http://i.imgur.com/LhkcMAS.png",
        "external-link-aqua04.png" => "http://i.imgur.com/lG7n48f.png",
        "external-link-aqua05.png" => "http://i.imgur.com/Gn9DUj7.png",
        "external-link-aqua06.png" => "http://i.imgur.com/gpfhtcO.png",
        "external-link-beige-dark02.png" => "http://i.imgur.com/ueSSeVI.png",
        "external-link-beige-dark03.png" => "http://i.imgur.com/9cVML7K.png",
        "external-link-beige-dark04.png" => "http://i.imgur.com/ME7ofva.png",
        "external-link-beige-dark05.png" => "http://i.imgur.com/ACwGXZv.png",
        "external-link-beige-dark06.png" => "http://i.imgur.com/KiJOK0R.png",
        "external-link-blue-default02.png" => "http://i.imgur.com/623Atc2.png",
        "external-link-blue-default03.png" => "http://i.imgur.com/6debsNx.png",
        "external-link-blue-default04.png" => "http://i.imgur.com/NMy2LQ5.png",
        "external-link-blue-default05.png" => "http://i.imgur.com/xIOzGOy.png",
        "external-link-blue-default06.png" => "http://i.imgur.com/0Zei6GD.png",
        "external-link-blue-light02.png" => "http://i.imgur.com/CnuKpkt.png",
        "external-link-blue-light03.png" => "http://i.imgur.com/5GD7cuE.png",
        "external-link-blue-light04.png" => "http://i.imgur.com/Dhxkbo6.png",
        "external-link-blue-light05.png" => "http://i.imgur.com/dO6XyB5.png",
        "external-link-blue-light06.png" => "http://i.imgur.com/JWTZAzR.png",
        "external-link-blue-medium02.png" => "http://i.imgur.com/PifKYrK.png",
        "external-link-blue-medium03.png" => "http://i.imgur.com/BoGs3UX.png",
        "external-link-blue-medium04.png" => "http://i.imgur.com/ayox3eg.png",
        "external-link-blue-medium05.png" => "http://i.imgur.com/kuS1uCg.png",
        "external-link-blue-medium06.png" => "http://i.imgur.com/Nk6UQMC.png",
        "external-link-brown02.png" => "http://i.imgur.com/V5A28oW.png",
        "external-link-brown03.png" => "http://i.imgur.com/ZrdypJz.png",
        "external-link-brown04.png" => "http://i.imgur.com/d8OjcyB.png",
        "external-link-brown05.png" => "http://i.imgur.com/1vT70Ry.png",
        "external-link-brown06.png" => "http://i.imgur.com/RhQLyAx.png",
        "external-link-green02.png" => "http://i.imgur.com/yLsxgNP.png",
        "external-link-green03.png" => "http://i.imgur.com/JTKLwUE.png",
        "external-link-green04.png" => "http://i.imgur.com/biFyvdK.png",
        "external-link-green05.png" => "http://i.imgur.com/xfECYji.png",
        "external-link-green06.png" => "http://i.imgur.com/SP24J3k.png",
        "external-link-green-bright02.png" => "http://i.imgur.com/5bI45Wg.png",
        "external-link-green-bright03.png" => "http://i.imgur.com/oesTlCK.png",
        "external-link-green-bright04.png" => "http://i.imgur.com/dAmFkMO.png",
        "external-link-green-bright05.png" => "http://i.imgur.com/btr11QB.png",
        "external-link-green-bright06.png" => "http://i.imgur.com/uSQUnur.png",
        "external-link-grey-dark02.png" => "http://i.imgur.com/xWqyzG5.png",
        "external-link-grey-dark03.png" => "http://i.imgur.com/05xtUxl.png",
        "external-link-grey-dark04.png" => "http://i.imgur.com/8Ym6MqL.png",
        "external-link-grey-dark05.png" => "http://i.imgur.com/onrLcT2.png",
        "external-link-grey-dark06.png" => "http://i.imgur.com/JYiOsJQ.png",
        "external-link-grey-gradient02.png" => "http://i.imgur.com/TEFKbd4.png",
        "external-link-grey-gradient03.png" => "http://i.imgur.com/DgOiptE.png",
        "external-link-grey-gradient04.png" => "http://i.imgur.com/qOEuu8w.png",
        "external-link-grey-gradient05.png" => "http://i.imgur.com/sQTDW0e.png",
        "external-link-grey-gradient06.png" => "http://i.imgur.com/3P3bLNR.png",
        "external-link-grey-light02.png" => "http://i.imgur.com/L2amBbA.png",
        "external-link-grey-light03.png" => "http://i.imgur.com/1O3gfm5.png",
        "external-link-grey-light04.png" => "http://i.imgur.com/LuCQFEv.png",
        "external-link-grey-light05.png" => "http://i.imgur.com/Z0vcH4o.png",
        "external-link-grey-light06.png" => "http://i.imgur.com/oioEvkP.png",
        "external-link-grey-medium02.png" => "http://i.imgur.com/KFJkZIi.png",
        "external-link-grey-medium03.png" => "http://i.imgur.com/RQ4KKZm.png",
        "external-link-grey-medium04.png" => "http://i.imgur.com/XaUfZcb.png",
        "external-link-grey-medium05.png" => "http://i.imgur.com/AYw03u7.png",
        "external-link-grey-medium06.png" => "http://i.imgur.com/RggNC4V.png",
        "external-link-lilac02.png" => "http://i.imgur.com/oCYuDxY.png",
        "external-link-lilac03.png" => "http://i.imgur.com/spVw0xP.png",
        "external-link-lilac04.png" => "http://i.imgur.com/fEeH7xM.png",
        "external-link-lilac05.png" => "http://i.imgur.com/yKEsEd1.png",
        "external-link-lilac06.png" => "http://i.imgur.com/SLPTKfO.png",
        "external-link-mint02.png" => "http://i.imgur.com/3Cxg7tl.png",
        "external-link-mint03.png" => "http://i.imgur.com/SFHYzYS.png",
        "external-link-mint04.png" => "http://i.imgur.com/yKDWEHT.png",
        "external-link-mint05.png" => "http://i.imgur.com/MtiUmI6.png",
        "external-link-mint06.png" => "http://i.imgur.com/yOjLHUP.png",
        "external-link-orange-dark02.png" => "http://i.imgur.com/ELDekrj.png",
        "external-link-orange-dark03.png" => "http://i.imgur.com/EfZPcNO.png",
        "external-link-orange-dark04.png" => "http://i.imgur.com/E8xWl7A.png",
        "external-link-orange-dark05.png" => "http://i.imgur.com/HxLPzhy.png",
        "external-link-orange-dark06.png" => "http://i.imgur.com/VKz1MAL.png",
        "external-link-orange-light02.png" => "http://i.imgur.com/Ojmk44l.png",
        "external-link-orange-light03.png" => "http://i.imgur.com/9IjFwGk.png",
        "external-link-orange-light04.png" => "http://i.imgur.com/fD0y0fm.png",
        "external-link-orange-light05.png" => "http://i.imgur.com/cMdwQDi.png",
        "external-link-orange-light06.png" => "http://i.imgur.com/739ePw5.png",
        "external-link-pink02.png" => "http://i.imgur.com/GOkpNUB.png",
        "external-link-pink03.png" => "http://i.imgur.com/hWOAlNQ.png",
        "external-link-pink04.png" => "http://i.imgur.com/UvbJYXJ.png",
        "external-link-pink05.png" => "http://i.imgur.com/wEt0rFj.png",
        "external-link-pink06.png" => "http://i.imgur.com/TcpISG0.png",
        "external-link-red02.png" => "http://i.imgur.com/QV3BU2v.png",
        "external-link-red03.png" => "http://i.imgur.com/QM952wk.png",
        "external-link-red04.png" => "http://i.imgur.com/Lo8vNY3.png",
        "external-link-red05.png" => "http://i.imgur.com/PSuScoC.png",
        "external-link-red06.png" => "http://i.imgur.com/I6lPJMv.png",
        "external-link-red-dark02.png" => "http://i.imgur.com/w6dRtPK.png",
        "external-link-red-dark03.png" => "http://i.imgur.com/WzbVmiu.png",
        "external-link-red-dark04.png" => "http://i.imgur.com/H6UPCvk.png",
        "external-link-red-dark05.png" => "http://i.imgur.com/V1vBqfi.png",
        "external-link-red-dark06.png" => "http://i.imgur.com/Nl89rsS.png",
        "external-link-violet02.png" => "http://i.imgur.com/py9cxzc.png",
        "external-link-violet03.png" => "http://i.imgur.com/krWZs6l.png",
        "external-link-violet04.png" => "http://i.imgur.com/ijtjIJR.png",
        "external-link-violet05.png" => "http://i.imgur.com/pfjgem5.png",
        "external-link-violet06.png" => "http://i.imgur.com/uEcX3r0.png" 
    );
    
    return $array[$image];
}
?>