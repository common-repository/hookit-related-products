<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Process the post content after save.
 *
 * @param int $post_id The post ID.
 * @param WP_Post $post The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 * @return The saved post meta
 */
function hookit_recommended_products_save_post( $post_id, $post, $update ) {
	// Ignore if is a post revision
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	
	// remove transient
	delete_transient( 'hookit_recommended_products_' . $post_id );
	
	// Ignore if not has active category that must recommend products
	$has_active_category = false;
	foreach ( get_the_category( $post_id ) as $category ) {
		if( hookit_recommended_products_is_active_category( $category ) ) {
			$has_active_category = true;
			break;
		}
	}
	
	if( ! ( $has_active_category && empty( $_POST['hookit_recommended_product_deactivate'] ) ) ) {
		$save = 'deactivated';
	} else {
		$save = hookit_recommended_products_get_recommended( $post );
		
		if( is_wp_error( $save ) ) {
			$save = $save->get_error_message();
		}
	}

	if( $update ) {
		update_post_meta( $post_id, 'hookit_recommended_products', $save );
	} else {
		add_post_meta( $post_id, 'hookit_recommended_products', $save );
	}
	
	return $save;
}
add_action( 'save_post', 'hookit_recommended_products_save_post', 10, 3 );

/**
 * Add admin style and scripts on admin
 */
function hookit_recommended_products_admin_enqueue_scripts() {
	global $hookit_recommended_products_base_url;
	
	wp_register_script( 
		'jquery-multi-select',
		$hookit_recommended_products_base_url . 'assets/js/jquery.multi-select.js',
		array( 'jquery' ),
		false,
		true
	);
	
	wp_register_style(
		'jquery-multi-select', 
		$hookit_recommended_products_base_url . 'assets/css/multi-select.css'
	);
	
	wp_enqueue_style( 
		'hookit-recommended-products-admin', 
		$hookit_recommended_products_base_url . 'assets/css/admin.css',
		array( 'jquery-multi-select' )
	);
	
	wp_enqueue_script(
		'hookit-recommended-products-admin',
		$hookit_recommended_products_base_url . 'assets/js/script.js',
		array( 'jquery-multi-select' ),
		false,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'hookit_recommended_products_admin_enqueue_scripts' );

function hookit_recommended_products_admin_menu() {
	add_menu_page( 
		__( 'Hookit Recommended Products', 'hookit-recommended-products' ),
		__( 'Hookit', 'hookit-recommended-products'),
		'manage_options',
		'hookit_recommended_products',
		'hookit_recommended_products_settings',
		'',
		100
	);
	
	add_submenu_page(
		'hookit_recommended_products',
		__( 'Settings', 'hookit-recommended-products'),
		__( 'Settings', 'hookit-recommended-products'),
		'manage_options',
		'hookit_recommended_products',
		'hookit_recommended_products_settings'
	);

	add_submenu_page(
		'hookit_recommended_products',
		__( 'Update Posts', 'hookit-recommended-products' ),
		__( 'Update Posts', 'hookit-recommended-products' ),
		'edit_posts',
		'hookit_recommended_products_tool',
		'hookit_recommended_products_tool'
	);
}
add_action( 'admin_menu', 'hookit_recommended_products_admin_menu' );
