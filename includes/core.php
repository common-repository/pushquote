<?php 

// Shortcode

function pullquote_simple_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'position' => 'left'
	), $atts));
	
	return "<span class='realtidbitsPushquote ".$position."'>".$content."</span>";
}
add_shortcode('pullquote', 'pullquote_simple_shortcode');

// Javascript Files

function realtidbitsPushquote_enqueue_scripts() {
	global $realtidbitsPushquote;
	if ( !is_admin() ){ 
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'realtidbitsPushquote', realtidbitsPushquote_plugin_url( 'js/pullquote.js' ),
			array('jquery'), REALPUSHQUOTE_VER, false); 
		wp_localize_script( 'realtidbitsPushquote', 'PushquoteAjax', array( 'show_credits' => (is_array($realtidbitsPushquote) ? $realtidbitsPushquote['show_credits'] : 0 ), 'login' => $realtidbitsPushquote['login'], 'api_key' => $realtidbitsPushquote['api_key'] ) );
	}
}

add_action( 'init', 'realtidbitsPushquote_enqueue_scripts' );

// Styles 

function realtidbitsPushquote_enqueue_styles() {	
  global $post, $realtidbitsPushquote, $wp_registered_widgets,$wp_widget_factory;
  
  wp_enqueue_style( 'realtidbitsPushquote_headcss', realtidbitsPushquote_plugin_url( 'css/pullquote.css' ),
	false, REALPUSHQUOTE_VER, 'all');
}
add_action( 'wp', 'realtidbitsPushquote_enqueue_styles' );

?>