<?php
class BMAGHeaderSettings{
	/*==========Variables==========*/
	private $settings_tab = 'header';
	public $options;

	/*==========Constructor==========*/
	public function __construct(){
		$this->options = array( 

	      	'header_layout' => array( 
	        'name' => 'header_layout', 
	        'title' => __( 'Header Layout', 'bmag' ), 
	        'type' => 'custom', 
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
	        'default' => false,
	        'customizer' => array()
	      ),
        );
	}
}