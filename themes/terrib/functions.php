<?php

function wptuts_recentpost($atts, $content=null){

	$getpost = get_posts( array('number' => 1) );

	$getpost = $getpost[0];


	$return = $getpost->post_title . "<br />" . $getpost->post_excerpt . "…";

	$return .= "<br /><a href='" . get_permalink($getpost->ID) . "'><em>read more →</em></a>";

	return $return;

}
add_shortcode('newestpost', 'wptuts_recentpost');



// Add CSS to Visual Editor
add_editor_style();

add_action( 'init', 'register_my_menus' );

function register_my_menus() {
    register_nav_menus(
        array(
            'mobile-menu' => __( 'Mobile Menu' )
        )
    );
}

?>
