<?php
/**
 * The template to display single post
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */

// Full post loading
$full_post_loading          = putter_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = putter_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = putter_get_theme_option( 'posts_navigation_scroll_which_block', 'article' );

// Position of the related posts
$putter_related_position   = putter_get_theme_option( 'related_position', 'below_content' );

// Type of the prev/next post navigation
$putter_posts_navigation   = putter_get_theme_option( 'posts_navigation' );
$putter_prev_post          = false;
$putter_prev_post_same_cat = (int)putter_get_theme_option( 'posts_navigation_scroll_same_cat', 1 );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( putter_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	putter_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'putter_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $putter_posts_navigation ) {
		$putter_prev_post = get_previous_post( $putter_prev_post_same_cat );  // Get post from same category
		if ( ! $putter_prev_post && $putter_prev_post_same_cat ) {
			$putter_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $putter_prev_post ) {
			$putter_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $putter_prev_post ) ) {
		putter_sc_layouts_showed( 'featured', false );
		putter_sc_layouts_showed( 'title', false );
		putter_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $putter_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/content', 'single-' . putter_get_theme_option( 'single_style' ) ), 'single-' . putter_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $putter_related_position, 'inside' ) === 0 ) {
		$putter_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'putter_action_related_posts' );
		$putter_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $putter_related_content ) ) {
			$putter_related_position_inside = max( 0, min( 9, putter_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $putter_related_position_inside ) {
				$putter_related_position_inside = mt_rand( 1, 9 );
			}

			$putter_p_number         = 0;
			$putter_related_inserted = false;
			$putter_in_block         = false;
			$putter_content_start    = strpos( $putter_content, '<div class="post_content' );
			$putter_content_end      = strrpos( $putter_content, '</div>' );

			for ( $i = max( 0, $putter_content_start ); $i < min( strlen( $putter_content ) - 3, $putter_content_end ); $i++ ) {
				if ( $putter_content[ $i ] != '<' ) {
					continue;
				}
				if ( $putter_in_block ) {
					if ( strtolower( substr( $putter_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$putter_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $putter_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $putter_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$putter_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $putter_content[ $i + 1 ] && in_array( $putter_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$putter_p_number++;
					if ( $putter_related_position_inside == $putter_p_number ) {
						$putter_related_inserted = true;
						$putter_content = ( $i > 0 ? substr( $putter_content, 0, $i ) : '' )
											. $putter_related_content
											. substr( $putter_content, $i );
					}
				}
			}
			if ( ! $putter_related_inserted ) {
				if ( $putter_content_end > 0 ) {
					$putter_content = substr( $putter_content, 0, $putter_content_end ) . $putter_related_content . substr( $putter_content, $putter_content_end );
				} else {
					$putter_content .= $putter_related_content;
				}
			}
		}

		putter_show_layout( $putter_content );
	}

	// Comments
	do_action( 'putter_action_before_comments' );
	comments_template();
	do_action( 'putter_action_after_comments' );

	// Related posts
	if ( 'below_content' == $putter_related_position
		&& ( 'scroll' != $putter_posts_navigation || (int)putter_get_theme_option( 'posts_navigation_scroll_hide_related', 0 ) == 0 )
		&& ( ! $full_post_loading || (int)putter_get_theme_option( 'open_full_post_hide_related', 1 ) == 0 )
	) {
		do_action( 'putter_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $putter_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $putter_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $putter_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $putter_prev_post ) ); ?>"
			data-cur-post-link="<?php echo esc_attr( get_permalink() ); ?>"
			data-cur-post-title="<?php the_title_attribute(); ?>"
			<?php do_action( 'putter_action_nav_links_single_scroll_data', $putter_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
