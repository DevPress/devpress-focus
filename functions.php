<?php
/**
 * Focus functions and definitions
 *
 * @package Focus
 */

/**
 * The current version of the theme.
 */
define( 'FOCUS_VERSION', '1.2.0' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 680; /* pixels */
}

if ( ! function_exists( 'focus_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function focus_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Focus, use a find and replace
	 * to change 'focus' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'focus', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// Registers menu below the site title
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'focus' ),
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 260,
		'height'      => 45,
		'flex-width'  => true,
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'audio', 'gallery', 'image', 'link', 'video'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'focus_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

}
endif; // focus_setup
add_action( 'after_setup_theme', 'focus_setup' );

if ( ! function_exists( 'focus_register_image_sizes' ) ) :
/*
 * Enables support for Post Thumbnails on posts and pages.
 *
 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
 */
function focus_register_image_sizes() {

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 680, 1200 );
	add_image_size( 'focus-archive', 380, 380, true );

}
add_action( 'after_setup_theme', 'focus_register_image_sizes' );
endif;

/**
 * Enqueue fonts.
 */
function focus_fonts() {

	// Font options
	$fonts = array();

	$fonts[1] = get_theme_mod( 'primary-font', customizer_library_get_default( 'primary-font' ) );
	$fonts[2] = get_theme_mod( 'secondary-font', customizer_library_get_default( 'secondary-font' ) );

	$font_uri = customizer_library_get_google_font_uri( $fonts );

	// Load Google Fonts
	wp_enqueue_style( 'focus-fonts', $font_uri, array(), null, 'screen' );

	// Icon Font
	wp_enqueue_style(
		'focus-icons',
		get_template_directory_uri() . '/fonts/focus-icons.css',
		array(),
		'1.0.0'
	);

}
add_action( 'wp_enqueue_scripts', 'focus_fonts' );

/**
 * Enqueue scripts and styles.
 */
function focus_scripts() {

	wp_enqueue_style(
		'focus-style',
		get_stylesheet_uri(),
		array(),
		FOCUS_VERSION
	);

	// Use style-rtl.css for RTL layouts
	wp_style_add_data(
		'focus-style',
		'rtl',
		'replace'
	);

	wp_enqueue_script(
		'focus-scripts',
		get_template_directory_uri() . '/js/focus.min.js',
		array( 'jquery' ),
		FOCUS_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'focus_scripts' );

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
require get_template_directory() . '/inc/customizer-library/customizer-library.php';
require get_template_directory() . '/inc/customizer-options.php';
require get_template_directory() . '/inc/styles.php';
require get_template_directory() . '/inc/mods.php';