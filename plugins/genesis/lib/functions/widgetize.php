<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\WidgetAreas
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

/**
 * Expedites the widget area registration process by taking common things, before / after_widget, before / after_title,
 * and doing them automatically.
 *
 * See the WP function `register_sidebar()` for the list of supports $args keys.
 *
 * A typical usage is:
 *
 * ~~~
 * genesis_register_widget_area(
 *     array(
 *         'id'          => 'my-sidebar',
 *         'name'        => __( 'My Sidebar', 'my-theme-text-domain' ),
 *         'description' => __( 'A description of the intended purpose or location', 'my-theme-text-domain' ),
 *     )
 * );
 * ~~~
 *
 * @since 2.1.0
 *
 * @uses genesis_markup() Contextual markup.
 *
 * @param string|array $args Name, ID, description and other widget area arguments.
 *
 * @return string The sidebar ID that was added.
 */
function genesis_register_widget_area( $args ) {

	$defaults = array(
		'before_widget' => genesis_markup( array(
			'html5' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'xhtml' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'echo'  => false,
		) ),
		'after_widget'  => genesis_markup( array(
			'html5' => '</div></section>' . "\n",
			'xhtml' => '</div></div>' . "\n",
			'echo'  => false
		) ),
		'before_title'  => '<h4 class="widget-title widgettitle">',
		'after_title'   => "</h4>\n",
	);

	/**
	 * A filter on the default parameters used by `genesis_register_widget_area()`. For backward compatibility.
	 *
	 * @since 1.0.1
	 */
	$defaults = apply_filters( 'genesis_register_sidebar_defaults', $defaults, $args );

	/**
	 * A filter on the default parameters used by `genesis_register_widget_area()`.
	 *
	 * @since 2.1.0
	 */
	$defaults = apply_filters( 'genesis_register_widget_area_defaults', $defaults, $args );

	$args = wp_parse_args( $args, $defaults );

	return register_sidebar( $args );

}

/**
 * An alias for `genesis_register_widget_area()`.
 *
 * @since 1.0.1
 * 
 * @uses genesis_register_widget_area()
 *
 * @param string|array $args Name, ID, description and other widget area arguments.
 *
 * @return string The sidebar ID that was added.
 */
function genesis_register_sidebar( $args ) {
	return genesis_register_widget_area( $args );
}

add_action( 'after_setup_theme', '_genesis_builtin_sidebar_params' );
/**
 * Alters the widget area params array for HTML5 compatibility.
 *
 * @since 2.0.0
 *
 * @uses genesis_html5() Check if HTML5 is supported.
 * 
 * @global $wp_registered_sidebars Holds all of the registered sidebars.
 */
function _genesis_builtin_sidebar_params() {

	global $wp_registered_sidebars;

	if ( ! genesis_html5() )
		return;

	foreach ( $wp_registered_sidebars as $id => $params ) {

		if ( ! isset( $params['_genesis_builtin'] ) )
			continue;

		$wp_registered_sidebars[ $id ]['before_widget'] = '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">';
		$wp_registered_sidebars[ $id ]['after_widget']  = '</div></section>';

	}

}

add_action( 'genesis_setup', 'genesis_register_default_widget_areas' );
/**
 * Register the default Genesis widget areas.
 *
 * @since 1.6.0
 *
 * @uses genesis_register_widget_area() Register widget areas.
 */
function genesis_register_default_widget_areas() {

	genesis_register_widget_area(
		array(
			'id'               => 'header-right',
			'name'             => is_rtl() ? __( 'Header Left', 'genesis' ) : __( 'Header Right', 'genesis' ),
			'description'      => __( 'This is the header widget area. It typically appears the the right of the site title or logo. This widget area is not equipped to display any widget, and works best with a custom menu, a search form, or possibly a text widget.', 'genesis' ),
			'_genesis_builtin' => true,
		)
	);

	genesis_register_widget_area(
		array(
			'id'               => 'sidebar',
			'name'             => __( 'Primary Sidebar', 'genesis' ),
			'description'      => __( 'This is the primary sidebar if you are using a two or three column site layout option.', 'genesis' ),
			'_genesis_builtin' => true,
		)
	);

	genesis_register_widget_area(
		array(
			'id'               => 'sidebar-alt',
			'name'             => __( 'Secondary Sidebar', 'genesis' ),
			'description'      => __( 'This is the secondary sidebar if you are using a three column site layout option.', 'genesis' ),
			'_genesis_builtin' => true,
		)
	);

}

