<?php

if(function_exists('get_field')){
	
	if ( get_field('facebook_link', 'options') || get_field('twitter_link', 'options') || get_field('linkedin_link', 'options') || get_field('youtube_channel_link', 'options') ) {
		
		echo '<div class="social-container">';
	
			if( get_field('facebook_link', 'options') ) echo '<a class="social facebook" href="'.get_field('facebook_link', 'options').'"></a>';
		
			if( get_field('twitter_link', 'options') ) echo '<a class="social twitter" href="'.get_field('twitter_link', 'options').'"></a>';
		
			if( get_field('linkedin_link', 'options') ) echo '<a class="social linkedin" href="'.get_field('linkedin_link', 'options').'"></a>';
		
			if( get_field('youtube_channel_link', 'options') ) echo '<a class="social youtube" href="'.get_field('youtube_channel_link', 'options').'"></a>';
		
		echo '</div><!-- end social-container -->';
	
	}
		
}

?>
	