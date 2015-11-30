<?php

add_action( 'admin_menu', 'bmag_add_theme_page' );
add_action( 'admin_init', 'bmag_register_settings' );
add_action( 'admin_enqueue_scripts', 'bmag_admin_enqueue_scripts' );
add_action( 'option_' . BMAG_OPT, 'bmag_options_mix_defaults' );
add_action( 'after_setup_theme', 'bmag_options_init', 10, 2 );


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
	global $bmag_tabs,$bmag_tabnames;
	//registering setting
	register_setting( 'bmag_options', 'theme_' . BMAG_VAR . '_options', 'bmag_options_validate' );

	//registering settings sections
	$bmag_tabs = bmag_get_tabs();
	$bmag_tabnames = bmag_get_tab_names();
	foreach ( $bmag_tabs as $tab ) {
		$tabname = $tab['name'];
		$sections = $tab['sections'];
		foreach ( $sections as $section ) {
			add_settings_section( 
				//String for use in the 'id' attribute of tags.
				'bmag_' . $section['name'] . '_section',
				//Title of the section.
				$section['title'],
				// Function that fills the section with the desired content. The function should echo its output.
				'bmag_section_callback',
				/* The menu page on which to display this section. Should match $menu_slug from add_theme_page
				   Or should be passed to do_settings_section to render this section */
				'bmag_' . $tabname . '_tab'
			);
		}

	}
	//registering settings fields
	$all_settings = bmag_get_all_settings();
	foreach ( $all_settings as $setting ) {
		if( isset( $setting['name'] ) && isset( $setting['title'] ) && isset( $setting['tab'] ) && isset( $setting['section'] ) && isset( $setting['type'] ) ){
			$settingname    = $setting['name'];
			$settingtitle   = $setting['title'];
			$settingtab     = $setting['tab'];
			$settingtype    = $setting['type'];
			$settingsection = $setting['section'];
			
			if( 'custom' != $settingtype ){
				add_settings_field( 
					// String for use in the 'id' attribute of tags.
					BMAG_VAR . '_setting_' . $settingname,
					// Title of the field.
					$settingtitle,
					/* Function that fills the field with the desired inputs as part of the larger form.
					  Passed a single argument, the $args array. Name and id of the input should match the $id given to this function.
					  The function should echo its output.*/
					'bmag_field_callback',
					// The menu page on which to display this field. Should match $menu_slug from add_theme_page() or from do_settings_sections(). 
					'bmag_' . $settingtab . '_tab',
					/* The section of the settings page in which to show the box (default or a section you added with add_settings_section(),
					   look at the page in the source to see what the existing ones are.) */
					'bmag_' . $settingsection . '_section',
					// Additional arguments that are passed to the $callback function.
					$setting 
				);
			} else {
				add_settings_field( 
				// String for use in the 'id' attribute of tags.
				BMAG_VAR . '_setting_' . $settingname,
				// Title of the field.
				$settingtitle,
				/* Function that fills the field with the desired inputs as part of the larger form.
				  Passed a single argument, the $args array. Name and id of the input should match the $id given to this function.
				  The function should echo its output.*/
				'bmag_field_callback_' . $settingname,
				// The menu page on which to display this field. Should match $menu_slug from add_theme_page() or from do_settings_sections(). 
				'bmag_' . $settingtab . '_tab',
				/* The section of the settings page in which to show the box (default or a section you added with add_settings_section(),
				   look at the page in the source to see what the existing ones are.) */
				'bmag_' . $settingsection . '_section'
			);
			}
		} 
	}
}



/**
 * Function where should be enqueued admin styles and scripts
 */
function bmag_admin_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-form', array( 'jquery' ) );
	wp_enqueue_script( 'themepagecontroller', BMAG_URL . '/inc/js/themepagecontroller.js', array('jquery'), BMAG_VERSION);
	wp_localize_script( 'themepagecontroller', 'bmag_admin', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'bmag_nonce' => wp_create_nonce( 'bmag_submit_form_data' )
		) );
	wp_enqueue_style( 'bmag-font-awesome', BMAG_URL . '/inc/css/font-awesome/font-awesome.css',array(), BMAG_VERSION);
	wp_enqueue_style( 'bmag-options-page', BMAG_URL . '/inc/css/bmag-options-page.css', array(), BMAG_VERSION );
}

