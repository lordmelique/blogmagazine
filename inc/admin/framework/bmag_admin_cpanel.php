<?php
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
add_action( 'admin_menu', 'bmag_add_theme_page' );

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
 * Function where should be enqueued admin script and styles
 */
function bmag_admin_scripts() {

}
?>