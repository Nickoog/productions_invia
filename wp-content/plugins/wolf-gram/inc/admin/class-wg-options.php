<?php
/**
 * Wolf Gram Options.
 *
 * @class WD_Options
 * @author WolfThemes
 * @category Admin
 * @package WolfGram/Admin
 * @version 1.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WG_Options class.
 */
class WG_Options {
	/**
	 * Constructor
	 */
	public function __construct() {
		// default options
		add_action( 'admin_init', array( $this, 'default_options' ) );

		// register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// add option sub-menu
		add_action( 'admin_menu', array( $this, 'add_settings_menu' ) );
	}

	/**
	 * Add settings menu
	 *
	 */
	public function add_settings_menu() {
		$icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0ZWQgYnkgSWNvTW9vbi5pbyAtLT4KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHdpZHRoPSIyOCIgaGVpZ2h0PSIyOCIgdmlld0JveD0iMCAwIDI4IDI4Ij4KPHBhdGggZmlsbD0iIzQ0NDQ0NCIgZD0iTTIxLjI4MSAyMi4yODF2LTEwLjEyNWgtMi4xMDlxMC4zMTMgMC45ODQgMC4zMTMgMi4wNDcgMCAxLjk2OS0xIDMuNjMzdC0yLjcxOSAyLjYzMy0zLjc1IDAuOTY5cS0zLjA3OCAwLTUuMjY2LTIuMTE3dC0yLjE4OC01LjExN3EwLTEuMDYyIDAuMzEzLTIuMDQ3aC0yLjIwM3YxMC4xMjVxMCAwLjQwNiAwLjI3MyAwLjY4dDAuNjggMC4yNzNoMTYuNzAzcTAuMzkxIDAgMC42NzItMC4yNzN0MC4yODEtMC42OHpNMTYuODQ0IDEzLjk1M3EwLTEuOTM3LTEuNDE0LTMuMzA1dC0zLjQxNC0xLjM2N3EtMS45ODQgMC0zLjM5OCAxLjM2N3QtMS40MTQgMy4zMDUgMS40MTQgMy4zMDUgMy4zOTggMS4zNjdxMiAwIDMuNDE0LTEuMzY3dDEuNDE0LTMuMzA1ek0yMS4yODEgOC4zMjh2LTIuNTc4cTAtMC40MzgtMC4zMTMtMC43NTh0LTAuNzY2LTAuMzJoLTIuNzE5cS0wLjQ1MyAwLTAuNzY2IDAuMzJ0LTAuMzEzIDAuNzU4djIuNTc4cTAgMC40NTMgMC4zMTMgMC43NjZ0MC43NjYgMC4zMTNoMi43MTlxMC40NTMgMCAwLjc2Ni0wLjMxM3QwLjMxMy0wLjc2NnpNMjQgNS4wNzh2MTcuODQ0cTAgMS4yNjYtMC45MDYgMi4xNzJ0LTIuMTcyIDAuOTA2aC0xNy44NDRxLTEuMjY2IDAtMi4xNzItMC45MDZ0LTAuOTA2LTIuMTcydi0xNy44NDRxMC0xLjI2NiAwLjkwNi0yLjE3MnQyLjE3Mi0wLjkwNmgxNy44NDRxMS4yNjYgMCAyLjE3MiAwLjkwNnQwLjkwNiAyLjE3MnoiPjwvcGF0aD4KPC9zdmc+Cg==';
		add_menu_page( esc_html__( 'Instagram', 'wolf-gram' ), esc_html__( 'Instagram', 'wolf-gram' ), 'activate_plugins', 'wolf-gram-options', array( $this,  'instagram_login_form' ), $icon );
	}

	/**
	 * Set Default Settings
	 */
	public function default_options() {
		global $options;

		if ( false === get_option( 'wolf_instagram_settings' ) ) {

			$default = array(
				'count' => 20,
				'lightbox' => 'swipebox',
				'widget_link' => 'lightbox',
				'gallery_link' => 'external'
			);

			add_option( 'wolf_instagram_settings', $default );
		}
	}

