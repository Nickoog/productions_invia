<?php
/**
 * Plugin Name: Wolf Music Network
 * Plugin URI: http://wolfthemes.com/plugin/wolf-music-network
 * Description: A plugin to display your music social profiles
 * Version: 1.1.5
 * Author: WolfThemes
 * Author URI: http://wolfthemes.com
 * Requires at least: 3.5
 * Tested up to: 4.2.2
 *
 * Text Domain: wolf
 * Domain Path: /lang/
 *
 * @package Wolf_Music_Network
 * @author WolfThemes
 *
 * Being a free product, this plugin is distributed as-is without official support.
 * Verified customers however, who have purchased a premium theme
 * at http://themeforest.net/user/BrutalDesign/portfolio?ref=BrutalDesign
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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Wolf_Music_Network' ) ) {
	/**
	 * Main Wolf_Music_Network Class
	 *
	 * Contains the main functions for Wolf_Music_Network
	 *
	 * @version 1.1.5
	 * @since 1.0.0
	 * @package WolfMusicNetwork
	 * @author WolfThemes
	 */
	class Wolf_Music_Network {

		/**
		 * @var string
		 */
		public $version = '1.1.5';

		/**
		 * @var string
		 */
		private $update_url = 'http://plugins.wolfthemes.com/update';

		/**
		 * Wolf_Music_Network Constructor.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {

			define( 'WOLF_MUSIC_NETWORK_URL', plugins_url( '/' . basename( dirname( __FILE__ ) ) ) );
			define( 'WOLF_MUSIC_NETWORK_DIR', dirname( __FILE__ ) );

			add_action( 'init', array( $this, 'plugin_textdomain' ) );
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu',  array( $this, 'add_menu' ) );
			add_action( 'admin_init', array( $this, 'plugin_update' ) );
			add_action( 'after_setup_theme', array( $this, 'options_init' ) );
			add_action( 'wp_head', array( $this, 'add_style' ) );
			add_shortcode( 'wolf_music_network', array( $this, 'shortcode' ) );
		}

		/**
		 * Loads the plugin text domain for translation
		 */
		public function plugin_textdomain() {

			$domain = 'wolf';
			$locale = apply_filters( 'wolf', get_locale(), $domain );
			load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
			load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

		}

		/**
		 * Add inline CSS
		 */
		public function add_style() {
			?><style type="text/css">.wolf-music-logo-link{ border:none!important; } .wolf-music-logo { border:none!important; box-shadow:none!important; -moz-box-shadow:none!important; -webkit-box-shadow:none!important; -o-box-shadow:none!important; }</style><?php
		}

		/**
		 * Returns images URL for Directory
		 */
		public function get_dir( $url = false ) {

			$dir_name = 'music-network-images';

			$img_dir = $url ? WOLF_MUSIC_NETWORK_URL . '/' . $dir_name : WOLF_MUSIC_NETWORK_DIR . '/' . $dir_name;

			if ( is_dir( get_stylesheet_directory() . '/' . $dir_name ) ) {

				$img_dir = $url ? get_stylesheet_directory_uri() . '/' . $dir_name : get_stylesheet_directory() . '/' . $dir_name;

			} elseif ( is_dir( get_template_directory() . '/' . $dir_name ) ) {

				$img_dir = $url ? get_template_directory_uri() . '/' . $dir_name : get_template_directory() . '/' . $dir_name;

			}

			return $img_dir;
		}

		/**
		 * Scan image files dir
		 */
		public function networks() {

			$img_dir = $this->get_dir();

			$services = array();
			$results  = scandir( $img_dir );
			foreach ( $results as $result ) {

				if ( $result === '.' || $result === '..' ) continue;

				if ( is_file( $img_dir . '/' . $result ) ) {
					$services[] = str_replace( '.png', '',  $result );
				}
			}
			//debug( $services);
			return $services;
		}

		/**
		 * Add Contextual Menu
		 */
		public function add_menu() {

			add_menu_page( __( 'Music Network', 'wolf' ), __( 'Music Network', 'wolf' ), 'administrator', basename( __FILE__ ), array( &$this, 'music_network_settings' ), 'dashicons-networking' );

		}

		/**
		 * Add Settings
		 */
		public function admin_init() {
			register_setting( 'wolf-music-network', 'wolf_music_network_settings', array( &$this, 'settings_validate' ) );
			add_settings_section( 'wolf-music-network', '', array( &$this, 'section_intro' ), 'wolf-music-network' );

			foreach ( $this->networks() as $s ) {
				add_settings_field( $s, ucfirst( $s ) . ' URL' , array( &$this, 'setting_profile' ), 'wolf-music-network', 'wolf-music-network', array(  'id' => $s ) );
			}

			add_settings_field( 'height', __( 'Height', 'wolf' ), array( &$this, 'setting_height' ), 'wolf-music-network', 'wolf-music-network' );
			add_settings_field( 'align', __( 'Align', 'wolf' ), array( &$this, 'setting_align' ), 'wolf-music-network', 'wolf-music-network' );
			add_settings_field( 'target', __( 'Open link in a new tab', 'wolf' ), array( &$this, 'setting_target' ), 'wolf-music-network', 'wolf-music-network' );
			add_settings_field( 'instructions', __( 'Shortcode and Template Tag', 'wolf' ), array( &$this, 'setting_instructions' ), 'wolf-music-network', 'wolf-music-network' );
		}

		/**
		 * Intro section used for debug
		 */
		public function section_intro() {
			// echo "<pre>";
			// print_r(get_option( 'wolf_music_network_settings' ) );
			// echo "</pre>";
		}

		/**
		 * Validate data
		 */
		public function settings_validate( $input ) {
			foreach ( $this->networks() as $s ) {
				$input[$s] = esc_url( $input[$s] );
			}
			$input['height'] = absint( $input['height'] );
			$input['align']  = esc_attr( $input['align'] );
			return $input;
		}

		/**
		 * Set default settings
		 */
		public function options_init() {
			global $options;

			if ( false === get_option( 'wolf_music_network_settings' ) ) {

				$default = array(
					'align' => 'center',
					'target' => '1',
					'twitter' => '#',
					'height' => 32,
				);

				add_option( 'wolf_music_network_settings', $default );
			}
		}

		/**
		 * Profile URL fields
		 *
		 * @param array $args
		 * @return string
		 */
		public function setting_profile( $args ) {
			if ( ! isset( $this->settings[ $args['id'] ] ) ) $this->settings[ $args['id'] ] = '';

			echo '<input type="text" name="wolf_music_network_settings['. $args['id'] .']" class="regular-text" value="'. $this->get_music_network_option( $args['id'] ) .'" /> ';

		}

		/**
		 * Alignment Setting
		 */
		public function setting_align() {
			echo '<select name="wolf_music_network_settings[align]">
			<option value="left"'. ( ( $this->get_music_network_option( 'align' ) == 'left' ) ? ' selected="selected"' : '' ) .'>left</option>
			<option value="center"'. ( ( $this->get_music_network_option( 'align' ) == 'center' ) ? ' selected="selected"' : '' ) .'>center</option>
			<option value="right"'. ( ( $this->get_music_network_option( 'align' ) == 'right' ) ? ' selected="selected"' : '' ) .'>right</option>
			</select>';
		}

		/**
		 * Height Setting
		 */
		public function setting_height() {
			echo '<input type="text" name="wolf_music_network_settings[height]" class="regular-text" value="'. absint( $this->get_music_network_option( 'height' ) ) .'">';
		}

		/**
		 * Target Setting
		 */
		public function setting_target() {
			echo '<input type="hidden" name="wolf_music_network_settings[target]" value="0" />
			<label><input type="checkbox" name="wolf_music_network_settings[target]" value="1"'. ( ( $this->get_music_network_option( 'target' ) ) ? ' checked="checked"' : '' ) .' /></label><br />';
		}

		/**
		 * Instructions
		 */
		public function setting_instructions() {
			?>
			<p><?php _e( 'To use Wolf_Music_Network in your posts and pages you can use the shortcode:', 'wolf' ); ?></p>
			<p><code>[wolf_music_network]</code></p>
			<p><?php _e( 'To use Wolf Music Network manually in your theme template use the following PHP code:', 'wolf' ); ?></p>
			<p><code>&lt;?php if ( function_exists( 'wolf_music_network' ) ) wolf_music_network(); ?&gt;</code></p>
			<p><?php _e( 'You can optionally pass in a "height",  "align" and "services" parameters to both of the above to override the default values eg:', 'wolf' ); ?></p>
			<p><code>[wolf_music_network height="32" align="center" services="twitter,facebook,soundcloud"]</code></p>
			<p><code>&lt;?php if ( function_exists( 'wolf_music_network' ) ) wolf_music_network( '32', 'center',  array( 'twitter','facebook','souncloud' ) ); ?&gt;</code></p>
			<h3><?php _e( 'Want to add your own music profile ? Simply upload your png image in the <code>music-network-images</code> folder of the plugin (e.g : mynetwork.png)', 'wolf' ); ?></h3>
			<p><?php _e( 'Additionally, you can copy and paste the <code>music-network-images</code> folder in your theme or child theme folder. The plugin will automatically use the content of this folder instead.', 'wolf' ); ?></p>
			<?php
		}

		/**
		 * Settings Form
		 */
		public function music_network_settings() {
			?>
			<div class="wrap">
				<div id="icon-options-general" class="icon32"></div>
				<h2><?php _e( 'Social Music Settings', 'wolf' ); ?></h2>
				<?php if ( isset( $_GET['settings-updated']) && $_GET['settings-updated'] ) { ?>
				<div id="setting-error-settings_updated" class="updated settings-error">
					<p><strong><?php _e( 'Settings saved.', 'wolf' ); ?></strong></p>
				</div>
				<?php } ?>
				<form action="options.php" method="post">
					<?php settings_fields( 'wolf-music-network' ); ?>
					<?php do_settings_sections( 'wolf-music-network' ); ?>
					<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'wolf' ); ?>" /></p>
				</form>
			</div>
			<?php
		}

		/**
		 * Get music-network Option
		 *
		 * @param string $value
		 * @return string|null
		 */
		public function get_music_network_option( $value = null ) {

			global $options;

			$wolf_music_network_settings = get_option( 'wolf_music_network_settings' );
			if ( isset( $wolf_music_network_settings[$value]) )
				return $wolf_music_network_settings[$value];
			else
				return null;
		}

		/**
		 * Display logos
		 *
		 * @param int $height
		 * @param string $align
		 * @param string $networks
		 * @return string $output
		 */
		public function show( $height, $align, $networks ) {

			$target = '_self';
			if ( $this->get_music_network_option( 'target' ) )
				$target = '_blank';

			if ( $height == null)
				$height = $this->get_music_network_option( 'height' );

			if ( $align == null)
				$align = $this->get_music_network_option( 'align' );

			$output = '<div class="wolf-music-social-icons" style="text-align:' . $align . '">';

			if ( $networks == array() ) {

				foreach ( $this->networks() as $s ) {

					if ( $this->get_music_network_option( $s ) ) {

						$title_attr = ucfirst( str_replace( array( '-', '_' ), ' ', $s ) );
						$output    .= '<a class="wolf-music-logo-link" title="' . esc_attr( $title_attr ) . '" target="' . $target . '" style="display:inline-block;" href="'. esc_url( $this->get_music_network_option( $s ) ) .'"><img class="wolf-music-logo" style="height:'. absint( $height ) .'px" height="' . absint( $height ) . '" src="' . esc_url( $this->get_dir( true ) . '/' . $s .'.png' ) .'" alt="' . esc_attr( $s ) .'"></a>';

					}
				}
			} else {

				foreach ( $networks as $s ) {

					if ( $this->get_music_network_option( $s ) ) {

						$title_attr = ucfirst( str_replace( array( '-', '_' ), ' ', $s ) );
						$output    .= '<a class="wolf-music-logo-link" title="' . esc_attr( $title_attr ) . '" target="' . $target . '" style="display:inline-block;" href="'. esc_url( $this->get_music_network_option( $s ) ) .'"><img class="wolf-music-logo" style="height:'. absint( $height ) .'px" height="' . absint( $height ) . '" src="' . esc_url( $this->get_dir( true ) . '/' . $s .'.png' ) .'" alt="' . esc_attr( $s ) .'"></a>';

					}
				}
			}

			$output .= '</div>';

			return $output;
		}

		/**
		 * Shortcode
		 *
		 * @param array $atts
		 */
		public function shortcode( $atts ) {
			extract(
				shortcode_atts(
					array(
						'height' => null,
						'align' => null,
						'services' => '',
					), $atts
				)
			);
			$services_wl = array();
			if ( $services) $services_wl = explode( ',', str_replace( ' ', '', esc_attr( $services ) ) );
			return $this->show( absint( $height ), $align, $services_wl );
		}

		/**
		 * Plugin update
		 */
		public function plugin_update() {

			$plugin_data = get_plugin_data( __FILE__ );

			$current_version = $plugin_data['Version'];
			$plugin_slug     = plugin_basename( dirname( __FILE__ ) );
			$plugin_path     = plugin_basename( __FILE__ );
			$remote_path     = $this->update_url . '/' . $plugin_slug;

			if ( ! class_exists( 'Wolf_WP_Update' ) )
				include_once('classes/class-wp-update.php');

			$wolf_plugin_update = new Wolf_WP_Update( $current_version, $remote_path, $plugin_path );
		}


	} // end class

	/**
	 * Init Wolf_Music_Network class
	 */
	$GLOBALS['wolf_music_network'] = new Wolf_Music_Network;
	require_once( 'includes/functions.php' );
} // end class check