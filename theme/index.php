<?php get_template_part('templates/wrapper-header'); ?>

	<?php 
    if ( ! have_posts() ) get_search_form();//Load the search form if no posts 
    ?>
    
    <?php
    /* Display title based on type */ 
    $date_format = get_option( 'date_format' ); 
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));//Get author information
    
    if ( is_day() ) echo '<h1>Archive: '.get_the_time($date_format).'</h1>';
    elseif ( is_month() ) echo '<h1>Archive: '.get_the_time($date_format).'</h1>'; 
    elseif ( is_year() ) echo '<h1>Archive: '.get_the_time($date_format).'</h1>';
    elseif ( is_category() ) echo '<h1>Category: '.single_cat_title( '', false ).'</h1>';
    elseif ( is_tag() ) echo '<h1>Tag: '.single_tag_title( '', false ).'</h1>';
    elseif ( is_author() ) echo '<h1>Author Archives: '.$curauth->first_name.' '.$curauth->last_name.'</h1>';
    else echo '<h1 class="title-blog">Blog</h1>';
    ?>
    
    <?php
        get_template_part( 'templates/post-author' );//Load author profile stuff
    ?>
    
    <?php $posts = query_posts($query_string.'&orderby=date&order=DESC'); ?>
    <?php if( $posts ) : ?>
    
        <div class="post-container">
        
            <?php while ( have_posts() ) : the_post(); ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('post index-post'); ?>>
                    
                    <h2 class="editor editor-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>	
                    
                        <?php get_template_part( 'templates/post-info', 'index' );?>
                    
                    <div class="editor editor-content">
						<?php 
                        if( get_the_excerpt() ) the_excerpt();
                        else the_content(); 
                        ?>
                    </div><!-- end post-content -->
                    
                    <div class="post-pages">
                        <?php wp_link_pages(); //Pagination for multi paged posts?>
                    </div>
                    
                </article><!-- post -->
        
            <?php endwhile; ?>
            
		</div><!--end post-container -->
            
    <?php endif; ?>
    
    <div class="pagination bottom"><?php if (function_exists('wp_pagenavi')) wp_pagenavi(); //Call for the pagenavi pagination plugin?></div>

<?php get_template_part('templates/wrapper-footer'); ?>