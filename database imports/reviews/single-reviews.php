<?php get_template_part('templates/wrapper-header'); ?>

    <!-- The post loop -->    
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    
        <div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
            
            <h1 class="editor post-title"><?php the_title(); ?></h1> 
            
            <?php 
			if( function_exists('get_field') ) {
				if( get_field('review_your_name') ) echo '<div class="review-name">Review by: '.get_field('review_your_name').'</div>';
				if( get_field('review_star_rating') ) {
					echo '<div class="review_star_rating"><span class="review-score per'.get_field('review_star_rating').'"></span></div>';
					echo '<div class="review_text_rating">('.get_field('review_star_rating').' out of 5 stars)</div>';
				}
			}
			?>

            <div class="editor editor-content">
				<?php the_content(); ?>
            </div><!-- end editor -->
            
            <div class="post-pagination">
                <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:'), 'after' => '</div>' ) ); ?>
                <?php paginate_links(); //Post Pagination?>
            </div><!-- end post-pagination-->
              
        </div><!-- end post -->	
    
    <?php endwhile; // end of the loop. ?>

<?php get_template_part('templates/wrapper-footer'); ?>
