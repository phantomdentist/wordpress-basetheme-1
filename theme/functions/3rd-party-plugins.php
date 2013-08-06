<?php
/*////////////////////////////////////////////////////////////
Remove plugin dashboardmeta boxes
////////////////////////////////////////////////////////////*/
function ttm_remove_plugin_dashboard_meta_boxes() {
	//if ( !current_user_can('manage_options') )://if not admin

		remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'side' );//gravity forms
	//endif;
}
add_action('wp_dashboard_setup', 'ttm_remove_plugin_dashboard_meta_boxes' );

/*////////////////////////////////////////////////////////////
Remove admin bar globally
////////////////////////////////////////////////////////////*/
function ttm_thirdparty_admin_bar_render() {
    global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wpseo-menu');   
}
// and we hook our function via
add_action( 'wp_before_admin_bar_render', 'ttm_thirdparty_admin_bar_render' );


/*////////////////////////////////////////////////////////////
Remove plugin widgets
////////////////////////////////////////////////////////////*/
add_action( 'widgets_init', 'ttm_unregister_plugin_widgets' );

function ttm_unregister_plugin_widgets() {
	unregister_widget( 'mypageorder_Widget' );//mypageorder
	unregister_widget( 'GADWidget' );//Google Analytics Dashboard
	unregister_widget( 'GFWidget' );//Gravity forms widget
}