/**
 * This is blueprint for settings tabs,
 * @return array of tab objects with its properties
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
		  ),
		  'demo_section2' => array(
			'name' => 'demo_section2',
			'title' => __( 'Demo Section 2', 'bmag' ),
			'description' => 'Demo Description'
		  )
	   ),
	  'icon' => 'fa fa-cogs',
	  'description' => bmag_tab_descr( 'general' )
	);
	$tabs['home'] = array(
		'name' => 'home',
		'title' => __( 'Home', 'bmag' ),
		'sections' => array(
		  'home_section' => array(
			'name' => 'home_section',
			'title' => __( 'Demo Section', 'bmag' ),
			'description' => 'Demo Description'
		  ),
		  'home_section2' => array(
			'name' => 'home_section2',
			'title' => __( 'Demo Section 2', 'bmag' ),
			'description' => 'Demo Description'
		  )
		),
		'icon' => 'fa fa-home',
		'description' => bmag_tab_descr( 'home' )
	);
	return apply_filters( 'bmag_get_tabs', $tabs );
}

/**
 * Returns tabnames
 */
function bmag_get_tab_names(){
	$bmag_tabs = bmag_get_tabs();
	$tabnames = array();
	foreach ( $bmag_tabs as $tab ) {
		array_push( $tabnames,$tab['name'] );
	}
	return $tabnames;
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

	require_once( BMAG_DIR . '/inc/admin/settings/BMAGHomeSettings.php' );
	$settings_by_tabs['home'] = new BMAGHomeSettings();


	foreach ( $settings_by_tabs as $tab ) {
		foreach ( $tab->options as $option => $value ) {
			$settings[$option] = $value;
		}
	}
	
	return apply_filters( 'bmag_get_all_settings', $settings );
}

/**
 * Returns default values of specific settings tab in name => value pairs
 */
function bmag_get_tab_defaults( $tabname ){
	$settings = bmag_get_all_settings();
	$tabsettings = array();

	foreach ( $settings as $setting => $value ) {
		if( $value['tab'] == $tabname ){
			$tabsettings[$setting] = $value['default'];
		}
	}
	return apply_filters( 'bmag_get_settings_by_tabname', $tabsettings );
}

/**
 * Returns default values of all settings in name => value pairs
 */
function bmag_get_defaults(){
	$settings = bmag_get_all_settings();
	$defaults = array();
	foreach ( $settings as $setting ) {
		$defaults[$setting['name']] = $setting['default'];
	}
	$defaults['theme_version'] = BMAG_VERSION;
	return apply_filters( 'bmag_get_defaults', $defaults );
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
		case 'home':{
			return __('This is demo description for home tab','bmag');
			break;
		}
		default:{
			return '';
		}
	}
}

/**
 * Callback function for settings sections
 */
function bmag_section_callback(){

}

/**
 * Callback function for settings fields
 */
function bmag_field_callback( $option, $context = 'option', $opt_val ='', $meta = array() ) {
	require_once( BMAG_DIR . '/inc/admin/framework/BMAGOutputs.php' );
	$bmag_outputs = new BMAGOutputs();
	$bmag_outputs->render_field( $option, $context, $opt_val, $meta );
}
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
function bmag_options_validate( $options ){

	require_once( BMAG_DIR . '/inc/admin/framework/BMAGInputs.php' );

	//$options = bmag_option_validator( $options );

	return apply_filters( 'bmag_sanitize_options', $options );
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

	return $options;
}
add_filter( 'bmag_sanitize_options', 'bmag_options_sanitizer' );



