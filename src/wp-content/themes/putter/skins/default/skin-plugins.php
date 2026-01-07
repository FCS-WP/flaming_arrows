<?php
/**
 * Required plugins
 *
 * @package PUTTER
 * @since PUTTER 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
if ( ! function_exists( 'putter_skin_required_plugins' ) ) {
	add_action( 'after_setup_theme', 'putter_skin_required_plugins', -1 );
	/**
	 * Create the list of required plugins for the skin/theme.
	 * Priority -1 is used to create the list of plugins before the rest skin/theme actions.
	 * 
	 * @hooked 'after_setup_theme', -1
	 */
	function putter_skin_required_plugins() {
		$putter_theme_required_plugins_groups = array(
		'core'          => esc_html__( 'Core', 'putter' ),
		'page_builders' => esc_html__( 'Page Builders', 'putter' ),
		'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'putter' ),
		'socials'       => esc_html__( 'Socials and Communities', 'putter' ),
		'events'        => esc_html__( 'Events and Appointments', 'putter' ),
		'content'       => esc_html__( 'Content', 'putter' ),
		'other'         => esc_html__( 'Other', 'putter' ),
		);
		$putter_theme_required_plugins = array(
			'trx_addons'                 => array(
				'title'       => esc_html__( 'ThemeREX Addons', 'putter' ),
				'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'putter' ),
				'required'    => true,
				'logo'        => 'trx_addons.png',
				'group'       => $putter_theme_required_plugins_groups['core'],
			),
			'elementor'                  => array(
				'title'       => esc_html__( 'Elementor', 'putter' ),
				'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'putter' ),
				'required'    => false,
				'logo'        => 'elementor.png',
				'group'       => $putter_theme_required_plugins_groups['page_builders'],
			),
			'gutenberg'                  => array(
				'title'       => esc_html__( 'Gutenberg', 'putter' ),
				'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'putter' ),
				'required'    => false,
				'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
				'logo'        => 'gutenberg.png',
				'group'       => $putter_theme_required_plugins_groups['page_builders'],
			),
			'js_composer'                => array(
				'title'       => esc_html__( 'WPBakery PageBuilder', 'putter' ),
				'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'putter' ),
				'required'    => false,
				'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
				'logo'        => 'js_composer.jpg',
				'group'       => $putter_theme_required_plugins_groups['page_builders'],
			),
			'woocommerce'                => array(
				'title'       => esc_html__( 'WooCommerce', 'putter' ),
				'description' => esc_html__( "Connect the store to your website and start selling now", 'putter' ),
				'required'    => false,
				'logo'        => 'woocommerce.png',
				'group'       => $putter_theme_required_plugins_groups['ecommerce'],
			),
			'elegro-payment'             => array(
				'title'       => esc_html__( 'Elegro Crypto Payment', 'putter' ),
				'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'putter' ),
				'required'    => false,
				'install'     => false, // TRX_addons has marked the "Elegro Crypto Payment" plugin as obsolete and no longer recommends it for installation, even if it had been previously recommended by the theme
				'logo'        => 'elegro-payment.png',
				'group'       => $putter_theme_required_plugins_groups['ecommerce'],
			),
			'instagram-feed'             => array(
				'title'       => esc_html__( 'Instagram Feed', 'putter' ),
				'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'putter' ),
				'required'    => false,
				'logo'        => 'instagram-feed.png',
				'group'       => $putter_theme_required_plugins_groups['socials'],
			),
			'mailchimp-for-wp'           => array(
				'title'       => esc_html__( 'MailChimp for WP', 'putter' ),
				'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'putter' ),
				'required'    => false,
				'logo'        => 'mailchimp-for-wp.png',
				'group'       => $putter_theme_required_plugins_groups['socials'],
			),
			'booked'                     => array(
				'title'       => esc_html__( 'Booked Appointments', 'putter' ),
				'description' => '',
				'required'    => false,
				'install'     => false,
				'logo'        => 'booked.png',
				'group'       => $putter_theme_required_plugins_groups['events'],
			),
			'quickcal'                     => array(
				'title'       => esc_html__( 'QuickCal', 'putter' ),
				'description' => '',
				'required'    => false,
				'install'     => false,
				'logo'        => 'quickcal.png',
				'group'       => $putter_theme_required_plugins_groups['events'],
			),
			'the-events-calendar'        => array(
				'title'       => esc_html__( 'The Events Calendar', 'putter' ),
				'description' => '',
				'required'    => false,
				'logo'        => 'the-events-calendar.png',
				'group'       => $putter_theme_required_plugins_groups['events'],
			),
			'contact-form-7'             => array(
				'title'       => esc_html__( 'Contact Form 7', 'putter' ),
				'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'putter' ),
				'required'    => false,
				'logo'        => 'contact-form-7.png',
				'group'       => $putter_theme_required_plugins_groups['content'],
			),

			'latepoint'                  => array(
				'title'       => esc_html__( 'LatePoint', 'putter' ),
				'description' => '',
				'required'    => false,
				'install'     => false,
				'logo'        => putter_get_file_url( 'plugins/latepoint/latepoint.png' ),
				'group'       => $putter_theme_required_plugins_groups['events'],
			),
			'advanced-popups'                  => array(
				'title'       => esc_html__( 'Advanced Popups', 'putter' ),
				'description' => '',
				'required'    => false,
				'logo'        => putter_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
				'group'       => $putter_theme_required_plugins_groups['content'],
			),
			'devvn-image-hotspot'                  => array(
				'title'       => esc_html__( 'Image Hotspot by DevVN', 'putter' ),
				'description' => '',
				'required'    => false,
				'install'     => false,
				'logo'        => putter_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
				'group'       => $putter_theme_required_plugins_groups['content'],
			),
			'ti-woocommerce-wishlist'                  => array(
				'title'       => esc_html__( 'TI WooCommerce Wishlist', 'putter' ),
				'description' => '',
				'required'    => false,
				'logo'        => putter_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
				'group'       => $putter_theme_required_plugins_groups['ecommerce'],
			),
			'woo-smart-quick-view'                  => array(
				'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'putter' ),
				'description' => '',
				'required'    => false,
				'install'     => false,
				'logo'        => putter_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
				'group'       => $putter_theme_required_plugins_groups['ecommerce'],
			),
			'twenty20'                  => array(
				'title'       => esc_html__( 'Twenty20 Image Before-After', 'putter' ),
				'description' => '',
				'required'    => false,
				'install'     => false,
				'logo'        => putter_get_file_url( 'plugins/twenty20/twenty20.png' ),
				'group'       => $putter_theme_required_plugins_groups['content'],
			),
			'essential-grid'             => array(
				'title'       => esc_html__( 'Essential Grid', 'putter' ),
				'description' => '',
				'required'    => false,
				'install'     => false,
				'logo'        => 'essential-grid.png',
				'group'       => $putter_theme_required_plugins_groups['content'],
			),
			'revslider'                  => array(
				'title'       => esc_html__( 'Revolution Slider', 'putter' ),
				'description' => '',
				'required'    => false,
				'logo'        => 'revslider.png',
				'group'       => $putter_theme_required_plugins_groups['content'],
			),
			'sitepress-multilingual-cms' => array(
				'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'putter' ),
				'description' => esc_html__( "Allows you to make your website multilingual", 'putter' ),
				'required'    => false,
				'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
				'logo'        => 'sitepress-multilingual-cms.png',
				'group'       => $putter_theme_required_plugins_groups['content'],
			),
			'wp-gdpr-compliance'         => array(
				'title'       => esc_html__( 'Cookie Information', 'putter' ),
				'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'putter' ),
				'required'    => false,
				'install'     => false,
				'logo'        => 'wp-gdpr-compliance.png',
				'group'       => $putter_theme_required_plugins_groups['other'],
			),
			'gdpr-framework'         => array(
				'title'       => esc_html__( 'The GDPR Framework', 'putter' ),
				'description' => esc_html__( "Tools to help make your website GDPR-compliant. Fully documented, extendable and developer-friendly.", 'putter' ),
				'required'    => false,
				'install'     => false,
				'logo'        => 'gdpr-framework.png',
				'group'       => $putter_theme_required_plugins_groups['other'],
			),
			'trx_updater'                => array(
				'title'       => esc_html__( 'ThemeREX Updater', 'putter' ),
				'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'putter' ),
				'required'    => false,
				'logo'        => 'trx_updater.png',
				'group'       => $putter_theme_required_plugins_groups['other'],
			),
		);

		if ( PUTTER_THEME_FREE ) {
			unset( $putter_theme_required_plugins['js_composer'] );
			unset( $putter_theme_required_plugins['booked'] );
			unset( $putter_theme_required_plugins['quickcal'] );
			unset( $putter_theme_required_plugins['the-events-calendar'] );
			unset( $putter_theme_required_plugins['calculated-fields-form'] );
			unset( $putter_theme_required_plugins['essential-grid'] );
			unset( $putter_theme_required_plugins['revslider'] );
			unset( $putter_theme_required_plugins['sitepress-multilingual-cms'] );
			unset( $putter_theme_required_plugins['trx_updater'] );
			unset( $putter_theme_required_plugins['trx_popup'] );
		}

		// Add plugins list to the global storage
		putter_storage_set( 'required_plugins', $putter_theme_required_plugins );
	}
}
