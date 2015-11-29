<?php

add_action( 'admin_menu', 'bmag_add_theme_page' );
add_action( 'admin_init', 'bmag_register_settings' );
add_action( 'admin_enqueue_scripts', 'bmag_admin_enqueue_scripts' );


add_action( 'wp_ajax_bmag_form_submit', 'bmag_form_submit_callback' );

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

	global $bmag_tabs,$bmag_tabnames,$bmag_defaults;
	//registering setting
	register_setting( 'bmag_options', 'theme_' . BMAG_VAR . '_options', 'bmag_options_validate' );
	
	//registering settings sections
	$bmag_tabs = bmag_get_tabs();
	$bmag_tabnames = bmag_get_tab_names();
	$bmag_defaults = bmag_get_defaults();
	foreach ($bmag_tabs as $tab) {
		$tabname = $tab['name'];
		$sections = $tab['sections'];
		foreach ($sections as $section) {
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
	foreach ($all_settings as $setting) {
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
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'themepagecontroller', BMAG_URL . '/inc/js/themepagecontroller.js', array('jquery'), BMAG_VERSION);
	wp_localize_script( 'themepagecontroller', 'bmag_admin', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'bmag_nonce' => wp_create_nonce( 'bmag_submit_form_data' )
		) );
	wp_enqueue_style( 'bmag-font-awesome', BMAG_URL . '/inc/css/font-awesome/font-awesome.css');

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
	  'description' => bmag_tab_descr('general')
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
		'description' => bmag_tab_descr('home')
	);
	return apply_filters( 'bmag_get_tabs', $tabs );
}

/**
 * Returns tabnames
 */
