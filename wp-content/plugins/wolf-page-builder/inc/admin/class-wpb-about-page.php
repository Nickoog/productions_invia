<?php
/**
 * Wolf Page Builder About Page.
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WPB_Welcome_Page' ) ) {
	/**
	 * Welcome Page Class
	 *
	 * Shows a feature overview for the new version (major ones).
	 *
	 *
	 * @author WolfThemes
	 * @category 	Admin
	 * @package 	wolf/Admin
	 * @version 1.0.0
	*/
	class WPB_Welcome_Page {

		/**
		 * __construct function.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {

			add_action( 'admin_menu', array( $this, 'admin_menu') );
			add_action( 'admin_head', array( $this, 'admin_head' ) );
			add_action( 'admin_init', array( $this, 'welcome' ) );
		}

		/**
		 * Add admin menus/screens
		 *
		 * @access public
		 * @return void
		 */
		public function admin_menu() {

			add_submenu_page( 'wpb-settings', esc_html__( 'About', 'wolf-page-builder' ), esc_html__( 'About', 'wolf-page-builder' ), 'edit_plugins', 'wpb-about', array( $this, 'about_screen' ) );
		}

		/**
		 * Add styles just for this page, and remove dashboard page links.
		 *
		 * @access public
		 * @return void
		 */
		public function admin_head() {
			//remove_submenu_page( 'index.php', 'wolf-about' );
			if ( isset( $_GET['page'] ) && 'wpb-about' == $_GET['page'] ) {
			?>
			<style type="text/css">
				/*<![CDATA[*/
				.wolf-admin-notice{
					display:none;
				}
				/*]]>*/
			</style>
			<?php
			}
		}

		/**
		 * Into text/links shown on all about pages.
		 *
		 * @access private
		 * @return void
		 */
		private function intro() {

			// force Welcome admin panel to show
			if ( isset( $_GET['wolf-theme-activated'] ) ) {
				update_user_meta( get_current_user_id(), 'show_welcome_panel', true );
			}

			$plugin_name = 'Wolf Page Builder';
			$plugin_version = WPB_VERSION;
			?>
			<h1><?php printf( esc_html__( 'Welcome to %s %s', 'wolf-page-builder' ), $plugin_name, $plugin_version ); ?></h1>

			<div class="about-text wpb-about-text">
				<?php
					if ( isset( $_GET['wolf-theme-updated'] ) )
						$message = esc_html__( 'Thank you for updating to the latest version!', 'wolf-page-builder' );
					else
						$message = sprintf( esc_html__( 'Thanks for installing %s!', 'wolf-page-builder' ), $plugin_name );

					if ( isset( $_GET['wolf-theme-activated'] ) ) {
						printf( esc_html__( '%s We hope you will enjoy using it.', 'wolf-page-builder' ), $message );
					} elseif ( isset( $_GET['wolf-theme-updated'] ) ) {
						printf( esc_html__( '%s <br> %s is now more stable and secure than ever.<br>We hope you enjoy using it.', 'wolf-page-builder' ), $message, $plugin_name );
					} else {
						printf( esc_html__( '%s We hope you enjoy using it.', 'wolf-page-builder' ), $message );
					}
				?>
			</div>
			<div class="wp-badge wpb-about-page-logo">
			Version <?php echo sanitize_text_field( $plugin_version ); ?></div>
			<?php
		}

		/**
		 * Output the about screen.
		 *
		 * @access public
		 * @return void
		 */
		public function about_screen() {
			?>
			<div class="wrap about-wrap">
				<?php $this->intro(); ?>
				<?php $this->features(); ?>
				<?php $this->changelog(); ?>
			</div>
			<?php
		}

		/**
		 * Output the last new feature if set in the changelog XML
		 *
		 * @access public
		 * @return void
		 */
		public function features() {
			$plugin_name = 'WPB';
			$twitter_url = 'http://' . WPB_WOLF_DOMAIN . '/wolf-page-builder';
			$twitter_text = sprintf( esc_html__( 'Build your website easily with %s', 'wolf-page-builder' ), 'Wolf Page Builder #wordpress #plugin by @wolf_themes' );
			?>
			<p class="wpb-about-actions">
<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=page' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Start now', 'wolf-page-builder' ); ?></a>
<a href="<?php echo esc_url( admin_url( 'admin.php?page=wpb-settings' ) ); ?>" class="button"><?php esc_html_e( 'Settings', 'wolf-page-builder' ); ?></a>
<a
					style="margin-right:3px;margin-top:3px;vertical-align:middle"
					href="https://twitter.com/share"
					data-text="<?php echo sanitize_text_field( $twitter_text ); ?>"
					data-url="<?php echo esc_url( $twitter_url ); ?>"
					class="twitter-share-button"
					data-count="none"
					data-size="large">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</p>
			<?php
		}

		/**
		 * Output the last new feature if set in the changelog XML
		 *
		 * @access public
		 * @return void
		 */
		public function changelog() {

			if ( $xml = wpb_get_changelog() ) {
				?>
				<div id="wpb-notifications">
					<?php if ( '' !== ( string )$xml->warning ) {
						$warning = ( string )$xml->warning;
					?>
						<div class="wpb-changelog-notification" id="wpb-changelog-warning"><?php echo $warning; ?></div>
					<?php } ?>
					<?php if ( '' !== ( string )$xml->info ) {
						$info = ( string )$xml->info;
					?>
						<div class="wpb-changelog-notification" id="wpb-changelog-info"><?php echo $info; ?></div>
					<?php } ?>
					<?php if ( '' !== ( string )$xml->new ) {
						$new = ( string )$xml->new;
					?>
						<div class="wpb-changelog-notification" id="wpb-changelog-news"><?php echo $new; ?></div>
					<?php } ?>
				</div><!-- #wpb-notifications -->
				
				<div id="wpb-changelog">
					<h3><?php _e( 'Changelog', 'wolf-page-builder' ); ?></h3>
					<?php echo wp_kses( $xml->changelog, array(
						'h4' => array(),
						'ul' => array(),
						'ol' => array(),
						'li' => array(),
						'strong' => array(),
					) ); ?>
				</div><!-- #wpb-changelog -->
				<hr>
				
				<div id="wpb-theme-details">
					<h3><?php esc_html_e( 'Details', 'wolf-page-builder' ); ?></h3>
					<p><?php esc_html_e( 'Requires', 'wolf-page-builder' ); ?> : Wordpress <?php echo sanitize_text_field( $xml->requires ); ?></p>
					<p><?php esc_html_e( 'Tested', 'wolf-page-builder' ); ?> : Wordpress <?php echo sanitize_text_field( $xml->tested ); ?></p>
					<p><?php esc_html_e( 'Last update', 'wolf-page-builder' ); ?> : <?php echo sanitize_text_field( mysql2date( get_option( 'date_format' ), $xml->date .' 00:00:00' ) ); ?></p>
				</div>
				<?php
			}
		}

		/**
		 * Sends user to the welcome page on first activation
		 *
		 * @access public
		 * @return void
		 */
		public function welcome() {

			// Bail if no activation redirect transient is set
			if ( ! get_transient( '_wpb_activation_redirect' ) ) {
				return;
			}

			// Delete the redirect transient
			delete_transient( '_wpb_activation_redirect' );

			// Bail if activating from network, or bulk, or within an iFrame
			if ( is_network_admin() || isset( $_GET['activate-multi'] ) || defined( 'IFRAME_REQUEST' ) || defined( 'DOING_AJAX' ) ) {
				return;
			}

			if ( ( isset( $_GET['action'] ) && 'upgrade-plugin' == $_GET['action'] ) || ( ! empty( $_GET['page'] ) && $_GET['page'] === 'wpb-about' ) ) {
				return;
			}

			// if admin
			if ( is_admin() ) {
				wp_redirect( admin_url( 'admin.php?page=wpb-about' ) );
			}
		}
	}

	return new WPB_Welcome_Page();
} // end class exists check
