<?php
if( function_exists('get_field') ) {
	if( get_field('link') ) $link = '<a class="button-intro" href="'.get_field('link').'">Find out more</a>';
	else $link = '';
	if( get_field('intro') ) echo '<div class="introduction">'.get_field('intro').$link.'</div>';	
}
?>