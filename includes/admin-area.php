<?php

// check if not an admin
$cur_user = wp_get_current_user();
$user_role = $cur_user->roles[0];




// add custom CSS for all users
function admin_style() {
	wp_enqueue_style('admin-styles', get_template_directory_uri().'/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');



// custom logo in admin bar for all users
function admin_bar_render_global(){
	global $wp_admin_bar;
	$wp_admin_bar->remove_node('wp-logo');
	$wp_admin_bar->add_node(array(
		"id" => "clu-dashboard",
		"meta" => array(
			"html" => "<img src=\"".get_bloginfo('template_url')."/web-dashboard.svg\" title=\"Web Dashboard\" class=\"web-dashboard-title\" />"
		)
	));
}
add_action( 'wp_before_admin_bar_render', 'admin_bar_render_global',1 );





// for everyone but admin level users
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
	function admin_bar_render() {
		global $wp_admin_bar;
		//$wp_admin_bar->remove_node('wp-logo');
		$wp_admin_bar->remove_menu('updates');
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('edit');
		$wp_admin_bar->remove_menu('new-content');
		$wp_admin_bar->remove_menu('my-account');
		$wp_admin_bar->remove_menu('site-name');
	}
	add_action( 'wp_before_admin_bar_render', 'admin_bar_render' );
	
	
	

}




// add post thumbnail column to admin post lists
add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);

function posts_columns($defaults){
	$defaults['post_thumbs'] = __('Featured Image');

	$acf_fields = get_field_objects();

	foreach($acf_fields as $key=>$field){
		if($field['type'] == 'group'){
			foreach($field['value'] as $subkey=>$subfield){
				$fullkey = $key.'_'.$subkey;
				$subname = get_field_object($fullkey);

				$defaults['acf_'.$fullkey] = __($subname['label']);
			}
		} else {
			$defaults['acf_'.$key] = __($field['label']);
		}
	}

	return $defaults;
}

function posts_custom_columns($column_name, $id){
	if($column_name === 'post_thumbs'){
		echo the_post_thumbnail( array(64, 64) );
	}

	if(strpos($column_name,'acf_') === 0){
		$field_name = str_replace('acf_','',$column_name);

		echo is_array(get_field($field_name)) ? substr(get_field($field_name)['label'], 0, 60) : substr(get_field($field_name), 0, 60);
		
	}
}



// add sortable admin columns

add_action( 'admin_init', 'admin_init' );
function admin_init(){

	$post_types = get_post_types(array('_builtin'=>false,'public'=>true),'objects');

	foreach($post_types as $pt){
		add_filter( 'manage_edit-'.$pt->name.'_sortable_columns', 'slug_title_not_sortable' );
		
	}

	

}


function slug_title_not_sortable( $cols ) {

	$acf_fields = get_field_objects();

	foreach($acf_fields as $key=>$field){
		if($field['type'] == 'group'){
			foreach($field['value'] as $subkey=>$subfield){
				$fullkey = $key.'_'.$subkey;
				$subname = get_field_object($fullkey);

				$cols['acf_'.$fullkey] = $subname['name'];
			}
		} else {
			$cols['acf_'.$key] = $field['name'];
		}
	}
	
	return $cols;
}



?>