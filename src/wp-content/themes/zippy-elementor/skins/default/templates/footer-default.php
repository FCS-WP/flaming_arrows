<?php
/**
 * The template to display default site footer
 *
 * @package PUTTER
 * @since PUTTER 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$putter_footer_scheme = putter_get_theme_option( 'footer_scheme' );
if ( ! empty( $putter_footer_scheme ) && ! putter_is_inherit( $putter_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $putter_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
