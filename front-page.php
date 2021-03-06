<?php
/**
 * This file adds a Front Page ( removing loop & content ) to Dame Clave theme.
 *
 * @author    Mauricio Alvarez
 * @example   http://designnify.com
 * @copyright 2015 Designnify
 */
 
add_action( 'genesis_meta', 'home_genesis_meta' );

function home_genesis_meta() {

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter( 'body_class', 'your_custom_body_class' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_loop', 'genesis_do_loop' );
	
}

//* Replace with your themes home page body class		
function your_custom_body_class( $classes ) {

	$classes[] = 'custom-body-class';
	return $classes;
	
}

genesis();