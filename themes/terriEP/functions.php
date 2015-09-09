<?php
//* Start the engine
require_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'executive', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'executive' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Executive Pro Theme', 'executive' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/executive/' );
define( 'CHILD_THEME_VERSION', '3.1.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'executive_load_scripts' );
function executive_load_scripts() {

	wp_enqueue_script( 'executive-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic|Lato:300,700,300italic', array(), CHILD_THEME_VERSION );

}



//* ----------------- Unregister or Remove -------------------------

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Register secondary sidebar
add_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );

/** Remove Title & Description */
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Remove Genesis in-post SEO Settings
remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'executive_remove_comment_form_allowed_tags' );
function executive_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Load Admin Stylesheet
add_action( 'admin_enqueue_scripts', 'executive_load_admin_styles' );
function executive_load_admin_styles() {

	wp_register_style( 'custom_wp_admin_css', get_stylesheet_directory_uri() . '/lib/admin-style.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );

}


//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav' );

//* ----------------- Header -------------------------


//* Add new image sizes
add_image_size( 'featured', 300, 100, TRUE );
add_image_size( 'portfolio', 300, 200, TRUE );
add_image_size( 'slider', 1200, 445, TRUE );


// Hook site header banner after header
add_action( 'genesis_header', 'site_header_banner',20 );
function site_header_banner() {

		if ( ! is_front_page() || get_query_var( 'paged' ) >= 2 )
		return;

	echo '<div class="site-header-banner"><img src="' . get_stylesheet_directory_uri() . '/images/banner.jpg" alt="Take your business &amp; your life to the
next level with small business coaching" /></div>';
}


// Remove the header right widget area
unregister_sidebar( 'header-right' );



//* ----------------- Widgets -------------------------

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-slider',
	'name'        => __( 'Home - Slider', 'executive' ),
	'description' => __( 'This is the slider section on the home page.', 'executive' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'executive' ),
	'description' => __( 'This is the top section of the home page.', 'executive' ),
) );
genesis_register_sidebar( array(
	'id'          => 'mktgbuttons',
	'name'        => __( 'Marketing Buttons', 'executive' ),
	'description' => __( 'This is the top button section of the home page.', 'executive' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home - Middle', 'executive' ),
	'description' => __( 'This is the middle section of the home page.', 'executive' ),
) );
genesis_register_sidebar( array(
	'id'          => 'infobuttons',
	'name'        => __( 'Info Buttons', 'executive' ),
	'description' => __( 'This is the middle section of the home page.', 'executive' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-testimonial',
	'name'        => __( 'Home Testimonial', 'executive' ),
	'description' => __( 'This is the testimonial section on the home page.', 'executive' ),
) );
