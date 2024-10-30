<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Load the plugin text domain with translations.
 */
function hookit_recommended_products_plugins_loaded() {
	$plugin_dir = 'hookit-related-products/languages';
	load_plugin_textdomain( 'hookit-recommended-products', false, $plugin_dir );
}
add_action( 'plugins_loaded', 'hookit_recommended_products_plugins_loaded' );

/**
 * Add the plugin base style
 */
function hookit_recommended_products_enqueue_scripts() {
	global $hookit_recommended_products_base_url;
	
	wp_enqueue_style( 
		'hookit-recommended-products',
		$hookit_recommended_products_base_url . 'assets/css/style.css'
	);
}
add_action( 'wp_enqueue_scripts', 'hookit_recommended_products_enqueue_scripts' );
