<?php get_header(); ?>

<?php 
//Load the search form if no posts
if ( ! have_posts() ) get_search_form(); 
?>

<?php
/* Display title based on type */ 
$date_format = get_option( 'date_format' ); 
if (is_day()) echo '<h2>Archive for'.get_the_time($date_format).'</h2>';
elseif (is_month()) echo '<h2>Archive for'.get_the_time($date_format).'</h2>'; 
elseif (is_year()) echo '<h2>Archive for'.get_the_time($date_format).'</h2>';
?>

<?php $posts = query_posts($query_string.'&orderby=date&order=DESC'); ?>
<?php if( $posts ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
            <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>	
            
            <div class="postmeta-info">
				<?php get_template_part( 'templates/post-info' );?>
            </div>
            
            <div class="post-content">
			    <?php get_template_part( 'templates/content-custom' );?>
            </div>
            
            <div class="post-pages">
				<?php wp_link_pages(); //Pagination for multi paged posts?>
            </div>
                    
        </div><!-- post -->

	<?php endwhile; ?>
<?php endif; ?>

<div class="pagination bottom"><?php if (function_exists('wp_pagenavi')) wp_pagenavi(); //Call for the pagenavi pagination plugin?></div>

<?php get_footer(); ?>