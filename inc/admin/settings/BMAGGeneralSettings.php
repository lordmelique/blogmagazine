<?php
class BMAGGeneralSettings{
	/*==========Variables==========*/
	private $settings_tab = 'general';
	public $options;

	/*==========Constructor==========*/
	public function __construct(){
		$this->options = array( 

	      	'demo_option1' => array( 
	        'name' => 'demo_option1', 
	        'title' => __( 'Custom CSS', 'bmag' ), 
	        'type' => 'checkbox_open', 
	        'description' => __( 'This is demo option 1', 'bmag' ), 
	        'show' => array('demo_option2'),
	        'hide' => array(),
	        'section' => 'demo_section', 
	        'tab' => $this->settings_tab, 
	        'default' => false,
	        'customizer' => array(),
	      ),

	      	'demo_option2' => array(
	        "name" => "demo_option2",
	        "title" => __("This is demo option 2", 'bmag' ),
	        'type' => 'select',
	        'multiple' => 'true',
	        "description" => "This is new amazing multiple select interface",
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
	        'section' => 'demo_section',
	        'tab' => $this->settings_tab,
	        'default' => 'right-top',
	        'customizer' => array() 
	      ),
	      	'demo_option3' => array( 
	        'name' => 'demo_option3', 
	        'title' => __( 'Color', 'bmag' ), 
	        'type' => 'color', 
	        'description' => __( 'This is demo option 3', 'bmag' ), 
	        'show' => array(),
	        'hide' => array(),
	        'section' => 'demo_section', 
	        'tab' => $this->settings_tab, 
	        'default' => '#000000',
	        'customizer' => array(),
	      ),
	      	'demo_option4' => array( 
	        'name' => 'demo_option4', 
	        'title' => __( 'Input type range', 'bmag' ), 
	        'type' => 'range', 
	        'description' => __( 'This is demo option 4', 'bmag' ), 
	        'show' => array(),
	        'hide' => array(),
	        'section' => 'demo_section2', 
	        'tab' => $this->settings_tab, 
	        'default' => false,
	        'customizer' => array(),
	      ),
        );
		
	}
}