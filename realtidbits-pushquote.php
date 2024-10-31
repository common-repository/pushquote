<?php
/*
Plugin Name: PushQuote Plugin
Description: Add pullquotes easily.
Version: 1.1	
Author: Realtidbits
Author URI: http://realtidbits.com/
Wordpress version supported: 2.8 and above
*/

//on activation
//defined global variables and constants here

global $realtidbitsPushquote;
$realtidbitsPushquote = get_option('realtidbitsPushquote_options');

define("REALPUSHQUOTE_VER","1.1",false);//Current Version of this plugin
if ( ! defined( 'REALPUSHQUOTE_PLUGIN_BASENAME' ) )
	define( 'REALPUSHQUOTE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if ( ! defined( 'REALPUSHQUOTE_CSS_DIR' ) ){
	define( 'REALPUSHQUOTE_CSS_DIR', WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'/css/' );
}
// Create Text Domain For Translations
load_plugin_textdomain('realtidbitsPushquote', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');

function checkMU_install_realtidbitsPushquote($network_wide) {
	global $wpdb;
	if ( $network_wide ) {
		$blog_list = get_blog_list( 0, 'all' );
		foreach ($blog_list as $blog) {
			switch_to_blog($blog['blog_id']);
			install_realtidbitsPushquote();
		}
		switch_to_blog($wpdb->blogid);
	} else {
		install_realtidbitsPushquote();
	}
}

function install_realtidbitsPushquote() {

    $default_settings = array();
    $default_settings = array(
		'active' =>false,
		'show_credits' => false
	);
   
	$realtidbitsPushquote = get_option('realtidbitsPushquote_options');
	
	//if(!$realtidbitsPushquote) {
	 $realtidbitsPushquote = array();
	//}
	
	foreach($default_settings as $key=>$value) {
	  if(!isset($realtidbitsPushquote[$key])) {
		 $realtidbitsPushquote[$key] = $value;
	  }
	}
	
	delete_option('realtidbitsPushquote_options');	  
	update_option('realtidbitsPushquote_options',$realtidbitsPushquote);
}
register_activation_hook( __FILE__, 'checkMU_install_realtidbitsPushquote' );

/* Uninstall */
function checkMU_uninstall_realtidbitsPushquote($network_wide) {
	global $wpdb;
	if ( $network_wide ) {
		$blog_list = get_blog_list( 0, 'all' );
		foreach ($blog_list as $blog) {
			switch_to_blog($blog['blog_id']);
			uninstall_realtidbitsPushquote();
		}
		switch_to_blog($wpdb->blogid);
	} else {
		uninstall_realtidbitsPushquote();
	}
}

function uninstall_realtidbitsPushquote() {
	global $wpdb;
	delete_option('realtidbitsPushquote_options'); 
	
}
register_uninstall_hook( __FILE__, 'checkMU_uninstall_realtidbitsPushquote' );

/* Add new Blog */

add_action( 'wpmu_new_blog', 'newBlog_realtidbitsPushquote', 10, 6); 		
 
function newBlog_realtidbitsPushquote($blog_id, $user_id, $domain, $path, $site_id, $meta ) {
	global $wpdb;
 
	if (is_plugin_active_for_network('realtidbitsPushquote/realtidbitsPushquote.php')) {
		$old_blog = $wpdb->blogid;
		switch_to_blog($blog_id);
		install_realtidbitsPushquote();
		switch_to_blog($old_blog);
	}
}

require_once (dirname (__FILE__) . '/functions.php');
require_once (dirname (__FILE__) . '/includes/core.php');
?>