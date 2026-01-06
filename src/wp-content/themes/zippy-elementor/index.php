<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package PUTTER
 * @since PUTTER 1.0
 */

$putter_template = apply_filters( 'putter_filter_get_template_part', putter_blog_archive_get_template() );

if ( ! empty( $putter_template ) && 'index' != $putter_template ) {

	get_template_part( $putter_template );

} else {

	putter_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$putter_stickies   = is_home()
								|| ( in_array( putter_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) putter_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$putter_post_type  = putter_get_theme_option( 'post_type' );
		$putter_args       = array(
								'blog_style'     => putter_get_theme_option( 'blog_style' ),
								'post_type'      => $putter_post_type,
								'taxonomy'       => putter_get_post_type_taxonomy( $putter_post_type ),
								'parent_cat'     => putter_get_theme_option( 'parent_cat' ),
								'posts_per_page' => putter_get_theme_option( 'posts_per_page' ),
								'sticky'         => putter_get_theme_option( 'sticky_style', 'inherit' ) == 'columns'
															&& is_array( $putter_stickies )
															&& count( $putter_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		putter_blog_archive_start();

		do_action( 'putter_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'putter_action_before_page_author' );
			get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'putter_action_after_page_author' );
		}

		if ( putter_get_theme_option( 'show_filters', 0 ) ) {
			do_action( 'putter_action_before_page_filters' );
			putter_show_filters( $putter_args );
			do_action( 'putter_action_after_page_filters' );
		} else {
			do_action( 'putter_action_before_page_posts' );
			putter_show_posts( array_merge( $putter_args, array( 'cat' => $putter_args['parent_cat'] ) ) );
			do_action( 'putter_action_after_page_posts' );
		}

		do_action( 'putter_action_blog_archive_end' );

		putter_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'putter_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
