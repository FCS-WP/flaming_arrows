<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package PUTTER
 * @since PUTTER 1.0.10
 */

// Footer sidebar
$putter_footer_name    = putter_get_theme_option( 'footer_widgets' );
$putter_footer_present = ! putter_is_off( $putter_footer_name ) && is_active_sidebar( $putter_footer_name );
if ( $putter_footer_present ) {
	putter_storage_set( 'current_sidebar', 'footer' );
	$putter_footer_wide = putter_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $putter_footer_name ) ) {
		dynamic_sidebar( $putter_footer_name );
	}
	$putter_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $putter_out ) ) {
		$putter_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $putter_out );
		$putter_need_columns = true;   //or check: strpos($putter_out, 'columns_wrap')===false;
		if ( $putter_need_columns ) {
			$putter_columns = max( 0, (int) putter_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $putter_columns ) {
				$putter_columns = min( 4, max( 1, putter_tags_count( $putter_out, 'aside' ) ) );
			}
			if ( $putter_columns > 1 ) {
				$putter_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $putter_columns ) . ' widget', $putter_out );
			} else {
				$putter_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $putter_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'putter_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $putter_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $putter_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'putter_action_before_sidebar', 'footer' );
				putter_show_layout( $putter_out );
				do_action( 'putter_action_after_sidebar', 'footer' );
				if ( $putter_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $putter_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'putter_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
