<?php
/**
 * The template 'Style 5' to displaying related posts
 *
 * @package PUTTER
 * @since PUTTER 1.0.54
 */

$putter_link        = get_permalink();
$putter_post_format = get_post_format();
$putter_post_format = empty( $putter_post_format ) ? 'standard' : str_replace( 'post-format-', '', $putter_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $putter_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	putter_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'putter_filter_related_thumb_size', putter_get_thumb_size( (int) putter_get_theme_option( 'related_posts' ) == 1 ? 'big' : 'med' ) ),
		)
	);
	?>
	<div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $putter_link ); ?>"><?php
			if ( '' == get_the_title() ) {
				esc_html_e( '- No title -', 'putter' );
			} else {
				the_title();
			}
		?></a></h6>
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<div class="post_meta">
				<a href="<?php echo esc_url( $putter_link ); ?>" class="post_meta_item post_date"><?php echo wp_kses_data( putter_get_date() ); ?></a>
			</div>
			<?php
		}
		?>
	</div>
</div>
