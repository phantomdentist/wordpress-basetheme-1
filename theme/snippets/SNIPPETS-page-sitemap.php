<?php get_header(); ?>

<div class="main-container">

    <div class="content">

        	<ul class="sitemap">
       			<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
            </ul>
    
    </div><!-- end content -->
    
    <div class="sidebar-right">
        <?php get_sidebar();?>
    </div><!-- end sidebar -->

<div class="clear"></div>

</div><!-- end main-container -->

<?php get_footer(); ?>
