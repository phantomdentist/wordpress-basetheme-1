<?php
//Requires jquery.tools.scrollable.fixed.js
//Requires shadowbox

if( function_exists('get_field') ) {
?>

<script>
Shadowbox.init();
</script>

<div class="carousel-wrapper">

    <div class="browse-container">
        <a class="prev browse left"></a>
        <a class="next browse right"></a>
    </div><!-- end browse-container -->
    
    <div class="carousel-container">
    
        <ul class="items">
        
        	<?php
			
			if( get_field('carousel_item') ):
			
				while( has_sub_field('carousel_item') ):
				
					$attachment_object = get_sub_field('carousel_image');
					$imageSize = "carousel-thumb";
					$image_title = $attachment_object['title'];
					$image_alt = $attachment_object['alt'];
					$image_rawUrl = $attachment_object['url'];
					
					$image_url = wp_get_attachment_image_src( $attachment_object['id'], $imageSize);
				
					echo 
					'<div class="item"><!-- end item -->
						<a href="'.$image_rawUrl.'" rel="shadowbox[Gallery]">
							<img src="'.$image_url[0].'"/>
						</a>
					</div><!-- end item -->';
				
				endwhile;
			
			endif;
			
			?>	   
        
        </ul><!-- end items -->
    
    </div><!-- end scrollable-carousel-container -->  
    
    <script>
    // execute your scripts when the DOM is ready. this is mostly a good habit
    jQuery(function($) {
        $(function() {
            // initialize scrollable
            $(".carousel-container").scrollable({circular:false, visible:5});
        });
    });
    </script>

</div><!-- end carousel-wrapper -->

<?php
}
?>