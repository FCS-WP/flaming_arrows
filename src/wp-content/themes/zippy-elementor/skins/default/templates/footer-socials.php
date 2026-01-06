<?php
/**
 * The template to display the socials in the footer
 *
 * @package PUTTER
 * @since PUTTER 1.0.10
 */


// Socials
if ( putter_is_on( putter_get_theme_option( 'socials_in_footer' ) ) ) {
	$putter_output = putter_get_socials_links();
	if ( '' != $putter_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php putter_show_layout( $putter_output ); ?>
			</div>
		</div>
		<?php
	}
}
