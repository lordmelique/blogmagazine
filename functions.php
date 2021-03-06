<?php
/**
 * Blog Magazine functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Blog_Magazine
 */
define('BMAG_TITLE','Blog Magazine');
define('BMAG_SLUG','blog-magazine');
define('BMAG_VAR','blog_magazine');
define("BMAG_OPT",'theme_' . BMAG_VAR . '_options');
define("BMAG_VERSION",wp_get_theme()->get('Version'));

define("BMAG_IS_PRO", true);
define("BMAG_HOMEPAGE", "#");

/*directories*/
define("BMAG_DIR", get_template_directory());
/*URLs*/
define("BMAG_URL", get_template_directory_uri());
define("BMAG_IMG", BMAG_URL.'/images/');
define("BMAG_IMG_INC", BMAG_URL.'/inc/images/');
require_once('inc/index.php');
if ( ! function_exists( 'bmag_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bmag_setup() {
	
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Blog Magazine, use a find and replace
	 * to change 'bmag' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'bmag', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'bmag_primary' => esc_html__( 'Primary Menu', 'bmag' ),
		'bmag_top' => esc_html__( 'Top Menu Bar','bmag' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'bmag_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );


	//initialize front globals
	bmag_init_front_params();
}
endif; // bmag_setup
add_action( 'after_setup_theme', 'bmag_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bmag_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bmag_content_width', 640 );
}
add_action( 'after_setup_theme', 'bmag_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bmag_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bmag' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'bmag_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bmag_scripts() {

	wp_enqueue_script('jquery');

	wp_enqueue_style( 'bmag-font-awesome', BMAG_URL . '/inc/css/font-awesome/font-awesome.css',array(), BMAG_VERSION);

	wp_enqueue_style( 'bmag-style', get_stylesheet_uri() );

	wp_enqueue_script( 'bmag-navigation', BMAG_URL . '/js/navigation.js', array(), BMAG_VERSION, true );

	wp_enqueue_script( 'bmag-skip-link-focus-fix', BMAG_URL . '/js/skip-link-focus-fix.js', array(), BMAG_VERSION, true );

	wp_enqueue_script( 'bmag-frontend', BMAG_URL . '/js/BMAGFrontend.js', array('jquery'), BMAG_VERSION);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


}
add_action( 'wp_enqueue_scripts', 'bmag_scripts' );

/**
 * Initializes globals $bmag_front and $bmag_front_output
 */
function bmag_init_front_params(){
	global $bmag_front;
	global $bmag_front_output;
	require_once(BMAG_DIR . '/inc/front/BMAG_front_functions.php');
	require_once(BMAG_DIR . '/inc/front/BMAG_front_output.php');
	$bmag_front = new BMAG_front_functions();
	$bmag_front_output = new BMAG_front_output();
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
