</div><!-- end wrapper-main -->

<footer class="footer">
	<div class="footer-content">
    
    	<div class="footer-left">
    		<nav class="nav-footer clearfix"><?php wp_nav_menu( array( 'theme_location' => 'menu-footer', 'container' => '') ); ?></nav>
    		<div class="company"><?php echo do_shortcode('[address separator=", "]'); ?>. Tel: <?php echo do_shortcode('[telephone]'); ?> <?php echo do_shortcode('[email]'); ?></div>
        </div><!-- end footer-left -->
        
        <div class="footer-right">
        </div><!-- end footer-right -->
        
        <div class="footer-bottom">
        	<span class="copyright">All Content &copy; <?php bloginfo('name'); ?> <?php $the_year = date("Y"); echo $the_year;?></span>
            <a href="http://www.tomango.co.uk/" class="credit">Web design in Sussex</a>
        </div><!-- end footer-bottom -->
        
	</div><!-- end footer-content -->
</footer><!-- end footer -->

<?php wp_footer();?>

</body>
</html>
