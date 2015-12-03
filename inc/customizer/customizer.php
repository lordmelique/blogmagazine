<?php

add_action( 'after_setup_theme', 'bmag_customizer_register' );


function bmag_customizer_register(){
  
  add_action( 'customize_register', 'bmag_customizer_add_panels' );
  add_action( 'customize_controls_enqueue_scripts', 'bmag_customizer_add_scripts' );
  global $wp_customize;
  if ( isset( $wp_customize ) ) {
    add_action( 'customize_preview_init','bmag_customizer_refresh_head', 9);
  }

  

}

function bmag_customizer_add_panels($wp_customize ){

  /*
  the following sections are standard

  title_tagline – Site Title & Tagline
  colors – Colors
  header_image – Header Image
  background_image – Background Image
  nav – Navigation
  static_front_page – Static Front Page
  */
  
  $panels = bmag_get_tabs();

  $priority = 1;
 
  // Add panels

  foreach ( $panels as $panel => $panel_data ) {
    $wp_customize->add_panel( BMAG_VAR .'_'. $panel, array(
        'priority'       => $priority,
        'capability'     => 'edit_theme_options',
        'title'          => $panel_data['title'],
        'description'    => $panel_data['description'],
      )
    );

    foreach ($panel_data['sections'] as $section => $section_data ){
      $wp_customize->add_section( $section, array(
          'priority'       => $priority,
          'capability'     => 'edit_theme_options',
          'title'          => $section_data['title'],
          'description'    =>  $section_data['description'],
          'panel'  => BMAG_VAR .'_'. $panel,
        )
      );
    }
    $priority += 1;
  }
  /*move standard WP sections to general panel*/
  
  $general_links_priority = $wp_customize->get_section( 'demo_section' )->priority;//this is the last section name in general settings

  $core_sections = array('title_tagline','header_image','background_image','static_front_page');
  $core_sections_priority = $general_links_priority+1;
  foreach($core_sections as $core_section){
    $core_sect = $wp_customize->get_section( $core_section );
    $core_sect->panel = BMAG_VAR .'_general'; 
    $core_sect->priority = $core_sections_priority;
    $core_sections_priority += 1;
  }
  
  /*move background color to color control panel*/
  $wp_customize->get_control( 'background_color' )->section = 'color_control';

  $builtin_mods = array(
    'background',
    'navigation',
    'site-title-tagline',
    'static-front-page',
  );
 
  $options = bmag_get_all_settings();
  // Add options to the section

  bmag_customizer_add_section_options( $options );
}



function bmag_customizer_add_section_options( $options_array) {
  global $wp_customize;
 
  foreach ( $options_array as $optionname => $option ) {
    // Add setting
    if ( isset( $option['customizer'] ) ) {
      $defaults = array(
        'type'                 => 'option',
        'capability'           => 'edit_theme_options',
        'theme_supports'       => '',
        'transport'            => 'refresh',
        'sanitize_callback'    => '',
        'sanitize_js_callback' => ''
      );
      $setting = wp_parse_args( $option['customizer'], $defaults );
      $setting_id = BMAG_OPT.'[' . $optionname . ']';
      $sanitize_callback = bmag_options_customizer_validate($option);

/*test*/
if($optionname == 'color_scheme'){
  $setting_id = BMAG_OPT.'[' . $optionname . '][active]';
}

      $wp_customize->add_setting( $setting_id, array(
        'default'              => $option['default'],
        'type'                 => $setting['type'],
        'capability'           => $setting['capability'],
        'theme_supports'       => $setting['theme_supports'],
        'transport'            => $setting['transport'],
        'sanitize_callback'    => $sanitize_callback,
        'sanitize_js_callback' => $setting['sanitize_js_callback'],
      ) );

      // Add controls
      require_once('BMAG_control_classes.php');
      // Check for a specialized control class
          
      // Dynamically generate a new class instance
      if(class_exists ( "BMAG_control_".$option['type'] )){
        $classname  = "BMAG_control_".$option['type'];
        $wp_customize->add_control( new $classname( $wp_customize, $setting_id, array('element'=>$option) ) );
      
      } 
      else {

        $wp_customize->add_control( $setting_id, array(
          'settings' => $setting_id,
          'label'    => $option['title'],
          'section'  => $option['section'],
          'type'     => $option['type']
          )
        );
      }
    }
  }
}


function bmag_options_customizer_validate($param){
  if(!isset($param['type'])){
    return '';
  }
  if(!isset($param ['sanitize_type'])){
    $param ['sanitize_type'] ='';
  }

  switch ($param['type']) :
    case 'text':
    case 'textarea':
    case 'upload_single':
      $callback_func = "text_" . $param ['sanitize_type'];
      break;
    case 'textarea_slider':
    case 'text_slider' :
    case 'upload_multiple' :
      $callback_func = "text_slider_" . $param ['sanitize_type'];
      break;
    case 'select' :
    case 'select_open' :
    case 'select_style' :
      $callback_func = "select_". $param ['sanitize_type'];
      break;
    case 'select_theme' :
      $callback_func = "select_theme_". $param ['sanitize_type'];
      break;
    default :
      return '';
      break;
  endswitch;

  return array('BMAG_customizer_sanitizer', $callback_func);

}



function bmag_customizer_add_scripts(){

  wp_enqueue_script('media-upload');
  add_thickbox();
  wp_enqueue_script( 'bmag_jquery-show', BMAG_URL.'/inc/js/jquery-show.js',array( 'jquery'), BMAG_VERSION);
  wp_enqueue_script( 'bmag_customizer-preview', BMAG_URL.'/inc/js/BMAG_elements.js',array( 'jquery','wp-color-picker','bmag_jquery-show' ), BMAG_VERSION, true);

  wp_localize_script( 'bmag_customizer-preview', 'bmag_slide_warning', __("You cannot delete the last slide! Try to turn off the slider", 'bmag') );
  
  wp_enqueue_style( 'bmag_customizer_style', BMAG_URL. '/inc/css/admin.css', array(),BMAG_VERSION );
  
  $customizer_reset_nonce = wp_create_nonce('bmag_customizer_reset');

  wp_enqueue_script( 'bmag_customizer-main', BMAG_URL.'/inc/customizer/customizer.js',array( 'jquery'), BMAG_VERSION);
  $params_array = array(
    'homepage' => BMAG_HOMEPAGE,
    'img_URL' => BMAG_IMG_INC,
    'is_pro' => BMAG_IS_PRO,
  );
  wp_localize_script( 'bmag_customizer-main', 'BMAG', $params_array );
  $server_url = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 'https://'.$_SERVER['SERVER_NAME'] : 'http://'.$_SERVER['SERVER_NAME'];
  wp_localize_script( 'bmag_customizer-main','bmag_customizer',array('bmag_customizer_reset_nonce'=>$customizer_reset_nonce,'bmag_server_name'=>$server_url));
}

/**
 * called right before the bmag_include_head() to update the options variable value
 * pre_option hook is called in customizer API
 */

function bmag_customizer_refresh_head(){
  global $bmag_front,
          $bmag_options;

  $bmag_options = bmag_get_options();
  $front_class = BMAG_VAR.'_front';
  // $bmag_front =  new $front_class($bmag_options);
  // add_filter( 'wp_title', array($bmag_front, 'title'), 10 , 2);

}



