<?php
/**
 * Skin Setup
 *
 * @package PUTTER
 * @since PUTTER 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'putter_theme_defaults' ) ) {
	function putter_theme_defaults( $name='', $value='' ) {
		$defaults = array(
			'page_width'          => 1290,
			'page_boxed_extra'  => 60,
			'page_fullwide_max' => 1920,
			'page_fullwide_extra' => 130,
			'sidebar_width'       => 410,
			'sidebar_gap'       => 40,
			'grid_gap'          => 30,
			'rad'               => 0,
		);
		if ( empty( $name ) ) {
			return $defaults;
		} else {
			if ( empty( $value ) && isset( $defaults[ $name ] ) ) {
				$value = $defaults[ $name ];
			}
			return $value;
		}
	}
}


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


//--------------------------------------------
// SKIN SETTINGS
//--------------------------------------------
if ( ! function_exists( 'putter_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'putter_skin_setup', 1 );
	function putter_skin_setup() {

		$GLOBALS['PUTTER_STORAGE'] = array_merge( $GLOBALS['PUTTER_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-themerex',

			'theme_doc_url'       => '//putter.themerex.net/doc',

			'theme_demofiles_url' => '//demofiles.themerex.net/putter/',
			
			'theme_rate_url'      => '//themeforest.net/download',

			'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

            'theme_download_url'  => '//themeforest.net/user/themerex/portfolio',            // ThemeREX

            'theme_video_url'     => '//www.youtube.com/channel/UCnFisBimrK2aIE-hnY70kCA',   // ThemeREX

            'theme_privacy_url'   => '//themerex.net/privacy-policy/',                       // ThemeREX

            'portfolio_url'       => '//themeforest.net/user/themerex/portfolio',            // ThemeREX

			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'putter_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'putter_skin_setup_settings', 1 );
	function putter_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		putter_storage_set_array( 'settings', 'thumbs_in_navigation', false );
        putter_storage_set_array2( 'required_plugins', 'instagram-feed', 'install', true);
        putter_storage_set_array2( 'required_plugins', 'quickcal', 'install', true);
	}
}



//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'putter_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'putter_skin_setup_fonts', 1 );
	function putter_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		putter_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'DM Sans',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'ital,wght@0,400;0,500;0,700;1,400;1,500;1,700',     // Parameter 'style' used only for the Google fonts
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		putter_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

        // Settings of the main tags.
        // Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
        // or as comma-separated string.
        // In the second case (if 'font-family' is specified manually as comma-separated string):
        //    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
        //    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
        // example:
        // Correct:   'font-family' => basekit_get_load_fonts_family_string( $load_fonts[0] )
        // Correct:   'font-family' => 'Roboto,sans-serif'
        // Correct:   'font-family' => '"PT Serif",sans-serif'
        // Incorrect: 'font-family' => 'Roboto, sans-serif'
        // Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'putter' );

		putter_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.647em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.57em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'putter' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '3.353em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-1.8px',
					'margin-top'      => '1.12em',
					'margin-bottom'   => '0.4em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '2.765em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.021em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-1.4px',
					'margin-top'      => '0.79em',
					'margin-bottom'   => '0.45em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '2.059em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-1px',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.63em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '1.647em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.214em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.5px',
					'margin-top'      => '1.44em',
					'margin-bottom'   => '0.62em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '1.412em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.208em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.5px',
					'margin-top'      => '1.55em',
					'margin-bottom'   => '0.8em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '1.118em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.474em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.6px',
					'margin-top'      => '1.75em',
					'margin-bottom'   => '1.1em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '1.7em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '21px',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'putter' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '16px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'putter' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '13px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '16px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'capitalize',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '14px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'other' => array(
					'title'           => esc_html__( 'Other', 'putter' ),
					'description'     => sprintf( $font_description, esc_html__( 'specific elements', 'putter' ) ),
					'font-family'     => '"DM Sans",sans-serif',
				),
			)
		);

		// Font presets
		putter_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'putter' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Dancing Script',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
													// Google font
													array(
														'name'   => 'Sansita Swashed',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Dancing Script",fantasy',
														'font-size'       => '1.25rem',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
														'font-size'       => '4em',
													),
													'h2'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h3'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h4'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h5'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h6'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'logo'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'button'  => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'submenu' => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
												),
							),
				'roboto' => array(
								'title'  => esc_html__( 'Roboto', 'putter' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Noto Sans JP',
														'family' => 'serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
													// Google font
													array(
														'name'   => 'Merriweather',
														'family' => 'sans-serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Noto Sans JP",serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
												),
							),
				'garamond' => array(
								'title'  => esc_html__( 'Garamond', 'putter' ),
								'load_fonts' => array(
													// Adobe font
													array(
														'name'   => 'Europe',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
													// Adobe font
													array(
														'name'   => 'Sofia Pro',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Sofia Pro",sans-serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Europe,sans-serif',
													),
												),
							),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'putter_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'putter_skin_setup_schemes', 1 );
	function putter_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		putter_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'putter' ),
					'description' => esc_html__( 'Colors of the main content area', 'putter' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'putter' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'putter' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'putter' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'putter' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'putter' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'putter' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'putter' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'putter' ),
				),
			)
		);

		putter_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'putter' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'putter' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'putter' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'putter' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'putter' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'putter' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'putter' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'putter' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'putter' ),
					'description' => esc_html__( 'Color of the text inside this block', 'putter' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'putter' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'putter' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'putter' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'putter' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'putter' ),
					'description' => esc_html__( 'Color of the links inside this block', 'putter' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'putter' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'putter' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'putter' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'putter' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'putter' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'putter' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'putter' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'putter' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'putter' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'putter' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'putter' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //+
					'bd_color'         => '#DBD9D7', //+

					// Text and links colors
					'text'             => '#6E6D68', //+
					'text_light'       => '#9A9694', //+
					'text_dark'        => '#1D1A0C', //+
					'text_link'        => '#2CC374', //+
					'text_hover'       => '#1BA25B', //+
					'text_link2'       => '#A6985B', //+
					'text_hover2'      => '#908246', //+
					'text_link3'       => '#9AA65B', //+
					'text_hover3'      => '#818D44', //+

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                    'alter_bg_color'   => '#F8F8F4', //+
                    'alter_bg_hover'   => '#F2F0EA', //+
                    'alter_bd_color'   => '#DBD9D7', //+
                    'alter_bd_hover'   => '#C3BFBB', //+
					'alter_text'       => '#6E6D68', //+
					'alter_light'      => '#9A9694', //+
					'alter_dark'       => '#1D1A0C', //+
					'alter_link'       => '#2CC374', //+
					'alter_hover'      => '#1BA25B', //+
					'alter_link2'      => '#A6985B', //+
					'alter_hover2'     => '#908246', //+
					'alter_link3'      => '#9AA65B', //+
					'alter_hover3'     => '#818D44', //+

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#19140F', //+
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#BCB5B0', //+
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#ffffff', //+
					'extra_link'       => '#2CC374', //+
					'extra_hover'      => '#ffffff', //+
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok
					'input_bg_hover'   => 'transparent', //ok
					'input_bd_color'   => '#DBD9D7', //+
					'input_bd_hover'   => '#BCBCBC', //ok
					'input_text'       => '#6E6D68', //+
					'input_light'      => '#9A9694', //+
					'input_dark'       => '#1D1A0C', //+

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#1D1A0C', //+
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#ffffff', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'putter' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#19140F', //+
					'bd_color'         => '#363029', //+

					// Text and links colors
					'text'             => '#BCB5B0', //+
					'text_light'       => '#A09C94', //+
					'text_dark'        => '#F8F8F4', //+
					'text_link'        => '#2CC374', //+
					'text_hover'       => '#1BA25B', //+
					'text_link2'       => '#A6985B', //+
					'text_hover2'      => '#908246', //+
					'text_link3'       => '#9AA65B', //+
					'text_hover3'      => '#818D44', //+

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#221C16', //+
					'alter_bg_hover'   => '#2B241D', //+
					'alter_bd_color'   => '#363029', //+
					'alter_bd_hover'   => '#413D36', //+
					'alter_text'       => '#BCB5B0', //+
					'alter_light'      => '#A09C94', //+
					'alter_dark'       => '#FCFCFC', //+
					'alter_link'       => '#2CC374', //+
					'alter_hover'      => '#1BA25B', //+
					'alter_link2'      => '#A6985B', //+
					'alter_hover2'     => '#908246', //+
					'alter_link3'      => '#9AA65B', //+
					'alter_hover3'     => '#818D44', //+

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#242833', //ok
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#BCB5B0', //+
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#ffffff', //ok
					'extra_link'       => '#2CC374', //+
					'extra_hover'      => '#ffffff', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent', //ok
					'input_bg_hover'   => '#transparent', //ok
					'input_bd_color'   => '#3C4252', //ok
					'input_bd_hover'   => '#53535C', //ok
					'input_text'       => '#BCB5B0', //+
					'input_light'      => '#A09C94', //+
					'input_dark'       => '#FFFFFF', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F5F6FA', //ok
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#1D1A0C', //+
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#1D1A0C', //+

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'default'
            'light' => array(
                'title'    => esc_html__( 'Light', 'putter' ),
                'internal' => true,
                'colors'   => array(

                    // Whole block border and background
                    'bg_color'         => '#F8F8F4', //+
                    'bd_color'         => '#DBD9D7', //+

                    // Text and links colors
                    'text'             => '#6E6D68', //+
                    'text_light'       => '#9A9694', //+
                    'text_dark'        => '#1D1A0C', //+
                    'text_link'        => '#2CC374', //+
                    'text_hover'       => '#1BA25B', //+
                    'text_link2'       => '#A6985B', //+
                    'text_hover2'      => '#908246', //+
                    'text_link3'       => '#9AA65B', //+
                    'text_hover3'      => '#818D44', //+

                    // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                    'alter_bg_color'   => '#FFFFFF', //+
                    'alter_bg_hover'   => '#FFFFFF', //ok
                    'alter_bd_color'   => '#DBD9D7', //+
                    'alter_bd_hover'   => '#BCBCBC', //ok
                    'alter_text'       => '#6E6D68', //+
                    'alter_light'      => '#9A9694', //+
                    'alter_dark'       => '#1D1A0C', //+
                    'alter_link'       => '#2CC374', //+
                    'alter_hover'      => '#1BA25B', //+
                    'alter_link2'      => '#A6985B', //+
                    'alter_hover2'     => '#908246', //+
                    'alter_link3'      => '#9AA65B', //+
                    'alter_hover3'     => '#818D44', //+

                    // Extra blocks (submenu, tabs, color blocks, etc.)
                    'extra_bg_color'   => '#242833', //ok
                    'extra_bg_hover'   => '#3f3d47',
                    'extra_bd_color'   => '#313131',
                    'extra_bd_hover'   => '#575757',
                    'extra_text'       => '#D2D3D5', //ok
                    'extra_light'      => '#afafaf',
                    'extra_dark'       => '#ffffff', //ok
                    'extra_link'       => '#2CC374', //+
                    'extra_hover'      => '#ffffff', //ok
                    'extra_link2'      => '#80d572',
                    'extra_hover2'     => '#8be77c',
                    'extra_link3'      => '#ddb837',
                    'extra_hover3'     => '#eec432',

                    // Input fields (form's fields and textarea)
                    'input_bg_color'   => 'transparent', //ok
                    'input_bg_hover'   => 'transparent', //ok
                    'input_bd_color'   => '#DBD9D7', //+
                    'input_bd_hover'   => '#BCBCBC', //ok
                    'input_text'       => '#6E6D68', //+
                    'input_light'      => '#9A9694', //+
                    'input_dark'       => '#1D1A0C', //+

                    // Inverse blocks (text and links on the 'text_link' background)
                    'inverse_bd_color' => '#67bcc1',
                    'inverse_bd_hover' => '#5aa4a9',
                    'inverse_text'     => '#1d1d1d',
                    'inverse_light'    => '#333333',
                    'inverse_dark'     => '#1D1A0C', //+
                    'inverse_link'     => '#ffffff', //ok
                    'inverse_hover'    => '#ffffff', //ok

                    // Additional (skin-specific) colors.
                    // Attention! Set of colors must be equal in all color schemes.
                    //---> For example:
                    //---> 'new_color1'         => '#rrggbb',
                    //---> 'alter_new_color1'   => '#rrggbb',
                    //---> 'inverse_new_color1' => '#rrggbb',
                ),
			),
		);
		putter_storage_set( 'schemes', $schemes );
		putter_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> putter_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'putter' ),
		//---> 	'description' => __( 'Description of the new color 1', 'putter' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		putter_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_dark_015'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.15,
                ),
                'alter_dark_02'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.2,
                ),
                'alter_dark_05'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.5,
                ),
                'alter_dark_08'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.8,
                ),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_003'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.03,
                ),
                'text_dark_005'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.05,
                ),
                'text_dark_008'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.08,
                ),
				'text_dark_015'      => array(
					'color' => 'text_dark',
					'alpha' => 0.15,
				),
				'text_dark_02'      => array(
					'color' => 'text_dark',
					'alpha' => 0.2,
				),
                'text_dark_03'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
                'text_link_007'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.07,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_03'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.3,
                ),
				'text_link_04'      => array(
					'color' => 'text_link',
					'alpha' => 0.4,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
                'text_link2_007'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.07,
                ),
				'text_link2_02'      => array(
					'color' => 'text_link2',
					'alpha' => 0.2,
				),
                'text_link2_03'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.3,
                ),
				'text_link2_05'      => array(
					'color' => 'text_link2',
					'alpha' => 0.5,
				),
                'text_link2_08'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.8,
                ),
                'text_link3_007'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.07,
                ),
				'text_link3_02'      => array(
					'color' => 'text_link3',
					'alpha' => 0.2,
				),
                'text_link3_03'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.3,
                ),
                'inverse_text_03'      => array(
                    'color' => 'inverse_text',
                    'alpha' => 0.3,
                ),
                'inverse_link_08'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.8,
                ),
                'inverse_hover_08'      => array(
                    'color' => 'inverse_hover',
                    'alpha' => 0.8,
                ),
				'text_dark_blend'   => array(
					'color'      => 'text_dark',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		putter_storage_set(
			'schemes_simple', array(
				'text_link'        => array(
					'alter_hover'      => 1,
					'extra_link'       => 1,
					'inverse_bd_color' => 0.85,
					'inverse_bd_hover' => 0.7,
				),
				'text_hover'       => array(
					'alter_link'  => 1,
					'extra_hover' => 1,
				),
				'text_link2'       => array(
					'alter_hover2' => 1,
					'extra_link2'  => 1,
				),
				'text_hover2'      => array(
					'alter_link2'  => 1,
					'extra_hover2' => 1,
				),
				'text_link3'       => array(
					'alter_hover3' => 1,
					'extra_link3'  => 1,
				),
				'text_hover3'      => array(
					'alter_link3'  => 1,
					'extra_hover3' => 1,
				),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
				'inverse_bd_color' => array(),
				'inverse_bd_hover' => array(),
			)
		);

		// Parameters to set order of schemes in the css
		putter_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		putter_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'putter' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	),
												'dark' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	)
												)
							),
				'green' => array(
								'title'  => esc_html__( 'Natural Green', 'putter' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	),
												'dark' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	)
												)
							),
			)
		);
	}
}
// Activation methods
if ( ! function_exists( 'putter_skin_filter_activation_methods2' ) ) {
    add_filter( 'trx_addons_filter_activation_methods', 'putter_skin_filter_activation_methods2', 11, 1 );
    function putter_skin_filter_activation_methods2( $args ) {
        $args['elements_key'] = true;
        return $args;
    }
}