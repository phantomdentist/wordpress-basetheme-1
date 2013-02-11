<?php get_header(); ?>

<div class="content">

	<?php the_post(); ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		
        <p>
			<?php get_search_form(); ?>
        </p>

		<h2>Archives by Month:</h2>
        <p>
            <ul>
                <?php wp_get_archives('type=monthly'); ?>
            </ul>
        </p>
        
        <h2>Archives by Year:</h2>
        <p>
            <ul>
                <?php wp_get_archives('type=yearly'); ?>
            </ul>
        </p>
		
		<h2>Archives by Subject:</h2>
        <p>
            <ul>
                 <?php wp_list_categories(); ?>
            </ul>
        </p>
        
        <h2>Archives by Tag:</h2>
        <p>
            <ul>
            <?php $tags = get_tags();
            if ($tags) {
                
                foreach ($tags as $tag) {
            echo '<li><a href="' . get_tag_link( $tag->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $tag->name ) . '" ' . '>' . $tag->name.'</a>, </li> ';
            }
            }
            ?>
            </ul>
        </p>

</div><!-- end content -->

<div class="sidebar-1">
	<?php get_sidebar();?>
</div><!-- end sidebar -->

<div class="clear"></div>

<?php get_footer(); ?>