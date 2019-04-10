<div class="wrap">
	<h2>Redirects</h2>

	<?php

	if(count($_POST) > 0) {
		update_option('clu_redirects', $_POST);
	} ?>

	<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
		<?php
		$post_types = get_post_types(array('_builtin'=>false,'public'=>true),'objects');
		$options = get_option('clu_redirects'); ?>

		<div style="margin-bottom: 1rem;">
			<label for="site_index" style="display: block; font-weight: bold;">Site Index</label>
			<input type="text" name="site_index" id="site_index" value="<?php echo $options['site_index']; ?>" style="width: 50%;">
		</div>
		
		<?php foreach($post_types as $post_type){ 
			$index_value = $options[$post_type->name.'_index'];
			$single_value = $options[$post_type->name.'_single'];
			
		?>
			<hr />
			<h3><?php echo $post_type->name; ?></h3>
		
			<div style="margin-bottom: 1rem;">
				<label for="<?php echo $post_type->name; ?>_index" style="display: block; font-weight: bold;">Index Page</label>
				<input type="text" name="<?php echo $post_type->name; ?>_index" id="<?php echo $post_type->name; ?>_index" value="<?php echo $index_value; ?>" style="width: 50%;">
			</div>
		
			<div style="margin-bottom: 1rem;">
				<label for="<?php echo $post_type->name; ?>_single" style="display: block; font-weight: bold;">Single Page</label>
				<input type="text" name="<?php echo $post_type->name; ?>_single" id="<?php echo $post_type->name; ?>_single" value="<?php echo $single_value; ?>" style="width: 50%;">
			</div>
		
			<?php if(isset($post_type->taxonomies[0])){ 
				$tax_value = $options[$post_type->name.'_tax'];
			?>
				<div style="margin-bottom: 1rem;">
					<label for="<?php echo $post_type->name; ?>_tax" style="display: block; font-weight: bold;">Category Page</label>
					<input type="text" name="<?php echo $post_type->name; ?>_tax" id="<?php echo $post_type->name; ?>_tax" value="<?php echo $tax_value; ?>" style="width: 50%;">
				</div>
			<?php } ?>
		
		<?php } ?>
		
			<input type="submit" value="Save" class="button button-primary button-large" style="margin-top: 3rem;">
	</form>

</div>