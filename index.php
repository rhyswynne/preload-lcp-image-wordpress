<?php

/*
Plugin Name: Preload LCP Image
Plugin URI: https://dwinrhys.com/preload-largest-contentful-paint-image-wordpress-plugin/?utm_source=wordpressorgplugin&utm_medium=wordpress&utm_campaign=preload_lcp
Description: Plugin to preload the LCP element within WordPress
Version: 1.4
Author: Dwi'n Rhys
Author URI: https://dwinrhys.com/?utm_source=wordpressorgplugin&utm_medium=wordpress&utm_campaign=preload_lcp
*/

define( 'DR_PRELOAD_LCP_PATH', dirname( __FILE__ ) );
define( 'DR_PRELOAD_LCP_URL', plugins_url( '', __FILE__ ) );
define( 'DR_PRELOAD_LCP_PLUGIN_VERSION', '1.4' );

require_once DR_PRELOAD_LCP_PATH . '/inc/core.php';
