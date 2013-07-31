<?php
if( function_exists('get_field') ){
 
	if(get_field('carousel_item')): ?>
	
		<?php if(get_field('carousel_interval')) 
		{
			$interval = get_field('carousel_interval');
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
					<?php while( has_sub_field('carousel_item') ):
                    	
                         if( get_sub_field('image') ) {
		
							$attachment_object = get_sub_field('image');
							$sliderSize = "carousel";
							
							$image_url = wp_get_attachment_image_src( $attachment_object['id'], $sliderSize);
						}
						?>	

						<li class="slider-item" style="background:url('<?php echo $image_url[0] ?>') no-repeat left top;">
                        	<div class="slide-content">
                            	<div class="slide-content-background"></div>
                                <div class="slide-content-info">
                        			<?php if ( get_sub_field('title') ) echo '<h2 class="slider-title">'.get_sub_field('title').'</h2>'; ?>
                       				<?php if ( get_sub_field('content') ) echo '<div class="slider-content">'.get_sub_field('content').'</div>'; ?>
									<?php if ( get_sub_field('link') ) echo '<a class="slider-link" href="'.get_sub_field('link').'">Find out more</a>'; ?>
                                </div>
                            </div><!-- end slide-content -->   
						</li><!-- end slide-item -->       
					<?php endwhile; ?> 
				</ul>
			</div>                            
		</div>            
	<?php 
	endif; 
}
?>      