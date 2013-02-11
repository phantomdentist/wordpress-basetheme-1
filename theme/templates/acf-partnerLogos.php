<?php

if( function_exists('get_field') ){

	if( get_field('logo_repeater','options') ):
	
		echo '<div class="partner-logos">';
	
			echo '<div class="partner-logos-content">';
		
				while( has_sub_field('logo_repeater','options') ):
				
					if( get_sub_field('logo_link') ) echo '<a href="'.get_sub_field('logo_link').'">';
						if( get_sub_field('logo_image') )
						{
							
							$attachment_object = get_sub_field('logo_image');
							$sliderSize = "partner-logo";
							$image_title = $attachment_object['title'];
							$image_alt = $attachment_object['alt'];
							//var_dump($attachment_object);
							
							$image_url = wp_get_attachment_image_src( $attachment_object['id'], $sliderSize);
							
							$permalink = get_permalink($post->ID);
							echo '<a href="'.get_sub_field('logo_link').'"><img class="blog-thumb" src="'.$image_url[0].'" alt="'.$image_alt.'" title="'.$image_title.'"/></a>';
							
						}
					if( get_sub_field('logo_link') ) echo '</a>';
			
				endwhile;
			
			echo '</div>';
			
		echo '</div>';
	
	endif;

}

?>