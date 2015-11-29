<?php 
class BMAGOutputs{

	private $params;
	
	function __construct($initial_params=array()){

		$defaults= array(
			"input_size" => "36",
			"textarea_height" => "150",
			"textarea_width" => "450",
			"select_width" => "240",
			"upload_size" => "30",
			"upload_filetype" => "image",
		);
		
		$this->params = $this->merge_params($defaults,$initial_params);     
	}
 
 	public function render_field($option,$context,$opt_val,$meta){
 		if(isset($option['mod']) && $option['mod']){
			$context = 'mod';
		}

 		switch($option['type']){
			case 'button' : { 
				echo $this->button($option, $context, $opt_val, $meta);
				break;
			}
			case 'color' : {
				echo $this->color($option, $context, $opt_val, $meta);
				break;
			}
			case 'colors' : {
				echo $this->colors($option, $context, $opt_val, $meta);
				break;
			}
			case 'checkbox' : {
				echo $this->checkbox($option, $context, $opt_val, $meta);
				break;
			}
			case 'checkbox_open' : { 
				echo $this->checkbox_open($option, $context, $opt_val, $meta);
				break;
			}
			case 'text' : {
				echo $this->input($option, $context, $opt_val, $meta);
				break;
			}  
			case 'layout' : {
				echo $this->radio_images($option, $context, $opt_val, $meta);
				break;
			}
			case 'layout_open' : {
				echo $this->radio_images_open($option, $context, $opt_val, $meta);
				break;
			}
			case 'radio' : {
				echo $this->radio($option, $context, $opt_val, $meta);
				break;
			}
			case 'radio_open' : {
				echo $this->radio_open($option, $context, $opt_val, $meta);
				break;
			}
			case 'select' : {
				echo $this->select($option, $context, $opt_val, $meta);
				break;
			}
			case 'select_open' : { 
				echo $this->select_open($option, $context, $opt_val, $meta);
				break;
			}
			case 'select_theme' : { 
				echo $this->select_theme($option, $context, $opt_val, $meta);
				break;
			}
			case 'select_style' : { 
				echo $this->select_style($option, $context, $opt_val, $meta);
				break;
			}
			case 'textarea' : { 
				echo $this->textarea($option, $context, $opt_val, $meta);
				break;
			}
			case 'text_preview' : { 
				echo $this->text_preview($option, $context, $opt_val, $meta);
				break;
			}
			case 'upload_single' : { 
				echo $this->upload_single($option, $context, $opt_val, $meta);
				break;
			}
			case 'upload_multiple' : { 
				echo $this->upload_multiple($option, $context, $opt_val, $meta);
				break;
			}
			case 'range' : {
				echo $this->range();
				break;
			}
			default : {
			  echo __("Such element type does not exist!", 'bmag');
			}    
		}
		if( isset( $option['description']) && $option['description'] != '' ) : ?>
			<label class="description" for="<?php echo $option['name'] ?>"><?php echo esc_html($option['description']); ?></label>
		<?php endif;
 	}

	/**
	 * Displays a single button for toggling some other elements onclick
	 *
	 * @param $element['show'] = array('name_of _element_to_hide')
	 * @param $element['hide'] = array('name_of _element_to_show')
	 */
	public function button($element, $context = 'option', $opt_val = '', $meta=array()){
		global $bmag_options; ?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<div class="block margin">
				<div class="optioninput checkbox">
					<span id="<?php echo $element['name']; ?>"  class="button" style="text-decoration:none;"><?php echo esc_html($element['title']); ?></span>
				</div>
			</div>
			<script>
			jQuery(document).ready(function () {
				/*init*/
				var element_<?php echo $element['name']; ?> = {
					id : "<?php echo $element['name']; ?>",
					show : [
						<?php
						foreach ($element['show'] as $element_to_show) :
						echo "'". $element_to_show ."', ";
						endforeach; 
						?>        
						],
					hide : [
						<?php
						foreach ($element['hide'] as $element_to_hide) :
						echo "'". $element_to_hide ."', ";
						endforeach; 
						?>        
					]
				};
				
				bmag_elements.button_toggle(element_<?php echo $element['name']; ?>);
				/*change on click*/
				jQuery('#<?php echo $element['name']; ?>').on( "click", function() {
					bmag_elements.button_toggle(element_<?php echo $element['name']; ?>);
				});
		
			});
			</script>
		</div>
		<?php   
	}

	/**
	 * Displays single checkbox with hidden input field
	 */
	public function checkbox($element, $context = 'option', $opt_val = '', $meta=array()){
		if($context == 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];
		}
		
		if(is_bool($opt_val)){
			$opt_val = $opt_val ? 'true' : '';
		} ?>

		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<div class="block margin">
				<div class="optioninput checkbox">
					<input type="checkbox" class="checkbox" name="<?php echo $optionname; ?>" id="<?php echo $element['name'] ?>" <?php checked($opt_val || $opt_val =='on'); ?> <?php $this->custom_attrs($element); ?>>
				</div>
			</div>
		</div>

      <script>
      
