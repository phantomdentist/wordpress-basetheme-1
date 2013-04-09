<?php
/*////////////////////////////////////////////////////////////
Custom loop Paginated
////////////////////////////////////////////////////////////*/
global $query_string; // required
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

//Query posts must be in double quotes for this to work for some reason!
$posts = query_posts(
	"post_type=reviews'.
	'&orderby=date'.
	'&order=DESC'.
	'&posts_per_page=3'.
	'&paged=$paged"
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
