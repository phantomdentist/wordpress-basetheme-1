<?php
/*////////////////////////////////////////////////////////////
Woocommerce
////////////////////////////////////////////////////////////*/

	/*////////////////////////////////////////////////////////////
	Add wrappers
	////////////////////////////////////////////////////////////*/

		//Remove default top content wrapper and replace with custom
		remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		add_action('woocommerce_before_main_content', 'ttm_woocommerce_wrapper_top', 10);
		function ttm_woocommerce_wrapper_top(){
			get_header();
			?>
			<div class="container-main clearfix">
				<div class="page-header clearfix">
					
                    <div class="page-header-left">
						<?php do_action('woocommerce_custom_breadcrumb'); ?>
                    </div><!-- end page-header-left-->
                    
                    <?php if( is_product() ){
						get_template_part('templates/social-share'); 
					}
					?>
                    
				</div><!-- end page-header -->
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
				<?php if( !is_product() ){ ?>
					<aside class="sidebar"><?php get_sidebar(2); ?></aside>
				<?php } ?>
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
		
		//Add wrapper around product category for product info (title, price etc)
		add_action( 'woocommerce_before_shop_loop_item_title', 'ttm_woocommerce_before_category_item', 20 );
		function ttm_woocommerce_before_category_item(){
			echo '<div class="details-wrapper">';
		}
		
		add_action( 'woocommerce_after_shop_loop_item_title', 'ttm_woocommerce_after_category_item', 20 );
		function ttm_woocommerce_after_category_item(){
			echo '</div><!-- end details-wrapper -->';
		}
	
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
		add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 20 );
		
		//Remove product count on category pages
		remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
		
		//Remove meta from single product pages
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
		
		//Remove related products
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
		
		//Breadcrumb separator
		add_filter( 'woocommerce_breadcrumb_defaults', 'ttm_change_breadcrumb_delimiter' );
		function ttm_change_breadcrumb_delimiter( $defaults ) {
			// Change the breadcrumb delimeter from '/' to '>'
			$defaults['delimiter'] = ' <span class="separator">&gt;</span> ';
			return $defaults;
		}
		
	/*////////////////////////////////////////////////////////////
	Remove plugin widgets
	////////////////////////////////////////////////////////////*/
	
		add_action( 'widgets_init', 'ttm_unregister_woocommerce_widgets' );
		
		function ttm_unregister_woocommerce_widgets() {
			
			unregister_widget( 'WC_Widget_Best_Sellers' );
			unregister_widget( 'WC_Widget_Cart' );
			unregister_widget( 'WC_Widget_Featured_Products' );
			unregister_widget( 'WC_Widget_Layered_Nav_Filters' );
			unregister_widget( 'WC_Widget_Layered_Nav' );
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
		
	/*////////////////////////////////////////////////////////////
	Move stuff
	////////////////////////////////////////////////////////////*/

		//Move single page price below summary
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
		add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 25);
				
		//Add pagination to top of category pages (already at bottom)
		add_action('woocommerce_before_shop_loop', 'woocommerce_pagination', 30);
		
		//Add clear and border after top pagination and sorting
		add_action('woocommerce_before_shop_loop', 'ttm_clear', 40);
		function ttm_clear(){
			echo '<div class="clear divider"></div>';
		}
		
		//Add product ordering to bottom of category pages (already at top)
		add_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 5);
		
		//Move category product rating
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );

	/*////////////////////////////////////////////////////////////
	General functions
	////////////////////////////////////////////////////////////*/
		
	/*////////////////////////////////////////////////////////////
	Project specific functions
	////////////////////////////////////////////////////////////*/	