<?php
class BMAGControllerThemePage_bmag {

  /*============Constructor===========*/
  public function __construct() {

  }
  
  /*==========Public Methods==========*/

  /**
   * Runs method defined in query task argument if method doesn't exist
   * runs default display() method, it also checks if there is message in query,
   * then displays it
   */
  //TODO fix nonce problem
  public function execute() {
   
    $task = BMAGLibrary::get('task');
    $message = BMAGLibrary::get('message');
    echo BMAGLibrary::message_id($message);
    if (method_exists($this, $task)) {
      check_admin_referer('nonce_bmag', 'nonce_bmag');
      $this->$task($id);
    }
    else {
      $this->display();
    }
  }

  
  private function display() {
    require_once (BMAG_DIR . "/inc/admin/mvc/models/BMAGModelThemePage_bmag.php");
    $model = new BMAGModelThemePage_bmag();

    require_once (BMAG_DIR . "/inc/admin/mvc/views/BMAGViewThemePage_bmag.php");
    $view = new BMAGViewThemePage_bmag($model);
    $view->display();
  }

}