/**
 * Prints out all settings sections added to a particular settings page
 *
 * This is a modified version of its analog do_settings_sections from Settings API
 *
 * Use this in a settings page callback function
 * to output all the sections and fields that were added to that $page with
 * add_settings_section() and add_settings_field()
 *
 * @global $wp_settings_sections Storage array of all settings sections added to admin pages
 * @global $wp_settings_fields Storage array of settings fields and info about their pages/sections
 * @since 2.7.0
 *
 * @param string $page The slug name of the page whos settings sections you want to output
 */
function bmag_do_settings_sections( $page , $display = '') {
	global $wp_settings_sections, $wp_settings_fields;

	if ( ! isset( $wp_settings_sections[$page] ) )
		return;

	if($display == 'active'){
		$active_class = 'bmag_active';
	}else{
		$active_class = '';
	}


	echo "<div class='bmag_settings_tab " . $active_class . "' tab='" . $page . "'>";
	foreach ( (array) $wp_settings_sections[$page] as $section ) {
		
		if ( $section['title'] )
			echo "<div class='bmag_settings_section'><h1 class='bmag_section_title'>{$section['title']}<span class='fa fa-chevron-right bmag_section_caret'></span></h1>\n";

		if ( $section['callback'] )
			call_user_func( $section['callback'], $section );

		if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) ){
			echo "</div>"; /* Closing div for <div class='bmag_settings_section'> in case of continuing loop */
			continue;
		}
		echo "<div class='bmag_settings_fields'>";
		bmag_do_settings_fields( $page, $section['id'] );
		echo "</div></div>";
	}
	echo "</div>";
}



/**
 * Print out the settings fields for a particular settings section
 *
 * This is a modified version of its analog do_settings_fields from Settings API
 *
 * Use this in a settings page to output
 * a specific section. Should normally be called by bmag_do_settings_sections()
 * rather than directly.
 *
 * @global $wp_settings_fields Storage array of settings fields and their pages/sections
 *
 * @since 2.7.0
 *
 * @param string $page Slug title of the admin page who's settings fields you want to show.
 * @param string $section Slug title of the settings section who's fields you want to show.
 */
function bmag_do_settings_fields( $page, $section ) {
	global $wp_settings_fields;
	if ( ! isset( $wp_settings_fields[$page][$section] ) )
		return;

	foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
		$class = '';

		if ( ! empty( $field['args']['class'] ) ) {
			$class = ' class="' . esc_attr( $field['args']['class'] ) . '"';
		}else{
			$class = ' class="bmag_settings_field"';
		}

		echo "<div{$class}>";

		if ( ! empty( $field['args']['label_for'] ) ) {
			echo '<h4 class="bmag_field_title"><label for="' . esc_attr( $field['args']['label_for'] ) . '">' . $field['title'] . '</label></h4>';
		} else {
			echo '<h4 class="bmag_field_title">' . $field['title'] . '</h4>';
		}

		echo '<div class="bmag_field_content">';
		call_user_func( $field['callback'], $field['args'] );
		echo '<div class="clear"></div>';
		echo '</div>';
		echo '</div>';
	}
}


/**
 * Pre oprion callback
 */
function bmag_options_mix_defaults( $options ){
  $option_defaults = bmag_get_defaults( );
  /*theme version is saved separately*/
  /*for the updater*/
  if( isset( $option_defaults['theme_version'] ) ){
    unset( $option_defaults['theme_version'] );
  }
  $options = wp_parse_args( $options, $option_defaults );
  return $options;
}

/**
 * Initializes theme options, if update needed updates them
 */
function bmag_options_init() {
  global $bmag_options;
  $option_defaults = bmag_get_defaults( );
  $new_version = $option_defaults['theme_version'];
  $options = get_option( BMAG_OPT, array( ) );

  if( isset( $options['theme_version'] ) ){
    $old_version = $options['theme_version'];
  }
  else{
    $old_version = '0.0.0';
  }

  if( $new_version !== $old_version ){
    require_once( 'bmag_updater.php' );
    $theme_update = new Blog_Magazine_updater( $new_version, $old_version );
    $options = $theme_update->get_old_params();  /* old params in new format */
  }
    
  /*overwrite defaults with new options*/
  $bmag_options = apply_filters( 'bmag_options_init', $options);
}