add_action( 'after_setup_theme', 'genesis_register_footer_widget_areas' );
/**
 * Register footer widget areas based on the number of widget areas the user wishes to create with `add_theme_support()`.
 *
 * @since 1.6.0
 *
 * @uses genesis_register_widget_area() Register footer widget areas.
 *
 * @return null Return early if there's no theme support.
 */
function genesis_register_footer_widget_areas() {

	$footer_widgets = get_theme_support( 'genesis-footer-widgets' );

	if ( ! $footer_widgets || ! isset( $footer_widgets[0] ) || ! is_numeric( $footer_widgets[0] ) )
		return;

	$footer_widgets = (int) $footer_widgets[0];

	$counter = 1;

	while ( $counter <= $footer_widgets ) {
		genesis_register_widget_area(
			array(
				'id'               => sprintf( 'footer-%d', $counter ),
				'name'             => sprintf( __( 'Footer %d', 'genesis' ), $counter ),
				'description'      => sprintf( __( 'Footer %d widget area.', 'genesis' ), $counter ),
				'_genesis_builtin' => true,
			)
		);

		$counter++;
	}

}

add_action( 'after_setup_theme', 'genesis_register_after_entry_widget_area' );
/**
 * Register after-entry widget area if user specifies in the child theme.
 *
 * @since 2.1.0
 *
 * @uses genesis_register_widget_area() Register widget area.
 *
 * @return null Return early if there's no theme support.
 */
function genesis_register_after_entry_widget_area() {

	if ( ! current_theme_supports( 'genesis-after-entry-widget-area' ) )
		return;

	genesis_register_widget_area(
		array(
			'id'          => 'after-entry',
			'name'        => __( 'After Entry', 'genesis' ),
			'description' => __( 'Widgets in this widget area will display after single entries.', 'genesis' ),
			'_builtin'    => true,
		)
	);

}

/**
 * Conditionally display a sidebar, wrapped in a div by default.
 *
 * The $args array accepts the following keys:
 *
 *  - `before` (markup to be displayed before the widget area output),
 *  - `after` (markup to be displayed after the widget area output),
 *  - `default` (fallback text if the sidebar is not found, or has no widgets, default is an empty string),
 *  - `show_inactive` (flag to show inactive sidebars, default is false),
 *  - `before_sidebar_hook` (hook that fires before the widget area output),
 *  - `after_sidebar_hook` (hook that fires after the widget area output).
 *
 * Return false early if the sidebar is not active and the `show_inactive` argument is false.
 *
 * @since 1.8.0
 *
 * @param string $id   Sidebar ID, as per when it was registered
 * @param array  $args Arguments.
 *
 * @return boolean False if $args['show_inactive'] set to false and sidebar is not currently being used. True otherwise.
 */
function genesis_widget_area( $id, $args = array() ) {

	if ( ! $id )
		return false;

	$args = wp_parse_args(
		$args,
		array(
			'before'              => genesis_html5() ? '<aside class="widget-area">' : '<div class="widget-area">',
			'after'               => genesis_html5() ? '</aside>' : '</div>',
			'default'             => '',
			'show_inactive'       => 0,
			'before_sidebar_hook' => 'genesis_before_' . $id . '_widget_area',
			'after_sidebar_hook'  => 'genesis_after_' . $id . '_widget_area',
		)
	);

	if ( ! is_active_sidebar( $id ) && ! $args['show_inactive'] )
		return false;

	//* Opening markup
	echo $args['before'];

	//* Before hook
	if ( $args['before_sidebar_hook'] )
			do_action( $args['before_sidebar_hook'] );

	if ( ! dynamic_sidebar( $id ) )
		echo $args['default'];

	//* After hook
	if( $args['after_sidebar_hook'] )
			do_action( $args['after_sidebar_hook'] );

	//* Closing markup
	echo $args['after'];

	return true;

}
