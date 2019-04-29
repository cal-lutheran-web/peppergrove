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


	


function custom_request($request){

	global $wp_query;
	$post_types = get_post_types(array('_builtin'=>false,'public'=>true),'objects');

	foreach($post_types as $pt){
		
		add_filter('rest_'.$pt->name.'_query', 'custom_request_param', 99,2);
	}
	add_filter('rest_post_query', 'custom_request_param', 99,2);


}

add_filter('rest_api_init', 'custom_request', 99, 2);

?>