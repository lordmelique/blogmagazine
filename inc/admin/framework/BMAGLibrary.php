<?php
/**
 * This class have common methods that will be used in theme, things such
 * updating messages, geting parameters from query string and other helpful methods
 */
class BMAGLibrary{

	/*============Constructor===========*/
	public function __construct() {

	}
	/*==========Public Methods==========*/

	/**
	* Gets gives parameter from query sting, if there are no parameter returns
	* blank string ''
	*/
	public static function get($key, $default_value = '') {
	    if (isset($_GET[$key])) {
	      $value = $_GET[$key];
	    }
	    elseif (isset($_POST[$key])) {
	      $value = $_POST[$key];
	    }
	    else {
	      $value = '';
	    }
	    if (!$value) {
	      $value = $default_value;
	    }
	    return esc_html($value);
  	}

  	/**
	* Returns message html by provided $message_id parameter
	* @param $message_id
  	*/
  	public static function message_id($message_id) {
    if ($message_id) {
      switch($message_id) {
        case 1: {
          $message = 'Item Succesfully Saved.';
          $type = 'updated';
          break;

        }
      }
      return '<div style="width:99%"><div class="' . $type . '"><p><strong>' . $message . '</strong></p></div></div>';
    }
  }


  public static function arrayToObject($d) {
    if (is_array($d)) {
    /*
    * Return array converted to object
    * Using __FUNCTION__ (Magic constant)
    * for recursive call
    */
      return (object) array_map(array('BMAGLibrary','arrayToObject'), $d);
    }
    else {
      // Return object
    return $d;
    }
  }

  public static function objectToArray($d) {
    if (is_object($d)) {
      // Gets the properties of the given object
      // with get_object_vars function
      $d = get_object_vars($d);
    }
   
    if (is_array($d)) {
    /*
    * Return array converted to object
    * Using __FUNCTION__ (Magic constant)
    * for recursive call
    */
      return array_map(array('BMAGLibrary','objectToArray'), $d);
    }
    else {
      // Return array
      return $d;
    }
  }
}
?>