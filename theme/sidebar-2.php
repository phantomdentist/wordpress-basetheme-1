<?php
	if (   ! is_active_sidebar( 'widget-area-2'  ))
	return;
?>

<?php if ( is_active_sidebar( 'widget-area-2' ) ) : ?>
    <div id="widget-area-2" class="widget-area sidebar-2">
        <ul>
            <?php dynamic_sidebar( 'widget-area-2' ); ?>
        </ul>
    </div>
<?php endif; ?>



