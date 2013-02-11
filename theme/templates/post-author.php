<?php
if( is_author() ) 
{
	$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));//Get author information
	
	echo '<div class="postmeta-author">';
		echo get_avatar( get_the_author_meta( 'user_email' ));
		if ( $curauth->first_name )  echo '<h2>About '.$curauth->first_name.'</h2>';
		if ( $curauth->description ) echo $curauth->description;
		if ( $curauth->user_url ) echo '<a href="'.$curauth->user_url.'">Visit authors website</a>';
	echo '</div><!-- end postmeta-author -->';
}
?>