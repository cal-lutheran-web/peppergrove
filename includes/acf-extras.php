<?php

// add support for campus_location ACF custom field
function my_acf_load_field( $field ) {
	
	$location_data = json_decode(file_get_contents('https://earth.callutheran.edu/utilities/map/locations-json.php'));
	$location_array = array(
		'' => ''
	);

	foreach($location_data as $slug => $name){		
		$location_array[$name->slug] = $name->name;
	}
	
    $field['choices'] = $location_array;

    return $field;
    
}

add_filter('acf/load_field/name=campus_location', 'my_acf_load_field');

?>