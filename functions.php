<?php

//  ini_set('display_errors', 1);
//  ini_set('display_startup_errors', 1);
//  error_reporting(E_ALL);

// add theme supports
add_theme_support('post-thumbnails');


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

	// add columns to admin post lists
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




	// add redirects admin page
	function add_menus(){
		add_menu_page( 'Redirects', 'Redirects', 'manage_options', 'post_type_redirects', 'admin_redirects', 'dashicons-external');
	}
	add_action('admin_menu', 'add_menus');

	function admin_redirects(){ 

?>
		<div class="wrap">
			<h2>Redirects</h2>

			<?php

			if(count($_POST) > 0) {
				update_option('clu_redirects', $_POST);
			} ?>

			<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
				<?php
				$post_types = get_post_types(array('_builtin'=>false,'public'=>true),'objects');
				$options = get_option('clu_redirects'); ?>

				<div style="margin-bottom: 1rem;">
					<label for="site_index" style="display: block; font-weight: bold;">Site Index</label>
					<input type="text" name="site_index" id="site_index" value="<?php echo $options['site_index']; ?>" style="width: 50%;">
				</div>
				
				<?php foreach($post_types as $post_type){ 
					$index_value = $options[$post_type->name.'_index'];
					$single_value = $options[$post_type->name.'_single'];
					
				?>
					<hr />
					<h3><?php echo $post_type->name; ?></h3>
				
					<div style="margin-bottom: 1rem;">
						<label for="<?php echo $post_type->name; ?>_index" style="display: block; font-weight: bold;">Index Page</label>
						<input type="text" name="<?php echo $post_type->name; ?>_index" id="<?php echo $post_type->name; ?>_index" value="<?php echo $index_value; ?>" style="width: 50%;">
					</div>
				
					<div style="margin-bottom: 1rem;">
						<label for="<?php echo $post_type->name; ?>_single" style="display: block; font-weight: bold;">Single Page</label>
						<input type="text" name="<?php echo $post_type->name; ?>_single" id="<?php echo $post_type->name; ?>_single" value="<?php echo $single_value; ?>" style="width: 50%;">
					</div>
				
					<?php if(isset($post_type->taxonomies[0])){ 
						$tax_value = $options[$post_type->name.'_tax'];
					?>
						<div style="margin-bottom: 1rem;">
							<label for="<?php echo $post_type->name; ?>_tax" style="display: block; font-weight: bold;">Category Page</label>
							<input type="text" name="<?php echo $post_type->name; ?>_tax" id="<?php echo $post_type->name; ?>_tax" value="<?php echo $tax_value; ?>" style="width: 50%;">
						</div>
					<?php } ?>
				
				<?php } ?>
				
					<input type="submit" value="Save" class="button button-primary button-large" style="margin-top: 3rem;">
			</form>

		</div>
	<?php }





// add Term ID to custom categories table
function my_custom_taxonomy_columns( $columns ){
	$columns['my_term_id'] = __('Term ID');
	return $columns;
}
add_filter('manage_edit-award_categories_columns', 'my_custom_taxonomy_columns');


function my_custom_taxonomy_columns_content( $content, $column_name, $term_id ){
    if ( 'my_term_id' == $column_name ) {
        $content = $term_id;
    }
	return $content;
}
add_filter('manage_award_categories_custom_column', 'my_custom_taxonomy_columns_content', 10, 3 );



// custom REST API parameters
// append request parameter with acf_ to access a custom field

function custom_request_param($args, $request){

	foreach($_GET as $key=>$value){
		if(strpos($key, 'acf_') !== false){
			$args['meta_query'] = array(
				array(
					'key'     => str_replace('acf_','',$key),
					'value'   => $_GET[$key],
					'compare' => '=',
				)
			);
		}
	}

	return $args;
}

add_filter('rest_venues_query', 'custom_request_param', 99, 2);








?>