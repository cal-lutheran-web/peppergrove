<?php

// this script will return data to be used for a list of archives based on yearly or monthly
// URL parameter with ?return=json must be set for data to return as JSON array
// ?archive can be set to yearly or monthly

$archive_type = isset($_GET['archive']) ? $_GET['archive'] : 'yearly';

$archives = wp_get_archives(
	array(
	  'type' => $archive_type,
	  'post_type' => get_post_type(),
	  'echo' => false,
	  'format' => 'custom',
	  'before' => '',
	  'after' => ''
	)
);

$archive_list = explode('</a>', $archives);
$return_array = array();

foreach($archive_list as $a){
	$return_array[] = trim(strip_tags($a));
	
}

if(isset($_GET['return']) && $_GET['return'] == 'json'){

	header('Content-Type: application/json');
	print_r(json_encode(array_filter($return_array)));

}


?>