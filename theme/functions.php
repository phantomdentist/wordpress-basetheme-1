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

/*////////////////////////////////////////////////////////////
//Register main scripts
////////////////////////////////////////////////////////////*/
function ttm_register_scripts() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
	wp_enqueue_script( 'jquery' );
	
	wp_deregister_script( 'jquery-ui' );
	wp_register_script( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js');
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
Automatically limit post content length using <?php content(100, __('(more...)')); ?>
////////////////////////////////////////////////////////////*/
function close_tags($text) {
    $patt_open    = "%((?<!</)(?<=<)[\s]*[^/!>\s]+(?=>|[\s]+[^>]*[^/]>)(?!/>))%";
    $patt_close    = "%((?<=</)([^>]+)(?=>))%";
	
    if (preg_match_all($patt_open,$text,$matches))
    {
        $m_open = $matches[1];
        if(!empty($m_open))
        {
            preg_match_all($patt_close,$text,$matches2);

            $m_close = $matches2[1];

            if (count($m_open) > count($m_close))

            {
                $m_open = array_reverse($m_open);

                foreach ($m_close as $tag) $c_tags[$tag]++;

                foreach ($m_open as $k => $tag)    if ($c_tags[$tag]--<=0) $text.='</'.$tag.'>';
            }
        }
    }
    return $text;
}

//Content Limit
function content($num, $more_link_text = '(more...)') {  
	$theContent = get_the_content($more_link_text);  
	//$output = preg_replace('/<img[^>]+./','', $theContent);//Use this line if you want images removed from the content on index.php etc  
	$output = $theContent;  
	$limit = $num+1;  
	$content = explode(' ', $output, $limit);  
	array_pop($content);  
	$content = implode(" ",$content);  
    $content = strip_tags($content, '<p><a><address><a><abbr><acronym><b><big><blockquote><br><caption><cite><class><code><col><del><dd><div><dl><dt><em><font><h1><h2><h3><h4><h5><h6><hr><i><img><ins><kbd><li><ol><p><pre><q><s><span><strike><strong><sub><sup><table><tbody><td><tfoot><tr><tt><ul><var>');

	echo close_tags($content);
	echo '<a class="custom-more-link" href="';
	the_permalink();
	echo '">'.$more_link_text.'</a>';
}

/*////////////////////////////////////////////////////////////
Function for calling custom content
////////////////////////////////////////////////////////////*/
function ttm_customExcerpt($readmore,$tagLimit,$defaultLimit) {
	//Use excerpt if it exists, if not but a more tag exists use the more tag, if neither exist use an abritary limit
	if ( has_excerpt() )
	{
		the_excerpt();
		echo '<a class="custom-more-link" href="'.get_permalink().'">'.$readmore.'</a>';
	}
	elseif( preg_match('/<!--more(.*?)?-->/', $post->post_content) )
	{
		content($tagLimit, __($readmore));//Custom post call using functions.php function
	}
	else
	{
		content($defaultLimit, __($readmore));//Custom post call using functions.php function to auto limit content length 
	}
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

function ttm_customComments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar($comment, $size = '48', $default = get_bloginfo('stylesheet_directory').'/images/default-avatar.gif' ); ?>
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
?>