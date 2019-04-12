<?php 
	$post_types = get_post_types(array('_builtin'=>false,'public'=>true),'objects');
?>

<div class="wrap">
	<h2>Categories Info</h2>

	<?php
		foreach($post_types as $pt){

			echo '<h3>'.$pt->label.'</h3>';

			echo '<dl>';

			if(count($pt->taxonomies) > 0){

				$terms = get_terms(array(
					'taxonomy' => $pt->taxonomies[0]
				));
				
				foreach($terms as $term){
					echo '<dt>'.$term->name.' ('.$term->slug.')</dt>';
					echo '<dd>'.$term->taxonomy.'='.$term->term_id.'</dd>';
				}

			} else {
				echo '<dt>This post type does not have categories.</dt>';
			}

			echo '</dl>';

			
		}
	?>


	
</div>