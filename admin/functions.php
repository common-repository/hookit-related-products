<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Call the Web Service to get recommended products of the post
 * 
 * @param WP_Post $post
 * @return string|WP_Error The Web Service return. If the the configuration wasn't defined or occurs a error on Web Service, return a WP_Error.
 */
function hookit_recommended_products_get_recommended( $post ) {
	$hookit_categories = array();
	$gender = hookit_recommended_products_get_gender();
	switch ($gender) {
		case 'Male' :
			$hookit_categories[] = 'Masculino';
			break;

		case 'Female' :
			$hookit_categories[] = 'Feminino';
			break;
	}
	
	return hookit_recommended_products_consume_ws( 'get-post-recommended-products', array(
		'id' => $post->ID,
		'title' => $post->post_title,
		'content' => strip_tags( $post->post_content ),
		'tags' => wp_get_post_tags( $post->ID, array( 'fields' => 'names' ) ),
		'hookit_categories' => $hookit_categories,
	) );
}

/**
 * Get all posts that has active the recommended product view.
 *
 * @return WP_Post[] The posts objects.
 */
function hookit_recommended_products_get_posts() {
	// create a WP_Query without args to not execute the query on create
	$query = new WP_Query();
	
	// get all posts
	$query->set( 'posts_per_page', -1 );
	
	// don't select deactivated post
	$query->set( 'meta_query', array(
		'relation' => 'OR',
		array(
			'key' => 'hookit_recommended_products',
			'value' => 'deactivated',
			'compare' => '!=',
		),
		array(
			'key' => 'hookit_recommended_products',
			'compare' => 'NOT EXISTS'
		),
	) );
	
	// if has active categories, filter them
	$categories = hookit_recommended_products_get_categories();
	if( ! empty( $categories ) ) {
		$query->set( 'category__in', $categories );
	}
	
	// execute the query
	return $query->get_posts();
}

/**
 * Get all posts that has active the recommended product view.
 * 
 * @return integer[] The posts id.
 */
function hookit_recommended_products_get_posts_id() {
	return wp_list_pluck( hookit_recommended_products_get_posts(), 'ID' );
}
