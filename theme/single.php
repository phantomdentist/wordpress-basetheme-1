<?php get_template_part('templates/wrapper-header'); ?>

    <!-- The post loop -->    
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    
        <div id="post-<?php the_ID(); ?>" <?php post_class('post single-post'); ?>>
                      
            <h1 class="editor editor-title"><?php the_title(); ?></h1> 
            
            <div class="postmeta-info">
                <?php get_template_part( 'templates/post-info' );?>
            </div><!-- end postmeta-info --> 
                   
            <div class="editor editor-content"><?php the_content(); ?></div><!-- end editor -->
            
            <div class="post-pagination">
                <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:'), 'after' => '</div>' ) ); ?>
                <?php paginate_links(); //Post Pagination?>
            </div><!-- end post-pagination-->
              
        </div><!-- end post -->	
    
        <div class="post-navigation bottom">
            <?php previous_post_link(); ?>
            <?php next_post_link(); ?>
        </div><!-- end post-navigation-->
        
        <div class="post-comments">
            <?php comments_template( '', true ); ?>
        </div><!-- end post-comments-->
    
    <?php endwhile; // end of the loop. ?>

<?php get_template_part('templates/wrapper-footer'); ?>
