<?php
$putter_woocommerce_sc = putter_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $putter_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$putter_scheme = putter_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $putter_scheme ) && ! putter_is_inherit( $putter_scheme ) ) {
			echo ' scheme_' . esc_attr( $putter_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( putter_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( putter_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$putter_css      = '';
			$putter_bg_image = putter_get_theme_option( 'front_page_woocommerce_bg_image' );
			if ( ! empty( $putter_bg_image ) ) {
				$putter_css .= 'background-image: url(' . esc_url( putter_get_attachment_url( $putter_bg_image ) ) . ');';
			}
			if ( ! empty( $putter_css ) ) {
				echo ' style="' . esc_attr( $putter_css ) . '"';
			}
			?>
	>
	<?php
		// Add anchor
		$putter_anchor_icon = putter_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$putter_anchor_text = putter_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $putter_anchor_icon ) || ! empty( $putter_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $putter_anchor_icon ) ? ' icon="' . esc_attr( $putter_anchor_icon ) . '"' : '' )
											. ( ! empty( $putter_anchor_text ) ? ' title="' . esc_attr( $putter_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( putter_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' putter-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$putter_css      = '';
				$putter_bg_mask  = putter_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$putter_bg_color_type = putter_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $putter_bg_color_type ) {
					$putter_bg_color = putter_get_theme_option( 'front_page_woocommerce_bg_color' );
				} elseif ( 'scheme_bg_color' == $putter_bg_color_type ) {
					$putter_bg_color = putter_get_scheme_color( 'bg_color', $putter_scheme );
				} else {
					$putter_bg_color = '';
				}
				if ( ! empty( $putter_bg_color ) && $putter_bg_mask > 0 ) {
					$putter_css .= 'background-color: ' . esc_attr(
						1 == $putter_bg_mask ? $putter_bg_color : putter_hex2rgba( $putter_bg_color, $putter_bg_mask )
					) . ';';
				}
				if ( ! empty( $putter_css ) ) {
					echo ' style="' . esc_attr( $putter_css ) . '"';
				}
				?>
		>
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$putter_caption     = putter_get_theme_option( 'front_page_woocommerce_caption' );
				$putter_description = putter_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $putter_caption ) || ! empty( $putter_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $putter_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $putter_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $putter_caption, 'putter_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $putter_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $putter_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $putter_description ), 'putter_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $putter_woocommerce_sc ) {
						$putter_woocommerce_sc_ids      = putter_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$putter_woocommerce_sc_per_page = count( explode( ',', $putter_woocommerce_sc_ids ) );
					} else {
						$putter_woocommerce_sc_per_page = max( 1, (int) putter_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$putter_woocommerce_sc_columns = max( 1, min( $putter_woocommerce_sc_per_page, (int) putter_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$putter_woocommerce_sc}"
										. ( 'products' == $putter_woocommerce_sc
												? ' ids="' . esc_attr( $putter_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $putter_woocommerce_sc
												? ' category="' . esc_attr( putter_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $putter_woocommerce_sc
												? ' orderby="' . esc_attr( putter_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( putter_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $putter_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $putter_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
