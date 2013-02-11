<?php
/*////////////////////////////////////////////////////////////
Register Scripts
////////////////////////////////////////////////////////////*/
wp_deregister_script( 'google-maps-api-v3' );
wp_register_script( 'google-maps-api-v3', 'http://maps.googleapis.com/maps/api/js?&key=AIzaSyCNxoHu7f79iqUKTWw8T6zOWXX2FNvWioY&sensor=false');
wp_enqueue_script( 'google-maps-api-v3' );

wp_deregister_script( 'shadowbox' );
wp_register_script( 'shadowbox', get_template_directory_uri().'/js/shadowbox-3.0.3/shadowbox.js');
wp_enqueue_script( 'shadowbox' );

wp_register_style( 'shadowbox-style', get_template_directory_uri().'/js/shadowbox-3.0.3/shadowbox.css' );
wp_enqueue_style( 'shadowbox-style' );


/*////////////////////////////////////////////////////////////
Enable post formats
////////////////////////////////////////////////////////////*/
add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );


/*////////////////////////////////////////////////////////////
Custom default avatar
////////////////////////////////////////////////////////////*/
if ( !function_exists('ttm_fb_addgravatar') ) {
	function fb_addgravatar( $avatar_defaults ) {
		$myavatar = get_bloginfo('template_directory').'/images/gravatar.jpg';
		//default avatar
		$avatar_defaults[$myavatar] = 'Exciting new gravtar';
		return $avatar_defaults;
	}
	add_filter( 'avatar_defaults', 'ttm_fb_addgravatar' );
}


/*////////////////////////////////////////////////////////////
Add and remove author fields
Use the following to pull custom author fields. <?php echo $curauth->twitter; ?>
////////////////////////////////////////////////////////////*/

//Remove
add_filter('user_contactmethods','ttm_hide_profile_fields',10,1);

function ttm_hide_profile_fields( $contactmethods ) {
unset($contactmethods['aim']);
unset($contactmethods['jabber']);
unset($contactmethods['yim']);
return $contactmethods;
}

//Add
function ttm_new_contactmethods( $contactmethods ) {
// Add Twitter
$contactmethods['twitter'] = 'Twitter';
//add Facebook
$contactmethods['facebook'] = 'Facebook';

return $contactmethods;
}
add_filter('user_contactmethods','ttm_new_contactmethods',10,1);


/*////////////////////////////////////////////////////////////
Custom excerpt length
////////////////////////////////////////////////////////////*/
// custom excerpt length
function ttm_custom_excerpt_length($length) {
	return 20;
}
add_filter('excerpt_length', 'ttm_custom_excerpt_length');


/*////////////////////////////////////////////////////////////
Fix custom posttype menu highlighting
////////////////////////////////////////////////////////////*/
function ttm_fixCustomPostTypeHighlight($menu){
	global $post;
	if ( 'reports' == get_post_type() )
	{
		$menu = str_replace( 'current_page_parent', '', $menu ); // remove all current_page_parent classes
		$menu = str_replace( 'menu-item-381', 'current-page-ancestor menu-item-381', $menu ); // add the current_page_parent class to the page you want
	}
	return $menu;
}
add_filter( 'nav_menu_css_class', 'ttm_fixCustomPostTypeHighlight', 0 );

/*////////////////////////////////////////////////////////////
Add taxonomy class to the body tag
////////////////////////////////////////////////////////////*/
function ttm_taxonomy_body_class( $classes ) {
	if ( is_tax() ) {
		$tax = get_query_var( 'taxonomy' );
		$term = $tax . '-' . get_query_var( 'term' );
		$classes = array_merge( $classes, array( 'taxonomy-archive', $tax, $term ) );
	}
	return $classes;
}
add_filter( 'body_class', 'ttm_taxonomy_body_class' );


/*////////////////////////////////////////////////////////////
Force display name from username to fullname
////////////////////////////////////////////////////////////*/
class myUsers {
	static function init() {
		// Change the user's display name after insertion
		add_action( 'user_register', array( __CLASS__, 'change_display_name' ) );	
	}
	
	static function change_display_name( $user_id ) {
		$info = get_userdata( $user_id );
		
		$args = array(
			'ID' => $user_id, 
			'display_name' => $info->first_name . ' ' . $info->last_name 
		);
		
		wp_update_user( $args ) ;
	}
}
myUsers::init();
/*//////////////////////////////////////////////////////////*/

//Hide name selection dropdown
add_action('admin_head','tmm_hide_displayname_selection');
function tmm_hide_displayname_selection() {
	echo '<style type="text/css">form#your-profile label[for="display_name"], form#your-profile select#display_name   { display:none;}</style>';
}

/*////////////////////////////////////////////////////////////
Change author permalink
////////////////////////////////////////////////////////////*/
function change_author_permalinks() {

    global $wp_rewrite;

    // Change the value of the author permalink base to whatever you want here
    $wp_rewrite->author_base = 'author';

    $wp_rewrite->flush_rules();
}

add_action('init','change_author_permalinks');