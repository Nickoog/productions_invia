<?php
/**
 * Wolf Gram Admin.
 *
 * @class WG_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfGram/Admin
 * @version 1.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WG_Admin class.
 */
class WG_Admin {
	/**
	 * Constructor
	 */
	public function __construct() {

		// Includes files
		$this->includes();

		// Admin init hooks
		$this->admin_init_hooks();
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once( 'class-wg-options.php' );
		include_once( 'wg-admin-functions.php' );
	}

	/**
	 * Admin init
	 */
	public function admin_init_hooks() {

		// Plugin paypal row meta
		add_filter( 'plugin_row_meta', array( $this, 'paypal_row_meta' ), 10, 2 );
		add_filter( 'plugin_action_links_' . plugin_basename( WG_PATH ), array( $this, 'settings_action_links' ) );

		// Plugin update notifications
		add_action( 'admin_init', array( $this, 'plugin_update' ) );
	}

	/**
	 * Add plugin row meta for paypal donation
	 */
	public static function paypal_row_meta( $links, $file ) {

		if ( strpos( $file, 'wolf-gram.php' ) !== false ) {

			$donation_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=GSKY6MFWYW48A&lc=FR&item_name=WolfThemes&no_note=0&cn=Ajouter%20des%20instructions%20particuli%c3%a8res%20pour%20le%20vendeur%20%3a&no_shipping=2&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted';
			
			$new_links = array(
				'<a href="' . esc_url( $donation_url ) . '" target="_blank">' . esc_html__( 'Donate', 'wolf-gram' ) . '</a>'
			);
			
			$links = array_merge( $links, $new_links );
		}
		
		return $links;
	}

	/**
	 * Add settings link in plugin page
	 */
	public function settings_action_links( $links ) {
		$setting_link = array(
			'<a href="' . admin_url( 'admin.php?page=wolf-gram-options' ) . '">' . esc_html__( 'Settings', 'wolf-gram' ) . '</a>',
		);
		return array_merge( $links, $setting_link );
	}

	/**
	 * Plugin update
	 */
	public function plugin_update() {
		
		$plugin_name = WG_SLUG;
		$plugin_slug = WG_SLUG;
		$plugin_path = WG_PATH;
		$remote_path = WG_UPDATE_URL . '/' . $plugin_slug;
		$plugin_data = get_plugin_data( WG_DIR . '/' . WG_SLUG . '.php' );
		$current_version = $plugin_data['Version'];
		include_once( 'class-wg-update.php');
		new WG_Update( $current_version, $remote_path, $plugin_path );
	}
}

return new WG_Admin();