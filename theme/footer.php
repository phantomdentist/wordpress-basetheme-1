</div><!-- end wrapper-main -->

    <footer class="footer">
        <div class="footer-content">
            <nav class="nav-footer clearfix"><?php wp_nav_menu( array( 'theme_location' => 'menu-footer', 'container' => '') ); ?></nav>
            <div class="company"><?php echo do_shortcode('[address separator=", "]'); ?>. Tel: <?php echo do_shortcode('[telephone]'); ?> <?php echo do_shortcode('[email]'); ?></div>
        </div><!-- end footer-content -->
        <div class="footer-bottom">
                <span class="copyright"> &copy <?php $the_year = date("Y"); echo $the_year;?> <?php bloginfo('name'); ?> All rights reserved  </span>
                <span class="credit"><a href="http://www.tomango.co.uk/">Web design in Sussex</a> - tomango</span>
        </div><!-- end footer-bottom -->
    </footer><!-- end footer -->

</div><!-- end wrapper-main -->

<?php wp_footer();?>

</body>
</html>

