<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package PUTTER
 * @since PUTTER 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$putter_copyright_scheme = putter_get_theme_option( 'copyright_scheme' );
if ( ! empty( $putter_copyright_scheme ) && ! putter_is_inherit( $putter_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $putter_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$putter_copyright = putter_get_theme_option( 'copyright' );
			if ( ! empty( $putter_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$putter_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $putter_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$putter_copyright = putter_prepare_macros( $putter_copyright );
				// Display copyright
				echo wp_kses( nl2br( $putter_copyright ), 'putter_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
