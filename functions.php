<?php

// add theme supports
add_theme_support('post-thumbnails');
add_filter('acf/settings/remove_wp_meta_box', '__return_false');

// admin area functions
include 'includes/admin-area.php';

// extra admin page
include 'includes/extra-pages.php';

// rest API
include 'includes/api-functions.php';

// extra ACF stuff
include 'includes/acf-extras.php';

// conejo front end framework
include 'includes/conejo-framework.php';




?>