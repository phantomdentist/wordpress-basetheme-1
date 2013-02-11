<?php
if( function_exists('get_field') ){
 
	if(get_field('slider_item')): ?>
	
		<?php if(get_field('slide_interval')) 
		{
			$interval = get_field('slide_interval');
			$intervalMultiplied = $interval * 1000 ; 
		}
		else
		{
			$intervalMultiplied = '5000';
		}
		?>
	  
		<script type="text/javascript">
			$(window).load(function() {
				$('.flexslider').flexslider({
				  animation: "fade",
				  controlsContainer: ".flexslider-container",
				  directionNav: false,
				  slideshow: true,
				  slideshowSpeed: <?php echo $intervalMultiplied; ?>,
				  animationLoop: true,           
				  pauseOnAction: false,
				  pauseOnHover: true
			  });
			});
		</script>
		<div class="flexslider-container">
			<div class="flexslider">
				<ul class="slides">
					<?php while(the_repeater_field('slider_item')):
                    	
                         if( get_sub_field('slider_background_image') ) {
		
							$attachment_object = get_sub_field('slider_background_image');
							$sliderSize = "slider";
							//$image_title = $attachment_object['title'];
							//$image_alt = $attachment_object['alt'];
							//var_dump($attachment_object);
							
							$image_url = wp_get_attachment_image_src( $attachment_object['id'], $sliderSize);
						}
						?>	

						<li class="slider-item" style="background:url('<?php echo $image_url[0] ?>') no-repeat left top;">
							<?php if (get_sub_field('slider_link')) echo '<a class="slider-link" href="'.get_sub_field('slider_link').'"></a>'; ?>
						</li><!-- end slide-item -->       
					<?php endwhile; ?> 
				</ul>
			</div>                            
		</div>            
	<?php 
	endif; 

}
?>                                                                              