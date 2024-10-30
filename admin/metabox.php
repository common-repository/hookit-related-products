<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Add a box to show recommended products on edit screen. Only add if the 
 * category is active to recommend products.
 */
function hookit_recommended_products_meta_box() {
	if( hookit_recommended_products_is_active_post( get_query_var( 'post' ) ) ) {
		add_meta_box(
			'hookit_recommended_products_meta_box',
			__( 'Hookit Recommended Products', 'hookit-recommended-products' ),
			'hookit_recommended_products_meta_box_callback',
			'post',
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'hookit_recommended_products_meta_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function hookit_recommended_products_meta_box_callback( $post ) {
	require __DIR__ . '/views/metabox.php';
}
