<?php
/**
 * Plugin Name: Wolf Maintenance
 * Plugin URI: http://wolfthemes.com/plugin/wolf-maintenance
 * Description: A plugin to manage your maintenance
 * Version: 1.0.2
 * Author: WolfThemes
 * Author URI: http://wolfthemes.com
 * Requires at least: 4.4.1
 * Tested up to: 4.7.1
 *
 * Text Domain: wolf-maintenance
 * Domain Path: /languages/
 *
 * @package WolfMaintenance
 * @category Core
 * @author WolfThemes
 *
 * Being a free product, this plugin is distributed as-is without official support.
 * Verified customers however, who have purchased a premium theme
 * at http://themeforest.net/user/Wolf-Themes/portfolio?ref=Wolf-Themes
 * will have access to support for this plugin in the forums
 * http://help.wolfthemes.com/
 *
 * Copyright (C) 2013 Constantin Saguin
 * This WordPress Plugin is a free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * It is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * See http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Wolf_Maintenance' ) ) {
	/**
	 * Main Wolf_Maintenance Class
	 *
	 * Contains the main functions for Wolf_Maintenance
	 *
	 * @class Wolf_Maintenance
	 * @version 1.0.2
	 * @since 1.0.0
	 */
	class Wolf_Maintenance {

		var $update_url = 'http://plugins.wolfthemes.com/update';

		/**
		 * Hook into the appropriate actions when the class is constructed.
		 */
		public function __construct() {

			add_action( 'init', array( $this, 'plugin_textdomain' ) );

			add_action( 'template_redirect', array( $this, 'do_redirect' ), 5 );

			add_action( 'admin_menu',  array( $this, 'add_menu' ) );
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_init', array( $this, 'plugin_update' ) );

			// Plugin row meta
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'settings_action_links' ) );
		}

		/**
		 * Redirect the page to the URL set in the post meta
		 */
		public function do_redirect() {
			
			$maintenance_page_id = $this->get_option( 'page_id' );

			if ( ! is_user_logged_in() && $maintenance_page_id && ! is_page( $maintenance_page_id ) ) {
				wp_safe_redirect( get_permalink( $maintenance_page_id ), 302 );
				exit;
			}
		}

		/**
		 * Add Contextual Menu
		 */
		public function add_menu() {

			add_management_page( esc_html__( 'Maintenance', 'wolf-maintenance' ), esc_html__( 'Maintenance', 'wolf-maintenance' ), 'administrator', 'wolf-maintenance', array( $this, 'maintenance_settings' ) );
		}

		/**
		 * Add Settings
		 */
		public function admin_init() {
			register_setting( 'wolf-maintenance', 'wolf_maintenance_settings', array( &$this, 'settings_validate' ) );
			add_settings_section( 'wolf-maintenance', '', array( $this, 'section_intro' ), 'wolf-maintenance' );

			add_settings_field( 'page_id', esc_html__( 'Choose your maintenance page', 'wolf-maintenance' ), array( $this, 'setting_page_id' ), 'wolf-maintenance', 'wolf-maintenance' );
		}

		/**
		 * Intro section used for debug
		 */
		public function section_intro() {
			// echo "<pre>";
			// print_r( get_option( 'wolf_maintenance_settings' ) );
			// echo "</pre>";
		}

		/**
		 * Alignment Setting
		 */
		public function setting_page_id() {
			$page_option = array( '' => esc_html__( '- Disabled -', 'wolf-maintenance' ) );
			$pages = get_pages();

			foreach ( $pages as $page ) {
				$page_option[ absint( $page->ID ) ] = sanitize_text_field( $page->post_title );
			}
			?>
			<select name="wolf_maintenance_settings[page_id]">
				<?php foreach ( $page_option as $k => $v ) : ?>
					<option <?php selected( $this->get_option( 'page_id' ), absint( $k ) ); ?> value="<?php echo absint( $k ); ?>"><?php echo sanitize_text_field( $v ); ?></option>
				<?php endforeach; ?>
			</select>
			<?php
		}

		/**
		 * Validate data
		 */
		public function settings_validate( $input ) {
			$input['page_id'] = absint( $input['page_id'] );
			return $input;
		}

		/**
		 * Get maintenance Option
		 *
		 * @param string $value
		 * @return string|null
		 */
		public function get_option( $value = null ) {

			global $options;

			$wolf_maintenance_settings = get_option( 'wolf_maintenance_settings' );
			
			if ( isset( $wolf_maintenance_settings[ $value ]) ) {
				return $wolf_maintenance_settings[ $value ];
			}
		}

		/**
		 * Settings Form
		 */
		public function maintenance_settings() {
			?>
			<div class="wrap">
				<div id="icon-options-general" class="icon32"></div>
				<h2><?php esc_html_e( 'Maintenance settings', 'wolf-maintenance' ); ?></h2>
				<?php if ( isset( $_GET['settings-updated']) && $_GET['settings-updated'] ) { ?>
				<div id="setting-error-settings_updated" class="updated settings-error">
					<p><strong><?php esc_html_e( 'Settings saved.', 'wolf-maintenance' ); ?></strong></p>
				</div>
				<?php } ?>
				<form action="options.php" method="post">
					<?php settings_fields( 'wolf-maintenance' ); ?>
					<?php do_settings_sections( 'wolf-maintenance' ); ?>
					<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'wolf-maintenance' ); ?>" /></p>
				</form>
			</div>
			<?php
		}

		/**
		 * Loads the plugin text domain for translation
		 */
		public function plugin_textdomain() {

			$domain = 'wolf-maintenance';
			$locale = apply_filters( 'wolf-maintenance', get_locale(), $domain );
			load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
			load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Add settings link in plugin page
		 */
		public function settings_action_links( $links ) {
			$setting_link = array(
				'<a href="' . admin_url( 'tools.php?page=wolf-maintenance' ) . '">' . esc_html__( 'Settings', 'wolf-maintenance' ) . '</a>',
			);
			return array_merge( $links, $setting_link );
		}

		/**
		 * Plugin update
		 */
		public function plugin_update() {

			$plugin_data = get_plugin_data( __FILE__ );

			$current_version = $plugin_data['Version'];
			$plugin_slug = plugin_basename( dirname( __FILE__ ) );
			$plugin_path = plugin_basename( __FILE__ );
			$remote_path = $this->update_url . '/' . $plugin_slug;

			if ( ! class_exists( 'Wolf_WP_Update' ) )
				include_once( 'class-wp-update.php');

			new Wolf_WP_Update( $current_version, $remote_path, $plugin_path );
		}

	} // end class

	$wolf_maintenance = new Wolf_Maintenance();

} // class_exists check