<?php
/**
 * Plugin Name: Wolf Twitter
 * Plugin URI: http://wolfthemes.com/plugin/wolf-twitter/
 * Description: A shortcode and a widget to display your twitter feed anywhere.
 * Version: 3.0.2
 * Author: WolfThemes
 * Author URI: http://wolfthemes.com
 * Requires at least: 3.5
 * Tested up to: 4.6.1
 *
 * Text Domain: wolf-twitter
 * Domain Path: /lang/
 *
 * @package WolfTwitter
 * @category Core
 * @author WolfThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Wolf_Twitter' ) ) :

/**
 * Main Wolf Twitter Class
 *
 * @class Wolf_Page_Builder
 * @version 3.0.2
 */
class Wolf_Twitter {

	/**
	 * @var string
	 */
	public $version = '3.0.2';

	/**
	 * @var Wolf Twitter The single instance of the class
	 */
	protected static $_instance = null;

	/**
	 * @var the URL where to fetch the updated files
	 */
	private $update_url = 'http://plugins.wolfthemes.com/update';

	/**
	 * @var the support forum URL
	 */
	private $support_url = 'http://help.wolfthemes.com/';

	/**
	 * @var string
	 */
	var $cache_duration_hour = 1; // cache duration in hour (can be decimal e.g : 1.5)

	/**
	 * Main Wolf Twitter Instance
	 *
	 * Ensures only one instance of Wolf Twitter is loaded or can be loaded.
	 *
	 * @since 2.0.8
	 * @static
	 * @see WT()
	 * @return Wolf Twitter - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 * @since 2.0.8
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wolf-twitter' ), '3.0.2' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 * @since 2.0.8
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wolf-twitter' ), '3.0.2' );
	}

	/**
	 * Wolf_Twitter Constructor.
	 */
	public function __construct() {

		define( 'WOLF_TWITTER_URL', plugins_url( '/' . basename( dirname( __FILE__ ) ) ) );
		define( 'WOLF_TWITTER_DIR', dirname( __FILE__ ) );

		// Require widget script
		include_once WOLF_TWITTER_DIR . '/wolf-twitter-widget.php';

		// Load plugin text domain
		add_action( 'init', array( $this, 'plugin_textdomain' ) );

		// shortcode
		add_shortcode( 'wolf_tweet', array( $this, 'shortcode') );

		// styles
		add_action( 'wp_enqueue_scripts', array( $this, 'print_styles' ) );

		add_action( 'admin_init', array( $this, 'plugin_update' ) );
	}

