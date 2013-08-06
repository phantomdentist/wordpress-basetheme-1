<?php
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
	register_options_page('Header');
	register_options_page('Footer');
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
	$toolbars['Standard' ][1] = array( 'bold' , 'italic' , 'bullist', 'numlist', 'removeformat', 'fontsizeselect', 'forecolorpicker' );
	
	$toolbars['Standard-Link' ] = array();
	$toolbars['Standard-Link' ][1] = array( 'bold' , 'italic' , 'bullist', 'numlist', 'link', 'unlink', 'removeformat', 'fontsizeselect', 'forecolorpicker' );
	
	$toolbars['Tagline' ] = array();
	$toolbars['Tagline' ][1] = array( 'bold' , 'italic' , 'link', 'unlink', 'removeformat', 'fontsizeselect', 'forecolorpicker' );
	
	$toolbars['Title' ] = array();
	$toolbars['Title' ][1] = array( 'bold' , 'italic' , 'removeformat', 'fontsizeselect', 'forecolorpicker' );
 
	// return $toolbars - IMPORTANT!
	return $toolbars;
}