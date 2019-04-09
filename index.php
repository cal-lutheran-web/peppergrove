<?php

$options = get_option('clu_redirects');	

if(is_home()){
	$url = $options['site_index'];

	
	if($url !== null){
		header("Location: ".$url);
	} 
}

if(is_single()){
	$post_type = get_post_type();
	$url = $options[$post_type.'_single'];
	
	if($url !== null){
		header("Location: ".$url.$post->ID);
	}
}


if(is_archive()){
	$tax = get_query_var('taxonomy');
	$term_id = get_term_by('slug',$term,$tax)->term_id;
	
	$post_type = get_post_type();
	$url = $options[$post_type.'_tax'];
	
	if($url !== null){
		header("Location: ".$url.$term_id);
	}
}


?>