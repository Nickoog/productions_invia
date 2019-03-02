<?php
/**
 * Plugin Name: Wolf Facebook Page Box
 * Plugin URI: http://wolfthemes.com/plugin/wolf-facebook-page-box
 * Description: A Facebook page box widget and shortcode for WordPress.
 * Version: 1.0.7
 * Author: WolfThemes
 * Author URI: http://wolfthemes.com
 * Requires at least: 4.4.1
 * Tested up to: 4.7.2
 *
 * Text Domain: wolf-facebook-page-box
 * Domain Path: /languages/
 *
 * @package WolfFacebookPageBox
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

if ( ! class_exists( 'Wolf_Facebook_Page_Box' ) ) {
	/**
	 * Main Wolf_Facebook_Page_Box Class
	 *
	 * Contains the main functions for Wolf_Facebook_Page_Box
	 *
	 * @class Wolf_Facebook_Page_Box
	 * @version 1.0.7
	 * @since 1.0.0
	 * @package WolfVideos
	 * @author WolfThemes
	 */
	class Wolf_Facebook_Page_Box {

		/**
		 * @var string
		 */
		public $version = '1.0.7';

		/**
		 * @var Wolf Facebook Page Box The single instance of the class
		 */
		protected static $_instance = null;

		/**
		 * @var string
		 */
		private $update_url = 'http://plugins.wolfthemes.com/update';

		/**
		 * @var the support forum URL
		 */
		private $support_url = 'http://help.wolfthemes.com/';

		/**
		 * @var string
		 */
		public $plugin_url;

		/**
		 * @var string
		 */
		public $plugin_path;

		/**
		 * Main Wolf Facebook Page Box Instance
		 *
		 * Ensures only one instance of Wolf Facebook Page Box is loaded or can be loaded.
		 *
		 * @static
		 * @see WPM()
		 * @return Wolf Facebook Page Box - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'wolf-facebook-page-box' ), '1.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'wolf-facebook-page-box' ), '1.0' );
		}

		/**
		 * Wolf_Facebook_Page_box Constructor.
		 */
		public function __construct() {

			// plugin update notification
			add_action( 'admin_init', array( $this, 'update' ), 5 );

			// init
			add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

			// register shortcode
			add_shortcode( 'wolf_facebook_page_box', array( $this, 'shortcode' ) );

			// output script
			add_action( 'wp_head', array( $this, 'output_script' ) );

			// Widget
			add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		}


		/**
		 * plugin update notification.
		 */
		public function update() {

			$plugin_data     = get_plugin_data( __FILE__ );
			$current_version = $plugin_data['Version'];
			$plugin_slug     = plugin_basename( dirname( __FILE__ ) );
			$plugin_path     = plugin_basename( __FILE__ );
			$remote_path     = $this->update_url . '/' . $plugin_slug;
			include_once( 'classes/class-wfpb-update.php' );
			$wolf_plugin_update = new WFPB_Update( $current_version, $remote_path, $plugin_path );
		}

		/**
		 * Load Localisation files.
		 */
		public function load_plugin_textdomain() {

			$domain = 'wolf-facebook-page-box';
			$locale = apply_filters( 'wolf-facebook-page-box', get_locale(), $domain );
			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * register_widgets function.
		 */
		public function register_widgets() {

			// Include
			include_once( 'classes/class-wfpb-widget.php' );

			// Register widgets
			register_widget( 'WFPB_Widget' );
		}

		/**
		 * Shortcode
		 *
		 * @access public
		 * @param array $atts
		 * @return string
		 */
		public function shortcode( $atts ) {

			extract(
				shortcode_atts(
					array(
						'page_url' => 'https://www.facebook.com/wolfthemes',
						'height' => 400,
						'hide_cover' => 'false',
						'show_posts' => 'true',
						'show_faces' => 'true',
						'small_header' => 'false',
					), $atts
				)
			);

			$hide_cover = ( 'false' == $hide_cover || '0' == $hide_cover || '' == $hide_cover ) ? false : true;
			$show_posts = ( 'false' == $show_posts || '0' == $show_posts || '' == $show_posts ) ? false : true;
			$show_faces = ( 'false' == $show_faces || '0' == $show_faces || '' == $show_faces ) ? false : true;
			$small_header = ( 'false' == $small_header || '0' == $small_header || '' == $small_header ) ? false : true;

			return $this->facebook_box( $page_url, $height, $hide_cover, $show_posts, $show_faces, $small_header );
		}

		/**
		 * Output script in head tag
		 *
		 * @access public
		 * @param array $atts
		 * @return string
		 */
		public function output_script() {

			$lang = apply_filters( 'wfpb_lang_code', esc_html__( 'en_US', 'wolf-facebook-page-box' ) );

			echo '<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/' . esc_js( $lang ) . '/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
		}

		/**
		 * Output Facebook Page Box
		 *
		 * @access public
		 * @param array $atts
		 * @return string
		 */
		public function facebook_box(
			$page_url = 'https://www.facebook.com/facebook',
			$height = 400,
			$hide_cover = false,
			$show_posts = true,
			$show_faces = true,
			$small_header = false
			) {

			$page_url = esc_url( $page_url  );
			$height = absint( $height );

			$hide_cover = ( $hide_cover ) ? 'true' : 'false';
			$small_header = ( $small_header ) ? 'true' : 'false';
			$show_posts = ( $show_posts ) ? 'timeline' : 'false';
			$show_faces = ( $show_faces ) ? 'true' : 'false';

			$output = '<style>
.fb_iframe_widget > span,
.fb_iframe_widget > div,
.fb_iframe_widget iframe{
	max-width:500px;
  	width:100%!important;
}</style>';

			$output = "<div class='fb-page'
				data-adapt-container-width='true'
				data-small-header='$small_header'
				data-href='$page_url'
				data-width='500'
				data-height='$height'
				data-hide-cover='$hide_cover'
				data-show-facepile='$show_faces'
				data-tabs='$show_posts'>
				<div class='fb-xfbml-parse-ignore'><blockquote cite='$page_url'><a href='$page_url'>Facebook</a></blockquote></div></div>";

			return $output;
		}

		/**
		 * Get the plugin url.
		 *
		 * @return string
		 */
		public function plugin_url() {
			if ( $this->plugin_url ) return $this->plugin_url;
			return $this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {
			if ( $this->plugin_path ) return $this->plugin_path;
			return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

	} // end class

} // end class exists check

/**
 * Returns the main instance of WFPB to prevent the need to use globals.
 *
 * @return Wolf_Facebook_Page_Box
 */
function WFPB() {
	return Wolf_Facebook_Page_Box::instance();
}
WFPB(); // Go