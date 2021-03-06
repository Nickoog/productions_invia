<?php
/**
 * Wolf Video Thumbnail Generator Admin.
 *
 * @class WVTG_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfVideoThumbnailGenerator/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WVTG_Admin class.
 */
class WVTG_Admin {
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
	 * Perform actions on updating the theme id needed
	 */
	public function update() {

		if ( ! defined( 'IFRAME_REQUEST' ) && ! defined( 'DOING_AJAX' ) && ( get_option( 'wvtg_version' ) != WVTG_VERSION ) ) {
		
			// Update hook
			do_action( 'wvtg_do_update' );

			// Update version
			delete_option( 'wvtg_version' );
			add_option( 'wvtg_version', WVTG_VERSION );

			// After update hook
			do_action( 'wvtg_updated' );
		}
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {

		
	}

	/**
	 * Admin init
	 */
	public function admin_init_hooks() {

		// Update version and perform stuf if needed
		add_action( 'admin_init', array( $this, 'update' ), 0 );

		// Plugin paypal row meta
		add_filter( 'plugin_row_meta', array( $this, 'paypal_row_meta' ), 10, 2 );

		// Plugin update notifications
		add_action( 'admin_init', array( $this, 'plugin_update' ) );

	}

	/**
	 * Add plugin row meta for paypal donation
	 */
	public static function paypal_row_meta( $links, $file ) {

		if ( strpos( $file, 'wolf-video-thumbnail-generator.php' ) !== false ) {

			$donation_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=GSKY6MFWYW48A&lc=FR&item_name=WolfThemes&no_note=0&cn=Ajouter%20des%20instructions%20particuli%c3%a8res%20pour%20le%20vendeur%20%3a&no_shipping=2&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted';
			
			$new_links = array(
				'<a href="' . esc_url( $donation_url ) . '" target="_blank">' . esc_html__( 'Donate', 'wolf-video-thumbnail-generator' ) . '</a>'
			);
			
			$links = array_merge( $links, $new_links );
		}
		
		return $links;
	}

	/**
	 * Plugin update
	 */
	public function plugin_update() {
		
		$plugin_slug = WVTG_SLUG;
		$plugin_path = WVTG_PATH;
		$remote_path = WVTG_UPDATE_URL . '/' . $plugin_slug;
		$plugin_data = get_plugin_data( WVTG_DIR . '/' . WVTG_SLUG . '.php' );
		$current_version = $plugin_data['Version'];
		include_once( 'class-wvtg-update.php');
		new WVTG_Update( $current_version, $remote_path, $plugin_path );
	}
}

return new WVTG_Admin();