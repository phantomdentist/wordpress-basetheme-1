
<?php get_header(); ?>


<div class="left-sidebar">
<?php get_sidebar(1);?>
</div>

<div class="content">

<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>

      <!--<h1 class="page-title"><?php #echo $term->name; ?></h1>-->

      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

          <div class="post type-post hentry">
            <h2 class="entry-title">
              <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
                <?php the_title(); ?>
              </a>
            </h2>

            <div class="entry-meta">
              <span class="meta-prep meta-prep-author">Posted on</span>
              <a href="<?php echo get_permalink(); ?>" title="<?php the_time( 'g:i a' ); ?>" rel="bookmark">
              <span class="entry-date"><?php the_time( 'F j, Y' ); ?></span></a>
            </div><!-- .entry-meta -->

            <div class="entry-summary">
              <?php the_excerpt(); ?>
            </div><!-- .entry-summary -->
          </div>

        <?php endwhile; ?>
      <?php endif; ?>


<?php get_footer(); ?>

</div><!-- end content -->
