<?php
class BMAGViewThemePage_bmag{
	/*=============Variables============*/
	private $model;

	/*============Constructor===========*/
	public function __construct($model){
		$this->model = $model;
	}

	/*==========Public Methods==========*/
	public function display(){
		?>
		<h3>Theme Page</h3>
		<?php
		
	}
}