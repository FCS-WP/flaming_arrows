<?php
/**
 * The Header: Logo and main menu
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( putter_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'putter_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'putter_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('putter_action_body_wrap_attributes'); ?>>

		<?php do_action( 'putter_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'putter_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('putter_action_page_wrap_attributes'); ?>>

			<?php do_action( 'putter_action_page_wrap_start' ); ?>

			<?php
			$putter_full_post_loading = ( putter_is_singular( 'post' ) || putter_is_singular( 'attachment' ) ) && putter_get_value_gp( 'action' ) == 'full_post_loading';
			$putter_prev_post_loading = ( putter_is_singular( 'post' ) || putter_is_singular( 'attachment' ) ) && putter_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $putter_full_post_loading && ! $putter_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="putter_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'putter_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'putter' ); ?></a>
				<?php if ( putter_sidebar_present() ) { ?>
				<a class="putter_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'putter_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'putter' ); ?></a>
				<?php } ?>
				<a class="putter_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'putter_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'putter' ); ?></a>

				<?php
				do_action( 'putter_action_before_header' );

				// Header
				$putter_header_type = putter_get_theme_option( 'header_type' );
				if ( 'custom' == $putter_header_type && ! putter_is_layouts_available() ) {
					$putter_header_type = 'default';
				}
				get_template_part( apply_filters( 'putter_filter_get_template_part', "templates/header-" . sanitize_file_name( $putter_header_type ) ) );

				// Side menu
				if ( in_array( putter_get_theme_option( 'menu_side', 'none' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				if ( apply_filters( 'putter_filter_use_navi_mobile', true ) ) {
					get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/header-navi-mobile' ) );
				}

				do_action( 'putter_action_after_header' );

			}
			?>

			<?php do_action( 'putter_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( putter_is_off( putter_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $putter_header_type ) ) {
						$putter_header_type = putter_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $putter_header_type && putter_is_layouts_available() ) {
						$putter_header_id = putter_get_custom_header_id();
						if ( $putter_header_id > 0 ) {
							$putter_header_meta = putter_get_custom_layout_meta( $putter_header_id );
							if ( ! empty( $putter_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$putter_footer_type = putter_get_theme_option( 'footer_type' );
					if ( 'custom' == $putter_footer_type && putter_is_layouts_available() ) {
						$putter_footer_id = putter_get_custom_footer_id();
						if ( $putter_footer_id ) {
							$putter_footer_meta = putter_get_custom_layout_meta( $putter_footer_id );
							if ( ! empty( $putter_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'putter_action_page_content_wrap_class', $putter_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'putter_filter_is_prev_post_loading', $putter_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( putter_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'putter_action_page_content_wrap_data', $putter_prev_post_loading );
			?>>
				<?php
				do_action( 'putter_action_page_content_wrap', $putter_full_post_loading || $putter_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'putter_filter_single_post_header', putter_is_singular( 'post' ) || putter_is_singular( 'attachment' ) ) ) {
					if ( $putter_prev_post_loading ) {
						if ( putter_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) != 'article' ) {
							do_action( 'putter_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$putter_path = apply_filters( 'putter_filter_get_template_part', 'templates/single-styles/' . putter_get_theme_option( 'single_style' ) );
					if ( putter_get_file_dir( $putter_path . '.php' ) != '' ) {
						get_template_part( $putter_path );
					}
				}

				// Widgets area above page
				$putter_body_style   = putter_get_theme_option( 'body_style' );
				$putter_widgets_name = putter_get_theme_option( 'widgets_above_page', 'hide' );
				$putter_show_widgets = ! putter_is_off( $putter_widgets_name ) && is_active_sidebar( $putter_widgets_name );
				if ( $putter_show_widgets ) {
					if ( 'fullscreen' != $putter_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					putter_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $putter_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'putter_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $putter_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'putter_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'putter_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="putter_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( putter_is_singular( 'post' ) || putter_is_singular( 'attachment' ) )
							&& $putter_prev_post_loading 
							&& putter_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) == 'article'
						) {
							do_action( 'putter_action_between_posts' );
						}

						// Widgets area above content
						putter_create_widgets_area( 'widgets_above_content' );

						do_action( 'putter_action_page_content_start_text' );
