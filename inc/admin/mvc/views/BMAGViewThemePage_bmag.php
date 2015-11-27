<?php
class BMAGViewThemePage_bmag{
	/*=============Variables============*/
	private $model;
	public $tabs;
	public $active_tab;

	/*============Constructor===========*/
	public function __construct($model){
		$this->model = $model;
		$this->tabs = $this->model->get_tabs();
		$this->active_tab = 'general';
	}

	/*==========Public Methods==========*/
	public function display(){
		require_once( BMAG_DIR . '/inc/admin/bmag_admin_cpanel.php' );
		$tabs = ($this->model->get_tabs());
		?>
		<style>
			.bmag_nav_tabs{
				width: 20%;
				float: left;
				background-color: red;
			}
			.nav_tab_title{
				word-wrap: break-word;
			}
			.bmag_form_container{
				width: 80%;
				float: right;
				background-color: green;
			}
			.bmag_settings_tab{
				display: none;
			}
			.bmag_active{
				display: block;
			}
		</style>
		<div class="wrap">
			<h2><?php _e('Blog Magazine Options','bmag') ?></h2>
			<div class="bmag_nav_tabs">
				<?php 
					foreach ($this->tabs as $tab) {
						$page = 'bmag_' . $tab['name'] . '_tab';
						?>
							<div id="<?php echo esc_attr( $page ); ?>" class="bmag_nav_tab">
								<div class="bmag_nav_tab_wrap">
									<h2 class="nav_tab_title"> <?php echo $tab['title'] ?> </h2>
								</div>
							</div>
						<?php
					}
				 ?>
			</div>
			<div class="bmag_form_container">
				<form id="bmag_settings_form" action="options.php" method="post">
				<?php
					settings_fields('bmag_options'); 
				    foreach ( $this->tabs as $tab ) {
				    	$page = 'bmag_' . $tab['name'] . '_tab';
				    	if( $this->active_tab == $tab['name'] ){
				    		bmag_do_settings_sections( $page, 'active' );
				    	}else{
				    		bmag_do_settings_sections( $page );
				    	}
				    	
				    }

					submit_button();
				 ?>
			</form>
			</div>
		</div>
		
		<?php
	}

}



	
			