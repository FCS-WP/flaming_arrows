<?php
/**
 * Quick Setup Section in the Theme Panel
 *
 * @package PUTTER
 * @since PUTTER 1.0.48
 */


// Load required styles and scripts for admin mode
if ( ! function_exists( 'putter_options_qsetup_add_scripts' ) ) {
	add_action("admin_enqueue_scripts", 'putter_options_qsetup_add_scripts');
	function putter_options_qsetup_add_scripts() {
		if ( ! PUTTER_THEME_FREE ) {
			$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
			if ( is_object( $screen ) && ! empty( $screen->id ) && false !== strpos($screen->id, 'page_trx_addons_theme_panel') ) {
				wp_enqueue_style( 'putter-fontello', putter_get_file_url( 'css/font-icons/css/fontello.css' ), array(), null );
				wp_enqueue_script( 'jquery-ui-tabs', false, array( 'jquery', 'jquery-ui-core' ), null, true );
				wp_enqueue_script( 'jquery-ui-accordion', false, array( 'jquery', 'jquery-ui-core' ), null, true );
				wp_enqueue_script( 'putter-options', putter_get_file_url( 'theme-options/theme-options.js' ), array( 'jquery' ), null, true );
				wp_localize_script( 'putter-options', 'putter_dependencies', putter_get_theme_dependencies() );
				wp_localize_script(	'putter-options', 'putter_options_vars', apply_filters(
					'putter_filter_options_vars', array(
						'max_load_fonts'            => putter_get_theme_setting( 'max_load_fonts' ),
						'save_only_changed_options' => putter_get_theme_setting( 'save_only_changed_options' ),
					)
				) );
			}
		}
	}
}


// Add step to the 'Quick Setup'
if ( ! function_exists( 'putter_options_qsetup_theme_panel_steps' ) ) {
	add_filter( 'trx_addons_filter_theme_panel_steps', 'putter_options_qsetup_theme_panel_steps' );
	function putter_options_qsetup_theme_panel_steps( $steps ) {
		if ( ! PUTTER_THEME_FREE ) {
			$steps = putter_array_merge( $steps, array( 'qsetup' => esc_html__( 'Start customizing your theme.', 'putter' ) ) );
		}
		return $steps;
	}
}


// Add tab link 'Quick Setup'
if ( ! function_exists( 'putter_options_qsetup_theme_panel_tabs' ) ) {
	add_filter( 'trx_addons_filter_theme_panel_tabs', 'putter_options_qsetup_theme_panel_tabs' );
	function putter_options_qsetup_theme_panel_tabs( $tabs ) {
		if ( ! PUTTER_THEME_FREE ) {
			putter_array_insert_after( $tabs, 'plugins', array( 'qsetup' => esc_html__( 'Quick Setup', 'putter' ) ) );
		}
		return $tabs;
	}
}

// Add accent colors to the 'Quick Setup' section in the Theme Panel
if ( ! function_exists( 'putter_options_qsetup_add_accent_colors' ) ) {
	add_filter( 'putter_filter_qsetup_options', 'putter_options_qsetup_add_accent_colors' );
	function putter_options_qsetup_add_accent_colors( $options ) {
		$colors = apply_filters( 'putter_filter_qsetup_colors', array(
			'text_link',
			'text_hover',
			'text_link2',
			'text_hover2',
			'text_link3',
			'text_hover3',
		) );
		if ( is_array( $colors ) && count( $colors ) > 0 ) {
			$names = putter_storage_get( 'scheme_color_names' );
			$list = array(
				'colors_info'        => array(
					'title'    => esc_html__( 'Theme Colors', 'putter' ),
					'desc'     => '',
					'qsetup'   => esc_html__( 'General', 'putter' ),
					'type'     => 'info',
				),
			);
			foreach ( $colors as $color ) {
				if ( empty( $names[ $color ] ) ) {
					continue;
				}
				$list[ 'colors_' . putter_get_scheme_color_name( $color ) ] = array(
					'title'    => esc_html( $names[ $color ]['title'] ),
					'desc'     => wp_kses_data( $names[ $color ]['description'] ),
					'std'      => '',
					'val'      => putter_get_scheme_color( $color ),
					'qsetup'   => esc_html__( 'General', 'putter' ),
					'type'     => 'color',
				);
			}
			$options = putter_array_merge( $list, $options );
		}
		return $options;
	}
}

