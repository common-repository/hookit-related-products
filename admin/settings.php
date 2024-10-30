<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Remove all transients of view if the number of products is changed.
 * 
 * @param string $new_value 
 * @param string $old_value
 */
function hookit_recommended_products_update_option_viewproducts( $old_value, $value ) {
	global $wpdb;
	
	if( $old_value !== $value ) {	
		$sql = "
			DELETE FROM {$wpdb->options}
			WHERE 
				option_name like '_transient_hookit_recommended_products_%' OR 
				option_name like '_transient_timeout_hookit_recommended_products_%'
		";
		return $wpdb->query($sql);
	}
}
add_filter( 'update_option_hookit_recommended_products_viewproducts', 'hookit_recommended_products_update_option_viewproducts', 10, 2 );


/**
 * Initialize the settings names of the plugin.
 */
function hookit_recommended_products_settings_admin_init() {
	register_setting( 'hookit-recommended-products', 'hookit_recommended_products_viewtitle' );
	register_setting( 'hookit-recommended-products', 'hookit_recommended_products_viewproducts' );
	register_setting( 'hookit-recommended-products', 'hookit_recommended_products_token' );
	register_setting( 'hookit-recommended-products', 'hookit_recommended_products_categories' );
	register_setting( 'hookit-recommended-products', 'hookit_recommended_products_sign' );
	register_setting( 'hookit-recommended-products', 'hookit_recommended_products_gender' );
}
add_action( 'admin_init', 'hookit_recommended_products_settings_admin_init' );

/**
 * Prints the settings page content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function hookit_recommended_products_settings( $post ) {
	require __DIR__ . '/views/settings.php';
}
