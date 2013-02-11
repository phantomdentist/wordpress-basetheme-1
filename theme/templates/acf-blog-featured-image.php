<?php
if( function_exists('get_field') ) {

	if( get_field('blog_featured_image') ) {
		
		$attachment_object = get_field('blog_featured_image');
		$sliderSize = "blog-thumb";
		$image_title = $attachment_object['title'];
		$image_alt = $attachment_object['alt'];
		//var_dump($attachment_object);
		
		$image_url = wp_get_attachment_image_src( $attachment_object['id'], $sliderSize);
		
		$permalink = get_permalink($post->ID);
		echo '<a href="'.$permalink.'"><img class="blog-thumb" src="'.$image_url[0].'" alt="'.$image_alt.'" title="'.$image_title.'"/></a>';
	}	
}
?>