<?php
/**
 * @package bookreviews
 * @version 0.1
 */
/*
Plugin Name: Book Reviews
Plugin URI: http://tatyanaberdan.com/book-reviews
Description: Review books I've read.
Author: Tat'yana Berdan
Version: 0.1
Author URI: http://tatyanaberdan.com
Code adapted from Andre Spittle's Book List plugin: https://github.com/andrewspittle/reading-list/blob/master/index.php
*/
/**
 *
 * @since bookreviews 0.1
 */
add_action( 'init', 'rl_create_post_type' );
function rl_create_post_type() {
	$labels = array(
		'name' 							=> __( 'Book Reviews', 'bookreviews' ),
		'singular_name' 				=> __( 'Book Review', 'bookreviews' ),
		'search_items'					=> __( 'Search Book Reviews', 'bookreviews' ),
		'all_items'						=> __( 'All Book Reviews', 'bookreviews' ),
		'edit_item'						=> __( 'Edit Book Review', 'bookreviews' ),
		'update_item' 					=> __( 'Update Book Review', 'bookreviews' ),
		'add_new_item' 					=> __( 'Add New Book Review', 'bookreviews' ),
		'new_item_name' 				=> __( 'New Book Review', 'bookreviews' ),
		'menu_name' 					=> __( 'Book Reviews', 'bookreviews' ),
	);
	$args = array (
		'labels' 		=> $labels,
		'public' 		=> true,
		'menu_position' => 20,
		'has_archive' 	=> true,
		'rewrite'		=> array( 'slug' => 'reviews' ),
		'supports' 		=> array( 'title', 'thumbnail', 'editor' ),
		'taxonomies'	=> array( 'category' )
	);
	register_post_type( 'rl_bookreviews', $args );
}
/**
 *
 * @since Reading List 0.1
 */
add_action( 'init', 'rl_create_bookreviews_taxonomies', 0 );
function rl_create_bookreviews_taxonomies() {
	$labels = array(
		'name' 							=> __( 'Authors', 'bookreviews' ),
		'singular_name' 				=> __( 'Author', 'bookreviews' ),
		'search_items' 					=> __( 'Search Authors', 'bookreviews' ),
		'all_items' 					=> __( 'All Authors', 'bookreviews' ),
		'edit_item' 					=> __( 'Edit Author', 'bookreviews' ), 
		'update_item' 					=> __( 'Update Author', 'bookreviews' ),
		'add_new_item' 					=> __( 'Add New Author', 'bookreviews' ),
		'new_item_name' 				=> __( 'New Author Name', 'bookreviews' ),
		'separate_items_with_commas' 	=> __( 'Separate authors with commas', 'bookreviews' ),
		'choose_from_most_used' 		=> __( 'Choose from the most used authors', 'bookreviews' ),
		'menu_name' 					=> __( 'Authors', 'bookreviews' ),
	); 	
	register_taxonomy( 'book-author', array( 'rl_bookreviews' ), array(
		'hierarchical' 		=> false,
		'labels' 			=> $labels,
		'show_ui' 			=> true,
		'show_admin_column' => true,
		'query_var' 		=> true,
		'rewrite' 			=> array( 'slug' => 'book-author' ),
	));
	$labels = array(
		'name' 							=> __( 'Genres', 'bookreviews' ),
		'singular_name' 				=> __( 'Genre', 'bookreviews' ),
		'search_items' 					=> __( 'Search Genres', 'bookreviews' ),
		'all_items' 					=> __( 'All Genres', 'bookreviews' ),
		'edit_item' 					=> __( 'Edit Genre', 'bookreviews' ), 
		'update_item' 					=> __( 'Update Genre', 'bookreviews' ),
		'add_new_item' 					=> __( 'Add New Genre', 'bookreviews' ),
		'new_item_name' 				=> __( 'New Genre Type', 'bookreviews' ),
		'separate_items_with_commas' 	=> __( 'Separate genres with commas', 'bookreviews' ),
		'choose_from_most_used' 		=> __( 'Choose from the most used genres', 'bookreviews' ),
		'menu_name' 					=> __( 'Genres', 'bookreviews' ),
	); 	
	register_taxonomy( 'book-genre', array( 'rl_bookreviews' ), array(
		'hierarchical' 		=> false,
		'labels' 			=> $labels,
		'show_ui' 			=> true,
		'show_admin_column' => true,
		'query_var' 		=> true,
		'rewrite' 			=> array( 'slug' => 'book-genre' ),
	));
}
/**
 * Add custom meta box for tracking the rating and page numbers of the book.
 *
 * Adapted from code by Justin Tadlock: http://wp.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/
 *
 * @since Reading List 1.0
 *
*/
add_action( 'load-post.php', 'rl_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'rl_post_meta_boxes_setup' );
function rl_post_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'rl_add_post_meta_boxes' );
	add_action( 'save_post', 'rl_rating_save_meta', 10, 2 );
	add_action( 'save_post', 'rl_pages_save_meta', 10, 2 );
}
function rl_add_post_meta_boxes() {
	add_meta_box(
		'rl-rating',								// Unique ID
		esc_html__( 'Rating', 'example' ),		// Title
		'rl_rating_meta_box',					// Callback function
		'rl_bookreviews',								// Add metabox to our custom post type
		'side',									// Context
		'default'								// Priority
	);
	add_meta_box(
		'rl-pages',								// Unique ID
		esc_html__( 'Pages', 'example' ),		// Title
		'rl_pages_meta_box',					// Callback function
		'rl_bookreviews',								// Add metabox to our custom post type
		'side',									// Context
		'default'								// Priority
	);
}
function rl_rating_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'rl_rating_nonce' ); ?>
	<p class="howto"><label for="rl-rating"><?php _e( "Rate a book on a scale of one to ten.", 'example' ); ?></label></p>
	<p><input class="widefat" type="text" name="rl-rating" id="rl-rating" value="<?php echo esc_attr( get_post_meta( $object->ID, 'rl_rating', true ) ); ?>" size="30" /></p>
<?php }
function rl_pages_meta_box( $object, $box ) { ?>
<?php wp_nonce_field( basename( __FILE__ ), 'rl_pages_nonce' ); ?>
	<p class="howto"><label for="rl-pages"><?php _e( "How many pages did the book have?", 'example' ); ?></label></p>
	<p><input class="widefat" type="text" name="rl-pages" id="rl-pages" value="<?php echo esc_attr( get_post_meta( $object->ID, 'rl_pages', true ) ); ?>" size="30" /></p>
<?php }
function rl_rating_save_meta( $post_id, $post ) {
	if ( !isset( $_POST['rl_rating_nonce'] ) || !wp_verify_nonce( $_POST['rl_rating_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	$post_type = get_post_type_object( $post->post_type );
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
	$new_meta_value = ( isset( $_POST['rl-rating'] ) ? sanitize_html_class( $_POST['rl-rating'] ) : '' );
	$meta_key = 'rl_rating';
	$meta_value = get_post_meta( $post_id, $meta_key, true );
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
} 
function rl_pages_save_meta( $post_id, $post ) {
	if ( !isset( $_POST['rl_pages_nonce'] ) || !wp_verify_nonce( $_POST['rl_pages_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	$post_type = get_post_type_object( $post->post_type );
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
	$new_meta_value = ( isset( $_POST['rl-pages'] ) ? sanitize_html_class( $_POST['rl-pages'] ) : '' );
	$meta_key = 'rl_pages';
	$meta_value = get_post_meta( $post_id, $meta_key, true );
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value ); } 
	?>