<?php

/**
 * Validates all settings getted from settings form
 *
 * If any option is not valid replaces option with its default
 * Then returns validated options with bmag_sanitize_options hook attached
 *
 * @param $options
 * @return $options
 *
 */
function bmag_options_validate( $input ){

	global $bmag_options;

	// OPTIONS

	$valid_input = $bmag_options;
	$option_defaults = bmag_get_defaults();

	// SETTINGS WITH ALL THEIR INFO

	$bmag_settings = bmag_get_all_settings();

	// TABS

	$bmag_tabs = bmag_get_tabs();
	$bmag_tabnames = bmag_get_tab_names();

	// INPUT TYPE
	
	$input_task = explode( '-', $input['task'] );
	$input_type = $input_task[0];	
	$input_name = $input_task[1];
	unset( $valid_input['task'] );

	if ( 'reset' == $input_type ) {
		if ( 'all' == $input_name ) {
			return $option_defaults;
		} else {
			foreach ( $bmag_tabnames as $tab_name ) {
				$tab_defaults = bmag_get_tab_defaults( $tab_name );
				$valid_input = wp_parse_args( $tab_defaults, $valid_input );
				return $valid_input;	
			}
		}
	} else {
		foreach ( $bmag_settings as $_setting ) {
			$setting = $_setting['name'];
			
			switch ($_setting['type']) :
				case 'color':
					$valid_input[$setting] = bmag_param_clean($input[$setting], $valid_input[$setting], 'color', $sanitize_type);
				break;
				case 'colors':
					/*to refresh colors of active theme in themes options*/
					$select_theme = $input[$setting]['select_theme'];
					$theme_index = isset($input[$setting]['active']) ? intval($input[$setting]['active']) : 0;
					/*corresponding themes options*/
					/*add to input params*/
					$valid_input[$select_theme] = $valid_input[$select_theme];
					$valid_input[$select_theme]['active'] = $theme_index;
					/* save color values from color panel to option*/
					foreach ($input[$setting]['colors'] as $color => $color_array) {
					$input[$setting]['colors'][$color]['value'] = bmag_param_clean($color_array['value'], $valid_input[$setting]['colors'][$color]['value'], 'color');

					/*also copy each color value to corresponding value in theme options array*/
					$valid_input[$select_theme]['colors'][$theme_index][$color]['value'] = $input[$setting]['colors'][$color]['value'];
					$valid_input[$select_theme]['colors'][$theme_index][$color]['default'] = $option_defaults[$select_theme]['colors'][$theme_index][$color]['default'];
					$input[$setting]['colors'][$color]['default'] = $option_defaults[$select_theme]['colors'][$theme_index][$color]['default'];
					}
					$valid_input[$setting] = $input[$setting];
				break;
				case 'checkbox':
				case 'checkbox_open':
					$valid_input[$setting] = ( isset( $input[$setting] ) && $input[$setting]!=='false' && $input[$setting]!==false ? true : false );
				break;
				case 'radio':
				case 'radio_open':
					$valid_input[$setting] = ( array_key_exists( $input[$setting], $valid_options ) ? $input[$setting] : $valid_input[$setting] );
				break;
				case 'layout' :
				case 'layout_open':
					$valid_input[$setting] = $input[$setting];
				break;
				case 'select':
				case 'select_open':
				case 'select_style':
					$valid_input[$setting] = bmag_param_clean($input[$setting], array(), 'select', $sanitize_type,'', $valid_options);
					break;
				case 'select_theme':
					/*do nothing, the theme options are saved via color panel input (see case 'colors' in this switch)*/
				break;
				case 'text':
				case 'textarea':
				case 'upload_single':
					$valid_input[$setting] = bmag_param_clean($input[$setting], '', 'text', $sanitize_type);
				break;
				case 'textarea_slider':
				case 'text_slider':
				case 'upload_multiple':
					$valid_input[$setting] = bmag_param_clean($input[$setting], '', 'text_slider', $sanitize_type);
				break;
				case 'text_diagram':
					$valid_input[$setting] = bmag_param_clean($input[$setting], '', 'text_diagram', $sanitize_type);
					break;
				default:
					/*do nothing*/
			endswitch;
		}
	}

	


	return apply_filters( 'bmag_sanitize_options', $valid_input );

}

/**
 * Salitizes all settings getted from bmag_option_validate() function
 *
 * If any option is not valid replaces option with it's default
 * 
 * @param $options
 * @return $options
 *
 */
