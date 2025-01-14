=== Preload LCP Image ===
Contributors: rhyswynne
Tags: LCP, preload, site speed, site optimisation, Largest Contentful Paint
Requires at least: 6.1.1
Tested up to: 6.7
Requires PHP: 8.0
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Allows you to specify on individual pages or posts the Largest Contentful Paint (LCP) Image on that page to preload, making the page load quicker.
 
== Description ==
This plugin will add the ability to preload the largest contentful paint (LCP) Image on an individual page or post. This is designed to remove the "Preload the image used by the LCP element in order to improve your LCP time" warning that Google's Pagespeed Insights sometimes serves.

= For Support =
I offer support in two places:-

* For urgent (paid for) support, please [contact me directly](https://dwinrhys.com/contact-me/?utm_source=wordpressorgtext&utm_medium=wordpress&utm_campaign=preload_lcp).
* For not so urgent support, please use the [WordPress.org forums](https://wordpress.org/support/plugin/preload-lcp-image/).

= On Github =
This project is now on github, [you can view the repository here](https://github.com/rhyswynne/preload-lcp-image-wordpress). There are other versions, but this is the one I've put up, so where all the developmental will be tracked.
 
== Installation ==
 
1. Upload the plugin to the /wp-content/plugins/ directory or use the Add New feature
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to any post and page and specify the LCP Image for that page.

Should you wish to use this plugin for custom post types, go to Settings > Preload LCP Image. By default it appears on posts and pages although you can set it to appear on any custom post type on this page.

For more guidance on how to determine the URL to use, please use [my guide on how to determining the LCP image for a WordPress post](https://dwinrhys.com/preload-largest-contentful-paint-image-wordpress-plugin/?utm_source=wordpressorgtext&utm_medium=wordpress&utm_campaign=preload_lcp#determining-the-lcp-image)

== Changelog ==
= 1.4 =
* Added the ability to add a LCP image to Taxonomy Pages

= 1.3.1 =
* Tested with WordPress 6.7

= 1.3 =
* Allow the user to fall back to "post thumbnail" if not specified.

= 1.2 =
* Fixes a bug that causes a console error that ignores the "as" types due to unknown “as” or “type” values, or non-matching “media” attribute.
* Improves the UX of the page in question

= 1.1 =
* Allow the ability to specify different URLs for mobile or desktop viewpoints.

= 1.0.3 =
* Tested with WordPress 6.4

= 1.0.2 =
* Tested with WordPress 6.3

= 1.0.1 =
* Tested with WordPress 6.2

= 1.0 =
* First Public Release 