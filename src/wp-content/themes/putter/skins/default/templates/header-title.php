<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */

// Page (category, tag, archive, author) title

if ( putter_need_page_title() ) {
	putter_sc_layouts_showed( 'title', true );
	putter_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								putter_show_post_meta(
									apply_filters(
										'putter_filter_post_meta_args', array(
											'components' => join( ',', putter_array_get_keys_by_value( putter_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', putter_array_get_keys_by_value( putter_get_theme_option( 'counters' ) ) ),
											'seo'        => putter_is_on( putter_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$putter_blog_title           = putter_get_blog_title();
							$putter_blog_title_text      = '';
							$putter_blog_title_class     = '';
							$putter_blog_title_link      = '';
							$putter_blog_title_link_text = '';
							if ( is_array( $putter_blog_title ) ) {
								$putter_blog_title_text      = $putter_blog_title['text'];
								$putter_blog_title_class     = ! empty( $putter_blog_title['class'] ) ? ' ' . $putter_blog_title['class'] : '';
								$putter_blog_title_link      = ! empty( $putter_blog_title['link'] ) ? $putter_blog_title['link'] : '';
								$putter_blog_title_link_text = ! empty( $putter_blog_title['link_text'] ) ? $putter_blog_title['link_text'] : '';
							} else {
								$putter_blog_title_text = $putter_blog_title;
							}
							?>
							<h1 class="sc_layouts_title_caption<?php echo esc_attr( $putter_blog_title_class ); ?>"<?php
								if ( putter_is_on( putter_get_theme_option( 'seo_snippets' ) ) ) {
									?> itemprop="headline"<?php
								}
							?>>
								<?php
								$putter_top_icon = putter_get_term_image_small();
								if ( ! empty( $putter_top_icon ) ) {
									$putter_attr = putter_getimagesize( $putter_top_icon );
									?>
									<img src="<?php echo esc_url( $putter_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'putter' ); ?>"
										<?php
										if ( ! empty( $putter_attr[3] ) ) {
											putter_show_layout( $putter_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $putter_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $putter_blog_title_link ) && ! empty( $putter_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $putter_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $putter_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'putter_action_breadcrumbs' );
						$putter_breadcrumbs = ob_get_contents();
						ob_end_clean();
						putter_show_layout( $putter_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
