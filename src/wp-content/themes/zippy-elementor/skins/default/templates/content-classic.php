<?php
/**
 * The Classic template to display the content
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
$putter_expanded   = ! putter_sidebar_present() && putter_get_theme_option( 'expand_content' ) == 'expand';

$putter_post_format = get_post_format();
$putter_post_format = empty( $putter_post_format ) ? 'standard' : str_replace( 'post-format-', '', $putter_post_format );

?><div class="<?php
	if ( ! empty( $putter_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( putter_is_blog_style_use_masonry( $putter_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $putter_columns ) : esc_attr( $putter_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $putter_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $putter_columns )
				. ' post_layout_' . esc_attr( $putter_blog_style[0] )
				. ' post_layout_' . esc_attr( $putter_blog_style[0] ) . '_' . esc_attr( $putter_columns )
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

	// Featured image
	$putter_hover      = ! empty( $putter_template_args['hover'] ) && ! putter_is_inherit( $putter_template_args['hover'] )
							? $putter_template_args['hover']
							: putter_get_theme_option( 'image_hover' );

	$putter_components = ! empty( $putter_template_args['meta_parts'] )
							? ( is_array( $putter_template_args['meta_parts'] )
								? $putter_template_args['meta_parts']
								: explode( ',', $putter_template_args['meta_parts'] )
								)
							: putter_array_get_keys_by_value( putter_get_theme_option( 'meta_parts' ) );

	putter_show_post_featured( apply_filters( 'putter_filter_args_featured',
		array(
			'thumb_size' => ! empty( $putter_template_args['thumb_size'] )
				? $putter_template_args['thumb_size']
				: putter_get_thumb_size(
					'classic' == $putter_blog_style[0]
						? ( strpos( putter_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $putter_columns > 2 ? 'big' : 'huge' )
								: ( $putter_columns > 2
									? ( $putter_expanded ? 'square' : 'square' )
									: ($putter_columns > 1 ? 'square' : ( $putter_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( putter_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $putter_columns > 2 ? 'masonry-big' : 'full' )
								: ($putter_columns === 1 ? ( $putter_expanded ? 'huge' : 'big' ) : ( $putter_columns <= 2 && $putter_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $putter_hover,
			'meta_parts' => $putter_components,
			'no_links'   => ! empty( $putter_template_args['no_links'] ),
        ),
        'content-classic',
        $putter_template_args
    ) );

	// Title and post meta
	$putter_show_title = get_the_title() != '';
	$putter_show_meta  = count( $putter_components ) > 0 && ! in_array( $putter_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $putter_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'putter_filter_show_blog_meta', $putter_show_meta, $putter_components, 'classic' ) ) {
				if ( count( $putter_components ) > 0 ) {
					do_action( 'putter_action_before_post_meta' );
					putter_show_post_meta(
						apply_filters(
							'putter_filter_post_meta_args', array(
							'components' => join( ',', $putter_components ),
							'seo'        => false,
							'echo'       => true,
						), $putter_blog_style[0], $putter_columns
						)
					);
					do_action( 'putter_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'putter_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'putter_action_before_post_title' );
				if ( empty( $putter_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'putter_action_after_post_title' );
			}

			if( !in_array( $putter_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'putter_filter_show_blog_readmore', ! $putter_show_title || ! empty( $putter_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $putter_template_args['no_links'] ) ) {
						do_action( 'putter_action_before_post_readmore' );
						putter_show_post_more_link( $putter_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'putter_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $putter_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('putter_filter_show_blog_excerpt', empty($putter_template_args['hide_excerpt']) && putter_get_theme_option('excerpt_length') > 0, 'classic')) {
			putter_show_post_content($putter_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $putter_template_args['more_button'] )) {
			if ( empty( $putter_template_args['no_links'] ) ) {
				do_action( 'putter_action_before_post_readmore' );
				putter_show_post_more_link( $putter_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'putter_action_after_post_readmore' );
			}
		}
		$putter_content = ob_get_contents();
		ob_end_clean();
		putter_show_layout($putter_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
