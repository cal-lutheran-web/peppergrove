<?php

// check if not an admin
$cur_user = wp_get_current_user();
$user_role = $cur_user->roles[0];
	
if($user_role !== 'administrator'){

	// remove stuff from sidebar in dashboard
	function remove_menus() {
		remove_menu_page('index.php');
		remove_menu_page('edit.php');
		remove_menu_page('edit.php?post_type=page');
		remove_menu_page('edit-comments.php');
		remove_menu_page('themes.php');
		remove_menu_page('plugins.php');
		remove_menu_page('users.php');
		remove_menu_page('tools.php');
		remove_menu_page('options-general.php');
		remove_menu_page('edit.php?post_type=acf-field-group');
		remove_menu_page('admin.php');
		remove_menu_page('admin.php?page=post_type_redirects');
		remove_menu_page('admin.php?page=post_type_categories');

		remove_meta_box('dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box('dashboard_activity', 'dashboard', 'normal' );
		remove_meta_box('welcome-panel', 'dashboard', 'normal');
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box('dashboard_plugins', 'dashboard', 'normal' );  
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box('dashboard_primary', 'dashboard', 'side' );
		remove_meta_box('dashboard_secondary', 'dashboard', 'side' );
		
	}
	add_action('admin_menu', 'remove_menus');

	
	// hide CPT in sidebar
	remove_action( 'admin_menu', 'cptui_plugin_menu' );
	
	
	// hide stuff in admin bar
	function mytheme_admin_bar_render() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('updates');
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('edit');
		$wp_admin_bar->remove_menu('new-content');
		$wp_admin_bar->remove_menu('my-account');
		$wp_admin_bar->remove_menu('site-name');
	}
	add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );
	
	
	

}




// add post thumbnail column to admin post lists
add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);

function posts_columns($defaults){
	$defaults['post_thumbs'] = __('Featured Image');
	return $defaults;
}

function posts_custom_columns($column_name, $id){
	if($column_name === 'post_thumbs'){
		echo the_post_thumbnail( array(64, 64) );
	}
}




?>