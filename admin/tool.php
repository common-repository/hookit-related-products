<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Add script to the tool.
 * 
 * The script manage the processing. It fires all posts active to recommend
 * products and get the results.
 * 
 * @param string $hook The admin page hook name.
 */
function hookit_recommended_products_tool_admin_enqueue_scripts( $hook ) {
	global $hookit_recommended_products_base_url;
	
	if( 'hookit_page_hookit_recommended_products_tool' !== $hook ) {
		return;
	}
	
	wp_enqueue_script( 
		'hookit-recommended-products-admin-tool', 
		$hookit_recommended_products_base_url . '/assets/js/tool.js',
		array( 'jquery' ),
		false,
		true
	);
	
	wp_localize_script( 'hookit-recommended-products-admin-tool', 'hookit_recommended_products_admin_tool', array(
		'posts_id' => hookit_recommended_products_get_posts_id(),
	) );
}
add_action( 'admin_enqueue_scripts', 'hookit_recommended_products_tool_admin_enqueue_scripts' );

/**
 * Process a post to get recommended products.
 */
function hookit_recommended_products_tool_ajax_process() {
	$post_id = (int)$_GET['post_id'];
	$post = get_post( $post_id );
	
	// use the save_post hook callback to process
	$saved_value = hookit_recommended_products_save_post( $post_id, $post, true );
	
	$message = is_array( $saved_value ) ? __( 'Ok', 'hookit-recommended-products' ) : $saved_value;
	
	die( sprintf( '%s - %s</br>', $post->post_title, $message ) );
}
add_action( 'wp_ajax_hookit_recommended_products_tool_process', 'hookit_recommended_products_tool_ajax_process' );

/**
 * Prints the settings page content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function hookit_recommended_products_tool() {
	require __DIR__ . '/views/tool.php';
}
