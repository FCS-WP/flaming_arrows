<?php
/**
 * The template to display the site logo in the footer
 *
 * @package PUTTER
 * @since PUTTER 1.0.10
 */

// Logo
if ( putter_is_on( putter_get_theme_option( 'logo_in_footer' ) ) ) {
	$putter_logo_image = putter_get_logo_image( 'footer' );
	$putter_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $putter_logo_image['logo'] ) || ! empty( $putter_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $putter_logo_image['logo'] ) ) {
					$putter_attr = putter_getimagesize( $putter_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $putter_logo_image['logo'] ) . '"'
								. ( ! empty( $putter_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $putter_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'putter' ) . '"'
								. ( ! empty( $putter_attr[3] ) ? ' ' . wp_kses_data( $putter_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $putter_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $putter_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
