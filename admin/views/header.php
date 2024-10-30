<?php $screen = get_current_screen() ?>

<h2 class="nav-tab-wrapper">
	<?php $active = 'toplevel_page_hookit_recommended_products' === $screen->base ? ' nav-tab-active' : '' ?>
    <a href="<?php menu_page_url( 'hookit_recommended_products' ) ?>" class="nav-tab<?php echo $active ?>">
    	<?php _e( 'Settings', 'hookit-recommended-products' ) ?>
    </a>
	
	<?php $active = 'hookit_page_hookit_recommended_products_tool' === $screen->base ? ' nav-tab-active' : '' ?>
    <a href="<?php menu_page_url( 'hookit_recommended_products_tool' ) ?>" class="nav-tab<?php echo $active ?>">
    	<?php _e( 'Update Posts', 'hookit-recommended-products' ) ?>
    </a>
</h2>