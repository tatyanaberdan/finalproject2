<?php
// enqueue 
function my_theme_enqueue_styles() {

    $parent_style = 'twentyseventeen-style';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
?>
<?php
// adding custom post type to regular RSS feed to get custom post type to show up in blog - code adapted from http://justintadlock.com/archives/2010/02/02/showing-custom-post-types-on-your-home-blog-page
add_filter('pre_get_posts', 'my_get_posts');
function my_get_posts($query) {
    if ((is_home() && $query->is_main_query()) || is_feed())
        $query->set('post_type', array( 'post', 'rl_bookreviews'));
    return $query;
}
// Create Slider Post Type
//require( get_template_directory() . 'plugins/slider/slider_post_type.php' );
// Create Slider
//require( get_template_directory() . 'plugins/slider/slider.php' );
?>