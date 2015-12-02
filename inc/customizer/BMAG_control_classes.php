<?php



class BMAG_control extends WP_Customize_Control {
  public $type = '';
  public $context = 'option';
  public $opt_val ='';
  public $element = array();
  public $params= array(
      "input_size"=>"36",
      "textarea_height"=>"200",
      "textarea_width"=>"250",
      "select_width"=>"200",
      "upload_size" => "36",
      "upload_filetype" => "image",
    );
  public function __construct( $manager, $id, $args = array() ) {
    
    parent::__construct( $manager, $id, $args );
    $this->section = $args['element']['section'];
    $this->label = isset($args['element']['title']) ? $args['element']['title'] : "";
    $this->description = isset($args['element']['description']) ? $args['element']['description'] : '';
    $this->type = $args['element']['type'];
    $this->element['custom_attrs'] = array();
    
  }
  protected function refresh_link( $setting_key = 'default'){
    if ( isset( $this->settings[ $setting_key ] ) ){
      /*if($this->type == 'select' || $this->type == 'select_open'){
        
        $this->element['custom_attrs']['data-customize-setting-link'] = esc_attr( $this->settings[ $setting_key ]->id )."[]";  
      }
      else{*/
        $this->element['custom_attrs']['data-customize-setting-link'] = esc_attr( $this->settings[ $setting_key ]->id );  
      /*}*/
      
    
    }
  }

}

class BMAG_control_Color extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
    $bmag_outputs->color($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}



class BMAG_control_Checkbox extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->checkbox($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}


class BMAG_control_Checkbox_Open extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->checkbox_open($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}

class BMAG_control_Radio extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->radio($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}

class BMAG_control_Radio_Open extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->radio_open($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}

class BMAG_control_Layout extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->radio_images($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}
class BMAG_control_Layout_Open extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->radio_images_open($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}

class BMAG_control_Select extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->select($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}

class BMAG_control_Select_Open extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->select_open($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}
class BMAG_control_Select_Style extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->select_style($this->element, 'customizer', $this->opt_val);
    ?>
    </label>

    <?php
  }
}

class BMAG_control_Select_Theme extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->select_theme($this->element, 'customizer', $this->opt_val);
    ?>
    </label>

    <?php
  }
}

class BMAG_control_Textarea extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    $this->element['width'] = $this->params['textarea_width'];
    $this->element['height'] = $this->params['textarea_height'];
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
    $bmag_outputs->textarea($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}

class BMAG_control_Text extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
    $bmag_outputs->input($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}


class BMAG_control_Upload_Single extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    $this->refresh_link();
    
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->upload_single($this->element, 'option', $this->opt_val);
    ?>
    </label>

    <?php
  }
}

class BMAG_control_Upload_Multiple extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    /* hardcode data-customize-setting-link in element view*/
    
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->upload_multiple($this->element, 'customizer', $this->opt_val);
    ?>
    </label>

    <?php
  }
}
class BMAG_control_Text_Slider extends  BMAG_control {
  public function render_content(){
    
    /*show nothing!*/
  }
}
class BMAG_control_Textarea_Slider extends  BMAG_control {
  public function render_content(){
    /*show nothing!*/
  }
}

class BMAG_control_Diagram extends  BMAG_control {
  public function render_content(){
    global $bmag_outputs;
    /* hardcode data-customize-setting-link in element view*/
    
    ?>
    <label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    <?php
      $bmag_outputs->diagram($this->element, 'customizer', $this->opt_val);
    ?>
    </label>

    <?php
  }
}
class BMAG_control_Text_Diagram extends  BMAG_control {
  public function render_content(){
    
    /*show nothing!*/
  }
}





