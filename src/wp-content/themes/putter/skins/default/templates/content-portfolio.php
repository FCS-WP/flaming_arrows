<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */

$putter_template_args = get_query_var( 'putter_template_args' );
if ( is_array( $putter_template_args ) ) {
	$putter_columns    = empty( $putter_template_args['columns'] ) ? 2 : max( 1, $putter_template_args['columns'] );
	$putter_blog_style = array( $putter_template_args['type'], $putter_columns );
    $putter_columns_class = putter_get_column_class( 1, $putter_columns, ! empty( $putter_template_args['columns_tablet']) ? $putter_template_args['columns_tablet'] : '', ! empty($putter_template_args['columns_mobile']) ? $putter_template_args['columns_mobile'] : '' );
} else {
	$putter_template_args = array();
	$putter_blog_style = explode( '_', putter_get_theme_option( 'blog_style' ) );
	$putter_columns    = empty( $putter_blog_style[1] ) ? 2 : max( 1, $putter_blog_style[1] );
    $putter_columns_class = putter_get_column_class( 1, $putter_columns );
}

$putter_post_format = get_post_format();
$putter_post_format = empty( $putter_post_format ) ? 'standard' : str_replace( 'post-format-', '', $putter_post_format );

?><div class="
<?php
if ( ! empty( $putter_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( putter_is_blog_style_use_masonry( $putter_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $putter_columns ) : esc_attr( $putter_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $putter_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $putter_columns )
		. ( 'portfolio' != $putter_blog_style[0] ? ' ' . esc_attr( $putter_blog_style[0] )  . '_' . esc_attr( $putter_columns ) : '' )
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

	$putter_hover   = ! empty( $putter_template_args['hover'] ) && ! putter_is_inherit( $putter_template_args['hover'] )
								? $putter_template_args['hover']
								: putter_get_theme_option( 'image_hover' );

	if ( 'dots' == $putter_hover ) {
		$putter_post_link = empty( $putter_template_args['no_links'] )
								? ( ! empty( $putter_template_args['link'] )
									? $putter_template_args['link']
									: get_permalink()
									)
								: '';
		$putter_target    = ! empty( $putter_post_link ) && putter_is_external_url( $putter_post_link )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$putter_components = ! empty( $putter_template_args['meta_parts'] )
							? ( is_array( $putter_template_args['meta_parts'] )
								? $putter_template_args['meta_parts']
								: explode( ',', $putter_template_args['meta_parts'] )
								)
							: putter_array_get_keys_by_value( putter_get_theme_option( 'meta_parts' ) );

	// Featured image
	putter_show_post_featured( apply_filters( 'putter_filter_args_featured',
        array(
			'hover'         => $putter_hover,
			'no_links'      => ! empty( $putter_template_args['no_links'] ),
			'thumb_size'    => ! empty( $putter_template_args['thumb_size'] )
								? $putter_template_args['thumb_size']
								: putter_get_thumb_size(
									putter_is_blog_style_use_masonry( $putter_blog_style[0] )
										? (	strpos( putter_get_theme_option( 'body_style' ), 'full' ) !== false || $putter_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( putter_get_theme_option( 'body_style' ), 'full' ) !== false || $putter_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => putter_is_blog_style_use_masonry( $putter_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $putter_components,
			'class'         => 'dots' == $putter_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $putter_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $putter_post_link )
												? '<a href="' . esc_url( $putter_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $putter_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $putter_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $putter_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!