<?php
if ( ! defined( 'ABSPATH' ) ){ 
    exit;
}
add_theme_support( 'title-tag' );
add_theme_support( 'custom-logo' );
add_action(
    'after_setup_theme',
    function() {
        add_theme_support( 'html5', array( 'script', 'style' ));
    }
);
// Register menu
add_action( 'after_setup_theme', function(){
	register_nav_menus( array(
		'header_menu' => 'Header menu',
		'header_blog_menu' => 'Header blog menu',
        'footer_menu' => 'Footer menu'
    ));
} );
// ACF page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> __('Site content'),
		'menu_title'	=> __('Site content'),
		'menu_slug' 	=> 'theme-general-content',
		'capability'	=> 'edit_posts',
		'redirect'		=> true,
        'position'      =>  6,
        'icon_url'      =>  'dashicons-welcome-widgets-menus'
    ));
    acf_add_options_page(array(
        'page_title'  => __('Header'),
        'menu_title'  => __('Header'),
        'parent_slug' => 'theme-general-content',
        'post_id' => 'header',
        'position'      =>  2,
    ));
    acf_add_options_page(array(
        'page_title'  => __('Footer'),
        'menu_title'  => __('Footer'),
        'parent_slug' => 'theme-general-content',
        'post_id' => 'footer',
        'position'      =>  3,
    ));
    acf_add_options_page(array(
        'page_title'  => __('Blocks shortcode'),
        'menu_title'  => __('Blocks shortcode'),
        'parent_slug' => 'theme-general-content',
        'post_id' => 'shortcode',
        'position'      =>  4,
    ));
}


if( function_exists('acf_add_options_page') ) {
    $maine_option = acf_add_options_page( array(
        'page_title' => 'Site Settings',
        'menu_title' => 'Site Settings',
        'redirect'   => 'Site Settings',
    ) );
}

// short code button
add_shortcode( 'button', 'button_short_code' );
function button_short_code( $atts ){
	$atts = shortcode_atts( array(
		'text' => 'text',
		'url' => '#'
	), $atts );
	return "<div class='btn'><a href='{$atts['url']}'>{$atts['text']}</a></div>";
}
// contact form
add_filter('wpcf7_autop_or_not', '__return_false');
add_filter('wpcf7_form_elements', function($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
    return $content;
});
function get_ago_time($post_data){
	$current_data = current_time( 'timestamp' );
	if($post_data + (60 * 60 * 24 * 7 ) >= $current_data){
		return sprintf( esc_html__( '%s ago', 'gladiator-theme' ), human_time_diff($post_data, $current_data ) );
	} else {
		return date('d F Y', $post_data);
	}
}