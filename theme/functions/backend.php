<?php

/*////////////////////////////////////////////////////////////
Remove default widgets
////////////////////////////////////////////////////////////*/
add_action( 'widgets_init', 'tmm_unregister_widgets' );

function tmm_unregister_widgets() {
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Search');
	#unregister_widget('WP_Widget_Text');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
}

/*////////////////////////////////////////////////////////////
Remove admin bar globally
////////////////////////////////////////////////////////////*/
function ttm_admin_bar_render() {
    global $wp_admin_bar;
    // we can remove a menu item, like the Comments link, just by knowing the right $id
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('dashboard');
	$wp_admin_bar->remove_menu('themes');
	$wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_menu('widgets');
	$wp_admin_bar->remove_menu('menus');
	//$wp_admin_bar->remove_menu('my-sites');
	//$wp_admin_bar->remove_menu('site-name'); 
	$wp_admin_bar->remove_menu('new-content');   
    $wp_admin_bar->remove_menu('view-site');  
}
// and we hook our function via
add_action( 'wp_before_admin_bar_render', 'ttm_admin_bar_render' );


/*////////////////////////////////////////////////////////////
Remove meta boxes
////////////////////////////////////////////////////////////*/
function ttm_remove_meta_boxes() {
	
	//if ( !current_user_can('manage_options') )://if not admin
	
	    /*Remove from posts*/
		remove_meta_box( 'postcustom' , 'post' , 'normal' ); 
		remove_meta_box( 'slugdiv' , 'post' , 'normal' ); 
		remove_meta_box( 'trackbacksdiv' , 'post' , 'normal' );
		remove_meta_box( 'authordiv', 'post', 'normal' );
		remove_meta_box( 'pageparentdiv', 'post', 'normal' );
		remove_meta_box( 'postimagediv', 'post', 'side' );
	    
		/*Remove from pages*/
		remove_meta_box( 'postcustom' , 'page' , 'normal' ); 
		remove_meta_box( 'slugdiv' , 'page' , 'normal' );
		remove_meta_box( 'trackbacksdiv' , 'page' , 'normal' );
		remove_meta_box( 'authordiv', 'page', 'normal' );
		remove_meta_box( 'pageparentdiv', 'page', 'side' );
		remove_meta_box( 'postimagediv', 'page', 'side' );
		remove_meta_box( 'commentstatusdiv' , 'page' , 'normal' ); 
		remove_meta_box( 'commentsdiv' , 'page' , 'normal' );
		
		/*Remove from studies*/
		/*
		remove_meta_box( 'postcustom' , 'customposttype' , 'normal' ); 
		remove_meta_box( 'slugdiv' , 'customposttype' , 'normal' );
		remove_meta_box( 'trackbacksdiv' , 'customposttype' , 'normal' );
		remove_meta_box( 'authordiv', 'customposttype', 'normal' );
		remove_meta_box( 'pageparentdiv', 'customposttype', 'side' );
		remove_meta_box( 'postimagediv', 'customposttype', 'side' );
		remove_meta_box( 'commentstatusdiv' , 'customposttype' , 'normal' ); 
		remove_meta_box( 'commentsdiv' , 'customposttype' , 'normal' );
		*/
		
	//endif;
}
add_action( 'do_meta_boxes' , 'ttm_remove_meta_boxes' );

/*////////////////////////////////////////////////////////////
Remove dashboardmeta boxes
////////////////////////////////////////////////////////////*/
function ttm_remove_dashboard_meta_boxes() {
	//if ( !current_user_can('manage_options') )://if not admin
	
		global $wp_meta_boxes;

		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);	
	//endif;
}
add_action('wp_dashboard_setup', 'ttm_remove_dashboard_meta_boxes' );

/*////////////////////////////////////////////////////////////
Reposition meta boxes
////////////////////////////////////////////////////////////*/

