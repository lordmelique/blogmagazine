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
		require_once( BMAG_DIR . '/inc/admin/bmag_admin_cpanel.php' );
		?>
		<h3>Theme Page</h3>
		<form action="options.php" method="post">
			<?php
			settings_fields('bmag_options'); 
		    bmag_do_settings_sections( 'bmag_general_tab' );
			submit_button();
			 ?>
		</form>
		<?php
		
	}
}