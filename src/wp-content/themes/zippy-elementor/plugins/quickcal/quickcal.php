<?php
/* QuickCal support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'putter_quickcal_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'putter_quickcal_theme_setup9', 9 );
	function putter_quickcal_theme_setup9() {
		if ( putter_exists_quickcal() ) {
			add_action( 'wp_enqueue_scripts', 'putter_quickcal_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_quickcal', 'putter_quickcal_frontend_scripts', 10, 1 );
			add_action( 'wp_enqueue_scripts', 'putter_quickcal_frontend_scripts_responsive', 2000 );
			add_action( 'trx_addons_action_load_scripts_front_quickcal', 'putter_quickcal_frontend_scripts_responsive', 10, 1 );
			add_filter( 'putter_filter_merge_styles', 'putter_quickcal_merge_styles' );
			add_filter( 'putter_filter_merge_styles_responsive', 'putter_quickcal_merge_styles_responsive' );
		}
		if ( is_admin() ) {
			add_filter( 'putter_filter_tgmpa_required_plugins', 'putter_quickcal_tgmpa_required_plugins' );
			add_filter( 'putter_filter_theme_plugins', 'putter_quickcal_theme_plugins' );
		}
	}
}


// Filter to add in the required plugins list
if ( ! function_exists( 'putter_quickcal_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('putter_filter_tgmpa_required_plugins',	'putter_quickcal_tgmpa_required_plugins');
	function putter_quickcal_tgmpa_required_plugins( $list = array() ) {
		if ( putter_storage_isset( 'required_plugins', 'quickcal' ) && putter_storage_get_array( 'required_plugins', 'quickcal', 'install' ) !== false && putter_is_theme_activated() ) {
			$path = putter_get_plugin_source_path( 'plugins/quickcal/quickcal.zip' );
			if ( ! empty( $path ) || putter_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => putter_storage_get_array( 'required_plugins', 'quickcal', 'title' ),
					'slug'     => 'quickcal',
					'source'   => ! empty( $path ) ? $path : 'upload://quickcal.zip',
					'version'  => '1.0.6',
					'required' => false,
				);
			}
		}
		return $list;
	}
}


// Filter theme-supported plugins list
if ( ! function_exists( 'putter_quickcal_theme_plugins' ) ) {
	//Handler of the add_filter( 'putter_filter_theme_plugins', 'putter_quickcal_theme_plugins' );
	function putter_quickcal_theme_plugins( $list = array() ) {
		return putter_add_group_and_logo_to_slave( $list, 'quickcal', 'quickcal-' );
	}
}


// Check if plugin installed and activated
if ( ! function_exists( 'putter_exists_quickcal' ) ) {
	function putter_exists_quickcal() {
		return class_exists( 'quickcal_plugin' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'putter_quickcal_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'putter_quickcal_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_quickcal', 'putter_quickcal_frontend_scripts', 10, 1 );
	function putter_quickcal_frontend_scripts( $force = false ) {
		putter_enqueue_optimized( 'quickcal', $force, array(
			'css' => array(
				'putter-quickcal' => array( 'src' => 'plugins/quickcal/quickcal.css' ),
			)
		) );
	}
}


// Enqueue responsive styles for frontend
if ( ! function_exists( 'putter_quickcal_frontend_scripts_responsive' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'putter_quickcal_frontend_scripts_responsive', 2000 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_quickcal', 'putter_quickcal_frontend_scripts_responsive', 10, 1 );
	function putter_quickcal_frontend_scripts_responsive( $force = false ) {
		putter_enqueue_optimized_responsive( 'quickcal', $force, array(
			'css' => array(
				'putter-quickcal-responsive' => array( 'src' => 'plugins/quickcal/quickcal-responsive.css', 'media' => 'all' ),
			)
		) );
	}
}


// Merge custom styles
if ( ! function_exists( 'putter_quickcal_merge_styles' ) ) {
	//Handler of the add_filter('putter_filter_merge_styles', 'putter_quickcal_merge_styles');
	function putter_quickcal_merge_styles( $list ) {
		$list[ 'plugins/quickcal/quickcal.css' ] = false;
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'putter_quickcal_merge_styles_responsive' ) ) {
	//Handler of the add_filter('putter_filter_merge_styles_responsive', 'putter_quickcal_merge_styles_responsive');
	function putter_quickcal_merge_styles_responsive( $list ) {
		$list[ 'plugins/quickcal/quickcal-responsive.css' ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( putter_exists_quickcal() ) {
	$putter_fdir = putter_get_file_dir( 'plugins/quickcal/quickcal-style.php' );
	if ( ! empty( $putter_fdir ) ) {
		require_once $putter_fdir;
	}
}
