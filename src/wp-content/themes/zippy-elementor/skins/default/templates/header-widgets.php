<?php
/**
 * The template to display the widgets area in the header
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */

// Header sidebar
$putter_header_name    = putter_get_theme_option( 'header_widgets' );
$putter_header_present = ! putter_is_off( $putter_header_name ) && is_active_sidebar( $putter_header_name );
if ( $putter_header_present ) {
	putter_storage_set( 'current_sidebar', 'header' );
	$putter_header_wide = putter_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $putter_header_name ) ) {
		dynamic_sidebar( $putter_header_name );
	}
	$putter_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $putter_widgets_output ) ) {
		$putter_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $putter_widgets_output );
		$putter_need_columns   = strpos( $putter_widgets_output, 'columns_wrap' ) === false;
		if ( $putter_need_columns ) {
			$putter_columns = max( 0, (int) putter_get_theme_option( 'header_columns' ) );
			if ( 0 == $putter_columns ) {
				$putter_columns = min( 6, max( 1, putter_tags_count( $putter_widgets_output, 'aside' ) ) );
			}
			if ( $putter_columns > 1 ) {
				$putter_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $putter_columns ) . ' widget', $putter_widgets_output );
			} else {
				$putter_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $putter_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'putter_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $putter_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $putter_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'putter_action_before_sidebar', 'header' );
				putter_show_layout( $putter_widgets_output );
				do_action( 'putter_action_after_sidebar', 'header' );
				if ( $putter_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $putter_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'putter_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
