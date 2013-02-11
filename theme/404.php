<?php get_template_part('templates/wrapper-header'); ?>

    <h1>Page not found 404</h1>
    
    <h2>Oooops we seem to have misplaced that page, or it never existed in the first place!</h2>
    
    <div class="nofound-search notification-box-blue">
        Perhaps searching will help: <?php get_search_form(); ?>
        <div class="clear"></div>
    </div>

	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>
    
<?php get_template_part('templates/wrapper-footer'); ?>
