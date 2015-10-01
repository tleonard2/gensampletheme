<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
// include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.2.0' );

add_action( 'wp_enqueue_scripts', 'ms_scripts_styles' );
function ms_scripts_styles() {

	wp_enqueue_script( 'ms-responsive-menu', esc_url( get_stylesheet_directory_uri() ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:400,700,400italic|Montserrat', array(), CHILD_THEME_VERSION );

}
//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );



//* ----------------- Move Entry Header -------------------------

function remove_entry_headers_genesis() {
if ( is_page() && !is_archive() && !is_page_template('page_blog-php') || $post->post_parent ) {
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
}}

add_action( 'genesis_before_content', 'remove_entry_headers_genesis' );


//* Add the entry header markup and entry title before the content on all pages except the front page
add_action( 'genesis_after_header', 'jw_add_entry_header' );
function jw_add_entry_header()
{
	if (is_front_page() ) {
		return;
	}
	genesis_entry_header_markup_open();
	genesis_do_post_title();
	genesis_entry_header_markup_close();
}

//* ----------------- Header -------------------------


//* Add new image sizes
add_image_size( 'featured', 300, 100, TRUE );
add_image_size( 'portfolio', 300, 200, TRUE );
add_image_size( 'slider', 1200, 445, TRUE );

// Hook site header banner after header
add_action( 'genesis_header', 'site_header_banner',20 );
function site_header_banner() {

		if (  is_front_page() )


	echo '<div class="site-header-banner"><img src="' . get_stylesheet_directory_uri() . '/images/banner.jpg" alt="Take your business &amp; your life to the
next level with small business coaching" /></div>';

if ( ! is_front_page() && !is_archive() && !is_page_template('page_blog-php') || $post->post_parent )

		echo '<div class="site-header-banner"><img src="' . get_stylesheet_directory_uri() . '/images/seafoam-bokeh-2000x143px.jpg" alt="Take your business &amp; your life to the
next level with small business coaching" /></div>';
}


//* ----------------- Unregister or Remove -------------------------

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Register secondary sidebar
add_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );

//* Remove Genesis in-post SEO Settings
remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'remove_comment_form_allowed_tags' );
function remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Load Admin Stylesheet
/*
add_action( 'admin_enqueue_scripts', 'load_admin_styles' );
function load_admin_styles() {

	wp_register_style( 'custom_wp_admin_css', get_stylesheet_directory_uri() . '/lib/admin-style.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );

}
*/

//* ----------------- Widgets -------------------------

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );


//* Register widget areas
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



//* ----------------- Footer -------------------------

//* Change the footer text
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] Terri Fry Brukhartz';
	return $creds;
}

//* ----------------- SEO optimizing -----------

// Enqueue sticky menu script - Crunchify Tips
add_action( 'wp_enqueue_scripts', 'crunchify_enqueue_script' );
function crunchify_enqueue_script() {
    wp_enqueue_script( 'follow', get_stylesheet_directory_uri() . '/js/follow.js', array( 'jquery' ), '', true );
}

/** Remove jQuery and jQuery-ui scripts loading from header */
add_action('wp_enqueue_scripts', 'crunchify_script_remove_header');
function crunchify_script_remove_header() {
      wp_deregister_script( 'jquery' );
      wp_deregister_script( 'jquery-ui' );
}

/** Load jQuery and jQuery-ui script just before closing Body tag */
add_action('genesis_after_footer', 'crunchify_script_add_body');
function crunchify_script_add_body() {
      wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', false, null);
      wp_enqueue_script( 'jquery');

      wp_register_script( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js', false, null);
      wp_enqueue_script( 'jquery-ui');
}



//* ----------------- MSP additons -----------




//* Add support for custom header
add_theme_support( 'custom-header', array(
	'default-image'   => get_stylesheet_directory_uri() . '/images/logo.png',
	'width'           => 130,
	'height'          => 130,
	'flex-width'      => false,
	'flex-height'     => false,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );


//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

//* Rename menus
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Left Navigation Menu', 'modern-studio' ), 'secondary' => __( 'Right Navigation Menu', 'modern-studio' ) ) );

//* Hook menus
add_action( 'genesis_header', 'ms_menus_container' );
function ms_menus_container() {

	echo '<div class="navigation-container">';
	do_action( 'ms_menus' );
	echo '</div>';

}

//* Relocate Primary (Left) Navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'ms_menus', 'genesis_do_nav' );

//* Relocate Secondary (Right) Navigation
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'ms_menus', 'genesis_do_subnav' );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );


//* Customize the entry meta in the entry header
add_filter( 'genesis_post_info', 'ms_entry_meta_header' );
function ms_entry_meta_header( $post_info ) {

	$post_info = '[post_date format="m.d.Y"] <span class="by">by</span> [post_author_posts_link] // [post_comments] [post_edit]';

	return $post_info;

}

//* Customize the entry meta in the entry footer
add_filter( 'genesis_post_meta', 'ms_entry_meta_footer' );
function ms_entry_meta_footer( $post_meta ) {

	$post_meta = '[post_categories before="Categories // "] [post_tags before="Tags // "]';

	return $post_meta;

}

