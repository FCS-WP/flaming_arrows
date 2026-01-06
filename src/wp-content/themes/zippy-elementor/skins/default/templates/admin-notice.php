<?php
/**
 * The template to display Admin notices
 *
 * @package PUTTER
 * @since PUTTER 1.0.1
 */

$putter_theme_slug = get_option( 'template' );
$putter_theme_obj  = wp_get_theme( $putter_theme_slug );
?>
<div class="putter_admin_notice putter_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$putter_theme_img = putter_get_file_url( 'screenshot.jpg' );
	if ( '' != $putter_theme_img ) {
		?>
		<div class="putter_notice_image"><img src="<?php echo esc_url( $putter_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'putter' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="putter_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'putter' ),
				$putter_theme_obj->get( 'Name' ) . ( PUTTER_THEME_FREE ? ' ' . __( 'Free', 'putter' ) : '' ),
				$putter_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="putter_notice_text">
		<p class="putter_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $putter_theme_obj->description ) );
			?>
		</p>
		<p class="putter_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'putter' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="putter_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=putter_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'putter' );
			?>
		</a>
	</div>
</div>
