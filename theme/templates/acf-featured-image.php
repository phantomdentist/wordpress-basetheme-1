<?php 
if( function_exists('get_field') ){
	
	if( get_field('featured_image') ) {
		$attachment_object = get_field('featured_image');
		
		if( is_post_type_archive() || is_page( 'blog' ) )
		{
			$imageSize = "featured-thumb";
		}
		else
		{
			$imageSize = "featured";
		}
		
		$image_title = $attachment_object['title'];
		$image_alt = $attachment_object['alt'];
		//var_dump($attachment_object);
		
		$image_url = wp_get_attachment_image_src( $attachment_object['id'], $imageSize);
	}
}
?>	

<img class="featured-image" src="<?php echo $image_url[0]; ?>" alt="<?php echo $image_alt; ?>" title="<?php echo $image_title; ?>"/>