// add_action('user_register', 'set_user_metaboxes');
add_action('admin_init', 'set_user_metaboxes');
function set_user_metaboxes($user_id=NULL) {

    // These are the metakeys we will need to update
    $meta_key['order'] = 'meta-box-order_post';
    $meta_key['hidden'] = 'metaboxhidden_post';

    // So this can be used without hooking into user_register
    if ( ! $user_id)
        $user_id = get_current_user_id(); 

    // Set the default order if it has not been set yet
    if ( ! get_user_meta( $user_id, $meta_key['order'], true) ) {
        $meta_value = array(
            'side' => 'submitdiv,pageparentdiv,formatdiv,categorydiv,tagsdiv-post_tag,commentstatusdiv,revisionsdiv,postimagediv',
            'normal' => 'postexcerpt,commentsdiv,su_postmeta,postcustom,trackbacksdiv,slugdiv,authordiv',//su_postmeta is ultimate seo plugin
            'advanced' => '',
        );
        update_user_meta( $user_id, $meta_key['order'], $meta_value );
    }

    // Set the default hiddens if it has not been set yet
    if ( ! get_user_meta( $user_id, $meta_key['hidden'], true) ) {
        $meta_value = array('postcustom','trackbacksdiv','slugdiv','authordiv','postimagediv');
        update_user_meta( $user_id, $meta_key['hidden'], $meta_value );
    }
}

/*////////////////////////////////////////////////////////////
Move author metabox into page attributes box
////////////////////////////////////////////////////////////*/
add_action( 'post_submitbox_misc_actions', 'move_author_to_publish_metabox' );
function move_author_to_publish_metabox() {
    global $post_ID;
    $post = get_post( $post_ID );
    echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">Author: ';
    post_author_meta_box( $post );
    echo '</div>';
}

/*////////////////////////////////////////////////////////////
Copy of page_attributes_meta_box() from meta-boxes.php with order box removed
////////////////////////////////////////////////////////////*/
function ttm_page_attributes_meta_box($post) {
	$post_type_object = get_post_type_object($post->post_type);
	if ( $post_type_object->hierarchical ) {
		$dropdown_args = array(
			'post_type'        => $post->post_type,
			'exclude_tree'     => $post->ID,
			'selected'         => $post->post_parent,
			'name'             => 'parent_id',
			'show_option_none' => __('(no parent)'),
			'sort_column'      => 'menu_order, post_title',
			'echo'             => 0,
		);

		$dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );
		$pages = wp_dropdown_pages( $dropdown_args );
		if ( ! empty($pages) ) {
?>
<?php _e('Parent:') ?>
<label class="screen-reader-text" for="parent_id"><?php _e('Parent') ?></label>
<?php echo $pages; ?>
<?php
		} // end empty pages check
	} // end hierarchical check.
	if ( 'page' == $post->post_type && 0 != count( get_page_templates() ) ) {
		$template = !empty($post->page_template) ? $post->page_template : false;
		?>
        <br/>
        <br/>
<?php _e('Template:') ?>
<label class="screen-reader-text" for="page_template"><?php _e('Page Template') ?></label><select name="page_template" id="page_template">
<option value='default'><?php _e('Default Template'); ?></option>
<?php page_template_dropdown($template); ?>
</select>
<?php
	}
}

add_action( 'post_submitbox_misc_actions', 'move_pageattributes_to_publish_metabox' );
function move_pageattributes_to_publish_metabox() {
    global $post_ID;
    $post = get_post( $post_ID );
    echo '<div id="ttm_pageparentdiv" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">';
    ttm_page_attributes_meta_box($post);
    echo '</div>';
}

/*////////////////////////////////////////////////////////////
Custom widget class dropdown
////////////////////////////////////////////////////////////*/
function kc_widget_form_extend( $instance, $widget ) {
 if ( !isset($instance['classes']) )
 $instance['classes'] = null;

/* Set your predetermied class choices here */
 $myarray = "style1,style2";

$myclasses = explode(",",$myarray);
 $row = "<p>\n";
 $row .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-classes'>Style:</label>\n";
 $row .= "\t<select  name='widget-{$widget->id_base}[{$widget->number}][classes]'  id='widget-{$widget->id_base}-{$widget->number}-classes'  class='widefat'>\n";
 foreach($myclasses as $myclass) {
 $instance_selected = null; if($instance['classes']==$myclass) $instance_selected = " selected='selected'";
 $row .= "\t<option value='".$myclass."'".$instance_selected.">".$myclass."</option>\n";
 }
 $row .= "</select>\n";

echo $row;
 return $instance;
}
add_filter('widget_form_callback', 'kc_widget_form_extend', 10, 2);function kc_widget_update( $instance, $new_instance ) {
 $instance['classes'] = $new_instance['classes'];
 return $instance;
}
add_filter( 'widget_update_callback', 'kc_widget_update', 10, 2 );
function kc_dynamic_sidebar_params( $params ) {
 global $wp_registered_widgets;
 $widget_id    = $params[0]['widget_id'];
 $widget_obj    = $wp_registered_widgets[$widget_id];
 $widget_opt    = get_option($widget_obj['callback'][0]->option_name);
 $widget_num    = $widget_obj['params'][0]['number'];

 if ( isset($widget_opt[$widget_num]['classes']) && !empty($widget_opt[$widget_num]['classes']) )
 $params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$widget_opt[$widget_num]['classes']} ", $params[0]['before_widget'], 1 );

 return $params;
}
add_filter( 'dynamic_sidebar_params', 'kc_dynamic_sidebar_params' );



