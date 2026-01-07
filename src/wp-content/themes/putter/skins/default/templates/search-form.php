<?php
$putter_args = array_merge(
	array(
		'style'      => 'normal',
		'class'      => '',
		'ajax'       => false,
		'post_types' => '',
		'role'       => 'search',
	),
	(array) get_query_var( 'putter_search_args' )
);
?><div class="search_wrap search_style_<?php echo esc_attr( $putter_args['style'] ) . ( ! empty( $putter_args['class'] ) ? ' ' . esc_attr( $putter_args['class'] ) : '' ); ?>">
	<div class="search_form_wrap">
		<form role="<?php echo esc_attr( $putter_args['role'] ); ?>" method="get" class="search_form" action="<?php echo esc_url( apply_filters( 'putter_filter_search_form_url', home_url( '/' ) ) ); ?>">
			<input type="hidden" value="<?php
				if ( ! empty( $args[ 'post_types' ] ) ) {
					echo esc_attr( is_array( $args[ 'post_types' ] ) ? join( ',', $args[ 'post_types' ] ) : $args[ 'post_types' ] );
				}
			?>" name="post_types">
			<input type="text" class="search_field" placeholder="<?php esc_attr_e( 'Search', 'putter' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
			<button type="submit" class="search_submit icon-search"></button>
		</form>
	</div>
</div>
