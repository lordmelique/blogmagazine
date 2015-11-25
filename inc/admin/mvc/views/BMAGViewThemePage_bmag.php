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
		<form action="options.php" method="post">
			<?php 
			settings_fields( 'bmag_options' );
			do_settings_sections( 'bmag_general_tab' );
			 ?>
		</form>
		<?php
		
	}
}