<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */

$putter_link        = get_permalink();
$putter_post_format = get_post_format();
$putter_post_format = empty( $putter_post_format ) ? 'standard' : str_replace( 'post-format-', '', $putter_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $putter_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	putter_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'putter_filter_related_thumb_size', putter_get_thumb_size( (int) putter_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
			'post_info'     => '<div class="post_header entry-header">'
									. '<div class="post_categories">' . wp_kses( putter_get_post_categories( '' ), 'putter_kses_content' ) . '</div>'
									. '<h6 class="post_title entry-title"><a href="' . esc_url( $putter_link ) . '">'
										. wp_kses_data( '' == get_the_title() ? esc_html__( '- No title -', 'putter' ) : get_the_title() )
									. '</a></h6>'
									. ( in_array( get_post_type(), array( 'post', 'attachment' ) )
											? '<div class="post_meta"><a href="' . esc_url( $putter_link ) . '" class="post_meta_item post_date">' . wp_kses_data( putter_get_date() ) . '</a></div>'
											: '' )
								. '</div>',
		)
	);
	?>
</div>
