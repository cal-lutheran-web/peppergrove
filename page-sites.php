<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Log into your Dashboard | Cal Lutherean</title>

	<link rel="stylesheet" href="https://www.callutheran.edu/_resources/css/styles.css">

	<style>
		body {
			background: #fcf4e0;
		}

		.top-header {
			padding: 2rem 0;
		}

		main.container {
			margin-top: 2rem;
			margin-bottom: 2rem;
			padding: 2rem;
		}

		@media (prefers-color-scheme: dark){
			body {
				background: #1d122f;
				color: white;
			}

			a, ul > li a {
				color: #ffc222;
			}

			.bg-white {
				background: #3b2360;
			}

			h1, h2 {
				color: #dfebf1;
			}
		}

	</style>
</head>
<body>

	<header class="bg-purple top-header centered">
		
		<img src="https://www.callutheran.edu/_resources/img/logos/primary-reverse.svg" alt="California Lutheran University" />
		
	</header>

	<main class="container bg-white">

		<h1>Sign-in to your Dashboard</h1>

		<?php

			if(is_user_logged_in()){

				$sites = get_blogs_of_user(wp_get_current_user()->data->ID);

				echo '<p>You are signed-in as '.wp_get_current_user()->data->user_login.'</p>';

				echo '<h2>Your Dashboards</h2>';

				echo '<ul>';
				foreach($sites as $site){
					echo '<li><a href="'.$site->siteurl.'/wp-admin/">'.$site->blogname.'</a></li>';
				}
				echo '</ul>';

			} else {

				echo '<h2>You are not signed-in</h2>';
				echo '<p><a href="'.wp_login_url(get_permalink()).'" class="btn green icon-user">Sign In</a></p>';
			}

		?>
	
	</main>

</body>
</html>