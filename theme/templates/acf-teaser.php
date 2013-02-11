<?php
if( function_exists('get_field') ) {

	if( get_field('teaser_repeater') ) {
		
		echo '<div class="teaser-container">';
		
		$x = 1;
		
			while( has_sub_field('teaser_repeater') ):
			
			if( $x % 2 == 0 ) $last = ' last';
			else $last = '';
				
				echo '<div class="teaser-item'.$last.'">';
				
				if( get_sub_field('teaser_title') ) echo '<h3>'.get_sub_field('teaser_title').'</h3>';
				
				if( get_sub_field('teaser_image') ) {
					
					$attachment_object = get_sub_field('teaser_image');
					$sliderSize = "subpage-thumb";
					$image_title = $attachment_object['title'];
					$image_alt = $attachment_object['alt'];
					//var_dump($attachment_object);
					
					$image_url = wp_get_attachment_image_src( $attachment_object['id'], $sliderSize);
					
					echo '<img class="teaser-thumb" src="'.$image_url[0].'" alt="'.$image_alt.'" title="'.$image_title.'"/>';	
				}
				
				if( get_sub_field('teaser_excerpt') ) echo '<p>'.get_sub_field('teaser_excerpt').'</p>';
				
				if( get_sub_field('teaser_link') ) echo '<a class="button-teaser" href="'.get_sub_field('teaser_link').'">Find out more</a>';
				
				
			
				echo '</div><!-- end teaser-item -->';
				
			$x++;
			
			endwhile;
			
		echo '</div><!-- end teaser-container -->';
	}	
}
?>