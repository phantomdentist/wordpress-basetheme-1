// registration code for reviews post type
	function register_reviews_posttype() {
		$labels = array(
			'name' 				=> _x( 'Reviews', 'post type general name' ),
			'singular_name'		=> _x( 'Review', 'post type singular name' ),
			'add_new' 			=> __( 'Add New' ),
			'add_new_item' 		=> __( 'Review' ),
			'edit_item' 		=> __( 'Review' ),
			'new_item' 			=> __( 'Review' ),
			'view_item' 		=> __( 'Review' ),
			'search_items' 		=> __( 'Review' ),
			'not_found' 		=> __( 'Review' ),
			'not_found_in_trash'=> __( 'Review' ),
			'parent_item_colon' => __( 'Review' ),
			'menu_name'			=> __( 'Reviews' )
		);
		
		$taxonomies = array();

		$supports = array('title','editor','author','excerpt','revisions');
		
		$post_type_args = array(
			'labels' 			=> $labels,
			'singular_label' 	=> __('Review'),
			'public' 			=> true,
			'show_ui' 			=> true,
			'publicly_queryable'=> true,
			'query_var'			=> true,
			'exclude_from_search'=> true,
			'show_in_nav_menus'	=> false,
			'capability_type' 	=> 'post',
			'has_archive' 		=> true,
			'hierarchical' 		=> false,
			'rewrite' 			=> array('slug' => 'reviews', 'with_front' => false ),
			'supports' 			=> $supports,
			'menu_position' 	=> 5,
			'menu_icon' 		=> 'includes/images/icon.png',
			'taxonomies'		=> $taxonomies
		 );
		 register_post_type('reviews',$post_type_args);
	}
	add_action('init', 'register_reviews_posttype');