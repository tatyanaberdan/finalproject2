<?php
/** 
 * @package Reading_List
 * @version 0.1
 Code modified from https://github.com/andrewspittle/reading-list/blob/master/index.php
 */
/*
Plugin Name: Book Review Custom Post
Plugin URI: http://andrewspittle.net/projects/reading-list??
Description: A custom post type for writing book reivews.
Author: Tat'yana Berdan 
Version: 0.1
Author URI: http://tatyanaberdan.com
*/
/**
 * Start up our custom post type and hook it in to the init action when that fires.
 *
 * @since Reading List 0.1
 */
add_action( 'init', 'rl_create_post_type' );
function rl_create_post_type() {
	$labels = array(
		'name' 							=> __( 'Book Reivews', 'post type general name' ),
		'singular_name' 				=> __( 'Book Review', 'post type singular name' ),
		'search_items'					=> __( 'Search Book Reivews' ),
		'all_items'						=> __( 'All Book Reviews' ),
		'edit_item'						=> __( 'Edit Book Review' ),
		'update_item' 					=> __( 'Update Book Review' ),
		'add_new_item' 					=> __( 'Add New Book Review' ),
		'new_item_name' 				=> __( 'New Book Review' ),
		'menu_name' 					=> __( 'Book Reviews' ),
	);
	
	$args = array (
		'labels' 		=> $labels,
		'public' 		=> true,
		'menu_position' => 20,
		'has_archive' 	=> true,
		'rewrite'		=> array( 'slug' => 'book reviews' ),
		'supports' 		=> array( 'title', 'thumbnail', 'editor' )
	);
	register_post_type( 'rl_book reviews', $args );
}
/**
 * Create our custom taxonomies. One hierarchical one for genres and a flat one for authors.
 *
 * @since Reading List 0.1
 */
/* Hook in to the init action and call rl_create_bookreview_taxonomies when it fires. */
add_action( 'init', 'rl_create_bookreview_taxonomies', 0 );
function rl_create_bookreview_taxonomies() {
	// Add new taxonomy, keep it non-hierarchical (like tags)
	$labels = array(
		'name' 							=> __( 'Authors', 'taxonomy general name' ),
		'singular_name' 				=> __( 'Author', 'taxonomy singular name' ),
		'search_items' 					=> __( 'Search Authors'),
		'all_items' 					=> __( 'All Authors' ),
		'edit_item' 					=> __( 'Edit Author' ), 
		'update_item' 					=> __( 'Update Author' ),
		'add_new_item' 					=> __( 'Add New Author' ),
		'new_item_name' 				=> __( 'New Author Name' ),
		'separate_items_with_commas' 	=> __( 'Separate authors with commas' ),
		'choose_from_most_used' 		=> __( 'Choose from the most used authors' ),
		'menu_name' 					=> __( 'Authors' ),
	); 	
		
	register_taxonomy( 'book-author', array( 'rl_bookreview' ), array(
		'hierarchical' 		=> false,
		'labels' 			=> $labels,
		'show_ui' 			=> true,
		'show_admin_column' => true,
		'query_var' 		=> true,
		'rewrite' 			=> array( 'slug' => 'book-author' ),
	));
}
/**
 * Add custom meta box for rating a book. 
 *
 * Props to Justin Tadlock: http://wp.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/
 *
 * @since Reading List 1.0???
 *
*/
/* Fire our meta box setup function on the editor screen. */
add_action( 'load-post.php', 'rl_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'rl_post_meta_boxes_setup' );
/* Our meta box set up function. */
function rl_post_meta_boxes_setup() {
	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'rl_add_post_meta_boxes' );
	
	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'rl_pages_save_meta', 10, 2 );
}
/* Create one or more meta boxes to be displayed on the post editor screen. */
function rl_add_post_meta_boxes() {
	add_meta_box(
		'rl-rating',								// Unique ID
		esc_html__( 'Rating', 'example' ),		// Title
		'rl_rating_meta_box',					// Callback function
		'rl_bookreview',								// Add metabox to our custom post type
		'side',									// Context
		'default'								// Priority
	);
}
/* Display the post meta box. */
function rl_rating_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'rl_rating_nonce' ); ?>

	<p class="howto"><label for="rl-rating"><?php _e( "Rate the book on a scale of 1 to 10.", 'example' ); ?></label></p>
	<p><input class="widefat" type="text" name="rl-rating" id="rl-rating" value="<?php echo esc_attr( get_post_meta( $object->ID, 'rl_rating', true ) ); ?>" size="30" /></p>
<?php }
/* Save the meta box's data. */
function rl_rating_save_meta( $post_id, $post ) {
	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['rl_rating_nonce'] ) || !wp_verify_nonce( $_POST['rl_rating_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );
	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['rl-rating'] ) ? sanitize_html_class( $_POST['rl-rating'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'rl_rating';
	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );
	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
} 
?>