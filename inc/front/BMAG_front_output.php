<?php
require_once('theme_front_output.php');
class BMAG_front_output extends theme_front_output{
	public function __construct(){

	}

	public function display_custom_menu($args){
		$defaults = array(
			'parent_tag' => 'ul',
			'parent_id' => '',
			'parent_class' =>'',
			'child_tag' => 'li.a',
			'child_class'=> '',
			'items' => array(),
			'url_pos' => 0
			);
		$args = wp_parse_args( $args, $defaults );
		$parent_class = ($args['parent_class'] != '') ? ' class="' . esc_attr( $args['parent_class'] ).'"' : '';
		$parent_id = ($args['parent_id'] != '') ? ' id=' . $args['parent_id'] : '';
		echo "<". $args['parent_tag'] . $parent_id . $parent_class .'>' ;
		foreach ( $args['items'] as $item ) {
			$child_tags = explode('.',$args['child_tag']);

			$child_classes = explode('.', $args['child_class']);
			
			$counter = 0;

			foreach ($child_tags as $tag) {
				$current_child_class = isset($child_classes[$counter]) ? $child_classes[$counter] : '';
				$class = ($current_child_class != '') ? ' class="' . $current_child_class : ' class="';
				
				$font_awesome = '';
				$url_pos = isset($item['url_pos']) ? $item['url_pos'] : $defaults['url_pos'];
				if( $counter == $url_pos ){
					if($tag == 'a'){
						$tag.= ' href="' . $item['url'] . '" ';
					}else{
						$tag.= ' data-url="' . $item['url'] . '" ';
					}
					$font_awesome = isset($item['font_awesome']) ? $item['font_awesome'] : '';
				}
				

								
				$class =  $class. ' ' . $font_awesome .'"';



				if($class == ' class="' || $class=='class=" "'){
					$class = "";
				}

				echo '<' . $tag . $class. '>';
				$counter++;
			}
			echo $item['name'];
			foreach (array_reverse($child_tags) as $tag) {
				echo '</' . $tag. '>';
			}
		}
		echo '</'. $args['parent_tag'] . '>';
	}
}