      jQuery(document).ready(function(){
          if(jQuery('#<?php echo $element["name"] ?>').attr('checked') != 'checked'){
             jQuery('#<?php echo $element["name"] ?>').after('<input type=\"hidden\" name=\"' + jQuery('#<?php echo $element["name"] ?>').attr("name") + '\" value="0">');
          }
          jQuery('#<?php echo $element["name"] ?>').on('click',function(){
            if (jQuery(this).attr("checked") != 'checked') {
                       jQuery(this).after("<input type=\"hidden\" name=\"" + jQuery(this).attr("name") + "\" value=0>");
                    } else {
                       jQuery(this).next().remove();
                    }
          });
      });
      </script>
		<?php   
	}

	/**
	 * Displays a checkbox which shows or hides some other elements onclick
	 *
	 * @param $element['show'] = array('name_of _element_to_show') on being checked
	 * @param $element['hide'] = array('name_of _element_to_hide') on being checked
	 */
	
	public function checkbox_open($element, $context = 'option', $opt_val ='', $meta=array()){   
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];  
		}
		if(is_bool($opt_val)){
			$opt_val = $opt_val ? 'true' : '';
		} ?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<div class="block margin">
				<div class="optioninput checkbox">
					<input type="checkbox" class="checkbox" name="<?php echo $optionname; ?>" id="<?php echo $element['name'] ?>" <?php checked($opt_val || $opt_val =='on'); ?>  <?php $this->custom_attrs($element); ?> value="<?php echo esc_attr($opt_val); ?>">
				</div>
			</div>
		</div>
		<script>
			jQuery(document).ready(function () {
				/*init*/
				var element_<?php echo $element["name"]; ?> = {
					id : "<?php echo $element["name"]; ?>",
					show : [
						<?php
						foreach ($element['show'] as $element_to_show) :
						echo "'". $element_to_show ."', ";
						endforeach; 
						?>        
						],
					hide : [
						<?php
						foreach ($element['hide'] as $element_to_hide) :
						echo "'". $element_to_hide ."', ";
						endforeach; 
						?>        
					]
				};
				
				bmag_elements.checkbox_open(element_<?php echo $element["name"]; ?>);
				/*change on click*/
				jQuery('#<?php echo $element["name"]; ?>').on( "click", function() {
					bmag_elements.checkbox_open(element_<?php echo $element["name"]; ?>);
				});
				jQuery('body #customize-control-<?php echo BMAG_OPT; ?>-<?php echo $element["name"]; ?>').parent().parent().on( "classChanged", function() {
					if(jQuery(this).is(":visible")){
						bmag_elements.checkbox_open(element_<?php echo $element["name"]; ?>);  
					}
				});
			});
		</script>
		<?php   
	}

	/**
	 * Displays a single color control
	 */
	public function color($element, $context='option', $opt_val='', $meta=array()){
		if($context== 'meta'){
			 $optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			 global $bmag_options;
			 $optionname = BMAG_OPT.'[' .$element['name']. ']';
			 $opt_val = $bmag_options[$element['name']];
		} ?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<div class='bmag_float'>  
				<div>
					<input type="text" class='color_input' id="<?php echo $element['name']; ?>" name="<?php echo $optionname; ?>"   value="<?php echo esc_attr($opt_val); ?>" data-default-color="<?php echo $element['default']; ?>" <?php $this->custom_attrs($element); ?> style="background-color:<?php echo esc_attr($opt_val); ?>;">
				</div>
			</div>
		</div>
		<script  type="text/javascript">
		jQuery(document).ready(function() {
			 jQuery('.color_input').wpColorPicker();
		});
		</script>
		<?php
	}

	/**
	 * Displays single input text field
	 * 
	 * @param $element['default']: one of the keys from 'valid options' as default value
	 * @param $element['input_size']: input field size
	 */
	public function input($element, $context = 'option', $opt_val = '', $meta=array()){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];
		}
		$input_size = isset($element["input_size"]) ? $element["input_size"] : $this->params["input_size"]; ?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<div class="block">
				<div class="optioninput">
					<input type="text" name="<?php echo $optionname; ?>" id="<?php echo $element['name']; ?>" <?php $this->custom_attrs($element); ?> value="<?php echo esc_attr($opt_val); ?>" size="<?php echo $input_size; ?>">
						<?php 
						if(isset($element['unit_symbol'])){
							echo $element['unit_symbol']; 
						}
						?>   
				</div>
			</div>
		</div>  
		<?php   
	}

	/**
	 * Displays a group of radio buttons
	 *
	 * @param $option['valid options']: ($key => array('title'=>'value', 'description'=>'value'))
	 * @param $option['default']: one of the keys from 'valid options' as default value ttt!!!
	 */
	public function radio($element, $context = 'option', $opt_val = '', $meta=array()){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];
		} ?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
		<?php  foreach ( $element['valid_options'] as $key => $option ) { ?>
			<input type="radio" name="<?php echo $optionname; ?>" <?php checked( $key, $opt_val ); ?> <?php $this->custom_attrs($element); ?> value="<?php echo esc_attr($key); ?>" /> <?php echo esc_html($option); ?>
		<?php  } ?>
		</div>
		<?php
	}

	/**
	 * Displays a group of radio buttons which show or hide some other elements onchange
	 *
	 * @param $element['show'] = array("key" => "value") or array("key" => array("value","valeu2"))
	 * @param $element['hide'] = array("key" => "value")
	 */
	public function radio_open($element,$context = 'option', $opt_val = '', $meta=array()){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];
		} ?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">    
			<?php foreach ( $element['valid_options'] as $key => $option ) { ?>
				<input type="radio" name="<?php echo $optionname; ?>" <?php checked( $key, $opt_val ); ?> <?php $this->custom_attrs($element); ?> value="<?php echo esc_attr($key); ?>" /> <?php echo esc_html($option); ?>
			<?php } ?> 
		</div>
		<script>
			jQuery(document).ready(function () {
				/*init*/
				var element_<?php echo $element["name"]; ?> = {
					name : "<?php echo $optionname; ?>",
					show : [
						<?php
						foreach ($element['show'] as $key => $value) :
							echo "{key: '" . $key ."', val: [" ; 
							if(gettype ($value)=='array'){ /*many items. array of strings of names*/
							 foreach ($value as $item){
								echo "'".$item."',";
							 } 
							}
							else{/*single item name string */
								echo "'".$value."',";
							}
							echo "]},";
						endforeach; 
						?>        
						],
					hide : [
						<?php
						foreach ($element['hide'] as $key => $value) :
							echo "{key: '" . $key ."', val: [" ; 
							if(gettype ($value)=='array'){ /*many items. array of strings of names*/
							 foreach ($value as $item){
								echo "'".$item."',";
							 } 
							}
							else{/*single item name string */
								echo "'".$value."',";
							}
							echo "]},";
						endforeach; 
						?>        
					]
				};
				
				bmag_elements.radio_open(element_<?php echo $element["name"]; ?>);
				/*shor or hide on change*/
				jQuery('input[type=radio][name="<?php echo $optionname; ?>"]').on( "change", function() {
					bmag_elements.radio_open(element_<?php echo $element["name"]; ?>);
				});
				jQuery('body #customize-control-<?php echo BMAG_OPT; ?>-<?php echo $element["name"]; ?>').parent().parent().on( "classChanged", function() {
					if(jQuery(this).is(":visible")){
						bmag_elements.radio_open(element_<?php echo $element["name"]; ?>);  
					}
				});
			});
		</script>
		<?php 
	}

	/**
	 * Displays a group of radio buttons with images as descriptions
	 *
	 * @param $element['valid options']: array( array('index' => 0, title'=>'value', 'description'=>'value'))
	 * @param $element['default']: one of the indices from 'valid options' as default value
	 * @param $element['img_src']:
	 * @param $element['img_height']:
	 * @param $element['img_width']:
	 */
	public function radio_images($element, $context='meta', $opt_val='', $meta=array()){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];
		}  ?>
			
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
		<?php 
		$img_h = intval($element['img_height']) / sizeof($element['valid_options']);
		foreach($element['valid_options'] as $option) { ?>
			<div class="sprite_layouts">
			<div alt="<?php echo esc_attr($option['title']); ?>" style="width:<?php echo esc_attr($element['img_width']); ?>px; height:<?php echo esc_attr($img_h); ?>px; background:url(<?php echo esc_url(BMAG_IMG_INC.$element['img_src']); ?>) no-repeat 0 -<?php echo (intval($option['index'])-1) * $img_h; ?>px;"></div>
			<input type="radio" name="<?php echo $optionname; ?>" <?php checked( $option['index'], $opt_val ); ?> <?php $this->custom_attrs($element); ?> value="<?php echo intval($option['index']); ?>">
			</div>
		<?php 
		}
		?>
		</div>
		<?php  
	}
	/**
	 * Displays a group of radio buttons with images as descriptions which show or hide some other elements onchange
	 *
	 * @param $element['valid options']: array( array('index' => 0, title'=>'value', 'description'=>'value'))
	 * @param $element['default']: one of the indices from 'valid options' as default value
	 * @param $element['img_src']:
	 * @param $element['img_height']:
	 * @param $element['img_width']:
	 * @param $element['show'] = array("key" => "value") or array("key" => array("value","valeu2"))
	 * @param $element['hide'] = array("key" => "value")
	 *
	 */
	
	public function radio_images_open($element, $context='option', $opt_val ='', $meta=array()){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];
		} ?>
			
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
		<?php 
		$img_h = intval($element['img_height']) / sizeof($element['valid_options']);
		foreach($element['valid_options'] as $option) { ?>
			<div class="sprite_layouts">
			<div alt="<?php echo esc_attr($option['title']); ?>" style="width:<?php echo $element['img_width']; ?>px; height:<?php echo $img_h; ?>px; background:url(<?php echo esc_url(BMAG_IMG_INC.$element['img_src']); ?>) no-repeat 0 -<?php echo (intval($option['index'])-1) * $img_h; ?>px;"></div>
			<input type="radio" name="<?php echo $optionname; ?>" <?php checked( $option['index'], $opt_val ); ?> <?php $this->custom_attrs($element); ?> value="<?php echo intval($option['index']); ?>">
			</div>
		<?php 
		}
		?>
		</div>
		<script>
			jQuery(document).ready(function () {
				/*init*/
				var element_<?php echo $element["name"]; ?> = {
					name : "<?php echo $optionname; ?>",
					show : [
						<?php
						foreach ($element['show'] as $key => $value) :
							echo "{key: '" . $key ."', val: [" ; 
							if(gettype ($value)=='array'){ /*many items. array of strings of names*/
							 foreach ($value as $item){
								echo "'".$item."',";
							 } 
							}
							else{/*single item name string */
								echo "'".$value."',";
							}
							echo "]},";
						endforeach; 
						?>        
						],
					hide : [
						<?php
						foreach ($element['hide'] as $key => $value) :
							echo "{key: '" . $key ."', val: [" ; 
							if(gettype ($value)=='array'){ /*many items. array of strings of names*/
							 foreach ($value as $item){
								echo "'".$item."',";
							 } 
							}
							else{/*single item name string */
								echo "'".$value."',";
							}
							echo "]},";
						endforeach; 
						?>        
					]
				};
				
				bmag_elements.radio_open(element_<?php echo $element["name"]; ?>);
				/*shor or hide on change*/
				jQuery('input[type=radio][name="<?php echo $optionname; ?>"]').on( "change", function() {
					bmag_elements.radio_open(element_<?php echo $element["name"]; ?>);
				});
				jQuery('body #customize-control-<?php echo BMAG_OPT; ?>-<?php echo $element["name"]; ?>').parent().parent().on( "classChanged", function() {
					if(jQuery(this).is(":visible")){
						bmag_elements.radio_open(element_<?php echo $element["name"]; ?>);  
					}
				});
				
		
			});
		</script>
		<?php  
	}

	/**
	 * Displays single <select> element
	 *
	 * @param $select['valid options']: ($key => $value)
	 * @param $select['default']: one of the keys from 'valid options' as default value
	 */
	
	public function select($element, $context='option', $opt_val = array(), $meta=array()){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. '][]';
			if(!is_array($opt_val)){
				/*old format*/
				$opt_val = $this->get_old_posts_cats($opt_val);
			}
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. '][]';
			$opt_val = $bmag_options[$element['name']];
		}
		$opt_val = is_array($opt_val) ? $opt_val : array($opt_val);
		$multiple = isset($element["multiple"]) ? true : false;
		$width = isset($element["width"]) ? intval($element["width"]) : $this->params["select_width"];
		$disabled = isset($element["disabled"]) ? $element["disabled"] : array(); ?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<div class="block">   
				<div class="optioninput">     
					<select name="<?php echo $optionname; ?>" id="<?php echo $element['name'] ?>" <?php echo $multiple ? 'multiple="multiple"' : ''; ?> <?php $this->custom_attrs($element); ?> style="width:<?php echo $width; ?>px; resize:vertical;">
					<?php foreach($element['valid_options'] as $key => $value){ ?>
						<option value="<?php echo esc_attr($key) ?>" <?php selected(true, in_array($key, $opt_val)); ?> <?php echo in_array($key, $disabled) ? 'disabled="disabled"' : ''; ?>>
							<?php echo esc_html($value); ?>
						</option>
					<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Displays a select with options which shows or hides some other elements onchange
	 *
	 * @param $element['show'] = array("key" => "value") or array("key" => array("value","valeu2"))
	 * @param $element['hide'] = array("key" => "value")
	 */

	public function select_open($element, $context='option', $opt_val ='', $meta=array()){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. '][]';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. '][]';
			$opt_val = $bmag_options[$element['name']];
		}
		$opt_val = is_array($opt_val) ? $opt_val : array($opt_val);
		$multiple = isset($element["multiple"]) ? true : false;
		$width = isset($element["width"]) ? intval($element["width"]) : $this->params["select_width"]; ?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">      
			<select name="<?php echo $optionname; ?>" id="<?php echo $element['name'] ?>" <?php echo $multiple ? 'multiple="multiple"' : ''; ?> <?php $this->custom_attrs($element); ?> style="width:<?php echo $width; ?>px; resize:vertical;">
			<?php  foreach($element['valid_options'] as $key => $value){ ?>
				<option value="<?php echo esc_attr($key); ?>" <?php selected(true, in_array($key, $opt_val)); ?>><?php echo esc_html($value); ?></option>
			<?php } ?>
			</select>
		</div>
		<script>
			jQuery(document).ready(function () {
				/*init*/
				var element_<?php echo $element["name"]; ?> = {
					id : "<?php echo $element['name']; ?>",
					show : [
						<?php
						foreach ($element['show'] as $key => $value) :
							echo "{key: '" . $key ."', val: [" ; 
							if(gettype ($value)=='array'){ /*many items. array of strings of names*/
								foreach ($value as $item){
								 echo "'".$item."',";
							 } 
							}
							else{/*single item name string */
								echo "'".$value."',";
							}
							echo "]},";
						endforeach; 
						?>        
						],
					hide : [
						<?php
						foreach ($element['hide'] as $key => $value) :
							echo "{key: '" . $key ."', val: [" ; 
							if(gettype ($value)=='array'){ /*many items. array of strings of names*/
							 foreach ($value as $item){
								echo "'".$item."',";
							 } 
							}
							else{/*single item name string */
								echo "'".$value."',";
							}
							echo "]},";
						endforeach; 
						?>        
					]
				};
				bmag_elements.select_open(element_<?php echo $element["name"]; ?>);
				/*change on click*/
				jQuery('#<?php echo $element["name"]; ?>').on( "change", function() {
					bmag_elements.select_open(element_<?php echo $element["name"]; ?>);
				});
				jQuery('body #customize-control-<?php echo BMAG_OPT; ?>-<?php echo $element["name"]; ?>').parent().parent().on( "classChanged", function() {
					if(jQuery(this).is(":visible")){
						bmag_elements.select_open(element_<?php echo $element["name"]; ?>);  
					}
				});
		
			});
		</script>
		<?php
	}

	/**
	 * Displays a select with style options which allow to modify preview text
	 *
	 * @param $element['text_preview'] = 'name'
	 * @param $element['style_param'] = 'font-size' (css param name)
	 * @param $element['valid_options'] = array('1em' => "1 em")
	 */

	public function select_style($element, $context='option', $opt_val='', $meta=array()){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. '][]';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. '][]';
			$opt_val = $bmag_options[$element['name']];
		}
		$width = isset($element["width"]) ? $element["width"] : $this->params["select_width"]; ?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<select name="<?php echo $optionname; ?>" id="<?php echo $element['name'] ?>" <?php $this->custom_attrs($element); ?> style="width:<?php echo $width;?>px;">
				<?php
				foreach($element['valid_options'] as $key => $value){ ?>
					<option value="<?php echo esc_attr($key); ?>" <?php selected(true, in_array($key, $opt_val)); ?>><?php echo esc_html($value); ?></option>
				<?php } ?>
			</select>
		</div>
		<?php if($context == 'option') : ?>
			<script>
				jQuery(document).ready(function () {
					/*init*/
					var element_<?php echo $element["name"]; ?> = {
						id : "<?php echo $element["name"]; ?>",
						text_preview : "<?php echo $element['text_preview']; ?>",
						style_param : "<?php echo $element['style_param']; ?>",
					};
					
					bmag_elements.select_style(element_<?php echo $element["name"]; ?>);
					/*change preview text*/
					jQuery('#<?php echo $element["name"]; ?>').on( "change", function() {
						bmag_elements.select_style(element_<?php echo $element["name"]; ?>);
					});
			
				});
			</script>
		<?php
		endif;
	}

	/**
	 * Displays single textarea field
	 *
	 * @param $params["textarea_height"] and $params["textarea_width"]
	 *
	 */
	public function textarea($element, $context='option', $opt_val='', $meta=array()){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];
		}
		$textarea_w = isset($element["width"]) ? $element["width"] : $this->params["textarea_width"];
		$textarea_h = isset($element["height"]) ? $element["height"] : $this->params["textarea_height"]; ?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<div class="block">
				<div class="optioninput">
					 <textarea name="<?php echo $optionname; ?>" id="<?php echo $element['name'] ?>" <?php $this->custom_attrs($element); ?> style="width:<?php echo $textarea_w; ?>px; height:<?php echo $textarea_h; ?>px;"><?php echo esc_html(stripslashes($opt_val)); ?></textarea>
				</div>
			</div>
		</div>
		<?php
	}
	
	/**
	 * displays a preview text in typography page
	 * @param $element['modified_by'] = array('home_font_weight' => 'font-weight')
	 */
	public function text_preview($element, $context='option', $opt_val='', $meta=array()){
		global $bmag_options; ?>    
		<div class="font_preview_wrap" id="bmag_wrap_<?php echo $element['name']; ?>">
			<label class="typagrphy_label" for="" style="font-size:18px;font-size: 20px;font-family: Segoe UI;"><?php echo __('Preview', BMAG_LANG ); ?></label>
			<div class="font_preview">
				<div class="optioninput-preview" id="<?php echo $element['name']; ?>" style="margin-top: 14px; margin-bottom: 23px;" ><?php
					$theme = wp_get_theme();
					echo esc_html($theme->description);
				?></div>
			</div>
		</div>
		<?php 
	}

	/**
	 * Displays an upload with single input field for filename
	 *
	 * @param $element[''] = 
	 *
	 * not for the slider!!!
	 */
	public function upload_single($element, $context='', $opt_val=''){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];
		}

		$upload_size =  isset($element["upload_size"]) ? $element["upload_size"] : $this->params["upload_size"];
		$filetype = (isset($element["filetype"]) && $element_filetype != '') ? $element["filetype"] : $this->params["upload_filetype"];  ?>
			<script>
				jQuery(document).ready(function ($) {
						
					/* set uploader size in resizing*/
					tb_position = function() {
						var tbWindow = jQuery('#TB_window'),
							width = jQuery(window).width(),
							H = jQuery(window).height(),
							W = ( 850 < width ) ? 850 : width,
							adminbar_height = 0;
				
						if ( jQuery('#wpadminbar').length ) {
							adminbar_height = parseInt(jQuery('#wpadminbar').css('height'), 10 );
						}
				
						if ( tbWindow.size() ) {
							tbWindow.width( W - 50 ).height( H - 45 - adminbar_height );
							jQuery('#TB_iframeContent').width( W - 50 ).height( H - 75 - adminbar_height );
							tbWindow.css({'margin-left': '-' + parseInt( ( ( W - 50 ) / 2 ), 10 ) + 'px'});
							if ( typeof document.body.style.maxWidth !== 'undefined' )
								tbWindow.css({'top': 20 + adminbar_height + 'px', 'margin-top': '0'});
						}
					};
					
					/*setup the var*/
					jQuery('#uploader_<?php echo $element['name']; ?>').on('click', function () {
						
						window.parent.uploadID = jQuery(this).prev('#<?php echo $element['name']; ?>');
						/*grab the specific input*/
						/*formfield = jQuery('.upload').attr('name');*/
						tb_show('', 'media-upload.php?type=<?php echo $filetype;?>&amp;TB_iframe=true');
						return false;
					});
					window.send_to_editor = function (html) {
						imgurl = jQuery('img', html).attr('src');
						/*assign the value to the input*/
						window.parent.uploadID.val(imgurl);
						/*trigger change for the customizer control*/
						window.parent.uploadID.change();
						tb_remove();
					};
					
					/*jQuery(".slide_tab").prev().parent().prev().css("display","none");*/
				});
			</script>
			<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
				<div class="optioninput" id="upload_images">
					<input type="text" class="upload" id="<?php echo $element["name"] ?>" name="<?php echo $optionname; ?>" size="<?php echo $upload_size; ?>" <?php $this->custom_attrs($element); ?> value="<?php echo esc_url($opt_val); ?>"/>
					<input class="upload-button button" type="button" id="uploader_<?php echo $element['name']; ?>" value="<?php esc_attr_e('Upload Image', BMAG_LANG); ?>"/>
				</div>
			</div>
		<?php 
	}

	/**
	 * Displays an upload with 
	 *          input fields for filename, 
	 *          remove button, 
	 *          img href text, image title text, imange description textarea,
	 *          and upload new image button
	 *
	 * @param $element[''] = 
	 *
	 * for the slider!!!
	 */


	public function upload_multiple($element, $context='', $opt_val='', $meta=array()){
		if($context== 'meta'){
		$optionname = BMAG_META.'[' .$element['name']. ']';
		/*correct here later*/
		}
		else {
			global $bmag_options;
			$imgs_url = $bmag_options[$element['name']];
			$optionname_url = BMAG_OPT.'[' .$element['name']. ']';

			$imgs_href = $bmag_options[$element['option']['imgs_href']] ;
			$optionname_href = BMAG_OPT.'[' .$element['option']['imgs_href']. ']';
			$imgs_title = $bmag_options[$element['option']['imgs_title']] ;
			$optionname_title = BMAG_OPT.'[' .$element['option']['imgs_title']. ']';
			$imgs_desc = $bmag_options[$element['option']['imgs_description']];
			$optionname_desc = BMAG_OPT.'[' .$element['option']['imgs_description']. ']';
		}
		/*do not forget to change ids so that we can have multiple sliders on the same screen ttt!!!*/
		$upload_size =  isset($element["upload_size"]) ? $element["upload_size"] : $this->params["upload_size"];
		$filetype = (isset($element["filetype"]) && $element_filetype != '') ? $element["filetype"] : $this->params["upload_filetype"]; ?>

		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<div class="bmag_slide bmag_slide_<?php echo $element['name']; ?> last_slide" id="bmag_slide_<?php echo $element['name']; ?>_0">
				<!-- Image URL -->
				<div class="slide-from-base_url" style="margin-bottom:3%;">
					<div valign="middle"><h2><?php esc_html_e("Image URL",BMAG_LANG); ?></h2></div>
					<div>
						<input type="text" id="<?php echo $element['name']; ?>_url_0" size="50" value="" class="upload image_links_group" >
						
						<input type="button" class="<?php echo $element['name']; ?>_update-image slide_but_up" id="<?php echo $element['name']; ?>_update-button_0" value="<?php esc_attr_e("Update image", BMAG_LANG); ?>">

						<input type="button" class="<?php echo $element['name']; ?>_remove-image slide_but_rem bmag_btn_red" id="<?php echo $element['name']; ?>_remove-button_0" value="<?php esc_attr_e("Remove this slide", BMAG_LANG); ?>"  />
					</div>
				</div>
				<!-- Image -->
				<div class="slide-from-base_image">
					<div><img style="width:82%;" id="<?php echo $element['name']; ?>_img_0" src="" /></div>
				</div>
				<!-- Image HREF -->
				<div class="slide-from-base_href">
					<div valign="middle"><h2><?php esc_html_e("Image Href", BMAG_LANG); ?></h2></div>
					<div><input  type="text" id="<?php echo $element['name']; ?>_href_0"  class="image_href_group" value="" /></div>
				</div>
				<!-- Image TITLE -->
				<div class="slide-from-base_title">
					<div  valign="middle">
						<h2><?php esc_html_e("Image Title", BMAG_LANG); ?></h2>
					</div>
					<div><input  type="text" id="<?php echo $element['name']; ?>_title_0" class="image_title_group" value="" /></div>
				</div>
				<!-- Image DESCRIPTION -->
				<div class="slide-from-base_desc" style="margin-bottom:3%;">
					<div valign="middle">
						<h2><?php esc_html_e("Image Description", BMAG_LANG); ?></h2>
					</div>
					<div>
						<textarea class="image_descr_group" id="<?php echo $element['name']; ?>_descr_0"  style="width:236px; height:120px;"></textarea>
					</div>
				</div>
			</div>
			
			<div class="slider-controls">
				<div valign="middle">
					<h2>
						<?php esc_html_e("Image", BMAG_LANG); ?>
						<span class="hasTip" style="cursor: pointer;color: #3B5998;" title="<?php esc_attr_e("Using this option you can add images for the slider.",BMAG_LANG); ?>">[?]</span>
					</h2>
				</div>
				<div>
					<input type="hidden" name="<?php echo $optionname_url; ?>" id="<?php echo $element['name']; ?>_urls" data-customize-setting-link="<?php echo $optionname_url; ?>" value="<?php echo esc_attr($imgs_url); ?>" >
					<input type="hidden" name="<?php echo $optionname_href; ?>" id="<?php echo $element['name']; ?>_hrefs" data-customize-setting-link="<?php echo $optionname_href; ?>" value="<?php echo esc_attr($imgs_href); ?>" >
					<input type="hidden" name="<?php echo $optionname_title; ?>" id="<?php echo $element['name']; ?>_titles" data-customize-setting-link="<?php echo $optionname_title; ?>" value="<?php echo esc_attr($imgs_title); ?>" >
					<input type="hidden" name="<?php echo $optionname_desc; ?>" id="<?php echo $element['name']; ?>_descrs" data-customize-setting-link="<?php echo $optionname_desc; ?>" value="<?php echo esc_attr($imgs_desc); ?>" >
					<input class="upload_button_slide" type="button" id="<?php echo $element['name']; ?>_add-button" value="<?php esc_attr_e('Add new slide', BMAG_LANG); ?>" />
				</div>
			</div>
		</div>
		<script type="text/javascript">
		jQuery(document).ready(function(){ 

			var element_<?php echo $element["name"]; ?> = {
				id : "<?php echo $element['name']; ?>",
				urls : jQuery('#<?php echo $element['name']; ?>_urls').val(),
				hrefs : jQuery('#<?php echo $element['name']; ?>_hrefs').val(),
				titles : jQuery('#<?php echo $element['name']; ?>_titles').val(),
				descrs : jQuery('#<?php echo $element['name']; ?>_descrs').val(),
				active : 0,
				number_slides :  bmag_elements.slider.len(jQuery('#<?php echo $element['name']; ?>_urls').val()),
				};
			/*init show*/
			bmag_elements.slider.init(element_<?php echo $element["name"]; ?>);
			bmag_elements.slider.show(element_<?php echo $element["name"]; ?>);

			/*watch for changes in values*/
			jQuery("#bmag_wrap_<?php echo $element['name']; ?>").on("change", ".image_links_group" , function (){
				var index = bmag_elements.slider.find_index(jQuery(this), "<?php echo $element['name']; ?>_url_");
				bmag_elements.slider.edit(element_<?php echo $element["name"]; ?>, index, "url");
			});
			jQuery("#bmag_wrap_<?php echo $element['name']; ?>").on("change", ".image_href_group", function (){
				var index = bmag_elements.slider.find_index(jQuery(this), "<?php echo $element['name']; ?>_href_");
				bmag_elements.slider.edit(element_<?php echo $element["name"]; ?>, index, "href");
			});
			jQuery("#bmag_wrap_<?php echo $element['name']; ?>").on("change", ".image_title_group", function (){
				var index = bmag_elements.slider.find_index(jQuery(this), "<?php echo $element['name']; ?>_title_");
				bmag_elements.slider.edit(element_<?php echo $element["name"]; ?>, index,  "title");
			});
			jQuery("#bmag_wrap_<?php echo $element['name']; ?>").on("change", ".image_descr_group", function (){
				var index = bmag_elements.slider.find_index(jQuery(this), "<?php echo $element['name']; ?>_descr_");
				bmag_elements.slider.edit(element_<?php echo $element["name"]; ?>, index, "descr");
			});
			/*add new slide*/
			jQuery("#<?php echo $element['name']; ?>_add-button").on('click', function(){
				tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");  
				add_image=send_to_editor ;
				window.send_to_editor = function(html) { 
					imgurl = jQuery("img",html).attr("src");
					after = element_<?php echo $element["name"]; ?>.number_slides-1;
					bmag_elements.slider.insert(element_<?php echo $element["name"]; ?>, after, imgurl);
					tb_remove();  
				};
				return false;   
			});
			/*update image*/
			jQuery("#bmag_wrap_<?php echo $element['name']; ?>").on('click', ".<?php echo $element['name']; ?>_update-image", function(){
				var index = bmag_elements.slider.find_index(jQuery(this), "<?php echo $element['name']; ?>_update-button_");        
				tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");    
				window.send_to_editor = function(html) { 
					imgurl = jQuery("img",html).attr("src");
					jQuery("#<?php echo $element['name']; ?>_url_"+index).val(imgurl);
					jQuery("#<?php echo $element['name']; ?>_url_"+index).change();
					tb_remove();
				};
				return false;   
			}); 
			/*remove slide*/
			jQuery("#bmag_wrap_<?php echo $element['name']; ?>").on('click', ".<?php echo $element['name']; ?>_remove-image", function(){
				var index = bmag_elements.slider.find_index(jQuery(this), "<?php echo $element['name']; ?>_remove-button_");                
				element_<?php echo $element["name"]; ?>.active = index;
				bmag_elements.slider.remove(element_<?php echo $element["name"]; ?>);
			});
		});
		</script>     
		<?php
	}

	/**
	 * Displays a select with color theme options which allows to select active theme
	 *
	 * @param $element['color_panel'] = 'name of color panel'
	 * @param $element['default'] = array(
	 *                                  'active'=>0, 
	 *                                  'themes' => array(array('name'=>'theme_1', "title" =>'')),
	 *                                  'colors'=> array(
	 *                                    array('color_name => 'array('value'=>'#cccccc', 'default'=>'#000000')))
	 *                                  )
	 * 
	 */
	
	public function select_theme($element, $context='option', $opt_val='', $meta=array()){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];
		}
		
		$current = $opt_val['active'];
		$width = isset($element["width"]) ? $element["width"] : $this->params["select_width"]; ?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<select name="<?php echo $optionname; ?>[active]" id="<?php echo $element['name'] ?>" <?php $this->custom_attrs($element); ?> style="width:<?php echo $width; ?>px;">
				<?php for($i=0; $i<sizeof($element['default']['themes']); $i++){ ?>
					<option value="<?php echo $i ?>" <?php selected( $current, $i); ?>> <?php echo esc_html($element['default']['themes'][$i]['title']); ?></option>
				<?php } ?>
			</select>
		</div>
		<script>/*stop here*/
			jQuery(document).ready(function () {

				/*create var storing all parameters*/
				var element_<?php echo $element['name'] ?> = {
						id : "<?php echo $element["name"]; ?>",
						cpanel:"<?php echo $element['color_panel']; ?>",
						themes:[],
						colors:[]
						 };

				<?php
				/*add themes to variable*/
				for($i=0; $i<sizeof($opt_val['themes']); $i++):
				?>
					element_<?php echo $element['name']; ?>.themes.push({name: "<?php echo $opt_val['themes'][$i]['name']; ?>", title: "<?php echo esc_attr($opt_val['themes'][$i]['title']); ?>"});
					var theme_colors = {};
					<?php
					foreach ($opt_val['colors'][$i] as $color_name => $color){
					?>
						theme_colors["<?php echo $color_name; ?>"] = { name: "<?php echo $color_name; ?>", val: "<?php echo $color['value']; ?>", def: "<?php echo $color['default']; ?>"};
					<?php
					}
					/*add colors of every theme to variable  */
					?>
					element_<?php echo $element['name']; ?>.colors.push(theme_colors);
				<?php
				endfor;
				?>
				/*refresh color panel on theme select change*/
				jQuery('#<?php echo $element["name"]; ?>').on( "change", function() {
					bmag_elements.refresh_colorpanel(element_<?php echo $element['name'] ?>);
				});
 
			});
		</script>
		<?php
	}

	/**
	 * Displays a color panel with names, pickers and default buttons for every color
	 * Active theme index and its colors are taken from here, not from select_theme
	 *
	 * @param $element['default'] = array( 'select_theme' => 'color_scheme', 'active' => 0, 
	 * 'colors' => array('color_name'=>array('value'=>'#cccccc', 'value'=>'#000000')))
	 */

	public function colors($element, $context='option', $opt_val='', $meta=array()){

		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];
		}
		
		$select_theme = $opt_val['select_theme']; ?>
	
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<input type="text" class="hidden_field" id="theme_<?php echo $element['name']; ?>" hidden='hidden' name="<?php echo $optionname.'[select_theme]'; ?>"   value="<?php echo esc_attr($opt_val['select_theme']); ?>">
			<input type="text" class="hidden_field" id="active_<?php echo $element['name']; ?>" hidden='hidden' name="<?php echo $optionname.'[active]'; ?>"   value="<?php echo esc_attr($opt_val['active']); ?>">
			<?php foreach($opt_val['colors'] as $color_name => $color): ?>
				<div class='bmag_float'>  
					<span class="bmag_color_title"><?php echo esc_html($element['color_names'][$color_name]); ?></span>
					<div>
						<input type="text" class="hidden_field" id="default_<?php echo $element['name']; ?>_<?php echo $color_name; ?>" hidden='hidden' name="<?php echo $optionname.'[colors]['.$color_name.']'.'[default]'; ?>"   value="<?php echo $color['default']; ?>">
						<input type="text" class='color_input' id="value_<?php echo $element['name']; ?>_<?php echo $color_name; ?>" name="<?php echo $optionname.'[colors]['.$color_name.']'.'[value]'; ?>"   value="<?php echo $color['value']; ?>" data-default-color="<?php echo $color['default']; ?>" style="background-color:<?php echo $color['value']; ?>;">
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<script  type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.color_input').wpColorPicker();
		});
		</script>
		<?php
	}


	/**
	 * Displays a diagram with 
	 *                    input fields for title and percent
	 * colors and other options are given separately, type (horizonral, circular etc. ...)                    
	 */
	public function diagram($element, $context='', $opt_val='', $meta=array()){
		if($context== 'meta'){
		$optionname = BMAG_META.'[' .$element['name']. ']';
		$diagram_title = isset($meta[$element['option']['diagram_title']]) ? $meta[$element['option']['diagram_title']] : '' ;
		$optionname_title = BMAG_META.'[' .$element['option']['diagram_title']. ']';
		$diagram_percent = isset($meta[$element['option']['diagram_percent']]) ? $meta[$element['option']['diagram_percent']] : '';
		$optionname_percent = BMAG_META.'[' .$element['option']['diagram_percent']. ']';
		}
		else {
			global $bmag_options;

			$diagram_title = $bmag_options[$element['option']['diagram_title']] ;
			$optionname_title = BMAG_OPT.'[' .$element['option']['diagram_title']. ']';
			$diagram_percent = $bmag_options[$element['option']['diagram_percent']];
			$optionname_percent = BMAG_OPT.'[' .$element['option']['diagram_percent']. ']';
		} ?>

		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			
			<div class="bmag_diagram bmag_diagram_<?php echo $element['name']; ?> last_percent" id="bmag_diagram_<?php echo $element['name']; ?>_0">
				<!-- Percent TITLE -->
				<div class="diagram-from-base_title">
					<div  valign="middle">
						<h2><?php esc_html_e("Title", BMAG_LANG); ?></h2>
					</div>
					<div><input  type="text" id="<?php echo $element['name']; ?>_title_0" class="diagram_title_group" value="" /></div>
				</div>
				<!-- percent DESCRIPTION -->
				<div class="diagram-from-base_desc" style="margin-bottom:3%;">
					<div valign="middle">
						<h2><?php esc_html_e("Percent", BMAG_LANG); ?></h2>
					</div>
					<div>
						<input type="text" class="diagram_percent_group" id="<?php echo $element['name']; ?>_percent_0"  value="" />% 
						<input type="button" class="<?php echo $element['name']; ?>_remove-percent bmag_btn_red" id="<?php echo $element['name']; ?>_remove-button_0" value="<?php esc_attr_e("Remove this percent", BMAG_LANG); ?>"  />
					</div>
				</div>
			</div>
			
			<div class="diagram-controls">
				<div>
					<input type="hidden" name="<?php echo $optionname_title; ?>" id="<?php echo $element['name']; ?>_titles" data-customize-setting-link="<?php echo $optionname_title; ?>" value="<?php echo esc_attr($diagram_title); ?>" >
					<input type="hidden" name="<?php echo $optionname_percent; ?>" id="<?php echo $element['name']; ?>_percents" data-customize-setting-link="<?php echo $optionname_percent; ?>" value="<?php echo esc_attr($diagram_percent); ?>" >
					<input class="add_percent bmag_btn_blue" type="button" id="<?php echo $element['name']; ?>_add-button" value="<?php esc_attr_e('Add new percent value', BMAG_LANG); ?>" />
				</div>
			</div>
		</div>
		<script type="text/javascript">
		jQuery(document).ready(function(){ 

			var element_<?php echo $element["name"]; ?> = {
				id : "<?php echo $element['name']; ?>",
				titles : jQuery('#<?php echo $element['name']; ?>_titles').val(),
				percents : jQuery('#<?php echo $element['name']; ?>_percents').val(),
				active : 0,
				number_percents :  bmag_elements.diagram.len(jQuery('#<?php echo $element['name']; ?>_titles').val()),
				};
			/*init show*/
			bmag_elements.diagram.init(element_<?php echo $element["name"]; ?>);
			bmag_elements.diagram.show(element_<?php echo $element["name"]; ?>);
			/*watch for changes in values*/
			jQuery("#bmag_wrap_<?php echo $element['name']; ?>").on("change", ".diagram_title_group", function (){
				var index = bmag_elements.diagram.find_index(jQuery(this), "<?php echo $element['name']; ?>_title_");
				bmag_elements.diagram.edit(element_<?php echo $element["name"]; ?>, index,  "title");
			});
			jQuery("#bmag_wrap_<?php echo $element['name']; ?>").on("change", ".diagram_percent_group", function (){
				var index = bmag_elements.diagram.find_index(jQuery(this), "<?php echo $element['name']; ?>_percent_");
				bmag_elements.diagram.edit(element_<?php echo $element["name"]; ?>, index, "percent");
			});
			/*add new percent*/
			jQuery("#<?php echo $element['name']; ?>_add-button").on('click', function(){
				after = element_<?php echo $element["name"]; ?>.number_percents-1;
				bmag_elements.diagram.insert(element_<?php echo $element["name"]; ?>, after, '');
			});
			/*remove percent*/
			jQuery("#bmag_wrap_<?php echo $element['name']; ?>").on('click', ".<?php echo $element['name']; ?>_remove-percent", function(){
				var index = bmag_elements.diagram.find_index(jQuery(this), "<?php echo $element['name']; ?>_remove-button_");                
				element_<?php echo $element["name"]; ?>.active = index;
				bmag_elements.diagram.remove(element_<?php echo $element["name"]; ?>);
			});
		});
		</script>     
		<?php
	}  
	
	/**
	 * Displays a range field 
	 * RRR does not work!!!
	 */

	public function range($element, $context = 'option', $opt_val = '', $meta=array()){
		if($context== 'meta'){
			$optionname = BMAG_META.'[' .$element['name']. ']';
		}
		else{
			global $bmag_options;
			$optionname = BMAG_OPT.'[' .$element['name']. ']';
			$opt_val = $bmag_options[$element['name']];
		}
		?>
		<div class="bmag_param" id="bmag_wrap_<?php echo $element['name']; ?>">
			<div class="block margin">
				<div class="optioninput">
					<input type="range" name="<?php echo $optionname; ?>" id="<?php echo $element['name']; ?>" <?php $this->custom_attrs($element); ?> value="<?php echo esc_attr($opt_val); ?>" ?>">
				</div>
			</div>
		</div>
		<?php   
	}

	private function merge_params($param_begin_low_prioritet,$param_last_high_priorete){
		$new_param=array();
		foreach($param_begin_low_prioritet as $key=>$value){
			if(isset($param_last_high_priorete[$key])){
				$new_param[$key]=$param_last_high_priorete[$key];
			}
			else{
				$new_param[$key]=$value;
			}
		}
		return $new_param;
	}

	private function custom_attrs($element = array()){
		$attrs_array = isset($element['custom_attrs']) ? $element['custom_attrs'] : array();
		foreach ($attrs_array as $attr => $value) {
			echo esc_html($attr).'="'.esc_attr($value).'" ';
		}
	}

	/**
	 * get posts and categories createdwith checkboxes
	 */
	protected function get_old_posts_cats($val){
		$value = $val;
		$val = json_decode( $val , true );
		$result = array();

		if( $val == NULL ){ 
			 if(is_string($value)){
				$result = explode(",", $value);
			 }
		} else {
			$result = $val;
		}
		return $result; 
	}
}
?>