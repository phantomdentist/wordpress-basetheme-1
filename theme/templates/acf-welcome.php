<?php
if( function_exists('get_field') ) {
	if( get_field('welcome_title') || get_field('welcome_content') || get_field('welcome_link') ) {
		?>
        <div class="welcome-wrapper editor">
			<?php
            if( get_field('welcome_title') ) echo '<h2 class="welcome_title">'.get_field('welcome_title'),'</h2>';	
            if( get_field('welcome_content') ) echo '<div class="welcome_content">'.get_field('welcome_content'),'</div>';	
            if( get_field('welcome_link') ) echo '<a class="welcome_link" href="'.get_field('link').'">Find out more</a>';
            ?>
        </div><!-- end welcome-wrapper -->
        <?php
	}
}