function bmag_get_tab_names(){
	$bmag_tabs = bmag_get_tabs();
	$tabnames = array();
	foreach ($bmag_tabs as $tab) {
		array_push($tabnames,$tab['name']);
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
 * Returns default values of all settings in name => value pairs
 */
function bmag_get_defaults(){
	$settings = bmag_get_all_settings();
	$defaults = array();
	foreach ($settings as $setting) {
		$defaults[$setting['name']] = $setting['default'];
	}
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

	require_once(BMAG_DIR . '/inc/admin/framework/BMAGOutputs.php');
	$bmag_outputs = new BMAGOutputs();
 
	if(isset($option['mod']) && $option['mod']){
		$context = 'mod';
	}

	$fieldtype = $option['type'];

	switch($fieldtype){

		case 'button' : { 
			echo $bmag_outputs->button($option, $context, $opt_val, $meta);
			break;
		}
		case 'color' : {
			echo $bmag_outputs->color($option, $context, $opt_val, $meta);
			break;
		}
		case 'colors' : {
			echo $bmag_outputs->colors($option, $context, $opt_val, $meta);
			break;
		}
		case 'checkbox' : {
			echo $bmag_outputs->checkbox($option, $context, $opt_val, $meta);
			break;
		}
		case 'checkbox_open' : { 
			echo $bmag_outputs->checkbox_open($option, $context, $opt_val, $meta);
			break;
		}
		case 'text' : {
			echo $bmag_outputs->input($option, $context, $opt_val, $meta);
			break;
		}  
		case 'layout' : {
			echo $bmag_outputs->radio_images($option, $context, $opt_val, $meta);
			break;
		}
		case 'layout_open' : {
			echo $bmag_outputs->radio_images_open($option, $context, $opt_val, $meta);
			break;
		}
		case 'radio' : {
			echo $bmag_outputs->radio($option, $context, $opt_val, $meta);
			break;
		}
		case 'radio_open' : {
			echo $bmag_outputs->radio_open($option, $context, $opt_val, $meta);
			break;
		}
		case 'select' : {
			echo $bmag_outputs->select($option, $context, $opt_val, $meta);
			break;
		}
		case 'select_open' : { 
			echo $bmag_outputs->select_open($option, $context, $opt_val, $meta);
			break;
		}
		case 'select_theme' : { 
			echo $bmag_outputs->select_theme($option, $context, $opt_val, $meta);
			break;
		}
		case 'select_style' : { 
			echo $bmag_outputs->select_style($option, $context, $opt_val, $meta);
			break;
		}
		case 'textarea' : { 
			echo $bmag_outputs->textarea($option, $context, $opt_val, $meta);
			break;
		}
		case 'text_preview' : { 
			echo $bmag_outputs->text_preview($option, $context, $opt_val, $meta);
			break;
		}
		case 'upload_single' : { 
			echo $bmag_outputs->upload_single($option, $context, $opt_val, $meta);
			break;
		}
		case 'upload_multiple' : { 
			echo $bmag_outputs->upload_multiple($option, $context, $opt_val, $meta);
			break;
		}
		case 'range' : {
			echo $bmag_outputs->range();
			break;
		}
		default : {
		  echo __("Such element type does not exist!", WDWT_LANG);
		}    
	}

	if( isset( $option['description']) && $option['description'] != '' ) : ?>
		<span class="description"><?php echo esc_html($option['description']); ?></span>
	<?php endif;
}
/**
 * Validates all settings getted from settings form
 *
 * If any option is not valid replaces option with it's default
 * Then returns validated options with bmag_sanitize_options hook attached
 *
 * @param $options
 * @return $options
 *
 */
function bmag_options_validate( $options ){

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
add_filter('bmag_sanitize_options', 'bmag_options_sanitizer');



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
function bmag_do_settings_fields($page, $section) {
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
		call_user_func($field['callback'], $field['args']);
		echo '</div>';
		echo '</div>';
	}
}

/**
 * Ajax callback of options form
 *
 * Verifies nonce, then parses data and filters it based on @param $task
 */
function bmag_form_submit_callback(){
	//verifing nonce
	global $bmag_tabnames,$bmag_defaults;
	//this should be done my global !!!!!!!!TODO
	$bmag_options = get_option( BMAG_OPT );

	$data = isset( $_POST['data'] ) ? $_POST['data'] : '';
	if( ! isset( $_POST['nonce'] ) ){
		wp_die('there are no nonce');
	}
	if ( ! wp_verify_nonce( $_POST['nonce'], 'bmag_submit_form_data' )){
		wp_die('invalid nonce');
	}

	//parsing data
	$strlen = strlen('theme_' . BMAG_VAR . '_options');
	$settings = json_decode( stripcslashes( $data ) );
	$options = array();
	foreach ( $settings as $setting ) {
		switch( $setting->name ){
			case 'bmag_current_tab':{
				$current_tab = $setting->value;
				break;
			}
			case 'bmag_task':{
				$task = $setting->value;
				break;
			}
			default:{
				$settingname = substr( $setting->name, $strlen + 1, strlen( $setting->name ) - $strlen - 2 );
				$options[$settingname] = $setting->value;
				break;
			}
		}
	}
	//removeing prefixes from tabname 'bmag_' . $tabname . '_tabs'
	$current_tab = substr( $current_tab, 5, strlen( $current_tab ) - 9 );
	if( isset( $task ) ){
		if ( isset( $current_tab ) && in_array( $current_tab, $bmag_tabnames ) ){
	
			switch( $task ){
				case 'save_tab':{
					$options = bmag_filter_by_tab($options,$current_tab);
					$options = wp_parse_args( $options, $bmag_options );
					break;
				}
				case 'reset_tab': {
					$defaults = bmag_filter_by_tab($bmag_defaults,$current_tab);
					$options = wp_parse_args( $defaults, $options );
					break;
				}
				case 'save_all': {
					$options = wp_parse_args( $options, $bmag_defaults );
					break;
				}
				case 'reset_all':{
					$options = $bmag_defaults;
					break;
				}
				default: {
					echo json_encode( array( 
									'error' => 'invalid_task',
									'error_msg'=>'__("Something went wrong try reloading the page","bmag")'
									));
					wp_die();
					break;
				}
			}	
		}else{
			switch( $task ){
				case 'save_all':{
					$options = wp_parse_args( $options, $bmag_defaults );
					break;
				}
				case 'reset_all':{
					$options = $bmag_defaults;
					break;
				}
				default:{
					echo json_encode( array( 
						'error' => 'wrong_settings_tab',
						'error_msg'=>'__("Something went wrong try reloading the page","bmag")'
						));
					wp_die();
				}
			}
			
		}
	}else{
		echo json_encode( array( 
								'error' => 'invalid_task',
								'error_msg'=>'__("Something went wrong try reloading the page","bmag")'
								));
					wp_die();
	}
	

	//updating data
	update_option( BMAG_OPT, $options);
	wp_die();
}

/**
 * Returns options which belong to that tab.
 */
function bmag_filter_by_tab($options,$tab){

	$all_settings = bmag_get_all_settings();
	$tab_settings = array();
	$filtered = array();

	foreach ( $all_settings as $setting ) {
		if( $setting['tab'] == $tab ){
			array_push( $tab_settings,$setting );
		}
	}


	foreach ($options as $option => $value) {
		foreach ($tab_settings as $setting) {
			if($option == $setting['name']){
				$filtered[$option] = $value;
			}
		}
	}

	return apply_filters( 'bmag_filter_by_tab', $filtered );
}

