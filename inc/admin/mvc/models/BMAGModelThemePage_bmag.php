<?php 
class BMAGModelThemePage_bmag {
  
  public $active_tab;
  /*============Constructor===========*/
  public function __construct($tab) {
    $this->active_tab = $tab;
  }
  /*==========Public Methods==========*/
  public function get_tabs(){
  	/* Include admin cpanel */
	require_once( BMAG_DIR . '/inc/admin/bmag_admin_cpanel.php' );
  	return bmag_get_tabs();
  }
  
}

