<?php
// The template for displaying Search Results pages.
?>

<?php get_template_part('templates/wrapper-header'); ?>

	<?php if ( have_posts() ) : ?>
        <h1><?php printf( __( 'Search Results for: %s'), '' . get_search_query() . '' ); ?></h1>
        
        <?php
        while ( have_posts() ) : the_post(); ?>
        
            <div id="post-<?php the_ID(); ?>" <?php post_class($firstclass); ?>>
            
                <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>	
                
                    <?php get_template_part( 'postmeta-info' ); ?>
                    
                    <?php the_excerpt(); ?>
                    
            </div> <!-- post -->
            
        <?php endwhile;?>
    
        <?php else : ?>
            <div id="post-0" class="post no-results not-found">
                <h2>Nothing Found</h2>
                
                <p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
                    <?php get_search_form(); ?>
                
            </div><!-- #post-0 -->
    <?php endif; ?>

<?php get_template_part('templates/wrapper-footer'); ?>
