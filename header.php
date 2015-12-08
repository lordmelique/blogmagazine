<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blog_Magazine
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>
<?php  
global $bmag_front;
global $bmag_front_output;
$header_image = get_header_image();




?>



<body <?php body_class(); ?>>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bmag' ); ?></a>

	<header class="site-header" role="banner">

		 <?php if(! empty($header_image)){  ?>
		    <div class="header-container">
				<a class="custom-header-a" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo header_image(); ?>" class="custom-header">	
				</a>
			</div>
		 <?php } ?>

		<div id="header">
			<div class="header-top-banner">
			<div class="container clearfix">
			<?php

				
				wp_nav_menu(array(
					'theme_location'  => 'top_menu_bar',
					'menu'            => '',
					'container'       => 'div',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => 'menu',
					'menu_id'         => '',
					'echo'            => true,
					'fallback_cb'     => '',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'items_wrap'      => '<ul id="%1$s" class="%2$s float-left">%3$s</ul>',
					'depth'           => -1,
					'walker'          => ''
				));

				$social_menu = array(
					'parent_tag' => 'ul',
					'parent_id' => '',
					'parent_class' =>'',
					'child_tag' => 'li.div.div.div.a',
					'child_class'=> 'valodik hasmik qyababv.samsonchik tup',
					'items' => array(
						array(
							'font_awesome' => 'fa fa-facebook',
							'name' => esc_html__('Facebook','bmag'),
							'url' => '#',
							'custom_class' => '',
							'url_pos' => 7
							),
						array(
							'font_awesome' => 'fa fa-twitter',
							'name' => esc_html__('Twitter','bmag'),
							'url' => '#',
							'custom_class' => '',
							'url_pos' => 7,
							),
						array(
							'font_awesome' => 'fa fa-vk',
							'name' => esc_html__('Vkontakte','bmag'),
							'url' => '#',
							'custom_class' => '',
							'url_pos' => 7
							),
						array(
							'font_awesome' => 'fa fa-instagram',
							'name' => esc_html__('Instagram','bmag'),
							'url' => '#',
							'custom_class' => '',
							'url_pos' => 7
							),
						)
					);
				$bmag_front_output->display_custom_menu($social_menu);

				?>
					<ul class="social float-right">
						<li><a href="#" class="fa fa-facebook"></a></li>
						<li><a href="#" class="fa fa-twitter"></a></li>
						<li><a href="#" class="fa fa-vk"></a></li>
						<li><a href="#" class="fa fa-instagram"></a></li>
					</ul>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
