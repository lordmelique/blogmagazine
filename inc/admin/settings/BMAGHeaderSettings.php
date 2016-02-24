<?php
class BMAGHeaderSettings{
	/*==========Variables==========*/
	private $settings_tab = 'header';
	public $options;

	/*==========Constructor==========*/
	public function __construct(){
		$this->options = array( 
			/* if type is starting with custom__ then callback must be seperate function */
	      	'header_layout' => array( 
		        'name' => 'header_layout', 
		        'title' => __( 'Header Layout', 'bmag' ), 
		        'type' => 'custom__header_layout_radio', 
		        'description' => __( 'This is how your header would be displayed', 'bmag' ), 
		        'show' => array(),
		        'hide' => array(),
		        "valid_options" => array(
		          "style_1" => __('Header Style 1','bmag'),
		          "style_2" => __('Header Style 2','bmag'),
		          "style_3" => __('Header Style 3','bmag'),
		          "style_4" => __('Header Style 4','bmag'),
		          "style_5" => __('Header Style 5','bmag'),
		        ),
		        'section' => 'header_layouting', 
		        'tab' => $this->settings_tab, 
		        'default' => 'style_1',
		        'customizer' => array()
	      	),

	      	'header_top_menu_bg_color' => array( 
		        'name' => 'header_top_menu_bg_color', 
		        'title' => __( 'Background color', 'bmag' ), 
		        'type' => 'color', 
		        'description' => "", 
		        'show' => array(),
		        'hide' => array(),
		        'section' => 'top_menu', 
		        'tab' => $this->settings_tab, 
		        'default' => '#000000',
		        'customizer' => array(),
	     	 ),

	      	"header_top_menu_height" => array(
				"name" => "header_top_menu_height",
				"title" => __('Menu height','bmag'),
				'type' => 'text',
				"sanitize_type" => "sanitize_text_field",
				"description" => __("px", 'bmag'),
				'section' => 'top_menu', 
		        'tab' => $this->settings_tab, 
				'default' => '35',
				'customizer' => array()	
			),

			'header_top_menu_color' => array( 
		        'name' => 'header_top_menu_color', 
		        'title' => __( 'Text color', 'bmag' ), 
		        'type' => 'color', 
		        'description' => "", 
		        'show' => array(),
		        'hide' => array(),
		        'section' => 'top_menu', 
		        'tab' => $this->settings_tab, 
		        'default' => '#000000',
		        'customizer' => array(),
	     	 ),

			'header_top_menu_hover_bg_color' => array( 
		        'name' => 'header_top_menu_hover_bg_color', 
		        'title' => __( 'Background hover color', 'bmag' ), 
		        'type' => 'color', 
		        'description' => "", 
		        'show' => array(),
		        'hide' => array(),
		        'section' => 'top_menu', 
		        'tab' => $this->settings_tab, 
		        'default' => '#000000',
		        'customizer' => array(),
	     	 ),

			'header_top_menu_hover_text_color' => array( 
		        'name' => 'header_top_menu_hover_text_color', 
		        'title' => __( 'Text hover color', 'bmag') , 
		        'type' => 'color', 
		        'description' => "", 
		        'show' => array(),
		        'hide' => array(),
		        'section' => 'top_menu', 
		        'tab' => $this->settings_tab, 
		        'default' => '#000000',
		        'customizer' => array(),
	     	 ),

			'header_body_bg_color' => array( 
		        'name' => 'header_body_bg_color', 
		        'title' => __( 'Background color', 'bmag' ), 
		        'type' => 'color', 
		        'description' => "", 
		        'show' => array(),
		        'hide' => array(),
		        'section' => 'general', 
		        'tab' => $this->settings_tab, 
		        'default' => '#000000',
		        'customizer' => array(),
	     	 ),

			"site_logo_width" => array(
				"name" => "site_logo_width",
				"title" => __('Site logo width','bmag'),
				'type' => 'text',
				"sanitize_type" => "sanitize_text_field",
				"description" => "px",
				'section' => 'general', 
		        'tab' => $this->settings_tab, 
				'default' => '35',
				'customizer' => array()	
			),

			'primary_menu_bg_color' => array( 
		        'name' => 'primary_menu_bg_color', 
		        'title' => __( 'Background color', 'bmag' ), 
		        'type' => 'color', 
		        'description' => "", 
		        'show' => array(),
		        'hide' => array(),
		        'section' => 'primary_menu', 
		        'tab' => $this->settings_tab, 
		        'default' => '#000000',
		        'customizer' => array(),
	     	 ),

			
			"primary_menu_font_size" => array(
				"name" => "primary_menu_font_size",
				"title" => __('Font size','bmag'),
				'type' => 'text',
				"sanitize_type" => "sanitize_text_field",
				"description" => 'px',
				'section' => 'primary_menu', 
		        'tab' => $this->settings_tab, 
				'default' => '25',
				'customizer' => array()	
			),

			'primary_menu_text_color' => array( 
		        'name' => 'primary_menu_text_color', 
		        'title' => __( 'Text color', 'bmag' ), 
		        'type' => 'color', 
		        'description' => "", 
		        'show' => array(),
		        'hide' => array(),
		        'section' => 'primary_menu', 
		        'tab' => $this->settings_tab, 
		        'default' => '#000000',
		        'customizer' => array(),
	     	 ),

			'primary_menu_bg_hover_color' => array( 
		        'name' => 'primary_menu_bg_hover_color', 
		        'title' => __( 'Background hover color', 'bmag' ), 
		        'type' => 'color', 
		        'description' => "", 
		        'show' => array(),
		        'hide' => array(),
		        'section' => 'primary_menu', 
		        'tab' => $this->settings_tab, 
		        'default' => '#000000',
		        'customizer' => array(),
	     	 ),

			'primary_menu_text_hover_color' => array( 
		        'name' => 'primary_menu_text_hover_color', 
		        'title' => __( 'Text hover color', 'bmag' ), 
		        'type' => 'color', 
		        'description' => "", 
		        'show' => array(),
		        'hide' => array(),
		        'section' => 'primary_menu', 
		        'tab' => $this->settings_tab, 
		        'default' => '#000000',
		        'customizer' => array(),
	     	 ),

			'primary_menu_submenu_bg_hover_color' => array( 
		        'name' => 'primary_menu_submenu_bg_hover_color', 
		        'title' => __( 'Submenu hover background color', 'bmag' ), 
		        'type' => 'color', 
		        'description' => "", 
		        'show' => array(),
		        'hide' => array(),
		        'section' => 'primary_menu', 
		        'tab' => $this->settings_tab, 
		        'default' => '#000000',
		        'customizer' => array(),
	     	 ),

			'primary_menu_enable_shadows' => array( 
		        'name' => 'primary_menu_enable_shadows', 
		        'title' => __( 'Enable menu item shadows', 'bmag' ), 
		        'type' => 'checkbox', 
		        'description' => __( 'If enabled each menu item would have small blurred box shadow on hover', 'bmag' ),  
		        'show' => array(),
		        'hide' => array(),
		        'section' => 'primary_menu', 
		        'tab' => $this->settings_tab, 
		        'default' => true,
		        'customizer' => array()
		      ),

        );
	}
}