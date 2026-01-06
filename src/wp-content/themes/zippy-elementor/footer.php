<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */

							do_action( 'putter_action_page_content_end_text' );
							
							// Widgets area below the content
							putter_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'putter_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'putter_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'putter_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'putter_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$putter_body_style = putter_get_theme_option( 'body_style' );
					$putter_widgets_name = putter_get_theme_option( 'widgets_below_page', 'hide' );
					$putter_show_widgets = ! putter_is_off( $putter_widgets_name ) && is_active_sidebar( $putter_widgets_name );
					$putter_show_related = putter_is_single() && putter_get_theme_option( 'related_position', 'below_content' ) == 'below_page';
					if ( $putter_show_widgets || $putter_show_related ) {
						if ( 'fullscreen' != $putter_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $putter_show_related ) {
							do_action( 'putter_action_related_posts' );
						}

						// Widgets area below page content
						if ( $putter_show_widgets ) {
							putter_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $putter_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'putter_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'putter_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! putter_is_singular( 'post' ) && ! putter_is_singular( 'attachment' ) ) || ! in_array ( putter_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="putter_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'putter_action_before_footer' );

				// Footer
				$putter_footer_type = putter_get_theme_option( 'footer_type' );
				if ( 'custom' == $putter_footer_type && ! putter_is_layouts_available() ) {
					$putter_footer_type = 'default';
				}
				get_template_part( apply_filters( 'putter_filter_get_template_part', "templates/footer-" . sanitize_file_name( $putter_footer_type ) ) );

				do_action( 'putter_action_after_footer' );

			}
			?>

			<?php do_action( 'putter_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'putter_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'putter_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>