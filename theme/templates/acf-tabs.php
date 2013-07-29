<?php
if( function_exists('get_field') ) {
	if( get_field('tabs_repeater') ) { ?>
		<script>
		$(function() {
		$( "#tabs" ).tabs();
		});
		</script>
		
		<div id="tabs">
            <ul>
            <?php $x = 1; ?>
            <?php while( has_sub_field('tabs_repeater') ) { ?>
                <li><a href="#tab-<?php echo $x; ?>"><?php echo get_sub_field('tab_title'); ?></a></li>
            <?php $x++; } ?>
            </ul>
            
            <?php $x = 1; ?>
            <?php while( has_sub_field('tabs_repeater') ) { ?>
                <div id="tab-<?php echo $x; ?>"><?php echo get_sub_field('tab_content'); ?></a></div>
            <?php $x++; } ?>
		</div>
		<?php
		}
	}
	?>

<!--
css
	.ui-tabs
	{
		position: relative;
	}
	.ui-tabs .ui-tabs-panel 
	{
		display: block;
	}
	.ui-tabs .ui-tabs-hide
	{
		display: none!important;
	}
-->
