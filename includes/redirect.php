<?php
// add redirects admin page
	function add_menus(){
		add_menu_page( 'Redirects', 'Redirects', 'manage_options', 'post_type_redirects', 'admin_redirects', 'dashicons-external');
	}
	add_action('admin_menu', 'add_menus');

	function admin_redirects(){ 
		include '../admin-pages/redirect-page.php';
	}