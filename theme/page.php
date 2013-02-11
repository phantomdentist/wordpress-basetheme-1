<?php get_template_part('templates/wrapper-header'); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                        
        <h1 class="entry-title"><?php the_title(); ?></h1>
        
        <div class="editor"><?php the_content(); ?></div><!-- end editor -->
        
        <?php wp_link_pages( array( 'before' => '' .'Pages:', 'after' => '' ) ); ?>
    
    <?php endwhile; ?>

<?php get_template_part('templates/wrapper-footer'); ?>