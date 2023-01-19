<?php

/*
Plugin Name: Preload LCP Image
Plugin URI: 
Description: Plugin to preload the LCP element within WordPress
Version: 1.0
Author: Dwi'n Rhys
Author URI: https://dwinrhys.com/
*/

define( 'DR_PRELOAD_LCP_PATH', dirname( __FILE__ ) );
define( 'DR_PRELOAD_LCP_URL', plugins_url( '', __FILE__ ) );
define( 'DR_PRELOAD_LCP_PLUGIN_VERSION', '1.0' );

require_once DR_PRELOAD_LCP_PATH . '/inc/core.php';
