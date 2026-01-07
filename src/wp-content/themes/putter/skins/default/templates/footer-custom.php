<?php
/**
 * The template to display default site footer
 *
 * @package PUTTER
 * @since PUTTER 1.0.10
 */

$putter_footer_id = putter_get_custom_footer_id();
$putter_footer_meta = get_post_meta( $putter_footer_id, 'trx_addons_options', true );
if ( ! empty( $putter_footer_meta['margin'] ) ) {
	putter_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( putter_prepare_css_value( $putter_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $putter_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $putter_footer_id ) ) ); ?>
						<?php
						$putter_footer_scheme = putter_get_theme_option( 'footer_scheme' );
						if ( ! empty( $putter_footer_scheme ) && ! putter_is_inherit( $putter_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $putter_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'putter_action_show_layout', $putter_footer_id );
	?>
</footer><!-- /.footer_wrap -->
