<?php

// add redirects admin page
function add_menus(){

	// redirects
	add_menu_page( 'Redirects', 'Redirects', 'manage_options', 'post_type_redirects', function(){
		get_template_part('admin-pages/redirect-page');
	}, 'dashicons-external');

	// category info
	add_menu_page( 'Categories', 'Categories', 'manage_options', 'post_type_categories', function(){
		get_template_part('admin-pages/post-categories');
	}, 'dashicons-external');
	
}

add_action('admin_menu', 'add_menus');


?>