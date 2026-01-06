<?php
/**
 * The template to display the attachment
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */


get_header();

while ( have_posts() ) {
	the_post();

	// Display post's content
	get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/content', 'single-' . putter_get_theme_option( 'single_style' ) ), 'single-' . putter_get_theme_option( 'single_style' ) );

	// Parent post navigation.
	$putter_posts_navigation = putter_get_theme_option( 'posts_navigation' );
	if ( 'links' == $putter_posts_navigation ) {
		?>
		<div class="nav-links-single<?php
			if ( ! putter_is_off( putter_get_theme_option( 'posts_navigation_fixed', 0 ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation( apply_filters( 'putter_filter_post_navigation_args', array(
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Published in', 'putter' ) . '</span> '
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'putter' ) . '</span> '
						. '<h5 class="post-title">%title</h5>'
						. '<span class="post_date">%date</span>',
			), 'image' ) );
			?>
		</div>
		<?php
	}

	// Comments
	do_action( 'putter_action_before_comments' );
	comments_template();
	do_action( 'putter_action_after_comments' );
}

get_footer();
