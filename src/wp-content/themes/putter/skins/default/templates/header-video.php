<?php
/**
 * The template to display the background video in the header
 *
 * @package PUTTER
 * @since PUTTER 1.0.14
 */
$putter_header_video = putter_get_header_video();
$putter_embed_video  = '';
if ( ! empty( $putter_header_video ) && ! putter_is_from_uploads( $putter_header_video ) ) {
	if ( putter_is_youtube_url( $putter_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $putter_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php putter_show_layout( putter_get_embed_video( $putter_header_video ) ); ?></div>
		<?php
	}
}
