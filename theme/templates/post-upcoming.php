<div id="zukunft">
	<div id="zukunft_header"><p>Future events</p></div>

	<?php query_posts('showposts=10&post_status=future'); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div >
			<p class><b><?php the_title(); ?></b><?php edit_post_link('e',' (',')'); ?><br />

			<span class="datetime"><?php the_time('j. F Y'); ?></span></p>
		</div>
	<?php endwhile; else: ?><p>No future events scheduled.</p><?php endif; ?>

</div>