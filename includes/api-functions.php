<?php

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