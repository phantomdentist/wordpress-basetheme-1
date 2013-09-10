<?php
/*////////////////////////////////////////////////////////////
Woocommerce
////////////////////////////////////////////////////////////*/


	/*////////////////////////////////////////////////////////////
	Remove features
	////////////////////////////////////////////////////////////*/
	
		/*
		Widgets
		*/
	
			add_action( 'widgets_init', 'ttm_unregister_woocommerce_widgets' );
			
			function ttm_unregister_woocommerce_widgets() {
				
				unregister_widget( 'WC_Widget_Best_Sellers' );
				unregister_widget( 'WC_Widget_Cart' );
				unregister_widget( 'WC_Widget_Featured_Products' );
				unregister_widget( 'WC_Widget_Layered_Nav_Filters' );
				//unregister_widget( 'WC_Widget_Layered_Nav' );
				unregister_widget( 'WC_Widget_Onsale' );
				unregister_widget( 'WC_Widget_Price_Filter' );
				unregister_widget( 'WC_Widget_Product_Categories' );
				unregister_widget( 'WC_Widget_Product_Search' );
				unregister_widget( 'WC_Widget_Product_Tag_Cloud' );
				unregister_widget( 'WC_Widget_Random_Products' );
				unregister_widget( 'WC_Widget_Recent_Products' );
				unregister_widget( 'WC_Widget_Recent_Reviews' );
				unregister_widget( 'WC_Widget_Recently_Viewed' );
				unregister_widget( 'WC_Widget_Top_Rated_Products' );
			}
			
			
		/*
		Checkout
		*/
	
			//Phone number not required
			add_filter( 'woocommerce_billing_fields', 'ttm_phone_number_not_required', 10, 1 );
			function ttm_phone_number_not_required( $address_fields ) {
				$address_fields['billing_phone']['required'] = false;
				return $address_fields;
			}
			
			// Hook in
			add_filter( 'woocommerce_checkout_fields' , 'ttm_remove_checkout_fields' );
			// Our hooked in function - $fields is passed via the filter!
			function ttm_remove_checkout_fields( $fields ) {
				 unset($fields['billing']['billing_company']);
				 return $fields;
			}
			
		/*
		Product types
		*/
			
			add_filter( 'product_type_selector', 'ttm_product_type_selector', 10, 1 );
			
			function ttm_product_type_selector( $product_types ) {
				foreach ( array( 'grouped', 'external' ) as $type ) {
					if ( isset( $product_types[ $type ] ) ) {
						unset( $product_types[ $type ] );
					}
				}
			
				return $product_types;
			}


	/*////////////////////////////////////////////////////////////
	Add wrappers
	////////////////////////////////////////////////////////////*/

		//Remove default top content wrapper and replace with custom
		remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		add_action('woocommerce_before_main_content', 'ttm_woocommerce_wrapper_top', 10);
		function ttm_woocommerce_wrapper_top(){
			get_header();
			?>
			<div class="container-main woo-wrapper clearfix">
            
				<div class="page-header clearfix">
                
                    <div class="page-header-left">
                        <?php do_action('woocommerce_custom_breadcrumb'); ?>
                    </div><!-- end page-header-left-->
                    
                    <?php if( is_product() ){
						get_template_part('templates/social-share'); 
					}
					?>
                    
				</div><!-- end page-header -->
                
                <?php if( is_shop() || is_product_category() || is_product_tag() ){ ?>
                    <div class="woocommerce-page-header clearfix">
                        <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
                        <?php do_action('woocommerce_page_header'); ?>
                    </div><!-- end woocommerce-page-header -->
                <?php } ?>
                
                <aside class="sidebar2"><?php get_sidebar(2); ?></aside>
			<div class="content clearfix">
			<?php
		}
		
		//Remove breadcrumbs and re-add on custom hook in ttm_woocommerce_wrapper_top function
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
		add_action('woocommerce_custom_breadcrumb', 'woocommerce_breadcrumb', 10);
		
		//Remove default bottom content wrapper and replace with custom
		remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
		add_action('woocommerce_after_main_content', 'ttm_woocommerce_wrapper_bottom', 10);
		function ttm_woocommerce_wrapper_bottom(){
			?>
					</div><!-- end content -->
			</div><!-- end container -->
			<?php
			get_footer();
		}
		
		//Add  wrapper around product image,excerpt, price, add to cart button etc
		add_action('woocommerce_before_single_product_summary', 'ttm_woocommerce_product_box_top', 5);
		function ttm_woocommerce_product_box_top(){
			echo '<div class="product-box clearfix">';
		}
		
		add_action('woocommerce_after_single_product_summary', 'ttm_woocommerce_product_box_bottom', 5);
		function ttm_woocommerce_product_box_bottom(){
			echo '</div><!-- end product-box -->';
		}
		
		remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
		
	
	/*////////////////////////////////////////////////////////////
	Set settings
	////////////////////////////////////////////////////////////*/
	
		//Products per row
		add_filter('loop_shop_columns', 'loop_columns');
		if (!function_exists('loop_columns')) {
			function loop_columns() {
				return 3;
			}
		}

		//Products per page
		add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );
		
		//Remove product count on category pages
		remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
		
		//Remove meta from single product pages
		//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
		
		//Remove related products
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
		
		//Breadcrumb separator
		add_filter( 'woocommerce_breadcrumb_defaults', 'ttm_change_breadcrumb_delimiter' );
		function ttm_change_breadcrumb_delimiter( $defaults ) {
			// Change the breadcrumb delimeter from '/' to '>'
			$defaults['delimiter'] = ' <span class="separator">&gt;</span> ';
			return $defaults;
		}
		
		//Gallery images per row
		add_filter ( 'woocommerce_product_thumbnails_columns', 'ttm_thumb_cols' );
 		function ttm_thumb_cols() {
     		return 5; // .last class applied to every 4th thumbnail
		}

		//Upsells per row
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 20);
		if (!function_exists('woocommerce_output_upsells')) {
			function woocommerce_output_upsells() {
				woocommerce_upsell_display(3,3); // Display 3 products in rows of 3
			}
		}
		
		//Catalogue add to cart button link
		add_filter ( 'add_to_cart_url', 'ttm_catalogue_add_to_cart_link' );
		function ttm_catalogue_add_to_cart_link(){
			return get_permalink( $product->id );
		}
		
		/*
		Labels
		*/
		
			//Add to cart button text - catalogue
			add_filter('add_to_cart_text', 'ttm_custom_cart_button_text');
			add_filter('variable_add_to_cart_text', 'ttm_custom_cart_button_text');
			function ttm_custom_cart_button_text() {
				return __('BUY', 'woocommerce');
			}
			
			//Single add to cart button text
			add_filter('single_add_to_cart_text', 'ttm_single_custom_cart_button_text');
			function ttm_single_custom_cart_button_text() {
                    return __('Add to basket', 'woocommerce');
            }
			
			//Price label based on product type - single
			add_filter( 'woocommerce_get_price_html', 'ttm_price_html', 100, 2 );
			function ttm_price_html( $price, $product ){
				if( is_product() && $product->product_type == 'simple' ){
					return '<span class="price-label">Price:</span> '.$price;
				}
				else
				{
					return $price;
				}
			}

	/*////////////////////////////////////////////////////////////
	Move stuff
	////////////////////////////////////////////////////////////*/
		
		//Move catalogue ordering into woocommerce page header
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		add_action( 'woocommerce_page_header', 'woocommerce_catalog_ordering', 10 );
		
		//Move category product rating
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );
		
		//Add rating under price on product single
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_rating', 15 );
		
		//Move product price so it can be group with buy button in catelogue
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 5 );
		
		//Remove product thumbnails when custom size being used
		add_action('wp_head','ttm_fire_hooks',0);
		function ttm_fire_hooks(){
			if( is_front_page() ){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			}
		}
		
		//Add loop sale flash into product title so it moves down with multi line titles
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		add_action( 'ttm_sale_flash', 'woocommerce_show_product_loop_sale_flash', 10 );
		

	/*////////////////////////////////////////////////////////////
	Replace widgets
	////////////////////////////////////////////////////////////*/
	
	function ttm_woocommerce_register_widgets() {
		register_widget('ttm_WC_Widget_Best_Sellers');
		register_widget('ttm_WC_Widget_Top_Rated_Products');
		register_widget('ttm_WC_Widget_Recent_Products');
		
		
	}
	add_action('widgets_init', 'ttm_woocommerce_register_widgets');
	
	
	
	//Best sellers
	
		if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
		
		class ttm_WC_Widget_Best_Sellers extends WP_Widget {
		
			var $woo_widget_cssclass;
			var $woo_widget_description;
			var $woo_widget_idbase;
			var $woo_widget_name;
		
			/**
			 * constructor
			 *
			 * @access public
			 * @return void
			 */
			function ttm_WC_Widget_Best_Sellers() {
		
				/* Widget variable settings. */
				$this->woo_widget_cssclass = 'woocommerce widget_best_sellers';
				$this->woo_widget_description = __( 'Display a list of your best selling products on your site.', 'woocommerce' );
				$this->woo_widget_idbase = 'woocommerce_best_sellers';
				$this->woo_widget_name = __( 'WooCommerce Best Sellers', 'woocommerce' );
		
				/* Widget settings. */
				$widget_ops = array( 'classname' => $this->woo_widget_cssclass, 'description' => $this->woo_widget_description );
		
				/* Create the widget. */
				$this->WP_Widget('best_sellers', $this->woo_widget_name, $widget_ops);
		
				add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
				add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
				add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
			}
		
		
			/**
			 * widget function.
			 *
			 * @see WP_Widget
			 * @access public
			 * @param array $args
			 * @param array $instance
			 * @return void
			 */
			function widget( $args, $instance ) {
				global $woocommerce;
		
				$cache = wp_cache_get('widget_best_sellers', 'widget');
		
				if ( !is_array($cache) ) $cache = array();
		
				if ( isset($cache[$args['widget_id']]) ) {
					echo $cache[$args['widget_id']];
					return;
				}
		
				ob_start();
				extract($args);
		
				$title = apply_filters('widget_title', empty($instance['title']) ? __('Best Sellers', 'woocommerce' ) : $instance['title'], $instance, $this->id_base);
				if ( !$number = (int) $instance['number'] )
					$number = 10;
				else if ( $number < 1 )
					$number = 1;
				else if ( $number > 15 )
					$number = 15;
		
				$query_args = array(
					'posts_per_page' => $number,
					'post_status' 	 => 'publish',
					'post_type' 	 => 'product',
					'meta_key' 		 => 'total_sales',
					'orderby' 		 => 'meta_value_num',
					'no_found_rows'  => 1,
				);
		
				$query_args['meta_query'] = $woocommerce->query->get_meta_query();
		
				if ( isset( $instance['hide_free'] ) && 1 == $instance['hide_free'] ) {
					$query_args['meta_query'][] = array(
						'key'     => '_price',
						'value'   => 0,
						'compare' => '>',
						'type'    => 'DECIMAL',
					);
				}
		
				$r = new WP_Query($query_args);
		
				if ( $r->have_posts() ) {
		
					echo $before_widget;
		
					if ( $title )
						echo $before_title . $title . $after_title;
		
					echo '<ul class="product_list_widget">';
		
					while ( $r->have_posts()) {
						$r->the_post();
						global $product;
		
						echo '<li>
							<a href="' . get_permalink() . '">
								' . get_the_title() . '
							</a> ' . $product->get_price_html() . '
						</li>';
					}
		
					echo '</ul>';
		
					echo $after_widget;
				}
		
				$content = ob_get_clean();
		
				if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;
		
				echo $content;
		
				wp_cache_set('widget_best_sellers', $cache, 'widget');
			}
		
		
			/**
			 * update function.
			 *
			 * @see WP_Widget->update
			 * @access public
			 * @param array $new_instance
			 * @param array $old_instance
			 * @return array
			 */
			function update( $new_instance, $old_instance ) {
				$instance = $old_instance;
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['number'] = (int) $new_instance['number'];
				$instance['hide_free'] = 0;
		
				if ( isset( $new_instance['hide_free'] ) ) {
					$instance['hide_free'] = 1;
				}
		
				$this->flush_widget_cache();
		
				$alloptions = wp_cache_get( 'alloptions', 'options' );
				if ( isset($alloptions['widget_best_sellers']) ) delete_option('widget_best_sellers');
		
				return $instance;
			}
		
		
			/**
			 * flush_widget_cache function.
			 *
			 * @access public
			 * @return void
			 */
			function flush_widget_cache() {
				wp_cache_delete( 'widget_best_sellers', 'widget' );
			}
		
		
			/**
			 * form function.
			 *
			 * @see WP_Widget->form
			 * @access public
			 * @param array $instance
			 * @return void
			 */
			function form( $instance ) {
				$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
				if ( !isset($instance['number']) || !$number = (int) $instance['number'] ) $number = 5;
				$hide_free_checked = ( isset( $instance['hide_free'] ) && 1 == $instance['hide_free'] ) ? ' checked="checked"' : '';
		
				?>
				<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'woocommerce' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		
				<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of products to show:', 'woocommerce' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
		
				<p><input id="<?php echo esc_attr( $this->get_field_id('hide_free') ); ?>" name="<?php echo esc_attr( $this->get_field_name('hide_free') ); ?>" type="checkbox"<?php echo $hide_free_checked; ?> />
				<label for="<?php echo $this->get_field_id('hide_free'); ?>"><?php _e( 'Hide free products', 'woocommerce' ); ?></label></p>
		
				<?php
			}
		}
	
	
	//Top Rated

		if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
		
		class ttm_WC_Widget_Top_Rated_Products extends WP_Widget {
		
			var $woo_widget_cssclass;
			var $woo_widget_description;
			var $woo_widget_idbase;
			var $woo_widget_name;
		
			/**
			 * constructor
			 *
			 * @access public
			 * @return void
			 */
			function ttm_WC_Widget_Top_Rated_Products() {
		
				/* Widget variable settings. */
				$this->woo_widget_cssclass = 'woocommerce widget_top_rated_products';
				$this->woo_widget_description = __( 'Display a list of top rated products on your site.', 'woocommerce' );
				$this->woo_widget_idbase = 'woocommerce_top_rated_products';
				$this->woo_widget_name = __( 'WooCommerce Top Rated Products', 'woocommerce' );
		
				/* Widget settings. */
				$widget_ops = array( 'classname' => $this->woo_widget_cssclass, 'description' => $this->woo_widget_description );
		
				/* Create the widget. */
				$this->WP_Widget('top-rated-products', $this->woo_widget_name, $widget_ops);
		
				add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
				add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
				add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
			}
		
			/**
			 * widget function.
			 *
			 * @see WP_Widget
			 * @access public
			 * @param array $args
			 * @param array $instance
			 * @return void
			 */
			function widget($args, $instance) {
				global $woocommerce;
		
				$cache = wp_cache_get('widget_top_rated_products', 'widget');
		
				if ( !is_array($cache) ) $cache = array();
		
				if ( isset($cache[$args['widget_id']]) ) {
					echo $cache[$args['widget_id']];
					return;
				}
		
				ob_start();
				extract($args);
		
				$title = apply_filters('widget_title', empty($instance['title']) ? __('Top Rated Products', 'woocommerce' ) : $instance['title'], $instance, $this->id_base);
		
				if ( !$number = (int) $instance['number'] ) $number = 10;
				else if ( $number < 1 ) $number = 1;
				else if ( $number > 15 ) $number = 15;
		
				add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
		
				$query_args = array('posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );
		
				$query_args['meta_query'] = $woocommerce->query->get_meta_query();
		
				$top_rated_posts = new WP_Query( $query_args );
		
				if ($top_rated_posts->have_posts()) :
		
					echo $before_widget;
		
					if ( $title ) echo $before_title . $title . $after_title;
						?>
						<ul class="product_list_widget">
							<?php while ($top_rated_posts->have_posts()) : $top_rated_posts->the_post(); global $product;
							?>
							<li>
                            	<a href="<?php echo esc_url( get_permalink( $top_rated_posts->post->ID ) ); ?>" title="<?php echo esc_attr($top_rated_posts->post->post_title ? $top_rated_posts->post->post_title : $top_rated_posts->post->ID); ?>">
									<?php if ( $top_rated_posts->post->post_title ) echo get_the_title( $top_rated_posts->post->ID ); else echo $top_rated_posts->post->ID; ?>
								</a> 
								<?php #echo $product->get_rating_html(); ?>
								<?php echo $product->get_price_html(); ?>
                            </li>
		
							<?php endwhile; ?>
						</ul>
						<?php
					echo $after_widget;
				endif;
		
				wp_reset_query();
				remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
		
				$content = ob_get_clean();
		
				if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;
		
				echo $content;
		
				wp_cache_set('widget_top_rated_products', $cache, 'widget');
			}
		
			/**
			 * update function.
			 *
			 * @see WP_Widget->update
			 * @access public
			 * @param array $new_instance
			 * @param array $old_instance
			 * @return array
			 */
			function update( $new_instance, $old_instance ) {
				$instance = $old_instance;
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['number'] = (int) $new_instance['number'];
				$this->flush_widget_cache();
		
				$alloptions = wp_cache_get( 'alloptions', 'options' );
				if ( isset($alloptions['widget_top_rated_products']) ) delete_option('widget_top_rated_products');
		
				return $instance;
			}
		
			function flush_widget_cache() {
				wp_cache_delete('widget_top_rated_products', 'widget');
			}
		
			/**
			 * form function.
			 *
			 * @see WP_Widget->form
			 * @access public
			 * @param array $instance
			 * @return void
			 */
			function form( $instance ) {
				$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
				if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
					$number = 5;
		?>
				<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'woocommerce' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		
				<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of products to show:', 'woocommerce' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
		<?php
			}
		
		}
		
		//Recently added
			
			if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
			
			class ttm_WC_Widget_Recent_Products extends WP_Widget {
			
				var $woo_widget_cssclass;
				var $woo_widget_description;
				var $woo_widget_idbase;
				var $woo_widget_name;
			
				/**
				 * constructor
				 *
				 * @access public
				 * @return void
				 */
				function ttm_WC_Widget_Recent_Products() {
			
					/* Widget variable settings. */
					$this->woo_widget_cssclass = 'woocommerce widget_recent_products';
					$this->woo_widget_description = __( 'Display a list of your most recent products on your site.', 'woocommerce' );
					$this->woo_widget_idbase = 'woocommerce_recent_products';
					$this->woo_widget_name = __( 'WooCommerce Recent Products', 'woocommerce' );
			
					/* Widget settings. */
					$widget_ops = array( 'classname' => $this->woo_widget_cssclass, 'description' => $this->woo_widget_description );
			
					/* Create the widget. */
					$this->WP_Widget('recent_products', $this->woo_widget_name, $widget_ops);
			
					add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
					add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
					add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
				}
			
				/**
				 * widget function.
				 *
				 * @see WP_Widget
				 * @access public
				 * @param array $args
				 * @param array $instance
				 * @return void
				 */
				function widget($args, $instance) {
					global $woocommerce;
			
					$cache = wp_cache_get('widget_recent_products', 'widget');
			
					if ( !is_array($cache) ) $cache = array();
			
					if ( isset($cache[$args['widget_id']]) ) {
						echo $cache[$args['widget_id']];
						return;
					}
			
					ob_start();
					extract($args);
			
					$title = apply_filters('widget_title', empty($instance['title']) ? __('New Products', 'woocommerce' ) : $instance['title'], $instance, $this->id_base);
					if ( !$number = (int) $instance['number'] )
						$number = 10;
					else if ( $number < 1 )
						$number = 1;
					else if ( $number > 15 )
						$number = 15;
			
					$show_variations = $instance['show_variations'] ? '1' : '0';
			
					$query_args = array('posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product');
			
					$query_args['meta_query'] = array();
			
					if ( $show_variations == '0' ) {
						$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
						$query_args['parent'] = '0';
					}
			
					$query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
					$query_args['meta_query']   = array_filter( $query_args['meta_query'] );
			
					$r = new WP_Query($query_args);
			
					if ( $r->have_posts() ) {
			
						echo $before_widget;
			
						if ( $title )
							echo $before_title . $title . $after_title;
			
						echo '<ul class="product_list_widget">';
			
						while ( $r->have_posts()) {
							$r->the_post();
							global $product;
			
							echo '<li>
								<a href="' . get_permalink() . '">
									' . get_the_title() . '
								</a> ' . $product->get_price_html() . '
							</li>';
						}
			
						echo '</ul>';
			
						echo $after_widget;
					}
			
					$content = ob_get_clean();
			
					if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;
			
					echo $content;
			
					wp_cache_set('widget_recent_products', $cache, 'widget');
				}
			
				/**
				 * update function.
				 *
				 * @see WP_Widget->update
				 * @access public
				 * @param array $new_instance
				 * @param array $old_instance
				 * @return array
				 */
				function update( $new_instance, $old_instance ) {
					$instance = $old_instance;
					$instance['title'] = strip_tags($new_instance['title']);
					$instance['number'] = (int) $new_instance['number'];
					$instance['show_variations'] = !empty($new_instance['show_variations']) ? 1 : 0;
			
					$this->flush_widget_cache();
			
					$alloptions = wp_cache_get( 'alloptions', 'options' );
					if ( isset($alloptions['widget_recent_products']) ) delete_option('widget_recent_products');
			
					return $instance;
				}
			
				function flush_widget_cache() {
					wp_cache_delete('widget_recent_products', 'widget');
				}
			
				/**
				 * form function.
				 *
				 * @see WP_Widget->form
				 * @access public
				 * @param array $instance
				 * @return void
				 */
				function form( $instance ) {
					$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
					if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
						$number = 5;
			
					$show_variations = isset( $instance['show_variations'] ) ? (bool) $instance['show_variations'] : false;
			?>
					<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'woocommerce' ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
			
					<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of products to show:', 'woocommerce' ); ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
			
					<p><input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_variations') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_variations') ); ?>"<?php checked( $show_variations ); ?> />
					<label for="<?php echo $this->get_field_id('show_variations'); ?>"><?php _e( 'Show hidden product variations', 'woocommerce' ); ?></label></p>
			
			<?php
				}
			}
			
			
	/*////////////////////////////////////////////////////////////
	Loops
	////////////////////////////////////////////////////////////*/

		function ttm_best_sellers()
		{
		
			global $woocommerce;
			global $product;	
			
			$query_args = array(
				'posts_per_page' => 4,
				'post_status' 	 => 'publish',
				'post_type' 	 => 'product',
				'meta_key' 		 => 'total_sales',
				'orderby' 		 => 'meta_value_num',
				'no_found_rows'  => 1,
			);
			
			if ( isset( $instance['hide_free'] ) && 1 == $instance['hide_free'] ) {
				$query_args['meta_query'][] = array(
					'key'     => '_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'DECIMAL',
				);
			}
			
			$r = new WP_Query($query_args);
			
			if ( $r->have_posts() ) {
			?>
			
				<ul class="products">
			
					<?php
					while ( $r->have_posts()) {
						$r->the_post();
					?>
				
						<li class="product"> 
						
							<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
				
							<a href="<?php the_permalink(); ?>">
                            
                            	<h3><?php the_title(); ?></h3>
			   
								<?php the_post_thumbnail( 'product-homepage' ); ?>
					
								<?php
								/**
								 * woocommerce_before_shop_loop_item_title hook
								 *
								 * @hooked woocommerce_show_product_loop_sale_flash - 10
								 * @hooked woocommerce_template_loop_product_thumbnail - 10
								 */
								do_action( 'woocommerce_before_shop_loop_item_title' );
		
								/**
								 * woocommerce_after_shop_loop_item_title hook
								 *
								 * @hooked woocommerce_template_loop_price - 10
								 */
								do_action( 'woocommerce_after_shop_loop_item_title' );
								?>
							
							</a>
		
							<div class="buy-wrapper">
								<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>   
							</div><!-- end buy-wrapper -->
						
						</li>
					<?php
					}
					?>
				
				</ul>
			<?php
			}
			wp_reset_query();
		} 
		
		function ttm_top_rated()
		{
			
			global $woocommerce;
			global $product;	
				
			add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
			
			$query_args = array(
				'posts_per_page' => 4, 
				'no_found_rows' => 1, 
				'post_status' => 'publish', 
				'post_type' => 'product' 
			);
		
			$query_args['meta_query'] = $woocommerce->query->get_meta_query();
		
			$top_rated_posts = new WP_Query( $query_args );
		
			if ($top_rated_posts->have_posts()) :
			?>
			
				<ul class="products">
				
					<?php 
					while ($top_rated_posts->have_posts()) :
						$top_rated_posts->the_post(); 
					?>
		
						<li class="product"> 
						
							<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
						
							<a href="<?php the_permalink(); ?>">
                            
                            	<h3><?php the_title(); ?></h3>
							
								<?php the_post_thumbnail( 'product-homepage' ); ?>
						
								<?php
									/**
									 * woocommerce_before_shop_loop_item_title hook
									 *
									 * @hooked woocommerce_show_product_loop_sale_flash - 10
									 * @hooked woocommerce_template_loop_product_thumbnail - 10
									 */
									do_action( 'woocommerce_before_shop_loop_item_title' );
						
									/**
									 * woocommerce_after_shop_loop_item_title hook
									 *
									 * @hooked woocommerce_template_loop_price - 10
									 */
									do_action( 'woocommerce_after_shop_loop_item_title' );
								?>
								
							</a>
						
							<div class="buy-wrapper">
								<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>   
							</div><!-- end buy-wrapper -->
						
						</li>
					
				   <?php endwhile; ?>
					
				</ul>
						
			<?php endif; 
			
			wp_reset_query();
		
		} 
			
		function ttm_recently_added()
		{
		
			global $woocommerce;
			global $product;
			
			remove_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) ); //Remove the filter used in the function above for ordering posts by rating
			
			$query_args = array(
				'posts_per_page' => 4, 
				'no_found_rows' => 1, 
				'post_status' => 'publish', 
				'post_type' => 'product'
			);
		
			$query_args['meta_query'] = array();
			$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
			$query_args['parent'] = '0';
			$query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
			$query_args['meta_query']   = array_filter( $query_args['meta_query'] );
		
			$recent = new WP_Query($query_args);
		
			if ( $recent->have_posts() ):
			?>
			
				<ul class="products">
		
				<?php
				while ( $recent->have_posts()):
					$recent->the_post();
				?>
		
					<li class="product"> 
						
						<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
					
						<a href="<?php the_permalink(); ?>">
                        
                        	<h3><?php the_title(); ?></h3>
						
							<?php the_post_thumbnail( 'product-homepage' ); ?>
					
							<?php
								/**
								 * woocommerce_before_shop_loop_item_title hook
								 *
								 * @hooked woocommerce_show_product_loop_sale_flash - 10
								 * @hooked woocommerce_template_loop_product_thumbnail - 10
								 */
								do_action( 'woocommerce_before_shop_loop_item_title' );
					
								/**
								 * woocommerce_after_shop_loop_item_title hook
								 *
								 * @hooked woocommerce_template_loop_price - 10
								 */
								do_action( 'woocommerce_after_shop_loop_item_title' );
							?>
							
						</a>
					
						<div class="buy-wrapper">
							<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>   
						</div><!-- end buy-wrapper -->
						
					</li>
						
				<?php endwhile; ?>
				 
				</ul>
				 
			<?php endif; 
			
			wp_reset_query();

		}