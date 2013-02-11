<?php

	if (   ! is_active_sidebar( 'widget-area-1'  ))
	return;

?>

<?php if ( is_active_sidebar( 'widget-area-1' ) ) : ?>
				<div id="widget-area-1" class="widget-area sidebar-1">
					<ul>
						<?php dynamic_sidebar( 'widget-area-1' ); ?>
					</ul>
				</div>
<?php endif; ?>
