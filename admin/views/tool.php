<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

?>
<div class="wrap">
	<?php require __DIR__ . '/header.php'; ?>

	<?php if( isset( $_REQUEST['process'] ) ) : ?>
	<div id="hookit-tool-console" class="hookit-tool-console">
		<p><?php _e( 'Getting recommended products...', 'hookit-recommended-products' )?></p>
	</div>
	<?php else : ?>
	<p>
		<a href="<?php echo add_query_arg( 'process', '1' ) ?>" class="button button-primary button-large">
			<?php _e( 'Process all posts', 'hookit-recommended-products' ) ?>
		</a>
	</p>
	<?php endif; ?>
</div>
