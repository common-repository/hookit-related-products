<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

?>
<div class="hookit-recommended-products">
	<?php do_action( 'hookit_recommended_products_before_products' ) ?>
	
	<?php 
		// Show title if the title setting isn't empty
		$title = hookit_recommended_products_get_viewtitle();
		if( '' !== $title ) :
			$title_element = apply_filters( 'hookit_recommended_products_title_element', 'h3' );
	?>
	<<?php echo $title_element ?> class="hookit-recommended-title"><?php echo $title ?></<?php echo $title_element?>>
	<?php endif; ?>
	
	<?php foreach ( $products as $product ) : ?>
	<div class="product">
		<div class="hookit-recommended-img-wrapper">
			<a target="_blank" href="<?php echo hookit_recommended_product_affiliate_url( $product ) ?>">
				<span class="hookit-recommended-helper"></span><img src="<?php echo hookit_recommended_products_get_s3_image( $product ) ?>" alt="<?php echo $product->nome ?>" />
			</a>
		</div>
		
		<p>
			by 
			<a target="_blank" href="http://hookit.cc/brands/<?php echo $product->ecommerce->seoName ?>">
				<strong><?php echo $product->ecommerce->nomeFantasia ?></strong>
			</a>
			<br />
			R$ <?php echo number_format( $product->preco, 2, ',', '.' ) ?>
			<br />
			<a target="_blank" href="<?php echo hookit_recommended_product_affiliate_url( $product ) ?>">
				<strong>Comprar</strong> &raquo;
			</a>
		</p>
	</div>
	<?php endforeach; ?>
	
	<div class="clear"></div>
	
	<?php if( hookit_recommended_products_get_sign() ) : ?>
	<div class="sign">
		<a href="http://hookit.cc" target="_blank">
			<?php global $hookit_recommended_products_base_url; ?>
			<img src="<?php echo $hookit_recommended_products_base_url ?>/assets/img/sign.png" alt="Hookit" />
		</a>
	</div>
	<?php endif; ?>
	
	<?php do_action( 'hookit_recommended_products_after_products' ) ?>
</div>