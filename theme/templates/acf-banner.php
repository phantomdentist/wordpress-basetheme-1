<?php
if( function_exists('get_field') ) {

	if( get_field('banner_image') ) {
		
		$attachment_object = get_field('banner_image');
		$sliderSize = "banner";
		//$image_title = $attachment_object['title'];
		//var_dump($attachment_object);
		
		$image_url = wp_get_attachment_image_src( $attachment_object['id'], $sliderSize);
		
		echo '<div class="banner" style="background:url(\''.$image_url[0].'\') left top no-repeat"></div>';
	}
	
}
?>