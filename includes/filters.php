<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Show recommended products in the footer of the post in the singular page.
 * Send a ping to server to sinalize that the recommended posts is loading.
 *
 * @param string $content The post content.
 */
function hookit_recommended_products_the_content( $content ) {
	if( is_singular() ) {
		if( hookit_recommended_products_is_active_post( get_the_ID() ) ) {
			$products = hookit_recommended_products_get_products( get_the_ID() );
		
			// Doesn't show recommended products elements if the post hadn't or deactivated for the post
			if( is_array( $products ) ) {
				ob_start();
				hookit_recommended_products_consume_ws( 'ping' );
				require __DIR__ . '/../views/recommended-products.php';
				$content .= ob_get_clean();
			}
		}
	}

	return $content;
}
add_filter( 'the_content', 'hookit_recommended_products_the_content', 20 );
