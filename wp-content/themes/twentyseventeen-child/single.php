<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0

 Code for displaying 'currently reading' and 'favorite_quote' custom fields adapted from http://www.wpbeginner.com/wp-tutorials/wordpress-custom-fields-101-tips-tricks-and-hacks/#cfoutofloop

 Code for inserting 'what should I read next?' poll into posts adapted from https://wordpress.org/plugins/wp-polls/
 
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/post/content', get_post_format() ); 
				
				echo get_post_meta($post->ID, 'favorite_quote', true); 

				echo get_post_meta($post->ID, 'rl_pages', true);

				echo get_post_meta($post->ID, 'rl_rating', true); 

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				the_post_navigation( array(
					'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'twentyseventeen' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'twentyseventeen' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
				) ); ?> 

				<?php echo get_post_meta($post->ID, 'Currently Reading', true); ?>
				
				<?php if ( function_exists( 'vote_poll' ) && ! in_pollarchive() ): ?>
				<li><?php get_poll(2);?></li> 
				</ul>
				<?php display_polls_archive_link(); ?>
				</li> 
				<?php endif; ?>
			<?php
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
