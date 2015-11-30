<?php 
class BMAGModelThemePage_bmag {
  
  /*============Constructor===========*/
  public function __construct() {
  }
  /*==========Public Methods==========*/
  public function get_tabs(){
  	/* Include admin cpanel */
	require_once( BMAG_DIR . '/inc/admin/bmag_admin_cpanel.php' );
  	return bmag_get_tabs();
  }
  
}

