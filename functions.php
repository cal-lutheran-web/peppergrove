<?php

//  ini_set('display_errors', 1);
//  ini_set('display_startup_errors', 1);
//  error_reporting(E_ALL);

// add theme supports
add_theme_support('post-thumbnails');
add_filter('acf/settings/remove_wp_meta_box', '__return_false');
// Enable the option show in rest
add_filter( 'acf/rest_api/field_settings/show_in_rest', '__return_true' );

// admin area functions
include 'includes/admin-area.php';

// extra admin page
include 'includes/extra-pages.php';

// rest API
include 'includes/api-functions.php';

// extra ACF stuff
include 'includes/acf-extras.php';






?>