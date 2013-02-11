<?php get_header(); ?>

<?php 
if ( ! have_posts() ) get_search_form(); //Load the search form if no posts
echo '<h1>Tag: '.single_tag_title( '', false ).'</h1>';/* Display title based on type */ 
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
            </div><!-- end post-content -->
            
            <div class="post-pages">
                <?php wp_link_pages(); //Pagination for multi paged posts?>
            </div>
                    
        </div><!-- post -->

	<?php endwhile; ?>
<?php endif; ?>

<div class="pagination bottom"><?php if (function_exists('wp_pagenavi')) wp_pagenavi(); //Call for the pagenavi pagination plugin?></div>

<?php get_footer(); ?>