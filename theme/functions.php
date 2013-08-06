<?php
/*////////////////////////////////////////////////////////////
Content Width
////////////////////////////////////////////////////////////*/
if ( ! isset( $content_width ) ) $content_width = 960;

/*////////////////////////////////////////////////////////////
Pull in other function files
////////////////////////////////////////////////////////////*/
include('functions/security.php');
include('functions/backend.php');
include('functions/widgets.php');
include('functions/shortcodes.php');
include('functions/3rd-party-plugins.php');
include('functions/setup.php');
include('functions/advanced-custom-fields.php');

/*////////////////////////////////////////////////////////////
//Register main scripts
////////////////////////////////////////////////////////////*/
function ttm_register_scripts() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri().'/js/jquery-1.10.2.min.js');
	wp_enqueue_script( 'jquery' );
	
	wp_deregister_script( 'jquery-ui' );
	wp_register_script( 'jquery-ui', get_template_directory_uri().'/js/jquery-ui-1.10.3.custom.min.js');
	wp_enqueue_script( 'jquery-ui' );
	
	wp_deregister_script( 'flexslider-min' );
	wp_register_script( 'flexslider-min', get_template_directory_uri().'/js/jquery.flexslider-min.js');
	wp_enqueue_script( 'flexslider-min' );
	
	wp_deregister_script( 'utility' );
	wp_register_script( 'utility', get_template_directory_uri().'/js/utility.js');
	wp_enqueue_script( 'utility' );
}    
add_action('wp_enqueue_scripts', 'ttm_register_scripts');

/*////////////////////////////////////////////////////////////
Sidebars
////////////////////////////////////////////////////////////*/
// Register widget-area-1
register_sidebar( array(
	'name' => 'Website Sidebar ',
	'id' => 'widget-area-1',
	'description' => 'Widget Area 1',
	'before_widget' => '<li id="%1$s" class="widget-container %2$s"><div class="widget-header"></div><!--end widget-header --><div class="widget-content">',
	'after_widget' => '</div><!--end widget-content --><div class="widget-footer"><!--end widget-footer --></div></li>',
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
) );

/*////////////////////////////////////////////////////////////
Menus
////////////////////////////////////////////////////////////*/
add_theme_support( 'nav-menus' );	
	
add_action( 'init', 'ttm_register_my_menus' );

function ttm_register_my_menus() 
{ 
register_nav_menus(array('menu-main' => __( 'Main Navigation' ),'menu-footer' => __( 'Footer Menu' )));
}

/*////////////////////////////////////////////////////////////
Add new image sizes
////////////////////////////////////////////////////////////*/
if (function_exists('add_image_size')){
	add_image_size( 'slider', 960, 300, true );
} 

/*////////////////////////////////////////////////////////////
Enable feeds
////////////////////////////////////////////////////////////*/
add_theme_support( 'automatic-feed-links' );

/*////////////////////////////////////////////////////////////
Enable threaded comments
////////////////////////////////////////////////////////////*/
function ttm_enable_threaded_comments(){
	if (!is_admin()) {
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
			wp_enqueue_script('comment-reply');
		}
}
add_action('get_header', 'ttm_enable_threaded_comments');

/*////////////////////////////////////////////////////////////
Stop the readmore link from jumping
////////////////////////////////////////////////////////////*/
function ttm_no_more_jumping($post) {
	return '<a href="'.get_permalink($post->ID).'" class="read-more">'.'Continue Reading'.'</a>';
}
add_filter('excerpt_more', 'ttm_no_more_jumping');



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

/*////////////////////////////////////////////////////////////
Excerpt length
////////////////////////////////////////////////////////////*/
function excerpt($num, $more) {
    $limit = $num+1;
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt)."... <a class='more-link' href='" .get_permalink($post->ID) ." '>".$more."</a>";
    echo $excerpt;
}

/*////////////////////////////////////////////////////////////
Removes more tag more link
////////////////////////////////////////////////////////////*/
add_filter( 'the_content_more_link', 'my_more_link', 10, 2 );

function my_more_link( $more_link, $more_link_text ) {
	return str_replace( $more_link_text, '', $more_link );
}

/*////////////////////////////////////////////////////////////
Add description to custom menus. Must add 'walker' => new description_walker() to menu call
////////////////////////////////////////////////////////////*/
class description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';

           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

           $prepend = '<strong>';
           $append = '</strong>';
           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

           if($depth != 0)
           {
                     $description = $append = $prepend = "";
           }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= $description.$args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
}


/*////////////////////////////////////////////////////////////
Google analytics
////////////////////////////////////////////////////////////*/
function googleAnalytics() {
	if( function_exists('get_field') && !is_user_logged_in() && get_field('analytics_ua','options') ){
		{
			$returnValue = 
			"<script>
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '".get_field('analytics_ua','options')."']);
			_gaq.push(['_trackPageview']);
			
			(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
			</script>
			";
			
			return $returnValue;
		}	
	}
}
add_action('wp_head', 'googleAnalytics');


/*////////////////////////////////////////////////////////////
Custom comments
////////////////////////////////////////////////////////////*/
function ttm_customComments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar($comment, $size = '48', $default = get_bloginfo('stylesheet_directory').'/images/default-avatar.jpg' ); ?>
				<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
                
                <div class="comment-meta commentmetadata">
                    <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a>
                    <?php edit_comment_link(__('(Edit)'),'  ','') ?>
                </div>
                
			</div>
			<?php if ($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.') ?></em>
				<br />
			<?php endif; ?>

			<?php comment_text() ?>

			<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
		</div>
<?php
}

/*////////////////////////////////////////////////////////////
Custom Featured Image
////////////////////////////////////////////////////////////*/
function acf_featured_image($imageSize) {
	if( function_exists('get_field') ) {
	
		if( get_field('blog_featured_image') ) {
			
			$attachment_object = get_field('blog_featured_image');
	
			$image_title = $attachment_object['title'];
			$image_alt = $attachment_object['alt'];
			//var_dump($attachment_object);
			
			$image_url = wp_get_attachment_image_src( $attachment_object['id'], $imageSize);
			
			$permalink = get_permalink($post->ID);
			echo '<a class="acf-featured-image" href="'.$permalink.'"><img class="blog-thumb" src="'.$image_url[0].'" alt="'.$image_alt.'" title="'.$image_title.'"/></a>';
		}	
	}
}