	/**
	 * Settings Init
	 */
	public function register_settings() {
		register_setting( 'wolf-instagram-settings', 'wolf_instagram_settings', array($this, 'settings_validate' ) );
		add_settings_section( 'wolf-instagram-settings', '', array($this, 'section_intro' ), 'wolf-instagram-settings' );
		add_settings_field( 'count', esc_html__( 'Number of photos to display in the Instagram gallery (max 30)', 'wolf-gram' ), array($this, 'setting_count' ), 'wolf-instagram-settings', 'wolf-instagram-settings' );
		add_settings_field( 'lightbox', esc_html__( 'Lightbox (thumbnails widgets)', 'wolf-gram' ) , array($this, 'setting_lightbox' ), 'wolf-instagram-settings', 'wolf-instagram-settings' );
		add_settings_field( 'widget_link', esc_html__( 'Widget Images Link', 'wolf-gram' ) , array($this, 'setting_widget_link' ), 'wolf-instagram-settings', 'wolf-instagram-settings' );
		add_settings_field( 'gallery_link', esc_html__( 'Gallery Images Link', 'wolf-gram' ) , array($this, 'setting_gallery_link' ), 'wolf-instagram-settings', 'wolf-instagram-settings' );
		add_settings_field( 'instructions', esc_html__( 'Instructions' , 'wolf-gram' ), array($this, 'setting_instructions' ), 'wolf-instagram-settings', 'wolf-instagram-settings' );
	}

	/**
	 * Validate data
	 *
	 */
	public function settings_validate( $input) {
		
		$input['count'] = absint( $input['count'] );
		
		if ( $input['count'] > 30 ) {
			$input['count']= 30;
		}

		$input['lightbox'] = esc_attr( $input['lightbox'] );

		return $input;
	}

	/**
	 * Intro section used for debug
	 *
	 */
	public function section_intro() {
		// global $options;
		// $this->debug(get_option( 'wolf_instagram_settings' ) );
	}

	/**
	 * Gallery Count
	 *
	 */
	public function setting_count() {
		echo '<input type="text" name="wolf_instagram_settings[count]" class="regular-text" value="'.wolf_gram_get_option( 'count' ) .'" />';
	}

	/**
	 * Lightbox Option
	 *
	 */
	public function setting_lightbox() {
		?>
		<select name="wolf_instagram_settings[lightbox]">
			<option <?php if (wolf_gram_get_option( 'lightbox' ) == 'swipebox' ) echo 'selected="selected"'; ?>>swipebox</option>
			<option <?php if (wolf_gram_get_option( 'lightbox' ) == 'fancybox' ) echo 'selected="selected"'; ?>>fancybox</option>
			<option <?php if (wolf_gram_get_option( 'lightbox' ) == 'none' ) echo 'selected="selected"'; ?>>none</option>
		</select>
		<?php
	}

