<?php

//// Common template functions /////////////////////////////////////////////////////
	
	// make slug from string
	function slug($text){
		
		$text = strtolower($text);
		$text = trim($text);
		$text = preg_replace('/\s+/', '', $text);
		
		return $text;
		
	}

	// template for numbered pagination
	function show_pages($data){
		
		$total_pages = $data->headers->{'X-WP-TotalPages'};
		//$page_requested = $_GET['page'];
		$current_page = (isset($_GET['page'])) ? $_GET['page'] : '1';

		if($total_pages > 1){
		
		// echo pages li based on page total
		echo '<ul class="block-selector">';
		for($i = 1; $i <= $total_pages; ++$i) {
			
			$class = ($current_page == $i) ? 'class="current-page"' : '';

			$_GET['page'] = $i;
			$url_query = http_build_query($_GET);
						
			echo '<li><a href="?'.$url_query.'" '.$class.'>'.$i.'</a></li>';
		}
		echo '</ul>';
		
		$_GET['page'] = $current_page;
		
		}
	}
	
	
	
	// return data in a short item component
	function short_item($si_aside,$si_content,$si_options=null,$si_id=null){
		echo '<div class="short-item '.$si_options.'">';
		echo '<div class="short-item-aside">'.$si_aside.'</div>';
		echo '<div class="short-item-content">'.$si_content.'</div>';
		echo '</div>';
	}
	
	




	
	// accordion
	function accordion($title='Read More',$content='',$id=null){
		
		$id = ($id !== null) ? $id : '';
		
		$html = '
			<div class="accordion">
				<button class="accordion-button" aria-controls="'.$id.'-content" id="'.$id.'-button" aria-expanded="false">'.$title.'</button>
				<div role="region" class="accordion-content" id="'.$id.'-content" aria-labelledby="'.$id.'-button" aria-hidden="true">'.$content.'</div>
			</div>
		';
		
		return $html;
	}
	
	
	
	// tabs
	function tabs($tabs,$css='',$group_id=''){
		
		/* takes array with arrays for each tab, ex:
			array(
				array(
				 'title' => TAB BUTTON NAME,
				 'content' => TAB CONTENT
				),
				etc...
			)
		*/
		
		$css = ($css !== '') ? ' '.$css : '';
		$html_id = ($group_id !== '') ? ' id="'.$group_id.'"' : '';
		
		$tab_titles = '';
		$tab_content = '';
		
		foreach($tabs as $key=>$tab){
			$id = slug($tab['title']);
			
			$tab_titles .= '<li role="none"><button class="tab-title-button" id="'.$id.'" role="tab" aria-controls="'.$id.'-content">'.$tab['title'].'</button></li>';
			
			$tab_content .= '<div class="tab-content" role="tabpanel" tabindex="0" id="'.$id.'-content" aria-labelledby="'.$id.'">'.$tab['content'].'</div>';
		}
		
		$html = '
			<div class="tabs'.$css.'"'.$html_id.'>
				<ul role="tablist" class="tab-list">
				'.$tab_titles.'
				</ul>
				'.$tab_content.'
			</div>
		';
		
		
		return $html;
		
		
	}
	
	
	
	// featured columns
	// requires array with three arrays containing values for title, img, content, url, and link_button
	
	function featured_columns($columns){
	
		echo '
		<div class="three-column-feature">
			<div class="row flexrow">';
	
			foreach($columns as $key=>$item){
	
				$link = (isset($item['url']) && $item['url'] !== '') ? '<a class="btn" href="'. $item['url'] .'">'. $item['link_button'] .'</a>' : '';
	
				echo '
					<div class="col-sm-4">
						<div class="wrap-16x9"><img src="'.$item['img'].'" alt="'.$item['title'].'"></div>
						<h3>'.$item['title'].'</h3>
						'.$item['content'].'
						'.$link.'
					</div>
				';
			}
	
		echo '
			</div>
		</div>';
	
	}
	
	
?>