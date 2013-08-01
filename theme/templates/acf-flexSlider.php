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
				 	directionNav: false,
					controlNav: true,
					controlsContainer: ".flexslider-container",
				  	slideshow: true,
				  	slideshowSpeed: <?php echo $intervalMultiplied; ?>,
				  	animationLoop: true,           
				  	pauseOnAction: false,
				 	pauseOnHover: true,
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
                        	<?php if( get_sub_field('title') ): ?>
                                <div class="slide-content">
                                    <?php if ( get_sub_field('title') ) echo '<h2 class="slide-title">'.get_sub_field('title').'</h2>'; ?>
                                    <?php if ( get_sub_field('subtitle') ) echo '<div class="slide-subtitle">'.get_sub_field('subtitle').'</div>'; ?>
                                    <?php if ( get_sub_field('excerpt') ) echo '<div class="slide-excerpt">'.get_sub_field('excerpt').'</div>'; ?>
                                    <?php if ( get_sub_field('link') ) echo '<a class="slide-link" href="'.get_sub_field('link').'">Find out more</a>'; ?>
                                </div><!-- end slide-content -->   
                            <?php endif; ?>
						</li><!-- end slide-item -->       
					<?php endwhile; ?> 
				</ul>
			</div>                            
		</div>            
	<?php 
	endif; 
}
?>                                                                              
?>      