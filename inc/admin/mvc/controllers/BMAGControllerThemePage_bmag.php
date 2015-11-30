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
  public function execute() {
      $this->display();
  }

  private function display() {
    require_once (BMAG_DIR . "/inc/admin/mvc/models/BMAGModelThemePage_bmag.php");
    $model = new BMAGModelThemePage_bmag();

    require_once (BMAG_DIR . "/inc/admin/mvc/views/BMAGViewThemePage_bmag.php");
    $view = new BMAGViewThemePage_bmag($model);
    $view->display();
  }
  
}
