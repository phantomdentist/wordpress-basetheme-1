<?php
$date_format = get_option( 'date_format' );
$time_format = get_option( 'time_format' );
?>
<div class="postmeta-info">
    <span class="postinfo-date-time-posted">Posted on <?php the_time($date_format) ?> at <?php the_time($time_format) ?></span>
    <span class="postinfo-author-post-link">by <?php the_author_posts_link() ?></span>
    <span class="postinfo-category">in the categories <?php the_category(' | '); ?></span>
    <span class="postinfo-tags"><?php the_tags('with the tags '); ?></span>
    <span class="postinfo-comment-number">and <?php comments_popup_link( 'No comments yet', '1 comment', '% comments', 'comments-link', 'Comments are off for this post'); ?></span>
</div><!-- end postmeta-info -->
