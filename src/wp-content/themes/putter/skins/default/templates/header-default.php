<?php
/**
 * The template to display default site header
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */

$putter_header_css   = '';
$putter_header_image = get_header_image();
$putter_header_video = putter_get_header_video();
if ( ! empty( $putter_header_image ) && putter_trx_addons_featured_image_override( is_singular() || putter_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$putter_header_image = putter_get_current_mode_image( $putter_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $putter_header_image ) || ! empty( $putter_header_video ) ? ' with_bg_image' : ' without_bg_image';
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

	// Main menu
	get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( putter_is_on( putter_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
