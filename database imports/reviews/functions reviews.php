<?php
//This filter is executed right before the post is created, allowing post data to be manipulated before the post is created
add_filter("gform_post_data_3", "set_post_terms", 10, 3); 
//post_data is the wordpress array used to create a post, form is the gravity form in the backend, entry is the info submitted by the form to the entries table     
function set_post_terms($post_data, $form, $entry){

		//push the new taxonomy college into the existing post_meta tax_input key
		$post_data["post_type"] = 'reviews';
		
		//return the changed data to use when the post is created
		return $post_data; 
	
}