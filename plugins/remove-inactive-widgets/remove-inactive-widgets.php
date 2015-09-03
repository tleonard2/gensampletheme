<?php
/*
Plugin Name: Remove Inactive Widgets
Plugin URI: http://benjaminsterling.com/wordpress-plugins/remove-inactive-widgets/
Description: This plugin adds a button to the widget's admin page that will delete all inactive widgets.
Version: 0.2.2
Author: Benjamin Sterling
Author URI: http://kenzomedia.com
Author Email: benjamin.sterling@kenzomedia.com
License: 

    Copyright 2013  Benjamin Sterling  (email : benjamin.sterling@kenzomedia.com)


    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function riw_admin_print_scripts( $arg ){
    global $pagenow;
    if (is_admin() && $pagenow == 'widgets.php') {
        $js = plugins_url('/riw.js', __FILE__ );
        wp_enqueue_script("riwscript", $js );
    }
}

function riw_async(){
    $widgets = get_option('sidebars_widgets');
    $widgets['wp_inactive_widgets'] = array();
    update_option('sidebars_widgets', $widgets);
}

function riw_add_action(){
    wp_nonce_field( 'riw_asyncnonce', 'riw_asyncnonce' );
}

add_action( 'admin_footer', 'riw_add_action' );
add_action( 'wp_ajax_riw_async', 'riw_async' );
add_action( 'admin_print_scripts', 'riw_admin_print_scripts' );
?>