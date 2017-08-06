<?php
// enqueue 
function my_theme_enqueue_styles() {

    $parent_style = 'twentyseventeen-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
?>
<?php
// adding custom post type to regular RSS feed to get custom post type to show up in blog - code adapted from http://www.wpbeginner.com/wp-tutorials/how-to-add-custom-post-types-to-your-main-wordpress-rss-feed/
function myfeed_request($qv) {
    if (isset($qv['feed']))
        $qv['post_type'] = array('rl_bookreviews');
    return $qv;
}
add_filter('request', 'myfeed_request'); 
?>