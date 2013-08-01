<?php get_template_part('templates/wrapper-header'); ?>

	<?php 
    if ( ! have_posts() ) get_search_form();//Load the search form if no posts 
    ?>

	<h1 class="title-blog">Reviews</h1>

    <?php $posts = query_posts($query_string.'&orderby=date&order=DESC'); ?>
    <?php if( $posts ) : ?>
    
        <div class="post-container">
        
            <?php while ( have_posts() ) : the_post(); ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('post clearfix'); ?>>
                        
                        <h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        
                        <?php 
						if( function_exists('get_field') ) {
							if( get_field('review_your_name') ) echo '<div class="review-name">Review by: '.get_field('review_your_name').'</div>';
							if( get_field('review_star_rating') ) {
								echo '<a href="'.get_permalink().'" class="review_star_rating"><span class="review-score per'.get_field('review_star_rating').'"></span></a>';
								echo '<div class="review_text_rating">('.get_field('review_star_rating').' out of 5 stars)</div>';
							}
						}
						?>	
									
                        <div class="editor editor-content">
                            <?php excerpt(21, 'Read more...'); ?>
                        </div><!-- end post-content -->
                    
                </article><!-- post -->
        
            <?php endwhile; ?>
            
		</div><!--end post-container -->
            
    <?php endif; ?>
    
    <div class="pagination bottom"><?php if (function_exists('wp_pagenavi')) wp_pagenavi(); //Call for the pagenavi pagination plugin?></div>

<?php get_template_part('templates/wrapper-footer'); ?>