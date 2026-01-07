<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package PUTTER
 * @since PUTTER 1.0.06
 */

$putter_header_css   = '';
$putter_header_image = get_header_image();
$putter_header_video = putter_get_header_video();
if ( ! empty( $putter_header_image ) && putter_trx_addons_featured_image_override( is_singular() || putter_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$putter_header_image = putter_get_current_mode_image( $putter_header_image );
}

$putter_header_id = putter_get_custom_header_id();
$putter_header_meta = get_post_meta( $putter_header_id, 'trx_addons_options', true );
if ( ! empty( $putter_header_meta['margin'] ) ) {
	putter_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( putter_prepare_css_value( $putter_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $putter_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $putter_header_id ) ) ); ?>
				<?php
				echo ! empty( $putter_header_image ) || ! empty( $putter_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $putter_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $putter_header_image ) {
					echo ' ' . esc_attr( putter_add_inline_css_class( 'background-image: url(' . esc_url( $putter_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( putter_is_on( putter_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight putter-full-height';
				}
				$putter_header_scheme = putter_get_theme_option( 'header_scheme' );
				if ( ! empty( $putter_header_scheme ) && ! putter_is_inherit( $putter_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $putter_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $putter_header_video ) ) {
		get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'putter_action_show_layout', $putter_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