	/**
	 * Widget Link
	 *
	 */
	public function setting_widget_link() {
		?>
		<select name="wolf_instagram_settings[widget_link]">
			<option value="lightbox" <?php if (wolf_gram_get_option( 'widget_link' ) == 'lightbox' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open in lightbox', 'wolf-gram' ); ?></option>
			<option value="external" <?php if (wolf_gram_get_option( 'widget_link' ) == 'external' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open Instagram Page', 'wolf-gram' ); ?></option>
		</select>
		<?php
	}

	/**
	 * Gallery Link
	 *
	 */
	public function setting_gallery_link() {
		?>
		<select name="wolf_instagram_settings[gallery_link]">
			<option value="lightbox" <?php if (wolf_gram_get_option( 'gallery_link' ) == 'lightbox' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open in lightbox', 'wolf-gram' ); ?></option>
			<option value="external" <?php if (wolf_gram_get_option( 'gallery_link' ) == 'external' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open Instagram Page', 'wolf-gram' ); ?></option>
		</select>
		<?php
	}

	/**
	 * Instructions
	 *
	 */
	public function setting_instructions() {
		?>
		<p><?php esc_html_e( 'You can display the gallery in your post or page with the following shortcode:', 'wolf-gram' )  ?></p>
		<p><code>[wolf_instagram_gallery count="18" button="true|false" button_text="Follow us"]</code></p>
		<?php
	}

	/**
	 * Admin login form
	 *
	 */
	public function instagram_login_form() {

		if ( isset( $_POST['wolf_instagram_logout'] ) && wp_verify_nonce( $_POST['wolf_instagram_logout_nonce'],'wolf_instagram_logout' ) ) {
			$this->instagram_logout();
		}
		?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			<h2>Instagram</h2>
		<?php if ( ! $this->instagram_login() ): // if not logged ?>
			<p><?php esc_html_e( 'WolfGram is a Wordpress plugin that uses the Instagram API to display your Instgram feed.', 'wolf-gram' ); ?></p>
			<p><?php esc_html_e( 'You need to link the WolfGram app to your Instagram account and get your access key to be able to use the WolfGram features.', 'wolf-gram' ); ?></p>
			<p><?php esc_html_e( 'To do so, simply follow the link below and follow the instructions.', 'wolf-gram' ); ?></p>
			<p><a target="_blank" href="http://wolfgram.wolfthemes.com/"><?php esc_html_e( 'Get your access key', 'wolf-gram' ); ?></a></p>
			<form action="<?php echo esc_url(admin_url( 'admin.php?page=wolf-gram-options' ) ); ?>" method="post">
				<?php wp_nonce_field( 'wolf_instagram_login', 'wolf_instagram_login_nonce' ); ?>
				<p><?php esc_html_e( 'Access Key', 'wolf-gram' ); ?>: <br><input style="width:200px;" type="text" name="wolf_instagram_code"></p>
				<p><input name="wolf_instagram_login" type="submit" class="button-primary" value="<?php esc_html_e( 'Link your Instagram account', 'wolf-gram' ); ?>"></p>
			</form>
		</div><!-- .wrap -->
		<?php
			if ( isset( $_POST['wolf_instagram_login'] )
				&& ! wolf_gram_get_auth()
				&& wp_verify_nonce( $_POST['wolf_instagram_login_nonce'], 'wolf_instagram_login' ) ):

				echo '<strong>';
				esc_html_e( 'Wrong code', 'wolf-gram' );
				echo '</strong>';
			endif;

		else: // if login

		$auth = wolf_gram_get_auth();

		?>
			<p><?php esc_html_e( 'You can now use the WolfGram.', 'wolf-gram' ); ?></p>
			<p><?php esc_html_e( 'You can log out to change your account and get a new code.', 'wolf-gram' ); ?></p>

			<form action="<?php echo admin_url( 'admin.php?page=wolf-gram-options' ); ?>" method="post">
				<?php wp_nonce_field( 'wolf_instagram_logout', 'wolf_instagram_logout_nonce' ); ?>
				<p><input name="wolf_instagram_logout" type="submit" class="button-primary" value="<?php esc_html_e( 'Reset', 'wolf-gram' ); ?>"></p>
			</form>
			<hr>
			<h3><?php esc_html_e( 'Settings', 'wolf-gram' ); ?></h3>
			<form action="options.php" method="post">
				<?php settings_fields( 'wolf-instagram-settings' ); ?>
				<?php do_settings_sections( 'wolf-instagram-settings' ); ?>
				<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'wolf-gram' ); ?>" /></p>
			</form>
		</div><!-- .wrap -->
		<?php endif;
	}

	/**
	 * Login function
	 * @return boolean
	 */
	public function instagram_login( $access_token = null) {

		if ( wolf_gram_get_auth() ) {
			return true;
		}

		if ( isset( $_POST['wolf_instagram_login'] ) && wp_verify_nonce( $_POST['wolf_instagram_login_nonce'],'wolf_instagram_login' ) ) {
			if ( isset( $_POST['wolf_instagram_code'] ) ) {
				$access_token = $_POST['wolf_instagram_code'];
			}
		}

		if ( ! wolf_gram_get_auth() && $access_token ) {
			if ( $this->verify_access_token( $access_token ) ) {
				add_option( 'wolf_instagram_access_token', $access_token  );
				return true;
			} else {
				return false;
			}


		} elseif ( ! wolf_gram_get_auth() && ! $access_token ) {
		 	return false;
		}
	}

	/**
	 * Authentification
	 */
	public function verify_access_token( $access_token) {
		
		$apiurl = "https://api.instagram.com/v1/users/self/media/recent?count=1&access_token=".$access_token;

		$response = wp_remote_get( $apiurl,
			array(
				'sslverify' => apply_filters( 'https_local_ssl_verify', false)
			)
		);

		if ( ! is_wp_error( $response) && $response['response']['code'] < 400 && $response['response']['code'] >= 200) {

			return true;
		}
	}

	/**
	 * Log Out
	 */
	public function instagram_logout() {
		$trans_key = 'wolf_instagram_data';
		delete_transient( $trans_key );
		delete_option( 'wolf_instagram_access_token' );
	}
}

return new WG_Options();