<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package PUTTER
 * @since PUTTER 1.71.0
 */

$putter_template_args = get_query_var( 'putter_template_args' );
if ( ! is_array( $putter_template_args ) ) {
	$putter_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$putter_columns       = 1;

$putter_expanded      = ! putter_sidebar_present() && putter_get_theme_option( 'expand_content' ) == 'expand';

$putter_post_format   = get_post_format();
$putter_post_format   = empty( $putter_post_format ) ? 'standard' : str_replace( 'post-format-', '', $putter_post_format );

if ( is_array( $putter_template_args ) ) {
	$putter_columns    = empty( $putter_template_args['columns'] ) ? 1 : max( 1, $putter_template_args['columns'] );
	$putter_blog_style = array( $putter_template_args['type'], $putter_columns );
	if ( ! empty( $putter_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $putter_columns > 1 ) {
	    $putter_columns_class = putter_get_column_class( 1, $putter_columns, ! empty( $putter_template_args['columns_tablet']) ? $putter_template_args['columns_tablet'] : '', ! empty($putter_template_args['columns_mobile']) ? $putter_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $putter_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $putter_post_format ) );
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
								: array_map( 'trim', explode( ',', $putter_template_args['meta_parts'] ) )
								)
							: putter_array_get_keys_by_value( putter_get_theme_option( 'meta_parts' ) );
	putter_show_post_featured( apply_filters( 'putter_filter_args_featured',
		array(
			'no_links'   => ! empty( $putter_template_args['no_links'] ),
			'hover'      => $putter_hover,
			'meta_parts' => $putter_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $putter_template_args['thumb_size'] )
								? $putter_template_args['thumb_size']
								: putter_get_thumb_size( 
								in_array( $putter_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( putter_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $putter_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$putter_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$putter_show_title = get_the_title() != '';
		$putter_show_meta  = count( $putter_components ) > 0 && ! in_array( $putter_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $putter_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'putter_filter_show_blog_categories', $putter_show_meta && in_array( 'categories', $putter_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'putter_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						putter_show_post_meta( apply_filters(
															'putter_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $putter_hover, 1
															)
											);
						?>
					</div>
					<?php
					$putter_components = putter_array_delete_by_value( $putter_components, 'categories' );
					do_action( 'putter_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'putter_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'putter_action_before_post_title' );
					if ( empty( $putter_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'putter_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $putter_template_args['excerpt_length'] ) && ! in_array( $putter_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$putter_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'putter_filter_show_blog_excerpt', empty( $putter_template_args['hide_excerpt'] ) && putter_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				putter_show_post_content( $putter_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'putter_filter_show_blog_meta', $putter_show_meta, $putter_components, 'band' ) ) {
			if ( count( $putter_components ) > 0 ) {
				do_action( 'putter_action_before_post_meta' );
				putter_show_post_meta(
					apply_filters(
						'putter_filter_post_meta_args', array(
							'components' => join( ',', $putter_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'putter_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'putter_filter_show_blog_readmore', ! $putter_show_title || ! empty( $putter_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $putter_template_args['no_links'] ) ) {
				do_action( 'putter_action_before_post_readmore' );
				putter_show_post_more_link( $putter_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'putter_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $putter_template_args ) ) {
	if ( ! empty( $putter_template_args['slider'] ) || $putter_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
