<?php

$hookit_recommended_products_base_url = plugin_dir_url( __FILE__ );
$hookit_recommended_products_base_dir = plugin_dir_path( __FILE__ );

require_once 'includes/actions.php';
require_once 'includes/filters.php';
require_once 'includes/functions.php';

if( is_admin() ) {
	require_once 'admin/actions.php';
	require_once 'admin/functions.php';
	require_once 'admin/metabox.php';
	require_once 'admin/settings.php';
	require_once 'admin/tool.php';
}
