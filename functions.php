<?php
function realtidbitsPushquote_admin_url( $query = array() ) {
	global $plugin_page;

	if ( ! isset( $query['page'] ) )
		$query['page'] = $plugin_page;

	$path = 'admin.php';

	if ( $query = build_query( $query ) )
		$path .= '?' . $query;

	$url = admin_url( $path );

	return esc_url_raw( $url );
}

function realtidbitsPushquote_plugin_url( $path = '' ) {
	global $wp_version;
	if ( version_compare( $wp_version, '2.8', '<' ) ) { // Using WordPress 2.7
		$folder = dirname( plugin_basename( __FILE__ ) );
		if ( '.' != $folder )
			$path = path_join( ltrim( $folder, '/' ), $path );

		return plugins_url( $path );
	}
	return plugins_url( $path, __FILE__ );
}


function realtidbitsPushquote_addbuttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "add_realtidbitsPushquote_tinymce_plugin");
     add_filter('mce_buttons', 'register_realtidbitsPushquote_button');
   }
}
 
function register_realtidbitsPushquote_button($buttons) {
   array_push($buttons, "pullquote");
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_realtidbitsPushquote_tinymce_plugin($plugin_array) {
   $plugin_array['pullquote'] = realtidbitsPushquote_plugin_url().'/tinymce/pullquote.js';
   return $plugin_array;
}
 
// init process for button control
add_action('init', 'realtidbitsPushquote_addbuttons');

$new_general_setting = new new_general_setting();
 
class new_general_setting {
    function new_general_setting( ) {
        add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
    }
    function register_fields() {
        register_setting( 'general', 'realtidbitsPushquote_options' );
        add_settings_field('pushquotes_show_credits', '<label for="show_credits">'.__('Show PushQuotes credits text?' ).'</label>' , array(&$this, 'fields_html') , 'general' );
		add_settings_field('pushquotes_login', '<label for="login">'.__('Bit.ly Login' ).'</label>' , array(&$this, 'login') , 'general' );
		add_settings_field('pushquotes_api_key', '<label for="api_key">'.__('Bit.ly Api Key' ).'</label>' , array(&$this, 'api_key') , 'general' );
    }
    function fields_html() {
		global $realtidbitsPushquote;
		if(is_array($realtidbitsPushquote)) {
        	$value = $realtidbitsPushquote['show_credits'];
		} else {
			$value = 0;
		}
        echo '<input type="checkbox" id="realtidbitsPushquote_options[show_credits]" name="realtidbitsPushquote_options[show_credits]" value="1" '.($value ? "checked='checked'" : "").' />';
    }
	function login() {
		global $realtidbitsPushquote;
		if(is_array($realtidbitsPushquote)) {
        	$value = $realtidbitsPushquote['login'];
		} else {
			$value = "";
		}
        echo '<input type="text" id="realtidbitsPushquote_options[login]" name="realtidbitsPushquote_options[login]" value="'.$value.'" />';
    }
	function api_key() {
		global $realtidbitsPushquote;
		if(is_array($realtidbitsPushquote)) {
        	$value = $realtidbitsPushquote['api_key'];
		} else {
			$value = "";
		}
        echo '<input type="text" id="realtidbitsPushquote_options[api_key]" name="realtidbitsPushquote_options[api_key]" value="'.$value.'" />';
    }
}
?>