/*////////////////////////////////////////////////////////////
Hide the update reminder from all non admin users
////////////////////////////////////////////////////////////*/
function hideuptdng()
{
	if ( !current_user_can('manage_options') )//if not admin
	{
    	remove_action( 'admin_notices', 'update_nag', 3 );
	}
}
add_action('admin_menu','hideuptdng');

/*////////////////////////////////////////////////////////////
Add custom menu items
////////////////////////////////////////////////////////////*/
add_action('admin_menu', 'ttm_register_menus_menu');

function ttm_register_menus_menu() {
   add_menu_page( 'Menus', 'Menus', 'edit_theme_options', 'nav-menus.php', '', get_template_directory_uri().'/images/admin-menu-icon-menus.png' );//Menus as top level
}

/////////////////////////////////////////////////////////////

add_action('admin_menu', 'ttm_register_widgets_menu');

function ttm_register_widgets_menu() {
   add_menu_page( 'Widgets', 'Widgets', 'edit_theme_options', 'widgets.php', '', get_template_directory_uri().'/images/admin-menu-icon-widgets.png' );//Widgets as top level
}

/*////////////////////////////////////////////////////////////
Remove menus for non admins
////////////////////////////////////////////////////////////*/
add_action('admin_menu','remove_menus');

function remove_menus()
{
	if( isset( $roles['administrator'] ) && !current_user_can('administrator') )//if not admin
	{
		remove_menu_page('themes.php');//appearance
	}
}

/*////////////////////////////////////////////////////////////
Admin backend css
////////////////////////////////////////////////////////////*/
function ttm_admin_css() {
	//Fixes support tag iframe
	//Hides native wordpress gallery tab
   echo '<style type="text/css">
          body.toplevel_page_support{overflow:hidden;}
		  body#media-upload li#tab-gallery{display:none}
		  body .empty-container {display:none}
         </style>';
}
add_action('admin_head', 'ttm_admin_css');

/*////////////////////////////////////////////////////////////
Editor Styles
////////////////////////////////////////////////////////////*/
add_editor_style( 'editor-style.css' );


/*////////////////////////////////////////////////////////////
Add existing buttons to tinymce
////////////////////////////////////////////////////////////*/
function enable_more_buttons($buttonsDefault) {
  $buttonsDefault[] = 'hr';
 
  /* 
  Repeat with any other buttons you want to add, e.g.
	  $buttons[] = 'fontselect';
	  $buttons[] = 'sup';
  */
 
  return $buttonsDefault;
}
add_filter("mce_buttons", "enable_more_buttons");

/*////////////////////////////////////////////////////////////
Remove default buttons from tinymce tinymce
////////////////////////////////////////////////////////////*/
function customformatTinyMCE($init) {
	// Add block format elements you want to show in dropdown
	$init['theme_advanced_blockformats'] = 'p,pre,h2,h3,h4';
	$init['theme_advanced_disable'] = 'justifyfull';
	$init['theme_advanced_enable'] = 'hr';

	return $init;
}

// Modify Tiny_MCE init
add_filter('tiny_mce_before_init', 'customformatTinyMCE' );

/*////////////////////////////////////////////////////////////
Visual Edtiro Dropdown Styles
////////////////////////////////////////////////////////////*/
add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );

function my_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );

function my_mce_before_init( $settings ) {

    $style_formats = array(
    	array(
    		'title' => 'Intro Paragraph',
    		'selector' => 'p',
    		'classes' => 'intro-paragraph'
    	)/*,
        array(
        	'title' => 'Grey Button',
        	'selector' => 'a',
        	'classes' => 'button-grey'
        ),
        array(
        	'title' => 'Bold Red Text',
        	'inline' => 'span',
        	'styles' => array(
        		'color' => '#f00',
        		'fontWeight' => 'bold'
        	)
        )*/
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}

?>