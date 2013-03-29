<?php
global $post;// if outside the loop
$parent_id = $post->ID;

$pages = get_pages( array( 'sort_column' => 'menu_order', 'child_of' => $parent_id ) );

if ( is_array( $pages ) ) {
	
	echo '<div class="subpage-container clearfix">';
	
		$x = 1;

		foreach ( $pages as $page ): 
		
			$currentID = $page->ID;
			
			if( $x % 2 == 0 ) $last = 'last';
			else $last = '';
			
			echo '<div class="post '.$last.'">';
			
				echo '<div class="content-left">';
					echo '<h2><a href="'.get_permalink( $currentID ).'" rel="bookmark">'.get_the_title( $currentID ).'</a></h2>';
					echo '<a class="view-this-x page" href="'.get_permalink( $currentID ).'">View this page</a>';
				echo '</div><!-- end content-left -->';

				if( get_field('featured_image', $currentID) ) {
					
					$attachment_object = get_field('featured_image', $currentID);
					$sliderSize = "subpage-thumb";
					$image_title = $attachment_object['title'];
					$image_alt = $attachment_object['alt'];
					//var_dump($attachment_object);
					
					$image_url = wp_get_attachment_image_src( $attachment_object['id'], $sliderSize);
					
					$permalink = get_permalink($currentID);
					echo '<div class="subpage-thumb"><div class="image-cover"></div><a href="'.$permalink.'" ><img src="'.$image_url[0].'" alt="'.$image_alt.'" title="'.$image_title.'"/></a></div>';
				}	
			
			echo '</div><!-- end subpage-teaser-item -->';
			
			$x++;
			
		endforeach;
		
	echo '</div><!-- end subpage-teaser-container -->';
		
}
?>