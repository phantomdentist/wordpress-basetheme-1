<?php get_header(); ?>

<?php if ( ! have_posts() ) get_search_form(); //Load the search form if no posts?>

<?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>

<h1>Author Archives: <?php echo $curauth->first_name.' '.$curauth->last_name; ?></h1>

<?php
get_template_part( 'templates/post-author' );
?>

<?php $posts = query_posts($query_string.'&orderby=date&order=DESC'); ?>
<?php if( $posts ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
            <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                
            <div class="postmeta-info">
                <?php get_template_part( 'templates/post-info', 'author' );?>
            </div><!-- end postmeta-info-->
            
            <div class="post-content">
                <?php get_template_part( 'templates/content-custom' );?>
            </div><!-- end post-content -->
            
            <div class="post-pages"><?php wp_link_pages(); //Pagination for multi paged posts?></div>
                    
        </div><!-- end post -->

	<?php endwhile; ?>
<?php endif; ?>

<div class="pagination bottom"><?php if (function_exists('wp_pagenavi')) wp_pagenavi(); //Call for the pagenavi pagination plugin?></div>

<?php get_footer(); ?>