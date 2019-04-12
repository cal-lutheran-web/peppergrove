<?php

// add redirects admin page
function add_menus(){
	add_menu_page( 'Redirects', 'Redirects', 'manage_options', 'post_type_redirects', 'admin_redirects', 'dashicons-external');
	add_menu_page( 'Categories', 'Categories', 'manage_options', 'post_type_categories', function(){
		get_template_part('admin-ages/post-categories');
	}, 'dashicons-external');
}
add_action('admin_menu', 'add_menus');

function admin_redirects(){ 
	get_template_part('admin-pages/redirect-page');
}

?>