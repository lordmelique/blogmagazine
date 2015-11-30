<?php
class BMAGViewThemePage_bmag{
	/*=============Variables============*/
	private $model;
	public $active_tab;
	public $links;
	/*============Constructor===========*/
	public function __construct($model){
		$this->model = $model;
		$this->tabs = $this->model->get_tabs();

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
		?>
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
				<button id="bmag_reset_tab_infobar" class="button button-secondary form_btn"><?php _e('Reset Tab','bmag'); ?></button>
				<button id="bmag_save_tab_infobar" class="button button-secondary"><?php _e('Save Tab','bmag'); ?></button>
				<button id="bmag_save_infobar" class="button button-primary"><?php _e('Save All','bmag'); ?></button>
				<div class="clear"></div>
			</div>
			<div class="bmag_body">
				<div class="bmag_nav_tabs">
					<?php 
						foreach ($this->tabs as $tab) {
							$page = 'bmag_' . $tab['name'] . '_tab';
							$active_class = ( $this->model->active_tab == $tab['name'] ) ? 'bmag_nav_tab_current' : '';
							?>
								<a style="text-decoration:none" href="<?php echo admin_url( "themes.php?page=blog-magazine&tab=" ) . $tab['name']; ?>">
									<div id="<?php echo esc_attr( $page ); ?>" class="bmag_nav_tab <?php echo $active_class; ?>">
										<div class="bmag_nav_tab_wrap">
											<span class="bmag_tab_icon <?php echo isset($tab['icon']) ? esc_attr( $tab['icon'] ) : ''; ?>"></span>
											<h3 class="bmag_nav_tab_title"> <?php echo $tab['title'] ?> </h3>
										</div>
									</div>
									<div class="clear"></div>
								</a>
							<?php
						}
					 ?>
				</div>
				<div class="bmag_form_container">
					<form id="bmag_settings_form" action="options.php" method="post">
					<input type="hidden" id="bmag_task" name="<?php echo BMAG_OPT. '[task]' ?>" value="submit">
					<?php
						settings_fields( "bmag_options" );
				    	$page = 'bmag_' .  $this->model->active_tab . '_tab';
				    	bmag_do_settings_sections( $page, 'active' );
					 ?>
					</form>
				<script>var bmag_current_tab = "<?php echo $this->model->active_tab ?>";</script>
				</div>
				<div class="clear"></div>
				<div class="bmag_save_bar">
					<button id="bmag_reset_savebar" class="button button-secondary"><?php _e('Reset Defaults','bmag'); ?></button>
					<button id="bmag_save_savebar" class="button button-primary"><?php _e('Save Changes','bmag'); ?></button>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<?php
	}
}



	
			