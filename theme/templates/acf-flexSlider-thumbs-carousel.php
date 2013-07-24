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

				//Nav slider
				$('.flexslider-nav').flexslider({
				animation: "slide",
				controlNav: false,
				animationLoop: false,
				slideshow: false,
				itemWidth: 118,
				itemMargin: 4,
				asNavFor: '.flexslider'
				});
				
				//Main slider
				$('.flexslider').flexslider({
				  animation: "fade",
				  controlsContainer: ".flexslider-container",
				  directionNav: false,
				  controlNav: false,
				  slideshow: false,
				  slideshowSpeed: <?php echo $intervalMultiplied; ?>,
				  animationLoop: false,           
				  pauseOnAction: false,
				  pauseOnHover: true,
				  sync: ".flexslider-nav"
			  });
			});
		</script>
        
		<div class="flexslider-container">
			<div class="flexslider">
				<ul class="slides">
					<?php while(has_sub_field('slider_item')):
                    	
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
        
        <?php if ( count( get_field('slider_item') ) >= 2 ) { ?>
       	<div class="flexslider-nav-container clearfix">
        	<div class="flexslider-nav">
				<ul class="slides">
					<?php while(has_sub_field('slider_item')): ?>
                    
						<?php
						if( get_sub_field('slider_background_image') ) {
							$attachment_object = get_sub_field('slider_background_image');
							$sliderSize = "slider-thumb";
							$image_title = $attachment_object['title'];
							$image_alt = $attachment_object['alt'];
							//var_dump($attachment_object);
							$image_url = wp_get_attachment_image_src( $attachment_object['id'], $sliderSize);
						}
                        ?>
                    
                        <li class="slider-item">
                            <img class="slider-thumb" src="<?php echo $image_url[0] ?>" alt="<?php echo $image_alt ?>" />
                        </li><!-- end slide-item -->  
                    <?php endwhile; ?> 
            	</ul>
			</div>  
        </div> 
        <?php } ?>            
	<?php 
	endif; 

}
?>                                                                              