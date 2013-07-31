<?php
if( function_exists('get_field') ){
 
	if(get_field('fullpageslider_repeater')): ?>

		<div class="flexslider-fullpage-content-container">
			<div class="flexslider-fullpage-content">
				<ul class="slides">
                	<?php $x = 1; ?>
					<?php while(has_sub_field('fullpageslider_repeater')): ?>

						<li class="flexslider-fullpage-content-item">
                        	<div class="flexslider-fullpage-content-content-wrapper clearfix">
                            	<?php 
								if ( $x == 1 ) $h = '1';
								else $h = '2';
								?>
                       			<?php if ( get_sub_field('fullpageslider_title') ) echo '<h'.$h.' class="flexslider-fullpage-content-title">'.get_sub_field('fullpageslider_title').'</h'.$h.'>'; ?>
                            	<?php if ( get_sub_field('fullpageslider_content') ) echo '<div class="flexslider-fullpage-content-content">'.get_sub_field('fullpageslider_content').'</div>'; ?>
								<?php if ( get_sub_field('fullpageslider_link') ) echo '<a class="flexslider-fullpage-content-link" href="'.get_sub_field('fullpageslider_link').'">'.get_sub_field('fullpageslider_call_to_action').'</a>'; ?>
                            </div>
						</li><!-- end slide-item -->  
                       	<?php $x++; ?>     
					<?php endwhile; ?> 
				</ul>
			</div> 
            <div class="flexslider-controls-container"></div>                           
		</div>            
	<?php 
	endif; 
}
?>                                                                              