	/**
	 * Loads the plugin text domain for translation
	 */
	public function plugin_textdomain() {

		$domain = 'wolf-twitter';
		$locale = apply_filters( 'wolf-twitter', get_locale(), $domain );
		load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Print twitter styles
	 */
	public function print_styles() {
		wp_enqueue_style( 'wolf-twitter', WOLF_TWITTER_URL . '/assets/css/twitter.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Display an error
	 *
	 * @param string $username
	 * @param bool $list
	 * @return string $output
	 */
	public function twitter_error( $username, $list = false ) {

		$error_message = sprintf(
				wp_kses(
					__( 'Our Twitter feed is currently unavailable but you can visit our official twitter page  <a href="%1s" target="_blank">%2s</a>.', 'wolf-twitter' ),
					array(
						'a' => array(
							'href' => array(),
							'target' => array(),
						)
					)
				),
				"http://twitter.com/$username", "@$username"
			);

		if ( $list ) {
			$output = "<ul class=\"wolf-tweet-list\"><li>$error_message</li></ul>";

		} else {

			$output = "<div class=\"wolf-bigtweet-content\"><span class=\"wolf-tweet-text\" style=\"font-size:14px\">$error_message</span></div>";

		}

		return $output;
	}

	/**
	 * Get the Twitter feed
	 *
	 * @param string $username
	 * @return string $data
	 */
	public function get_twitter_feed( $username ) {

		$data = null;
		$trans_key = 'wolf_twitter_'.$username;
		$url = "http://twitter.wolfthemes.com/username/$username";
		
		// delete_transient( $trans_key );

		$cache_duration = ceil( $this->cache_duration_hour * 3600 );

		if ( $cache_duration < 3600 ) {
			$cache_duration = 3600;
		}

		if ( false === ( $cached_data = get_transient( $trans_key ) ) ) {

			$response = wp_remote_get( $url , array( 'timeout' => 10 ) );

			if ( is_array( $response ) ) {
				$data = $response['body']; // use the content
				// var_dump( 'not cached' );
				set_transient( $trans_key, $data, $cache_duration );
			}
		} else {
			// var_dump( 'cached' );
			$data = $cached_data;
		}

		if ( $data ) {
			$data = json_decode( $data );
			return $data;
		}
	}

	/**
	 * Display tweets as list or single tweet
	 *
	 * @param string $username
	 * @param int $count
	 * @param bool $list
	 * @return string $tweet
	 */
	public function twitter( $username, $count = 3, $list = true ) {

		$tweet ='';
		$data = $this->get_twitter_feed( $username );

		$count = absint( $count );

		if ( $data && is_array( $data ) ) {
			/* Display as list */
			if ( $list) {
				if ( isset( $data[0] ) ) {
					$tweet .= "<ul class=\"wolf-tweet-list\">";
					for ( $i=0; $i < $count; $i++ ) {
						if ( isset( $data[ $i ] ) ) {
							$content = $data[ $i ]->text;
							$created = $data[ $i ]->created_at;
							$id = $data[ $i ]->id_str;
							$tweet_link = "https://twitter.com/$username/statuses/$id";

							$tweet .= "<li>";
							$tweet .= "<span class=\"wolf-tweet-time\"><a href=\"$tweet_link\" target=\"_blank\">".__( 'about', 'wolf-twitter' )." ". $this->twitter_time_ago( $created )."</a></span>";
							$tweet .= "<span class=\"wolf-tweet-text\">".$this->twitter_to_link( $content )."</span>";
							$tweet .= "</li>";
						}
					}
					$tweet .= "</ul>";
				} else {
					$tweet = $this->twitter_error( $username, $list );
				}

			/* Display as single tweet */
			} else {
				if ( isset( $data[0] ) ) {
					$content = $data[0]->text;
					$created = $data[0]->created_at;
					$id = $data[0]->id_str;
					$tweet_link = "https://twitter.com/$username/statuses/$id";

					$tweet .= "<div class=\"wolf-bigtweet-content\"><span class=\"wolf-tweet-text\">". $this->twitter_to_link( $content )."</span>";
					$tweet .= "<br><span class=\"wolf-tweet-time_big\"><a href=\"$tweet_link\" target=\"_blank\">".__( 'about', 'wolf-twitter' )." ". $this->twitter_time_ago( $created )."</a>
					<span class=\"wolf-tweet-separator\">|</span> <a href=\"http://twitter.com/$username/\" target=\"_blank\">@$username</a></span></div>";
				} else {
					$tweet = $this->twitter_error( $username, $list );
				}
			}

		} else {
			$tweet = $this->twitter_error( $username, $list );
		}

		return $tweet;
	}

	/**
	 * Find url strings, tags and username strings and make them as link
	 *
	 * @param string $text
	 * @return string $text
	 */
	public function  twitter_to_link( $text ) {

		// Match URLs
		$text = preg_replace( '/(^|[^=\"\/])\b((?:\w+:\/\/|www\.)[^\s<]+)((?:\W+|\b)(?:[\s<]|$))/m', '<a href="$0" target="_blank">$0</a>', $text);

		// Match @name
		$text = preg_replace( '/(@)([a-zA-ZÀ-ú0-9\_]+)/', '<a href="https://twitter.com/$2" target="_blank">@$2</a>', $text);

		// Match #hashtag
		$text = preg_replace( '/(#)([a-zA-ZÀ-ú0-9\_]+)/', '<a href="https://twitter.com/search/?q=$2" target="_blank">#$2</a>', $text);

		return $text;
	}

	/**
	 * Convert the twitter date to "X ago" type
	 *
	 * @param string $date
	 * @return string $date
	 */
	public function twitter_time_ago( $date ) {
		$date = esc_html(
			sprintf(
				__( '%s ago', 'wolf-twitter' ), human_time_diff( strtotime( $date ), current_time( 'timestamp' ) )
			)
		);

		return $date;
	}

	/**
	 * Shortcode
	 *
	 * @param array $atts
	 */
	public function shortcode( $atts ) {

		extract( shortcode_atts( array(
			'username' => '',
			'type' => 'single',
			'count' => 1,
			'animation' => '', // for WPB
			'animation_delay' => '', // for WPB
		), $atts ) );

		$list = ( 'list' == $type ) ? true : false;

		$class = 'wolf-twitter-container';
		$style = '';
		$output = '';

		if ( $animation ) {
			$class .= " wow $animation";
		}

		if ( $animation_delay && $animation ) {
			$style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}
		
		$output .= '<div class="' . $class . '" style="' . $style . '">';
		$output .= $this->twitter( $username, $count, $list, $animation, $animation );
		$output .= '</div>';

		return $output;
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

		if ( ! class_exists( 'Wolf_WP_Update' ) ) {
			include_once( 'class/class-wp-update.php');
		}

		new Wolf_WP_Update( $current_version, $remote_path, $plugin_path );
	}

} // end class

endif;

/**
 * Returns the main instance of WT to prevent the need to use globals.
 *
 * @since  2.0.9
 * @return Wolf_Twitter
 */
function WT() {
	return Wolf_Twitter::instance();
}

WT();

// Widget function
function wolf_twitter_widget( $username, $count ) {
	echo WT()->twitter( $username, $count , true );
}