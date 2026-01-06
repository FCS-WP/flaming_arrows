<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package PUTTER
 * @since PUTTER 1.0.50
 */

$putter_template_args = get_query_var( 'putter_template_args' );
if ( is_array( $putter_template_args ) ) {
	$putter_columns    = empty( $putter_template_args['columns'] ) ? 2 : max( 1, $putter_template_args['columns'] );
	$putter_blog_style = array( $putter_template_args['type'], $putter_columns );
} else {
	$putter_template_args = array();
	$putter_blog_style = explode( '_', putter_get_theme_option( 'blog_style' ) );
	$putter_columns    = empty( $putter_blog_style[1] ) ? 2 : max( 1, $putter_blog_style[1] );
}
$putter_blog_id       = putter_get_custom_blog_id( join( '_', $putter_blog_style ) );
$putter_blog_style[0] = str_replace( 'blog-custom-', '', $putter_blog_style[0] );
$putter_expanded      = ! putter_sidebar_present() && putter_get_theme_option( 'expand_content' ) == 'expand';
$putter_components    = ! empty( $putter_template_args['meta_parts'] )
							? ( is_array( $putter_template_args['meta_parts'] )
								? join( ',', $putter_template_args['meta_parts'] )
								: $putter_template_args['meta_parts']
								)
							: putter_array_get_keys_by_value( putter_get_theme_option( 'meta_parts' ) );
$putter_post_format   = get_post_format();
$putter_post_format   = empty( $putter_post_format ) ? 'standard' : str_replace( 'post-format-', '', $putter_post_format );

$putter_blog_meta     = putter_get_custom_layout_meta( $putter_blog_id );
$putter_custom_style  = ! empty( $putter_blog_meta['scripts_required'] ) ? $putter_blog_meta['scripts_required'] : 'none';

if ( ! empty( $putter_template_args['slider'] ) || $putter_columns > 1 || ! putter_is_off( $putter_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $putter_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( putter_is_off( $putter_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $putter_custom_style ) ) . "-1_{$putter_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $putter_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $putter_columns )
					. ' post_layout_' . esc_attr( $putter_blog_style[0] )
					. ' post_layout_' . esc_attr( $putter_blog_style[0] ) . '_' . esc_attr( $putter_columns )
					. ( ! putter_is_off( $putter_custom_style )
						? ' post_layout_' . esc_attr( $putter_custom_style )
							. ' post_layout_' . esc_attr( $putter_custom_style ) . '_' . esc_attr( $putter_columns )
						: ''
						)
		);
	putter_add_blog_animation( $putter_template_args );
	?>
>
	<?php
	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}
	// Custom layout
	do_action( 'putter_action_show_layout', $putter_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $putter_template_args['slider'] ) || $putter_columns > 1 || ! putter_is_off( $putter_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
