<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Verify if the category must process the products. If any category was 
 * selected, consider apply the recommended products for all.
 *
 * @param WP_Term $category The category
 * @return boolean True, if must. False, otherwise.
 */
function hookit_recommended_products_is_active_category( $category ) {
	$categories = hookit_recommended_products_get_categories();
	if( empty( $categories ) ) {
		return true;
	}
	
	return in_array( $category->term_id, $categories );
}

/**
 * Verify if someone post category is active to recommend products.
 *
 * @param WP_Post|int $post The post object or post id.
 * @return boolen True, if someone post has active category. False, otherwise.
 */
function hookit_recommended_products_is_active_post( $post ) {
	if( is_a( $post, 'WP_Post' ) ) {
		$post = $post->ID;
	}

	foreach ( get_the_category( $post ) as $category ) {
		if( hookit_recommended_products_is_active_category( $category ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Get recommended products of a post.
 * 
 * @param int $post_ID The post ID.
 * @param int|bool $limit The limit of produts for querying, false for no limit. Default: false
 * @param bool $frontend If true, select only actives products and that has image. Default: false
 * @return array|WP_Error An object array with the results. If cannot connect to Hookit Database, return a WP_Error.
 */
function hookit_recommended_products_get_products( $post_ID ) {
	// load products from transient
	if( false !== ( $products = get_transient( 'hookit_recommended_products_' . $post_ID ) ) ) {
		return $products;
	}
	
	$products = get_post_meta( $post_ID, 'hookit_recommended_products', true );
	
	// return if the deactivated option was marked on the post edit page
	if( 'deactivated' === $products ) {
		return 'deactivated';
	}
	
	// return empty array if not found any product
	if( 0 === count( $products ) ) {
		return array();
	}
	
	// get information of the classified products saved on database
	$products = hookit_recommended_products_consume_ws( 'get-product-information', $products );
	
	// fix to not show warning when the first post access before the plugin
	if( is_null( $products ) ) {
		return array();
	}
	
	if( is_wp_error( $products ) ) {
		return $products;
	}
	
	$active_products = array();
	foreach( $products as $product ) {
		// ignore inactive and without image name products
		if( ( 0 === $product->status || null === $product->nomeImagem ) ) {
			continue;
		}
	
		$active_products[] = $product;
		
		// stop if arrive in the number to show
		if( count( $active_products ) == hookit_recommended_products_get_viewproducts() ) {
			break;
		}
	}
	
	// set transient cache to 8 hours
	set_transient( 'hookit_recommended_products_' . $post_ID, $active_products, 8 * HOUR_IN_SECONDS );
	
	return $active_products;
}

/**
 * Get the cached image on the S3 bucket.
 * 
 * @param stdClass $product The product information of the hookit_recommended_products_get_products
 * @return string The image URL.
 */
function hookit_recommended_products_get_s3_image( $product ) {
	$bucket_url = 'http://hookit-hoook.hookit.cc';
	$img_folder = $product->ecommerce->seoName . '/' . md5( $product->ecommerce->id . '-' . $product->codigo );
	$prefix = 'tmb_';
	return $bucket_url . '/' . $img_folder . '/' . $prefix . $product->nomeImagem;
}

/**
 * Message that link the plugin page on Hookit Wiki.
 * 
 * @return string The message.
 */
function hookit_recommended_products_wiki_page_link() {
	return sprintf( __( 
		'See the <a href="%s" target="_blank">Wiki page</a> to solve this problem.',
		'hookit-recommended-products'
	), 'http://wiki.hookit.cc/index.php/Plugin_WordPress_Recomenda%C3%A7%C3%A3o_Produtos' );
}

/**
 * Consume the Hookit Web Semantic API using cURL.
 * 
 * @param string $service The name of the method that will be called.
 * @param string $body A JSON with the service body
 * @return WP_Error|string A JSON with the result of the call. A WP_Error if the Web Service return a error.
 */
function hookit_recommended_products_consume_ws( $service, $body = array() ) {
	$curl = curl_init();

	$service_uri = defined( 'HOOKIT_WS_URI' ) ? HOOKIT_WS_URI : 'http://apiws.hookit.cc:8080';
		
	curl_setopt_array( $curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $service_uri . '/hookit-ws/services/text/' . $service,
		CURLOPT_HTTPHEADER => array( 'Content-Type: application/json' ),
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => json_encode( $body )
	) );
	
	$return = curl_exec( $curl );
	$http_code = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
	curl_close( $curl );
	
	if( $http_code === 0 ) {
		return new WP_Error( 'webservice', 'The Web Service is offline.', 'hookit-recommended-products' );
	}
	
	if( $http_code !== 200 ) {
		return new WP_Error( 'webservice', sprintf( __( 'The Web Service returned the %d code.', 'hookit-recommended-products' ), $http_code ) );
	}
	
	if( false === ( $return = json_decode( $return ) ) ) {
		return new WP_Error( 'webservice', 'The Web Service response isn\'t a JSON.', 'hookit-recommended-products' );
	}
	
	return $return;
}

/**
 * Generate url to monetize the sale to the blogger if he puts your token.
 *
 * @param stdClass $product The product object.
 * @return string The url to monetize the sale.
 */
function hookit_recommended_product_affiliate_url( $product ) {
	$url = 'http://hoook.cc/' . $product->hash;
	if( false != ( $token = hookit_recommended_products_get_token() ) ) {
		$url .= '?rel=' . $token;
	}

	return $url;
}

/**
 * Get the view product setting. If not setted get the default.
 * 
 * @return The setting.
 */
function hookit_recommended_products_get_viewproducts() {
	return get_option( 'hookit_recommended_products_viewproducts', 4 );
}

/**
 * Get the view title setting. If not setted get the default.
 *
 * @return The setting.
 */
function hookit_recommended_products_get_viewtitle() {
	return get_option( 'hookit_recommended_products_viewtitle', '' );
}

/**
 * Get the token setting. If not setted get the default.
 *
 * @return The setting.
 */
function hookit_recommended_products_get_token() {
	return get_option( 'hookit_recommended_products_token', false );
}

/**
 * Get the categories activated to show the recommended products. If not setted
 * get the default.
 *
 * @return The setting.
 */
function hookit_recommended_products_get_categories() {
	return get_option( 'hookit_recommended_products_categories', array() );
}

/**
 * Get the categories activated to show the recommended products. If not setted
 * get the default.
 *
 * @return boolean The setting.
 */
function hookit_recommended_products_get_sign() {	
	return '1' === get_option( 'hookit_recommended_products_sign', '' );
}

/**
 * Get the gender of the products that must be showed.
 *
 * @return boolean The setting.
 */
function hookit_recommended_products_get_gender() {	
	return get_option( 'hookit_recommended_products_gender', 'Both' );
}
