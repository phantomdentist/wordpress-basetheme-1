<?php get_header(); ?>

		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php
		$authors = $wpdb->get_results('SELECT DISTINCT post_author FROM '.$wpdb->posts);
		if($authors):
			foreach($authors as $author):
			if (!$author->role == 'administrator') {
		?>
				<div class='author' id='author-<?php the_author_meta('user_login', $author->post_author); ?>'>
					<h2><?php the_author_meta('display_name', $author->post_author); ?></h2>
					
					<?php if(get_the_author_meta('description', $author->post_author)): ?>
					<div class='description'>
						<?php echo get_avatar(get_the_author_meta('user_email', $author->post_author), 80); ?>
						<p><?php the_author_meta('description', $author->post_author); ?></p>
					</div>
					<?php endif; ?>
					
					<?php
					$recentPost = new WP_Query('author='.$author->post_author.'&showposts=1');
					while($recentPost->have_posts()): $recentPost->the_post();
					?>
					<h3>Recent Post: <a href='<?php the_title();?>'><?php the_title(); ?></a></h3>
					<?php endwhile; ?>
			<?php } ?>
					
				<?php endforeach; endif; ?>

<?php get_footer(); ?>