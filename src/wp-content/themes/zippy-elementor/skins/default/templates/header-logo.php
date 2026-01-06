<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */

$putter_args = get_query_var( 'putter_logo_args' );

// Site logo
$putter_logo_type   = isset( $putter_args['type'] ) ? $putter_args['type'] : '';
$putter_logo_image  = putter_get_logo_image( $putter_logo_type );
$putter_logo_text   = putter_is_on( putter_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$putter_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $putter_logo_image['logo'] ) || ! empty( $putter_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $putter_logo_image['logo'] ) ) {
			if ( empty( $putter_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($putter_logo_image['logo']) && (int) $putter_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$putter_attr = putter_getimagesize( $putter_logo_image['logo'] );
				echo '<img src="' . esc_url( $putter_logo_image['logo'] ) . '"'
						. ( ! empty( $putter_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $putter_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $putter_logo_text ) . '"'
						. ( ! empty( $putter_attr[3] ) ? ' ' . wp_kses_data( $putter_attr[3] ) : '' )
						. '>';
			}
		} else {
			putter_show_layout( putter_prepare_macros( $putter_logo_text ), '<span class="logo_text">', '</span>' );
			putter_show_layout( putter_prepare_macros( $putter_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
