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
global $bmag_options;
$header_image = get_header_image();


?>



<body <?php body_class(); ?>>

<!-- this style tag should be moved to single file -->
<style type="text/css">
	
.header-top-banner{
	background-color: <?php echo $bmag_options['header_top_menu_bg_color']?>; /*header_top_menu_bg_color*/
	height: <?php echo $bmag_options['header_top_menu_height'] ?>px; /* header_top_menu_height */
}

.header-top-banner ul li a{
	color: <?php echo $bmag_options['header_top_menu_color'] ?>; /* header_top_menu_color */
}

.top-menu>ul>li:hover{
	background-color: <?php echo $bmag_options['header_top_menu_hover_bg_color'] ?>; /*header_top_menu_hover_bg_color*/
}

.top-menu>ul>li:hover>a{
	color: <?php echo $bmag_options['header_top_menu_hover_text_color'] ?>; /* header_top_menu_hover_text_color */

}


.header-body{
	background-color: <?php echo $bmag_options['header_body_bg_color']?>;/*header_body_bg_color*/
}

.site-logo{
	width: <?php echo $bmag_options['site_logo_width']?>px;/* site_logo_width */
}


/*------------------------Header Style End-------------------*/


/*--------------------------------------------------------------
# Navigation
--------------------------------------------------------------*/
.header-nav{
	background-color: <?php echo $bmag_options['primary_menu_bg_color']?>;/*primary_menu_bg_color*/
	font-size: <?php echo $bmag_options['primary_menu_font_size']?>px; /*primary_menu_font_size*/
}
.primary-menu a,
.primary-menu a:visited,
.primary-menu a:hover{
	color: <?php echo $bmag_options['primary_menu_text_color']?>; /*primary_menu_text_color*/
}

.primary-menu .current-menu-item>a,
.primary-menu .current-menu-ancestor>a{
	color: <?php echo $bmag_options['primary_menu_text_hover_color']?>; /*primary_menu_text_hover_color*/
}

.primary-menu>.menu-item:hover>a{
	color: <?php echo $bmag_options['primary_menu_text_hover_color']?>;/*primary_menu_text_hover_color*/
}
.primary-menu>.menu-item:hover{
	background-color: <?php echo $bmag_options['primary_menu_bg_hover_color']?>;/*primary_menu_bg_hover_color*/
}
.primary-menu>.menu-item:hover>.sub-menu{
	background-color: <?php echo $bmag_options['primary_menu_bg_color']?>; /*primary_menu_bg_color*/
	<?php if( true == $bmag_options['primary_menu_enable_shadows'] ):?>
		-webkit-box-shadow: 2px 3px 5px 0px rgba(0,0,0,0.4);
		-moz-box-shadow: 2px 3px 5px 0px rgba(0,0,0,0.4);
		box-shadow: 2px 3px 5px 0px rgba(0,0,0,0.4);
	<?php endif;?>
}

.primary-menu .sub-menu>.menu-item:hover{
	background-color: <?php echo $bmag_options['primary_menu_submenu_bg_hover_color']?>;/*primary_menu_submenu_bg_hover_color*/
}
.primary-menu .sub-menu>.menu-item:hover>a{
	color: <?php echo $bmag_options['primary_menu_text_hover_color']?>;/*primary_menu_text_hover_color*/
}

.primary-menu>.menu-item:hover>.sub-menu>.menu-item:hover>.sub-menu{
	background-color: <?php echo $bmag_options['primary_menu_bg_color']?>; /*primary_menu_bg_color*/
	<?php if( true == $bmag_options['primary_menu_enable_shadows'] ):?>
		-webkit-box-shadow: 2px 3px 5px 0px rgba(0,0,0,0.4);
		-moz-box-shadow: 2px 3px 5px 0px rgba(0,0,0,0.4);
		box-shadow: 2px 3px 5px 0px rgba(0,0,0,0.4);
	<?php endif;?>
}

</style>




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
					'theme_location'  => 'bmag_top',
					'menu'            => '',
					'container'       => 'div',
					'container_class' => 'top-menu clearfix',
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
					'parent_id' => 'bmag_social',
					'parent_class' =>'social float-right',
					'child_tag' => 'li.a',
					'child_class'=> 'top-social-item',
					'items' => array(
						array(
							'font_awesome' => 'fa fa-facebook',
							'name' => esc_html__('','bmag'),
							'url' => '#',
							'custom_class' => '',
							'url_pos' => 1
							),
						array(
							'font_awesome' => 'fa fa-twitter',
							'name' => esc_html__('','bmag'),
							'url' => '#',
							'custom_class' => '',
							'url_pos' => 1,
							),
						array(
							'font_awesome' => 'fa fa-vk',
							'name' => esc_html__('','bmag'),
							'url' => '#',
							'custom_class' => '',
							'url_pos' => 1
							),
						array(
							'font_awesome' => 'fa fa-instagram',
							'name' => esc_html__('','bmag'),
							'url' => '#',
							'custom_class' => '',
							'url_pos' => 1
							),
						)
					);
				$bmag_front_output->display_custom_menu($social_menu);

				?>

				</div>
			</div>

			<div class="header-body">
				<div class="header-body-wrapper container clearfix">
					<div class="header-nav-mobile">
						<div class="header-nav-wrapper-mobile container">
							<?php 
							wp_nav_menu(array(
								'theme_location'  => 'bmag_primary',
								'menu'            => '',
								'container'       => 'div',
								'container_class' => 'primary-menu-wrapper-mobile clearfix',
								'container_id'    => '',
								'menu_class'      => 'primary-menu-mobile',
								'menu_id'         => 'bmag-primary-menu',
								'echo'            => true,
								'fallback_cb'     => '',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth'           => 3,
								'walker'          => ''
							));
					 	?>
						</div>
					</div>

					<div class="site-logo">
						<img src="<?php echo BMAG_URL. '/inc/images/logo.png' ?>" alt="">
					</div>
					<div class="ad-wrapper">
						<div class="advertisment">300x100</div>
					</div>
				</div>
			</div>
			<div class="header-nav">
				<div class="header-nav-wrapper container">
					<?php 
					wp_nav_menu(array(
						'theme_location'  => 'bmag_primary',
						'menu'            => '',
						'container'       => 'div',
						'container_class' => 'primary-menu-wrapper clearfix',
						'container_id'    => '',
						'menu_class'      => 'primary-menu',
						'menu_id'         => 'bmag-primary-menu',
						'echo'            => true,
						'fallback_cb'     => '',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 3,
						'walker'          => ''
					));
			 	?>
				</div>
			</div>
			
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
