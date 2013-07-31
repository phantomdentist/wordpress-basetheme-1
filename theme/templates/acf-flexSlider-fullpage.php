<?php
if( function_exists('get_field') ){
 
	if(get_field('fullpageslider_repeater')): ?>

		<script>
			$(window).load(function() {
				$('.flexslider-fullpage-content').flexslider({
				  directionNav: false,
				  controlNav: false,  
				  slideshowSpeed: 10000,            
			  });
			});
		</script>

		<script>
			$(window).load(function() {
				$('.flexslider-fullpage').flexslider({
				  animation: "fade",
				  controlsContainer: ".flexslider-controls-container",
				  directionNav: false,
				  slideshow: true,
				  slideshowSpeed: 10000,
				  animationLoop: true,           
				  pauseOnAction: true,
				  pauseOnHover: false,
				  controlNav: true,                 
				  prevText: "",
			      nextText: "",
				  sync: ".flexslider-fullpage-content"  
			  });
			});
		</script>
		<div class="flexslider-fullpage-container">
			<div class="flexslider-fullpage">
				<ul class="slides">
					<?php while(has_sub_field('fullpageslider_repeater')):
                    	
                         if( get_sub_field('fullpageslider_image') ) {
							$attachment_object = get_sub_field('fullpageslider_image');
							$sliderSize = "slider-fullpage";
							$image_url = wp_get_attachment_image_src( $attachment_object['id'], $sliderSize);
						}
						?>	
						<li class="slider-fullpage-item" style="background-image:url('<?php echo $image_url[0] ?>');"></li><!-- end slide-item -->       
					<?php endwhile; ?> 
				</ul>
			</div>                            
		</div>            
	<?php 
	endif; 

}
?>                                                                              