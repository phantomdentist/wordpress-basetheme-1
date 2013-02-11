<?php
/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'load_widgets' );

/* Function that registers our widget. */
function load_widgets() 
{
	register_widget( 'tmm_child_parent_menu' );
	//register_widget( 'tmm_social_widget' );
	//register_widget( 'tmm_quotation_widget' );
	register_widget( 'tmm_cta_widget' );
}

/*------------------------------------------------------------------------------
Child sibling widget
------------------------------------------------------------------------------*/
class tmm_child_parent_menu extends WP_Widget 
{

	function tmm_child_parent_menu() 
	{
		parent::WP_Widget(false, $name = 'Child & Sibling Menu');
	}
	
	function widget( $args, $instance ) 
	{
		extract( $args );

		global $post;// if outside the loop
		$post_type = '&post_type='.get_post_type(); 
		$children = get_pages('child_of='.$post->ID.$post_type);
		$parent_title = get_the_title($post->post_parent);
		$parent_permalink = get_permalink($post->post_parent);
	 
		//child pages	
		if ( $post->post_parent && count( $children ) == 0 && !is_search() && !is_404() && !is_single() && !is_archive()  && !is_home() )
		{ ?> 
        
        	<?php echo $before_widget;/* Before widget (defined by themes). */ ?>
        
        	<?php echo $before_title; ?>
            <?php echo '<a href="'.$parent_permalink.'">'.$parent_title.'</a>'; ?>
            <?php echo $after_title; ?>
            <ul class="parent-page-children">
            <?php wp_list_pages( 'title_li=&child_of='.$post->post_parent.'&sort_column=menu_order'.$post_type ); ?>
            </ul>
            
            <?php echo $after_widget;;/* Before widget (defined by themes). */ ?>
            
			<?php
		} 
	
		//parent pages
		elseif ( count( $children ) != 0 && !is_search() && !is_404() && !is_single() && !is_archive() && !is_home() )
		{ ?>
        
        	<?php echo $before_widget;/* Before widget (defined by themes). */ ?>
        
        	<?php echo $before_title; ?>
            <?php the_title(); ?>
             <?php echo $after_title; ?>
            <ul class="parent-page-children">
            <?php wp_list_pages( 'title_li=&child_of='.$post->ID.'&sort_column=menu_order'.$post_type ); ?>
            </ul>
            
            <?php echo $after_widget;;/* Before widget (defined by themes). */ ?>
            
			<?php 
		} 	
	
	}

	function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		return $instance;
	}

	function form( $instance ) 
	{		
	?>       

	<?php
	}
}

/*------------------------------------------------------------------------------
Social widget
------------------------------------------------------------------------------*/
class tmm_social_widget extends WP_Widget {

	function tmm_social_widget() 
	{
		parent::WP_Widget(false, $name = 'Social');
	}
	
	function widget( $args, $instance ) 
	{
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		?>
		
		<?php if( get_field('facebook_link', 'options' ) ) { ?> <a class="social-icon facebook" href="<?php the_field('facebook_link', 'options') ?>"></a> <?php } ?>
        
		<?php if( get_field('twitter_link', 'options' ) ) { ?> <a class="social-icon twitter" href="<?php the_field('twitter_link', 'options') ?>"></a> <?php } ?>
        
		<?php if( get_field('linkedin_link', 'options' ) ) { ?> <a class="social-icon linkedin" href="<?php the_field('linkedin_link', 'options') ?>"></a> <?php } ?>
        
		<div class="clear"></div>
		
		<?php

		echo $after_widget;
	}

	function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form( $instance ) 
	{		

		?>       
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_name( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />        
		</p>
		<?php
	}

}

/*------------------------------------------------------------------------------
Quotation Widget
------------------------------------------------------------------------------*/
class tmm_quotation_widget extends WP_Widget 
{
	function tmm_quotation_widget() 
	{
		parent::WP_Widget(false, $name = 'Quotation');
	}
		
	function widget( $args, $instance ) 
	{
		extract( $args );
	
		/* Add user settings */
		$title = $instance['title'];
		$quote = $instance['quote'];
		$author = $instance['author'];
	
		/* Output Before widget (defined by themes) */
		echo $before_widget;
	
		/* Output widget title (before and after defined by themes) */
		if ( $title )
			echo $before_title . $title . $after_title;
		else
			echo '<div class="no-title"></div>';
	
		/* Output widget content */
		echo '<p><span class="quote-mark">"</span>'.$quote.'<span class="quote-mark">"</span></p>';
		echo '<div class="quote-widget-author">'.$author.'</div>';
	
		/* Output After widget (defined by themes) */
		echo $after_widget;
	}
	
	 function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['quote'] = strip_tags($new_instance['quote']);
		$instance['author'] = strip_tags($new_instance['author']);
		return $instance;
	}
	
	function form( $instance ) 
	{
		#$title = esc_attr($instance['title']);	
		?> 	  
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_name( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />        
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'quote' ); ?>">Quote:</label>
			<textarea id="<?php echo $this->get_field_name( 'quote' ); ?>" name="<?php echo $this->get_field_name( 'quote' ); ?>" style="width:100%;"><?php echo $instance['quote']; ?></textarea>        
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'author' ); ?>">Author:</label>
			<input id="<?php echo $this->get_field_name( 'author' ); ?>" name="<?php echo $this->get_field_name( 'author' ); ?>" value="<?php echo $instance['author']; ?>" style="width:100%;" />        
		</p>
		<?php
	}
}

/*------------------------------------------------------------------------------
CTA Widget
------------------------------------------------------------------------------*/
class tmm_cta_widget extends WP_Widget 
{
	function tmm_cta_widget() 
	{
		parent::WP_Widget(false, $name = 'Call to action');
	}
		
	function widget( $args, $instance ) 
	{
		extract( $args );
			
		/* Add user settings */
		$cta = $instance['cta'];
		$detail = $instance['detail'];
		$link = $instance['link'];

		/* Output Before widget (defined by themes) */
		echo $before_widget;
	
		/* Output widget title (before and after defined by themes) */
	
		echo '<a href="'.$link.'">';
		echo '<span class="cta">'.$cta.'</span>';
		echo '<span class="detail">'.$detail.'</span>';
		echo '</a>';
	
		/* Output After widget (defined by themes) */
		echo $after_widget;
	}
	
	 function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['cta'] = $new_instance['cta'];
		$instance['detail'] = $new_instance['detail'];
		$instance['link'] = $new_instance['link'];
		return $instance;
	}
	
	function form( $instance ) 
	{
		#$title = esc_attr($instance['title']);	
		?> 	  
		<p>
			<label for="<?php echo $this->get_field_name( 'cta' ); ?>">Call to action:</label>
			<input id="<?php echo $this->get_field_name( 'cta' ); ?>" name="<?php echo $this->get_field_name( 'cta' ); ?>" value="<?php echo $instance['cta']; ?>" style="width:100%;" />        
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'detail' ); ?>">Detail:</label>
			<textarea id="<?php echo $this->get_field_name( 'detail' ); ?>" name="<?php echo $this->get_field_name( 'detail' ); ?>" style="width:100%;"><?php echo $instance['detail']; ?></textarea>        
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'link' ); ?>">Link:</label>
			<textarea id="<?php echo $this->get_field_name( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" style="width:100%;"><?php echo $instance['link']; ?></textarea>        
		</p>
		<?php
	}	
	
}
?>