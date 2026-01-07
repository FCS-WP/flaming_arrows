<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */

$putter_template_args = get_query_var( 'putter_template_args' );
$putter_columns = 1;
if ( is_array( $putter_template_args ) ) {
	$putter_columns    = empty( $putter_template_args['columns'] ) ? 1 : max( 1, $putter_template_args['columns'] );
	$putter_blog_style = array( $putter_template_args['type'], $putter_columns );
	if ( ! empty( $putter_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $putter_columns > 1 ) {
	    $putter_columns_class = putter_get_column_class( 1, $putter_columns, ! empty( $putter_template_args['columns_tablet']) ? $putter_template_args['columns_tablet'] : '', ! empty($putter_template_args['columns_mobile']) ? $putter_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $putter_columns_class ); ?>">
		<?php
	}
} else {
	$putter_template_args = array();
}
$putter_expanded    = ! putter_sidebar_present() && putter_get_theme_option( 'expand_content' ) == 'expand';
$putter_post_format = get_post_format();
$putter_post_format = empty( $putter_post_format ) ? 'standard' : str_replace( 'post-format-', '', $putter_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $putter_post_format ) );
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
			'thumb_size' => ! empty( $putter_template_args['thumb_size'] )
							? $putter_template_args['thumb_size']
							: putter_get_thumb_size( strpos( putter_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $putter_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$putter_template_args
	) );

	// Title and post meta
	$putter_show_title = get_the_title() != '';
	$putter_show_meta  = count( $putter_components ) > 0 && ! in_array( $putter_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $putter_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'putter_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'putter_action_before_post_title' );
				if ( empty( $putter_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'putter_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'putter_filter_show_blog_excerpt', empty( $putter_template_args['hide_excerpt'] ) && putter_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'putter_filter_show_blog_meta', $putter_show_meta, $putter_components, 'excerpt' ) ) {
				if ( count( $putter_components ) > 0 ) {
					do_action( 'putter_action_before_post_meta' );
					putter_show_post_meta(
						apply_filters(
							'putter_filter_post_meta_args', array(
								'components' => join( ',', $putter_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'putter_action_after_post_meta' );
				}
			}

			if ( putter_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'putter_action_before_full_post_content' );
					the_content( '' );
					do_action( 'putter_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'putter' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'putter' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				putter_show_post_content( $putter_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'putter_filter_show_blog_readmore',  ! isset( $putter_template_args['more_button'] ) || ! empty( $putter_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $putter_template_args['no_links'] ) ) {
					do_action( 'putter_action_before_post_readmore' );
					if ( putter_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						putter_show_post_more_link( $putter_template_args, '<p>', '</p>' );
					} else {
						putter_show_post_comments_link( $putter_template_args, '<p>', '</p>' );
					}
					do_action( 'putter_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $putter_template_args ) ) {
	if ( ! empty( $putter_template_args['slider'] ) || $putter_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
