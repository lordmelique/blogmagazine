<?php

add_action( 'admin_menu', 'bmag_add_theme_page' );
add_action( 'admin_init', 'bmag_register_settings' );

/**
 * Creates Theme menu page
 */ 
function bmag_add_theme_page() {
	$menu = add_theme_page(
			 /* The text to be displayed in the title tags of the page when the menu is selected. */
			 BMAG_TITLE,
			 /* The text to be used for the menu */ 
			 BMAG_TITLE,
			 /* The capability required for this menu to be displayed to the user. */ 
			 'edit_theme_options',
			 /* The slug name to refer to this menu by (should be unique for this menu). */
			 BMAG_SLUG, 
			 /* The function to be called to output the content for this page. */
			 'bmag_theme_page_callback'
			 );
	add_action( 'admin_print_styles' . $menu, 'bmag_admin_scripts' );
}

/**
 * Callback function for rendering theme page
 */
function bmag_theme_page_callback() {
	require_once(BMAG_DIR . '/inc/admin/framework/BMAGLibrary.php');
	$controller_class = "BMAGControllerThemePage_bmag";
	require_once(BMAG_DIR . '/inc/admin/mvc/controllers/' . $controller_class . '.php');
	$controller = new $controller_class();
	$controller->execute();
}


/**
 * Registers theme settings
 */
function bmag_register_settings(){

}

/**
 * Function where should be enqueued admin script and styles
 */
function bmag_admin_scripts() {

}

/**
 * This is blueprint for settings tabs,
 * @return array of tab objects with it's properties
 */
function bmag_get_tabs(){
	$tabs = array();

	$tabs['general'] = array(
	    'name' => 'general',
	    'title' => __( 'General', 'bmag' ),
	    'sections' => array(
	      'demo_section' => array(
	        'name' => 'demo_section',
	        'title' => __( 'Demo Section', 'bmag' ),
	        'description' => 'Demo Description'
	      )
	   ),
	  'description' => bmag_tab_descr('general')
	);
	return apply_filters( 'bmag_get_tabs', $tabs );
}

/**
 * Collects settings from all tabs into single settings array
 * settings blueprints are located in admin/settings
 */
function bmag_get_all_settings(){
	
	$settings_by_tabs = array();
	$settings = array();

	require_once( BMAG_DIR . '/inc/admin/settings/BMAGGeneralSettings.php' );
  	$settings_by_tabs['general'] = new BMAGGeneralSettings();

  	foreach ( $settings_by_tabs as $tab ) {
  		foreach ( $tab->options as $option => $value ) {
  			$settings[$option] = $value;
  		}
  	}
  	
  	return apply_filters( 'bmag_get_all_settings', $settings );
}

/**
 * @param $tabname
 * @return $tabdescription
 */
function bmag_tab_descr( $tabname ){
	switch ( $tabname ){
		case 'general':{
			return __('This is demo description for general tab','bmag');
			break;
		}
		default:{
			return '';
		}
	}
}

?>