<?php

// custom REST API parameters


function custom_request_param($args, $request){
	// query based on acf_ prefix on custom field name
	foreach($_GET as $key=>$value){

		// acf equal to
		if(strpos($key, 'acf_') !== false){
			$args['meta_query'] = array(
				array(
					'key'     => str_replace('acf_','',$key),
					'value'   => $_GET[$key],
					'compare' => '=',
				)
			);
		}

		// acf greater than
		else if(strpos($key, 'gt_acf_') !== false){
			$args['meta_query'] = array(
				array(
					'key'     => str_replace('gt_acf_','',$key),
					'value'   => $_GET[$key],
					'compare' => '>',
				)
			);
		}

		// acf equal and greater than
		else if(strpos($key, 'gte_acf_') !== false){
			$args['meta_query'] = array(
				array(
					'key'     => str_replace('gte_acf_','',$key),
					'value'   => $_GET[$key],
					'compare' => '>=',
				)
			);
		}

		// acf less than
		else if(strpos($key, 'lt_acf_') !== false){
			$args['meta_query'] = array(
				array(
					'key'     => str_replace('lt_acf_','',$key),
					'value'   => $_GET[$key],
					'compare' => '<',
				)
			);
		}

		// acf equal and less than
		else if(strpos($key, 'lte_acf_') !== false){
			$args['meta_query'] = array(
				array(
					'key'     => str_replace('lte_acf_','',$key),
					'value'   => $_GET[$key],
					'compare' => '<=',
				)
			);
		}


		


	}
	
	// custom_orderby parameter based on custom field 
	if(isset($_GET['custom_orderby'])){
		$args['orderby'] = 'meta_value';
		$args['meta_key'] = $_GET['custom_orderby'];
	}

	return $args;
}


// add custom_orderby request param to orderby
function custom_request_query($params,$post_type){
	$new_order = $_GET['custom_orderby'];
	$params['orderby']['enum'][] = $new_order;
	
	return $params;
}


	

// setup options on custom post types
function custom_request($request){

	global $wp_query;
	$post_types = get_post_types(array('_builtin'=>false,'public'=>true),'objects');

	foreach($post_types as $pt){
		// add to existing query params
		add_filter('rest_'.$pt->name.'_collection_params', 'custom_request_query', 99, 2 );
		
		// make new query param with acf_ prefix
		add_filter('rest_'.$pt->name.'_query', 'custom_request_param', 99,2);
	}
	add_filter('rest_post_query', 'custom_request_param', 99,2);


}

add_filter('rest_api_init', 'custom_request', 99, 2);



?>
