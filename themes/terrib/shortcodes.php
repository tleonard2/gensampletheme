function terri_recentpost($atts, $content=null){

$getpost = get_posts( array('number' => 1) );

$getpost = $getpost[0];

$return = $getpost->post_title . "<br />" . $getpost->post_excerpt . "…";

$return .= "<br /><a href='" . get_permalink($getpost->ID) . "'><em>read more →</em></a>";

return $return;

}


add_shortcode('newestpost', 'terri_recentpost');