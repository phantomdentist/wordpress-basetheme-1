<?php
/*////////////////////////////////////////////////////////////
Make custom taxonomy use checkboxes like blog categories
////////////////////////////////////////////////////////////*/
add_action('add_meta_boxes_tours', 'ttm_checkbox_taxonomies_tours');

function ttm_checkbox_taxonomies_tours ($post) {

    $taxoms = array('destinations', 'grades', 'categories', 'themes', 'month', 'type', 'duration' );

    foreach ( get_object_taxonomies( $post ) as $tax_name ) {
        if( !in_array($tax_name, $taxoms) ) continue;

        $taxonomy = get_taxonomy($tax_name);
        if ( ! $taxonomy->show_ui )
            continue;

        $label = $taxonomy->labels->name;

        if ( !is_taxonomy_hierarchical($tax_name) ) {
            add_meta_box($tax_name . 'div', $label, 'post_categories_meta_box', null, 'side', 'core', array( 'taxonomy' => $tax_name ));
            remove_meta_box('tagsdiv-' . $tax_name, null, 'side');
        }
    }
}

/*////////////////////////////////////////////////////////////
Replace custom taxonomy dropdown with select

Assumes post type of tours and taxonomy of destinations
////////////////////////////////////////////////////////////*/
function custom_meta_box() {

    remove_meta_box( 'tagsdiv-destinations', 'tours', 'side' );

    add_meta_box( 'tagsdiv-destinations', 'Destinations', 'destinations_meta_box', 'tours', 'side' );

}
add_action('add_meta_boxes', 'custom_meta_box');

/* Prints the taxonomy box content */
function destinations_meta_box($post) {

    $tax_name = 'destinations';
    $taxonomy = get_taxonomy($tax_name);
?>
<div class="tagsdiv" id="<?php echo $tax_name; ?>">
    <div class="jaxtag">
    <?php 
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'destinations_noncename' );
    $destination_IDs = wp_get_object_terms( $post->ID, 'destinations', array('fields' => 'ids') );
    wp_dropdown_categories('taxonomy=destinations&hide_empty=0&orderby=name&name=destinations&show_option_none=Select destination&selected='.$destination_IDs[0]); ?>
    <p class="howto">Select your destination</p>
    </div>
</div>
<?php
}

/* When the post is saved, saves our custom taxonomy */
function destinations_save_postdata( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['destinations_noncename'], plugin_basename( __FILE__ ) ) )
      return;


  // Check permissions
  if ( 'tours' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // OK, we're authenticated: we need to find and save the data

  $destination_ID = $_POST['destinations'];

  $destination = ( $destination_ID > 0 ) ? get_term( $destination_ID, 'destinations' )->slug : NULL;

  wp_set_object_terms(  $post_id , $destination, 'destinations' );

}
/* Do something with the data entered */
add_action( 'save_post', 'destinations_save_postdata' );
