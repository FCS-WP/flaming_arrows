<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */

if ( putter_sidebar_present() ) {
	
	$putter_sidebar_type = putter_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $putter_sidebar_type && ! putter_is_layouts_available() ) {
		$putter_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $putter_sidebar_type ) {
		// Default sidebar with widgets
		$putter_sidebar_name = putter_get_theme_option( 'sidebar_widgets' );
		putter_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $putter_sidebar_name ) ) {
			dynamic_sidebar( $putter_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$putter_sidebar_id = putter_get_custom_sidebar_id();
		do_action( 'putter_action_show_layout', $putter_sidebar_id );
	}
	$putter_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $putter_out ) ) {
		$putter_sidebar_position    = putter_get_theme_option( 'sidebar_position' );
		$putter_sidebar_position_ss = putter_get_theme_option( 'sidebar_position_ss', 'below' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $putter_sidebar_position );
			echo ' sidebar_' . esc_attr( $putter_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $putter_sidebar_type );

			$putter_sidebar_scheme = apply_filters( 'putter_filter_sidebar_scheme', putter_get_theme_option( 'sidebar_scheme', 'inherit' ) );
			if ( ! empty( $putter_sidebar_scheme ) && ! putter_is_inherit( $putter_sidebar_scheme ) && 'custom' != $putter_sidebar_type ) {
				echo ' scheme_' . esc_attr( $putter_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="putter_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'putter_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $putter_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$putter_title = apply_filters( 'putter_filter_sidebar_control_title', 'float' == $putter_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'putter' ) : '' );
				$putter_text  = apply_filters( 'putter_filter_sidebar_control_text', 'above' == $putter_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'putter' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $putter_title ); ?>"><?php echo esc_html( $putter_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'putter_action_before_sidebar', 'sidebar' );
				putter_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $putter_out ) );
				do_action( 'putter_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'putter_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
