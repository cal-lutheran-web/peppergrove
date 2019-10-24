<?php

// add support for campus_location ACF custom field
function acf_campus_locations_widget( $field ) {
	
	$location_data = json_decode(file_get_contents('http://earth.callutheran.edu/utilities/map/locations-json.php'));
	$location_array = array(
		'' => ''
	);

	foreach($location_data as $slug => $name){		
		$location_array[$name->slug] = $name->name;
	}
	
    $field['choices'] = $location_array;

    return $field;
    
}

add_filter('acf/load_field/name=campus_location', 'acf_campus_locations_widget');


// faculty search list
function acf_faculty_list_widget( $field ) {
	
	$faculty_data = json_decode(file_get_contents('http://earth.callutheran.edu/utilities/faculty/faculty-list-json.php'));
	$faculty_array = array(
		'' => ''
	);

	foreach($faculty_data as $slug => $name){		
		$faculty_array[$name->slug] = $name->name;
	}
	
    $field['choices'] = $faculty_array;

    return $field;
    
}

add_filter('acf/load_field/name=faculty_list', 'acf_faculty_list_widget');




?>