<?php get_template_part('templates/wrapper-header'); ?>

   	<h1><?php the_title(); ?></h
   
    <h2 id="pages">Pages</h2>
    <ul>
    <?php
    // Add pages you'd like to exclude in the exclude here
    wp_list_pages(
      array(
        'exclude' => '',
        'title_li' => '',
      )
    );
    ?>
    </ul>
    
    <h2 id="posts">Blog</h2>
    <ul>
    <?php
    // Add categories you'd like to exclude in the exclude here
    $cats = get_categories('exclude=');
    foreach ($cats as $cat) {
      echo "<li><h3>".$cat->cat_name."</h3>";
      echo "<ul>";
      query_posts('posts_per_page=-1&cat='.$cat->cat_ID);
      while(have_posts()) {
        the_post();
        $category = get_the_category();
        // Only display a post link once, even if it's in multiple categories
        if ($category[0]->cat_ID == $cat->cat_ID) {
          echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
        }
      }
      echo "</ul>";
      echo "</li>";
    }
    ?>
    </ul>
    
    <?php
	$post_type = 'post-type-name';
	$pt = get_post_type_object( $post_type );
	
	echo '<h2>'.$pt->labels->name.'</h2>';
	echo '<ul>';
	
	query_posts('post_type='.$post_type.'&posts_per_page=-1');
	while( have_posts() ) {
	the_post();
	echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
	}
	
	echo '</ul>';
	?>

<?php get_template_part('templates/wrapper-footer'); ?>