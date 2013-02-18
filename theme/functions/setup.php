<?php

/*////////////////////////////////////////////////////////////
If needed to run functions again chnage uncommend below
////////////////////////////////////////////////////////////*/
//update_option( 'theme_setup_status', '0' );

/*////////////////////////////////////////////////////////////
Run on first theme switch
////////////////////////////////////////////////////////////*/
add_action( 'after_setup_theme', 'the_theme_setup' );

function the_theme_setup()
{
	// First we check to see if our default theme settings have been applied.
	$the_theme_status = get_option( 'theme_setup_status' );
	// If the theme has not yet been used we want to run our default settings.
	if ( $the_theme_status !== '1' ) {
/*////////////////////////////////////////////////////////////
Setup Default WordPress settings
////////////////////////////////////////////////////////////*/
		$core_settings = array(
			'avatar_default'				=> 'mystery',					// Comment Avatars should be using mystery by default
			'avatar_rating'					=> 'G',							// Avatar rating
			'comment_max_links'				=> 0,							// We do not allow links from comments
			'comments_per_page'				=> 20							// Default to 20 comments per page
		);
		foreach ( $core_settings as $k => $v ) {
			update_option( $k, $v );
		}
/*////////////////////////////////////////////////////////////
Delete dummy post, page and comment.
////////////////////////////////////////////////////////////*/
		wp_delete_post( 1, true );
		wp_delete_post( 2, true );
		wp_delete_comment( 1 );

/*////////////////////////////////////////////////////////////
Change permalink structure
////////////////////////////////////////////////////////////*/
global $wp_rewrite;
    $wp_rewrite->set_permalink_structure( '/%postname%/' );
	
/*////////////////////////////////////////////////////////////
set page as front page
////////////////////////////////////////////////////////////*/
	$homeSet = get_page_by_title( 'Home' );
	update_option( 'page_on_front', $homeSet->ID );
	update_option( 'show_on_front', 'page' );
	
/*////////////////////////////////////////////////////////////
Remove wordpress roles
////////////////////////////////////////////////////////////*/	
remove_role( 'author' );
remove_role( 'contributor' );

	
/*////////////////////////////////////////////////////////////
Set theme_setup_status as 1
////////////////////////////////////////////////////////////*/
		update_option( 'theme_setup_status', '1' );
		$msg = '
		<div class="error">
			<p>The ' . get_option( 'current_theme' ) . 'theme has changed your WordPress default <a href="' . admin_url() . 'options-general.php" title="See Settings">settings</a> and deleted default posts & comments.</p>
		</div>';
		add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
		
		
		
	}
	elseif ( $the_theme_status === '1' and isset( $_GET['activated'] ) ) {
		$msg = '
		<div class="updated">
			<p>The ' . get_option( 'current_theme' ) . ' theme was successfully re-activated.</p>
		</div>';
		add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
	}
}
?>