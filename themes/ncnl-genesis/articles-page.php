<?php

/* Template Name: Articles Template */

/** Replace the standard loop with our custom loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'wnd_do_custom_loop' );

function wnd_do_custom_loop() {
    global $paged; // current paginated page
    global $query_args; // grab the current wp_query() args
    $args = array(
        'cat' => 8949, /* shows all posts and child posts from category id */
        'paged'            => $paged, // respect pagination
    );

/* If you want to show posts from a category only and no subcategory posts, use 'category_name' => 'category-slug', instead of 'cat' => 8, for example, 'category_name' => 'articles', */
    genesis_custom_loop( wp_parse_args($query_args, $args) );
}

genesis();