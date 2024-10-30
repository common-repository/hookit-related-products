jQuery(function($) {
	var posts_id = hookit_recommended_products_admin_tool.posts_id,
		processed = 0;
	$( posts_id ).each( function( i, item ) {
		$.get( ajaxurl, {
			'action' : 'hookit_recommended_products_tool_process',
			'post_id' : item
		}, function( response ) {
			processed++;
			var message = '(' + processed + '/' + posts_id.length + ') ' + response;
			$( '.hookit-tool-console' ).append( message );
		});
	});
});
