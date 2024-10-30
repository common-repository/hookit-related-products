<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$products = hookit_recommended_products_get_products( get_the_ID() );
$deactivated = 'deactivated' === $products;

?>

<div class="hookit-recommended-product-deactivate">
	<label for="hookit_recommended_product_deactivate">
		<?php $checked = $deactivated ? 'checked="checked"' : ''; ?>
		<input id="hookit_recommended_product_deactivate" type="checkbox" name="hookit_recommended_product_deactivate" <?php echo $checked ?> />
		<?php _e( 'Deactivate recommended products to this post.', 'hookit-recommended-products' ) ?>
	</label>
</div>

<?php
if( ! $deactivated ) :
	if( is_wp_error( $products ) ) :
		echo $products->get_error_message();
	elseif( $products ) :
		foreach( $products as $product ) : 
	?>
	<a target="_blank" href="<?php echo hookit_recommended_product_affiliate_url( $product ) ?>">
		<strong><?php echo $product->nome ?></strong>
	</a>
	-
	<a target="_blank" href="http://hookit.cc/brands/<?php echo $product->ecommerce->seoName ?>">
		<?php echo $product->ecommerce->nomeFantasia ?>
	</a>
	
	<?php if( 0 == $product->status ) : ?>
	- <?php _e( 'Inactive', 'hookit-recommended-products' ) ?>
	<?php endif; ?>
	
	<br />
	<?php 
		endforeach; 
	else:
		_e( 'Any product found for this post.', 'hookit-recommended-products' );
	endif; 
endif;

?>