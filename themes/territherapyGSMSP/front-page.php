<?php
/**
 * This file adds the Home Page to the gensample Pro Theme.
 *
 * @author StudioPress
 * @package gensample Pro
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'gensample_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function gensample_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-cta' ) || is_active_sidebar( 'home-middle' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'gensample_home_sections' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		add_filter( 'body_class', 'gensample_add_home_body_class' );

	}

}

function gensample_home_sections() {

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'mktgbuttons', array(
		'before' => '<div class="mktgbuttons widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-middle', array(
		'before' => '<div class="home-middle widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'infobuttons', array(
		'before' => '<div class="infobuttons widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-testimonial', array(
		'before' => '<div class="home-testimonial widget-area">',
		'after'  => '</div>',
	) );

}

//* Add body class to home page
function gensample_add_home_body_class( $classes ) {

	$classes[] = 'gensample-pro-home';
	return $classes;

}

genesis();