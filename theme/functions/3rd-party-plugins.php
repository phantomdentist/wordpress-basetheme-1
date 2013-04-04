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

/*////////////////////////////////////////////////////////////
Activate advanced custom field premium features
////////////////////////////////////////////////////////////*/
if(!get_option('acf_repeater_ac')) update_option('acf_repeater_ac', "QJF7-L4IX-UCNP-RF2W");
if(!get_option('acf_flexible_content_ac')) update_option('acf_flexible_content_ac', "FC9O-H6VN-E4CL-LT33");
if(!get_option('acf_options_page_ac')) update_option('acf_options_page_ac', "OPN8-FA4J-Y2LW-81LS");
if(!get_option('acf_gallery_ac')) update_option('acf_gallery_ac', "GF72-8ME6-JS15-3PZC");//Not sure this is correct, might not be acf_gallery_ac

/*////////////////////////////////////////////////////////////
Advanced Custom Fields options pages
////////////////////////////////////////////////////////////*/
if(function_exists("register_options_page"))
{
    register_options_page('Company');
	//register_options_page('Header');
	//register_options_page('Footer');
	register_options_page('Technical');
}

/*////////////////////////////////////////////////////////////
Advanced Custom Fields WYSIWYG filters
////////////////////////////////////////////////////////////*/
add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
function my_toolbars( $toolbars )
{
 
	// Add a new toolbar called "Very Simple"
	// - this toolbar has only 1 row of buttons
	$toolbars['Standard' ] = array();
	$toolbars['Standard' ][1] = array( 'bold' , 'italic' , 'bullist', 'numlist', 'removeformat', 'fontsizeselect' );
	
	$toolbars['Standard-Link' ] = array();
	$toolbars['Standard-Link' ][1] = array( 'bold' , 'italic' , 'bullist', 'numlist', 'link', 'unlink', 'removeformat', 'fontsizeselect' );
	
	$toolbars['Title' ] = array();
	$toolbars['Title' ][1] = array( 'bold' , 'italic' , 'removeformat', 'fontsizeselect' );
 
	// return $toolbars - IMPORTANT!
	return $toolbars;
}

/*////////////////////////////////////////////////////////////
Admin css
////////////////////////////////////////////////////////////*/
function ttm_plugin_admin_css() {
   echo '<style type="text/css">
		  body.gallery_page_nggallery-manage-gallery #gallerydiv{display:none;}
		  body #normal-sortables #sc_advanced_meta_box{display:none;}
		  body #normal-sortables #sc_external_meta_box{display:none;}
		  body #sc_Author_meta_box{display:none;}
         </style>';
}
add_action('admin_head', 'ttm_plugin_admin_css');
?>