// Display 'Quick Setup' section in the Theme Panel
if ( ! function_exists( 'putter_options_qsetup_theme_panel_section' ) ) {
	add_action( 'trx_addons_action_theme_panel_section', 'putter_options_qsetup_theme_panel_section', 10, 2);
	function putter_options_qsetup_theme_panel_section( $tab_id, $theme_info ) {
		if ( 'qsetup' !== $tab_id ) return;
		?>
		<div id="trx_addons_theme_panel_section_<?php echo esc_attr($tab_id); ?>" class="trx_addons_tabs_section">

			<?php do_action('trx_addons_action_theme_panel_section_start', $tab_id, $theme_info); ?>
			
			<div class="trx_addons_theme_panel_section_content trx_addons_theme_panel_qsetup">

				<?php do_action('trx_addons_action_theme_panel_before_section_title', $tab_id, $theme_info); ?>

				<h1 class="trx_addons_theme_panel_section_title">
					<?php esc_html_e( 'Quick Setup', 'putter' ); ?>
				</h1>

				<?php do_action('trx_addons_action_theme_panel_after_section_title', $tab_id, $theme_info); ?>
				
				<div class="trx_addons_theme_panel_section_description">
					<p>
						<?php
						echo wp_kses_data( __( 'Here you can customize the basic settings of your website.', 'putter' ) )
							. ' '
							. wp_kses_data( sprintf(
								__( 'For a detailed customization, go to %s.', 'putter' ),
								'<a href="' . esc_url(admin_url() . 'customize.php') . '">' . esc_html__( 'Customizer', 'putter' ) . '</a>'
								. ( PUTTER_THEME_FREE 
									? ''
									: ' ' . esc_html__( 'or', 'putter' ) . ' ' . '<a href="' . esc_url( get_admin_url( null, 'admin.php?page=trx_addons_theme_panel' ) ) . '">' . esc_html__( 'Theme Options', 'putter' ) . '</a>'
									)
								)
							);
						echo ' ' . wp_kses_data( __( "If you've imported the demo data, you may skip this step, since all the necessary settings have already been applied.", 'putter' ) );
						?>
					</p>
				</div>

				<?php
				do_action('trx_addons_action_theme_panel_before_qsetup', $tab_id, $theme_info);

				putter_options_qsetup_show();

				do_action('trx_addons_action_theme_panel_after_qsetup', $tab_id, $theme_info);

				do_action('trx_addons_action_theme_panel_after_section_data', $tab_id, $theme_info);
				?>

			</div>

			<?php do_action('trx_addons_action_theme_panel_section_end', $tab_id, $theme_info); ?>

		</div>
		<?php
	}
}


