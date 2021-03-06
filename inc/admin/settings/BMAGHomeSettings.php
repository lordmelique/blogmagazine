<?php
class BMAGHomeSettings{
	/*==========Variables==========*/
	private $settings_tab = 'home';
	public $options;

	/*==========Constructor==========*/
	public function __construct(){
		$this->options = array( 

	      	'home_option1' => array( 
	        'name' => 'home_option1', 
	        'title' => __( 'Home option', 'bmag' ), 
	        'type' => 'checkbox', 
	        'description' => __( 'This is home 1', 'bmag' ), 
	        'show' => array(),
	        'hide' => array(),
	        'section' => 'home_section', 
	        'tab' => $this->settings_tab, 
	        'default' => false,
	        'customizer' => array()
	      ),

	      	'home_option2' => array(
	        "name" => "home_option2",
	        "title" => __("This is home option 2", 'bmag' ),
	        'type' => 'select',
	        "description" => "Hi dude how are you",
	        "valid_options" => array(
	          "left-top" => "left-top",
	          "left-middle"  =>  "left-middle",
	          "left-bottom"  =>  "left-bottom",
	          "center-top"  =>  "center-top",
	          "center-middle"  =>  "center-middle",
	          "center-bottom"  =>  "center-bottom",
	          "right-top"  =>  "right-top",
	          "right-middle"  =>  "right-middle",
	          "right-bottom"  =>  "right-bottom"   
	        ),
	        'section' => 'home_section2',
	        'tab' => $this->settings_tab,
	        'default' => 'left-top',
	        'customizer' => array() 
	      )
        );
	}
}