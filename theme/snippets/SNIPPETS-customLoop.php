<?php
$args = array ( 'post_type' => 'post' , 'posts_per_page' => 3 , 'order' => 'DESC' , 'orderby' => 'date' );
$the_query = new WP_Query( $args );
                                
if( $the_query->have_posts() ): 
?>

	<div class="news-container">

		<?php
        while ( $the_query->have_posts() ) :
         $the_query->the_post();
         ?>
            <article>
                <h3><?php the_title(); ?></h3>
                <?php
                $date_format = get_option( 'date_format' );
                $time_format = get_option( 'time_format' );
                ?>
                <div>
                    <span class="date-posted">Posted on <?php the_time($date_format); ?></span>
                    <span class="author">by <strong><?php the_author_posts_link(); ?></strong></span>
                </div>
                <?php custom_excerpt(42, 'Read more...') ?>
            </article>
    
        <?php
        endwhile;	
        ?>
    
    </div><!-- end news-container -->
    
<?php
endif;
?>

<?php  wp_reset_query(); // reset the query ?> 