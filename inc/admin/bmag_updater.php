<?php 
require_once ('themeUpdater.php');


class Blog_Magazine_updater extends themeUpdater{

  /*first version with settings API*/
  protected $version_set_api = '0.0.50';  
  protected $old_meta_name = '_blog-magazine_meta';  
  protected $theme_mods_name = 'theme_mods_blogmagazine';

 /**
  * rules for converting old param to new
  *
  * keep order from old to new
  * 
  * 
  * start from $version_set_api
  * @param types: get_param_with_old_name, get_old_colors, checkbox_to_select, option_change, widget name change, slider
  */
  protected $rules = array();
  /**
  *  meta name should not be changed !!!
  * only content
  *
  */
  protected $rules_meta = array();
  
  protected $rules_widget = array();
  /**
  * get colors created with theme mods
  * $args=array('default'=>'')
  */

  protected function get_old_colors( $val, $param_name, $args=array()){
    /*not applicable*/
  }



}

