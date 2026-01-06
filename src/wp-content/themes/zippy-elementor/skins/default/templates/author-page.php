<?php
/**
 * The template to display the user's avatar, bio and socials on the Author page
 *
 * @package PUTTER
 * @since PUTTER 1.71.0
 */
?>

<div class="author_page author vcard"<?php
	if ( putter_is_on( putter_get_theme_option( 'seo_snippets' ) ) ) {
		?> itemprop="author" itemscope="itemscope" itemtype="<?php echo esc_attr( putter_get_protocol( true ) ); ?>//schema.org/Person"<?php
	}
?>>

	<div class="author_avatar"<?php
		if ( putter_is_on( putter_get_theme_option( 'seo_snippets' ) ) ) {
			?> itemprop="image"<?php
		}
	?>>
		<?php
		$putter_mult = putter_get_retina_multiplier();
		echo get_avatar( get_the_author_meta( 'user_email' ), 120 * $putter_mult );
		?>
	</div>

	<h4 class="author_title"<?php
		if ( putter_is_on( putter_get_theme_option( 'seo_snippets' ) ) ) {
			?> itemprop="name"<?php
		}
	?>><span class="fn"><?php the_author(); ?></span></h4>

	<?php
	$putter_author_description = get_the_author_meta( 'description' );
	if ( ! empty( $putter_author_description ) ) {
		?>
		<div class="author_bio"<?php
			if ( putter_is_on( putter_get_theme_option( 'seo_snippets' ) ) ) {
				?> itemprop="description"<?php
			}
		?>><?php echo wp_kses( wpautop( $putter_author_description ), 'putter_kses_content' ); ?></div>
		<?php
	}
	?>

	<div class="author_details">
		<span class="author_posts_total">
			<?php
			$putter_posts_total = count_user_posts( get_the_author_meta('ID'), 'post' );
			if ( $putter_posts_total > 0 ) {
				// Translators: Add the author's posts number to the message
				echo wp_kses( sprintf( _n( '%s article published', '%s articles published', $putter_posts_total, 'putter' ),
										'<span class="author_posts_total_value">' . number_format_i18n( $putter_posts_total ) . '</span>'
								 		),
							'putter_kses_content'
							);
			} else {
				esc_html_e( 'No posts published.', 'putter' );
			}
			?>
		</span><?php
			ob_start();
			do_action( 'putter_action_user_meta', 'author-page' );
			$putter_socials = ob_get_contents();
			ob_end_clean();
			putter_show_layout( $putter_socials,
				'<span class="author_socials"><span class="author_socials_caption">' . esc_html__( 'Follow:', 'putter' ) . '</span>',
				'</span>'
			);
		?>
	</div>

</div>
