<?php
/*////////////////////////////////////////////////////////////
Custom loop
////////////////////////////////////////////////////////////*/
global $query_string; // required
$posts = query_posts(
	'post_type=post'.
	'&orderby=date'.
	'&order=DESC'.
	'&posts_per_page=1'
);
?>

<?php if (have_posts()): ?>

	<div class="-container">

		<?php while(have_posts()): ?>
    
            <article class="">
        
                <?php the_post(); ?>
    
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            
            </article><!-- end -->
                                    
        <?php endwhile; ?>
    
    </div><!-- end -container -->
    
<?php endif; ?>

<?php  wp_reset_query(); // reset the query ?> 