function bmag_options_sanitizer( $options ){
	var_dump($options);
	die();
	return $options;
}
add_filter( 'bmag_sanitize_options', 'bmag_options_sanitizer' );


/*----------------*//*----------------*//*----------------*/
require_once( 'BMAGkses.php' );

function bmag_allowed_html_custom($allowed, $context){
	if ($context === 'allowed_footer_html') {
	global $bmag_allowed_for_footer;
	$allowed = $bmag_allowed_for_footer;
	}else if ($context === 'allowed_slider_desc_html') {
	global $bmag_allowed_for_slider_desc;
	$allowed = $bmag_allowed_for_slider_desc;
	}else if ($context === 'allowed_custom_head') {
	global $bmag_allowed_for_custom_head;
	$allowed = $bmag_allowed_for_custom_head;
	}
	return $allowed;
}
add_filter('wp_kses_allowed_html','bmag_allowed_html_custom',10, 2);

/*----------------*//*----------------*//*----------------*/
function bmag_param_clean($input, $default = false, $param_type, $sanitize_type = '', $validate_type = '', $valid_options = array()){
	$allowed_footer_html = apply_filters( 'wp_kses_allowed_html', "", "allowed_footer_html" );
	$allowed_slider_desc_html = apply_filters( 'wp_kses_allowed_html', "", "allowed_slider_desc_html" );
	$allowed_custom_head = apply_filters( 'wp_kses_allowed_html', "", "allowed_custom_head" );

	$delimiter = '||wd||';

	switch ($param_type) :
	case "color" :
		/* remove whitespaces and add hash symbol if missed */
		$input = str_replace(' ', '',$input);
		if(substr($input,0,1) != "#"){
		 $input = '#'.$input;
		}
		$input = substr($input,0,7);
		/*verify color*/
		if(preg_match('/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $input, $matches)){
		$input = $matches[0];
		}
		else{/*reset color to default value if wrong input*/
		$input = $default; 
		}
		break;

	case 'text':
		if ( 'sanitize_text_field' == $sanitize_type ) {
		$input = wp_filter_nohtml_kses( $input);
		}
		if ( 'sanitize_html_field' == $sanitize_type  ) {
		$input = wp_filter_kses( $input );
		}
		if ( 'esc_url_raw' == $sanitize_type  ) {
		$input = esc_url_raw( $input );
		}
		if ( 'css' == $sanitize_type  ) {
		$input = esc_js( str_replace(array("\n", "\r"), "",$input) );
		}
		if ( 'sanitize_footer_html_field' == $sanitize_type  ) {
		$input = addslashes(wp_kses(stripslashes($input),$allowed_footer_html));
		}
		if ( 'sanitize_head_html_field' == $sanitize_type  ) {
		$input = addslashes(wp_kses(stripslashes($input),$allowed_custom_head));
		}
		break;

	case 'text_slider' :

		if ( 'sanitize_text_field' == $sanitize_type) {
			$arr = explode( $delimiter , $input );
			for ($i=0; $i < sizeof($arr); $i++) { 
			$arr[$i] = wp_filter_nohtml_kses( str_replace(array("\n", "\r"), "", $arr[$i] ));
			}
			$input = implode ( $delimiter , $arr );
		}
		if ( 'sanitize_html_field' == $sanitize_type ) {
			$arr = explode( $delimiter , $input );
			for ($i=0; $i < sizeof($arr); $i++) { 
			$arr[$i] = addslashes(wp_kses(stripslashes(str_replace(array("\n", "\r"), "",$arr[$i])),$allowed_slider_desc_html));
			}
			$input = implode ( $delimiter , $arr );

		}
		if ( 'esc_url_raw' == $sanitize_type) {
			$arr = explode( $delimiter , $input );
			for ($i=0; $i < sizeof($arr); $i++) { 
			$arr[$i] = esc_url_raw($arr[$i]);
			}
			$input = implode ( $delimiter , $arr );
		}
		break;
		
	case 'text_diagram' :

		if ( 'sanitize_text_field' == $sanitize_type) {
			$arr = explode( $delimiter , $input );
			for ($i=0; $i < sizeof($arr); $i++) { 
			$arr[$i] = wp_filter_nohtml_kses( str_replace(array("\n", "\r"), "", $arr[$i] ));
			}
			$input = implode ( $delimiter , $arr );
		}
		break;
	case 'select' :
		$valid_input = $default;
		if(is_string($input)){
		$input = array($input);
		}
		foreach ($input as $key=> $value) { /*selects are always arrays in admin and meta!*/
		if('sanitize_text_field' == $sanitize_type){
			$valid_input[$key]  = wp_filter_nohtml_kses( $value);  
		}
		else{ /*no sanitize*/
			$valid_input[$key]  = $value;  
		}
		
		}
		$input = $valid_input;
		break;

	default :
		break;
	endswitch;
	
	return $input;
}

/*----------------*//*----------------*//*----------------*/
class BMAG_customizer_sanitizer {
	/*--------*//*---------*/ 
	static function color_($input, $setting){
	$default = '#000000';
	/* remove whitespaces and add hash symbol if missed */
	$input = str_replace(' ', '',$input);
	if(substr($input,0,1) != "#"){
		 $input = '#'.$input;
	}
	$input = substr($input,0,7);
	/*verify color*/
	if(preg_match('/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $input, $matches)){
		$input = $matches[0];
	}
	else{/*reset color to default value if wrong input*/
		$input = $default; 
	}
	return $input;
	}
	/*--------*//*---------*/ 
	static function text_($input, $setting){
	return $input;
	}
	/*--------*//*---------*/ 
	static function text_sanitize_text_field($input, $setting){
	$input = wp_filter_nohtml_kses( $input);
	return $input;
	}
	/*--------*//*---------*/ 
	static function text_sanitize_html_field($input, $setting){
	$input = wp_filter_kses( $input);
	return $input;
	}
	/*--------*//*---------*/ 
	static function text_sanitize_footer_html_field($input, $setting){
	$allowed_footer_html = apply_filters( 'wp_kses_allowed_html', "", "allowed_footer_html" );
	$input = addslashes(wp_kses(stripslashes($input),$allowed_footer_html));
	return $input;
	}
	/*--------*//*---------*/ 
	static function text_sanitize_head_html_field($input, $setting){
	$allowed_custom_head = apply_filters( 'wp_kses_allowed_html', "", "allowed_custom_head" );
	$input = addslashes(wp_kses(stripslashes($input),$allowed_custom_head));
	return $input;
	}
	/*--------*//*---------*/ 
	static function text_esc_url_raw($input, $setting){
	$input = esc_url_raw( $input);
	return $input;
	}
	/*--------*//*---------*/ 
	static function text_css($input, $setting){
	$input = esc_js( str_replace(array("\n", "\r"), "",$input) );
	return $input;
	}
	/*--------*//*---------*/ 
	static function text_slider_sanitize_text_field($input, $setting){
	$arr = explode( self::delimiter() , $input );
	for ($i=0; $i < sizeof($arr); $i++) { 
		$arr[$i] = wp_filter_nohtml_kses( str_replace(array("\n", "\r"), "", $arr[$i] ));
	}
	$input = implode ( self::delimiter() , $arr );
	return $input;
	}
	/*--------*//*---------*/ 
	static function text_slider_sanitize_html_field($input, $setting){
	$allowed_slider_desc_html = apply_filters( 'wp_kses_allowed_html', "", "allowed_slider_desc_html" );
	$arr = explode( self::delimiter() , $input );
	for ($i=0; $i < sizeof($arr); $i++) { 
		$arr[$i] = addslashes(wp_kses(stripslashes(str_replace(array("\n", "\r"), "",$arr[$i])),$allowed_slider_desc_html));
	}
	$input = implode ( self::delimiter() , $arr );
	return $input;
	}
	/*--------*//*---------*/ 
	static function text_slider_esc_url_raw($input, $setting){
	$arr = explode( self::delimiter() , $input );
	for ($i=0; $i < sizeof($arr); $i++) { 
		$arr[$i] = esc_url_raw($arr[$i]);
	}
	$input = implode ( self::delimiter() , $arr );
	return $input;
	}
	/*--------*//*---------*/ 
	static function select_($input, $setting){
	$valid_input = array();
	/*if multiple*/
	if(is_array($input)){
		foreach ($input as $key=> $value) {
		$valid_input[$key]  = $value;
		}
	}
	else{
		$valid_input[0]  = $input;
	}
	$input = $valid_input;
	return $input;
	}
	/*--------*//*---------*/ 
	static function select_sanitize_text_field($input, $setting){
	$valid_input = array();
	/*if multiple*/
	if(is_array($input)){
		foreach ($input as $key=> $value) {
		$valid_input[$key]  = wp_filter_nohtml_kses( $value);
		}
	}
	else{
		$valid_input[0]  = wp_filter_nohtml_kses($input);
	}
	$input = $valid_input;
	return $input;
	}
	static function delimiter(){
	return "||wd||";
	}
}