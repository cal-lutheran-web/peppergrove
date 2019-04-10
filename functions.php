<?php

//  ini_set('display_errors', 1);
//  ini_set('display_startup_errors', 1);
//  error_reporting(E_ALL);

// add theme supports
add_theme_support('post-thumbnails');

// admin area functions
include 'includes/admin-area.php';

// redirects admin page
include 'includes/redirect.php';

// rest API
include 'includes/api-functions.php'

?>