<?php

if(is_user_logged_in()){

	$sites = get_blogs_of_user(wp_get_current_user()->data->ID);

	echo '<p>User: '.wp_get_current_user()->data->user_login.'<br /><em>'.wp_get_current_user()->roles[0].'</em></p>';

	echo '<ul>';
	foreach($sites as $site){
		echo '<li><a href="'.$site->siteurl.'/wp-admin/">'.$site->blogname.'</a></li>';
	}
	echo '</ul>';

} else {

	echo '<p>Not logged in</p>';
	echo '<p><a href="'.wp_login_url(get_permalink()).'">Login</a></p>';
}

?>