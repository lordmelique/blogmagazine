<?php
class BMAGViewThemePage_bmag{
	/*=============Variables============*/
	private $model;
	public $tabs;
	public $active_tab;
	public $links;
	/*============Constructor===========*/
	public function __construct($model){
		$this->model = $model;
		$this->tabs = $this->model->get_tabs();
		$this->active_tab = 'general';

		$this->links = array(
		'documentation' => array(
								'link'  => '#',
								'title' => __('Online Documentation','bmag')
								),
		'support'       => array(
								'link'  => '#',
								'title' => __('Support Forum','bmag')
								)
		);
	}

	/*==========Public Methods==========*/
	public function display(){
		require_once( BMAG_DIR . '/inc/admin/bmag_admin_cpanel.php' );
		$tabs = ($this->model->get_tabs());
		?>
		<style>
			.clear{
				clear:both;
			}

			.bmag_header{
				height: 70px;
			    background: #f1f1f1;
			    border: 1px solid #ccc;
			    -webkit-border-radius: 6px 6px 0 0;
			    -moz-border-radius: 6px 6px 0 0;
			    border-radius: 6px 6px 0 0;
			    background-image: -ms-linear-gradient(top,#f9f9f9,#ececec);
			    background-image: -moz-linear-gradient(top,#f9f9f9,#ececec);
			    background-image: -o-linear-gradient(top,#f9f9f9,#ececec);
			    background-image: -webkit-gradient(linear,left top,left bottom,from(#f9f9f9),to(#ececec));
			    background-image: -webkit-linear-gradient(top,#f9f9f9,#ececec);
			    background-image: linear-gradient(top,#f9f9f9,#ececec);
			    -moz-box-shadow: inset 0 1px 0 #fff;
			    -webkit-box-shadow: inset 0 1px 0 #fff;
			    box-shadow: inset 0 1px 0 #fff;
			}
			.bmag_logo{
				float: left;
    			margin: 10px 20px;
			}
			.bmag_logo>span{
				color: #888888;
			}
			.bmag_logo>h2{
				display: inline-block;
			    font-style: normal;
			    line-height: inherit;
			    padding: 0 5px 0 0;
			    font-size: 23px;
			    font-weight: normal;
			    margin-bottom: 0;
			    margin-top: 15px;
			}
			.bmag_docs{
				float: left;
			    margin: 28px 27px;
			    font-size: 14px;
			}
			.bmag_sep{
				padding: 0 10px;
			}
			.bmag_info_bar{
				background: #f3f3f3;
			    border: solid #d8d8d8;
			    border-bottom: 1px solid #D8D8D8;
			    border-width: 0px 1px 1px 1px;
			    padding: 6px 20px 0px 6px;
			    height: 31px;

			    text-align: right;
			    -moz-box-shadow: inset 0 1px 0 #fcfcfc;
			    -webkit-box-shadow: inset 0 1px 0 #fcfcfc;
			    box-shadow: inset 0 1px 0 #fcfcfc;
			}
			#bmag_save_infobar,
			#bmag_save_savebar{
				font-family: Arial,Verdana,sans-serif;
			    padding: 0 7px;
			    height: 23px;
			    line-height: 23px;
			    border: 1px solid #0a6d9b !important;
			    float: right;
			}
			#bmag_save_tab_infobar{
				font-family: Arial,Verdana,sans-serif;
			    padding: 0 7px;
			    height: 23px;
			    line-height: 23px;
				color: #24B300;
				border: 1px solid #24B300 !important;
				float: left;
			}
			#bmag_reset_savebar,
			#bmag_reset_tab_infobar{
				font-family: Arial,Verdana,sans-serif;
			    padding: 0 7px;
			    height: 23px;
			    line-height: 23px;
				color: #ff4444;
				border: 1px solid #ff4444 !important;
				float: left;
			}
			#bmag_reset_tab_infobar,
			#bmag_save_infobar,
			#bmag_save_tab_infobar{
				margin-left: 5px;
				float: right;
			}
			.bmag_body{
				background-color: #f1f1f1;
			    border-left: 1px solid #d8d8d8;
			    border-right: 1px solid #d8d8d8;
			    border-bottom: 1px solid #d8d8d8;
			}
			.bmag_nav_tabs{
				float: left;
			    position: relative;
			    z-index: 9999;
			    width: 20%;
			}
			.bmag_nav_tab{
				margin-bottom: 0;
			    -moz-box-shadow: inset 0 1px 0 #f9f9f9;
			    -webkit-box-shadow: inset 0 1px 0 #f9f9f9;
			    box-shadow: inset 0 1px 0 #f9f9f9;
			    margin-right: 1px;
			    padding: 10px;
			    border-bottom: 1px solid #d8d8d8;
			}
			.bmag_nav_tab_title{
				margin: 0;
				word-wrap: break-word;
				display: inline-block;
			}
			.bmag_nav_tab_current{
				margin-right: 0;
				background-color: #FCFCFC;
			}
			.bmag_nav_tab span,
			.bmag_nav_tab h3{
				color: #797979;
			}
			.bmag_nav_tab_current span,
			.bmag_nav_tab_current h3{
				color: #000000;
			}
			.bmag_tab_icon{
				font-size: 1.3em;
			}
			.bmag_nav_tab:hover{
				cursor: pointer;
				background-color: #ededed;
			}
			.bmag_nav_tab_current:hover{
				cursor: pointer;
				background-color: #FCFCFC;
			}



			.bmag_form_container{
				float: left;
			    min-height: 500px;
			    width: 78%;
			    margin-left: -1px;
			    padding: 0 1%;
			    font-family: "Lucida Grande", Sans-serif;
			    background-color: #FCFCFC;
			    border-left: 1px solid #d8d8d8;
			    -moz-box-shadow: inset 0 1px 0 #fff;
			    -webkit-box-shadow: inset 0 1px 0 #fff;
			    box-shadow: inset 0 1px 0 #fff;

			    -webkit-user-select: none; /* Chrome/Safari */        
				-moz-user-select: none; /* Firefox */
				-ms-user-select: none; /* IE10+ */

				/* Rules below not implemented in browsers yet */
				-o-user-select: none;
				user-select: none;
			}

			.bmag_settings_tab{
				display: none;
			}
			.bmag_active{
				display: block;
			}
			.bmag_settings_section{
				margin-bottom: 10px;
   				overflow: hidden;
   				margin: 20px 0 0;
			    float: none;
			    width: auto;
			}
			.bmag_settings_field{
				margin-bottom: 10px;
			}
			.bmag_settings_fields{
				display: none;
			}
			.bmag_settings_tab .bmag_settings_section:nth-child(1) .bmag_settings_fields{
				display: block;
			}
			.bmag_settings_tab .bmag_settings_section:nth-child(1) .bmag_section_caret{
				transform: rotate(90deg);
			}
			.bmag_settings_field label{
			    padding: 0 10px 0 0;
			    font-size: 11px;
			    color: #999999;
			}
			.bmag_settings_section .bmag_section_title{
				padding: 15px 10px;
			    line-height: 1.2em;
			    background-color: #f1f1f1;
			    border: 1px solid #D0D0D0;
			    color: #797979;
			    overflow: hidden;
			}
			.bmag_section_caret{
				float: right;
			    margin-right: 10px;
			    line-height: 1.2em !important;
			}
			.bmag_section_title:hover{
				cursor: pointer;
			}
			.bmag_field_title{
				margin: 10px 0 10px 0;
			    padding: 7px 0px;
			    border-bottom: 1px solid #e7e7e7;
			    font-size: 14px;
			    color: black;
			}
			
			.bmag_save_bar{
				background: #f3f3f3;
			    border: solid #ccc;
			    border-width: 1px 0px 0px 0px;
			    padding: 10px 20px 0px 20px;
			    height: 35px;
			    text-align: right;
			    -webkit-border-radius: 0 0 3px 3px;
			    -moz-border-radius: 0 0 3px 3px;
			    border-radius: 0 0 3px 3px;
			    -moz-box-shadow: inset 0 1px 0 #fff;
			    -webkit-box-shadow: inset 0 1px 0 #fff;
			    box-shadow: inset 0 1px 0 #fff;
			}


			@media screen and (min-width: 0px) and (max-width: 610px){
				.bmag_header{
					height: auto;
				}
				.bmag_logo{
					float: none;
	    			margin: 2px 4px;
				}

				.bmag_docs{
					float: none;
				    margin: 5px 5px;
				    font-size: 14px;
				}
				.bmag_info_bar{
					height: auto;
				}
				.bmag_nav_tab_title{
					display: none;
				}
				.bmag_nav_tab_wrap{
					text-align: center;
				}
			}

		</style>
		<div class="wrap" id="bmag_theme_options">
			<div class="bmag_header">
				<div class="bmag_logo">
					<h2> <?php _e('Blog Magazine','bmag') ?> </h2>
					<span><?php echo BMAG_VERSION ?></span>
				</div>
				<div class="bmag_docs">
					<a target="_blank" href="<?php echo $this->links['documentation']['link']; ?>" class="bmag_header_link"><?php echo $this->links["documentation"]["title"]; ?></a>
					<span class="bmag_sep">|</span>
					<a target="_blank" href="<?php echo $this->links['support']['link']; ?>" class="bmag_header_link"><?php echo $this->links["support"]["title"]; ?></a>
				</div>
				<div class="bmag_icon_settings"></div>
				<div class="clear"></div>
			</div>
			<div class="bmag_info_bar">
				<span>
					<div class="bmag_expand_options"></div>
				</span>
				<button id="bmag_reset_tab_infobar" class="button button-secondary"><?php _e('Reset Tab','bmag'); ?></button>
				<button id="bmag_save_tab_infobar" class="button button-secondary"><?php _e('Save Tab','bmag'); ?></button>
				<button id="bmag_save_infobar" class="button button-primary"><?php _e('Save All','bmag'); ?></button>
				<div class="clear"></div>
			</div>
			<div class="bmag_body">
				<div class="bmag_nav_tabs">
					<?php 
						foreach ($this->tabs as $tab) {
							$page = 'bmag_' . $tab['name'] . '_tab';
							$active_class = ( $this->active_tab == $tab['name'] ) ? 'bmag_nav_tab_current' : '';


							?>
								<div id="<?php echo esc_attr( $page ); ?>" class="bmag_nav_tab <?php echo $active_class; ?>" onclick="bmag_admin_controller.switchTab('<?php echo esc_attr( $page ); ?>')">
									<div class="bmag_nav_tab_wrap">
										<span class="bmag_tab_icon <?php echo isset($tab['icon']) ? esc_attr( $tab['icon'] ) : ''; ?>"></span>
										<h3 class="bmag_nav_tab_title"> <?php echo $tab['title'] ?> </h3>
									</div>
								</div>
							<?php
						}
					 ?>
				</div>
				<div class="bmag_form_container">
					<form id="bmag_settings_form" action="options.php" method="post">
					<input type="hidden" id="bmag_current_tab" name="bmag_current_tab" value="bmag_<?php echo $this->active_tab; ?>_tab">
					<input type="hidden" id="bmag_task" name="bmag_task" value="">
					<?php
						
					    foreach ( $this->tabs as $tab ) {
					    	$page = 'bmag_' . $tab['name'] . '_tab';
					    	if( $this->active_tab == $tab['name'] ){
					    		bmag_do_settings_sections( $page, 'active' );
					    	}else{
					    		bmag_do_settings_sections( $page );
					    	}
					    	
					    }
					 ?>
					</form>
				</div>
				<div class="clear"></div>
				<div class="bmag_save_bar">
					<button id="bmag_reset_savebar" class="button button-secondary"><?php _e('Reset Options','bmag'); ?></button>
					<button id="bmag_save_savebar" class="button button-primary"><?php _e('Save All Changes','bmag'); ?></button>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		
		<?php
	}

}



	
			