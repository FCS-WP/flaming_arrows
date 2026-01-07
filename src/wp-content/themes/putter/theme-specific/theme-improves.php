<?php
/**
 * Theme improves - functions and definitions for the theme improvements (compatibility with WordPress and plugins updates)
 *
 * @package PUTTER
 * @since PUTTER 2.31.3
 */


//----------------------------------------------------------------------
//-- Additional theme options
//----------------------------------------------------------------------

// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'putter_improves_add_disable_hyphens_option' ) ) {
	add_action( 'after_setup_theme', 'putter_improves_add_disable_hyphens_option', 3 );
	/**
	 * Add 'General' section to the Typography options with the 'Disable word hyphenation' option
	 * 
	 * @hooks after_setup_theme, 3
	 */
	function putter_improves_add_disable_hyphens_option() {

		// Add 'General' section to the Typography
		putter_storage_set_array_after( 'options', 'fonts', array(
			// Fonts - General
			'font_general_section' => array(
				'title' => esc_html__( 'General', 'putter' ),
				'desc'  => '',
				'demo'  => true,
				'type'  => 'section',
			),
			'font_general_info'    => array(
				'title' => esc_html__( 'General', 'putter' ),
				'desc'  => wp_kses_data( __( 'General typography settings.', 'putter' ) ),
				'demo'  => true,
				'type'  => 'info',
			),
			'disable_hyphens'      => array(
				'title' => esc_html__( 'Disable word hyphenation', 'putter' ),
				'desc'  => wp_kses_data( __( 'Disable word hyphenation for the headings on tablets and mobile devices.', 'putter' ) ),
				'std'   => 0,
				'type'  => 'switch',
			),
		) );
	}
}

if ( ! function_exists( 'putter_improves_add_disable_hyphens_styles' ) ) {
	add_action( 'wp_head', 'putter_improves_add_disable_hyphens_styles' );
	/**
	 * Add styles for the 'Disable word hyphenation' option
	 * 
	 * @hook wp_head
	 */
	function putter_improves_add_disable_hyphens_styles() {
		
		// Get 'Disable word hyphenation' option value
		$disable_hyphens = putter_get_theme_option( 'disable_hyphens' );

		// Add styles
		if ( (int)$disable_hyphens > 0 ) {
			putter_add_inline_css( '
				@media (max-width: 1279px) {
					h1, h2, h3, h4, h5, h6 {
						hyphens: none;
						word-break: keep-all;
						white-space: normal;
					}
				}
			' );
		}
	}
}