// Display options
if ( ! function_exists( 'putter_options_qsetup_show' ) ) {
	function putter_options_qsetup_show() {
		$tabs_titles  = array();
		$tabs_content = array();
		$options      = apply_filters( 'putter_filter_qsetup_options', putter_storage_get( 'options' ) );
		// Show fields
		$cnt = 0;
		foreach ( $options as $k => $v ) {
			if ( empty( $v['qsetup'] ) ) {
				continue;
			}
			if ( is_bool( $v['qsetup'] ) ) {
				$v['qsetup'] = esc_html__( 'General', 'putter' );
			}
			if ( ! isset( $tabs_titles[ $v['qsetup'] ] ) ) {
				$tabs_titles[ $v['qsetup'] ]  = $v['qsetup'];
				$tabs_content[ $v['qsetup'] ] = '';
			}
			if ( 'info' !== $v['type'] ) {
				$cnt++;
				if ( ! empty( $v['class'] ) ) {
					$v['class'] = str_replace( array( 'putter_column-1_2', 'putter_new_row' ), '', $v['class'] );
				}
				$v['class'] = ( ! empty( $v['class'] ) ? $v['class'] . ' ' : '' ) . 'putter_column-1_2' . ( $cnt % 2 == 1 ? ' putter_new_row' : '' );
			} else {
				$cnt = 0;
			}
			$tabs_content[ $v['qsetup'] ] .= putter_options_show_field( $k, $v );
		}
		if ( count( $tabs_titles ) > 0 ) {
			?>
			<div class="putter_options putter_options_qsetup">
				<form action="<?php echo esc_url( get_admin_url( null, 'admin.php?page=trx_addons_theme_panel' ) ); ?>" class="trx_addons_theme_panel_section_form" name="trx_addons_theme_panel_qsetup_form" method="post">
					<input type="hidden" name="qsetup_options_nonce" value="<?php echo esc_attr( wp_create_nonce( admin_url() ) ); ?>" />
					<?php
					if ( count( $tabs_titles ) > 1 ) {
						?>
						<div id="putter_options_tabs" class="putter_tabs">
							<ul>
								<?php
								$cnt = 0;
								foreach ( $tabs_titles as $k => $v ) {
									$cnt++;
									?>
									<li><a href="#putter_options_<?php echo esc_attr( $cnt ); ?>"><?php echo esc_html( $v ); ?></a></li>
									<?php
								}
								?>
							</ul>
							<?php
							$cnt = 0;
							foreach ( $tabs_content as $k => $v ) {
								$cnt++;
								?>
								<div id="putter_options_<?php echo esc_attr( $cnt ); ?>" class="putter_tabs_section putter_options_section">
									<?php putter_show_layout( $v ); ?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					} else {
						?>
						<div class="putter_options_section">
							<?php putter_show_layout( putter_array_get_first( $tabs_content, false ) ); ?>
						</div>
						<?php
					}
					?>
					<div class="putter_options_buttons trx_buttons">
						<a href="#" class="putter_options_button_submit trx_addons_button trx_addons_button_accent" tabindex="0"><?php esc_html_e( 'Save Options', 'putter' ); ?></a>
					</div>
				</form>
			</div>
			<?php
		}
	}
}


// Save quick setup options
if ( ! function_exists( 'putter_options_qsetup_save_options' ) ) {
	add_action( 'after_setup_theme', 'putter_options_qsetup_save_options', 4 );
	function putter_options_qsetup_save_options() {

		if ( ! isset( $_REQUEST['page'] ) || 'trx_addons_theme_panel' != $_REQUEST['page'] || '' == putter_get_value_gp( 'qsetup_options_nonce' ) ) {
			return;
		}

		// verify nonce
		if ( ! wp_verify_nonce( putter_get_value_gp( 'qsetup_options_nonce' ), admin_url() ) ) {
			trx_addons_set_admin_message( esc_html__( 'Bad security code! Options are not saved!', 'putter' ), 'error', true );
			return;
		}

		// Check permissions
		if ( ! current_user_can( 'manage_options' ) ) {
			trx_addons_set_admin_message( esc_html__( 'Manage options is denied for the current user! Options are not saved!', 'putter' ), 'error', true );
			return;
		}

		// Prepare colors for Theme Options
		$scheme_storage = get_theme_mod( 'scheme_storage' );
		if ( empty( $scheme_storage ) ) {
			$scheme_storage = putter_get_scheme_storage();
		}
		if ( ! empty( $scheme_storage ) ) {
			$schemes = putter_unserialize( $scheme_storage );
			if ( is_array( $schemes ) ) {
				$main_scheme = putter_storage_get_array( 'schemes_sorted', 0 );
				if ( empty( $main_scheme ) ) {
					$main_scheme = 'default';
				}
				$color_scheme = get_theme_mod( $main_scheme, putter_storage_get_array( 'options', $main_scheme, 'std' ) );
				if ( empty( $color_scheme ) ) {
					$color_scheme = putter_array_get_first( $schemes );
				}
				if ( ! empty( $schemes[ $color_scheme ] ) ) {
					$schemes_simple = putter_storage_get( 'schemes_simple' );
					// Get posted data and calculate substitutions
					$need_save = false;
					foreach ( $schemes[ $color_scheme ][ 'colors' ] as $k => $v ) {
						$v2 = putter_get_value_gp( "putter_options_field_colors_{$k}" );
						if ( ! empty( $v2 ) && $v != $v2 ) {
							$schemes[ $color_scheme ][ 'colors' ][ $k ] = $v2;
							$need_save = true;
							// Сalculate substitutions
							if ( isset( $schemes_simple[ $k ] ) && is_array( $schemes_simple[ $k ] ) ) {
								foreach ( $schemes_simple[ $k ] as $color => $level ) {
									$new_v2 = $v2;
									// Make color_value darker or lighter
									if ( 1 != $level ) {
										$hsb = putter_hex2hsb( $new_v2 );
										$hsb[ 'b' ] = min( 100, max( 0, $hsb[ 'b' ] * ( $hsb[ 'b' ] < 70 ? 2 - $level : $level ) ) );
										$new_v2 = putter_hsb2hex( $hsb );
									}
									$schemes[ $color_scheme ][ 'colors' ][ $color ] = $new_v2;
								}
							}
						}
					}
					// Put new values to the POST
					if ( $need_save ) {
						$_POST[ 'putter_options_field_scheme_storage' ] = serialize( $schemes );
					}
				}
			}
		}

		// Save options
		putter_options_update( null, 'putter_options_field_' );

		// Return result
		trx_addons_set_admin_message( esc_html__( 'Options are saved', 'putter' ), 'success', true );
		wp_redirect( get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_qsetup' ) );
		exit();
	}
}
