=== WP Links ===
Contributors: nasium
Tags: seo, external, links, new tab, new window, nofollow, rel, target, _blank, Post, posts, page, pages, custom post type, comments, google, url, plugin, article, blog, search engine optimization
Requires at least: 3.0
Tested up to: 4.1
Stable tag: 1.6
Author URI: https://twitter.com/TheRealJAG
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

SEO friendly plugin that forces external links to open in a new tab increasing visit length and potentially increasing your search engine ranking.

== Description ==

WP Links is a SEO friendly, external link handler to improve your on page SEO and increase the time a user spends on your website/blog. One of the ways you can increase your search engine ranking is by increasing the time a user spends browsing your website. 

WP Links also offers the ability to add rel="external nofollow" to all external links. Adding this html attribute to a link effectively stops a link becoming a vote for another page, as far as Google and some other search engines are concerned. As your site grows some links become stale and could hurt your search engine rankings. Using the html attribute on an external (outbound) link tells Google you don't vouch for this other web page enough to help it's search rankings.

Want to see WP Links in action? Visit <a href="http://watchworthy.com/underwater-base-jumping/" target="_blank">Watch Worthy</a>

= Options =
1. Add rel="external nofollow" to external links
2. Open external links in comments in a new tab
3. Open external links in excerpts in a new tab
 
= How does it work? =

The plugin parses links on your post/page/comments/excerpts before it gets written to the screen and adds target="_blank" to the HTML anchor tag. WP Links will preserve title="" and all other anchor tag attributes. 

Additional options are available in the options page. 
 
 == Screenshots ==

1. Options Page

== Installation ==

1. Upload the folder `wp-links` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit the `WP Links Options` page under settings and adjust advanced settings.

== Changelog ==

= 1.5 =
Added the ability to display an icon next to external link. 

= 1.5 =
Core update

= 1.4 =
Fix blank space error.
 
= 1.0 =
First release of the plugin. 