<?php
/**
 * Wolf Playlist frontend functions
 *
 * General functions available on frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPlaylistManager/Frontend
 * @version 1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueue CSS
 *
 * @since Wolf Playlist 1.0
 */
function wpm_enqueue_styles() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '': '.min';
	wp_enqueue_style( 'wp-mediaelement' );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'wpm', WPM_CSS . '/wpm' . $suffix . '.css', array(), WPM_VERSION );
}
add_action( 'wp_enqueue_scripts', 'wpm_enqueue_styles', 1 );

/**
 * Enqueue JS
 *
 * @since Wolf Playlist 1.0
 */
function wpm_enqueue_scripts() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '': '.min';
	wp_enqueue_script( 'wp-mediaelement' );
	wp_enqueue_script( 'jquery-cue', WPM_JS . '/lib/jquery.cue' . $suffix . '.js', array( 'jquery' ), '1.1.9', true );
	wp_enqueue_script( 'wpm-mejs', WPM_JS . '/wpm-mejs' . $suffix . '.js', array( 'jquery' ), WPM_VERSION, true );
	wp_enqueue_script( 'wpm-app', WPM_JS . '/app' . $suffix . '.js', array( 'jquery' ), WPM_VERSION, true );
	wp_localize_script(
			'wpm-app', 'WPMParams', array(
				'cueFeatures' => apply_filters( 'wpm_cue_features', array(
					'cuebackground',
					'cuehistory',
					'cueartwork',
					'cuecurrentdetails',
					'cueprevioustrack',
					'playpause',
					'cuenexttrack',
					'progress',
					'current',
					'duration',
					'cueplaylist',
					'cueplaylisttoggle',
				) ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'wpm_enqueue_scripts' );


/**
 * Get tracklist in array format from post
 *
 * @since Wolf Playlist 1.0
 * @param object $post
 * @return array
 */
function get_wpm_playlist_tracks( $post_id ) {


	$tracks = array();
	$tracklist = get_post_meta( $post_id, '_wpm_tracklist', true );

	if ( is_array( $tracklist ) ) {
		foreach ( $tracklist as $attachment_id ) {

			if ( get_post_status( $post_id ) ) {
				$tracks[] = get_wpm_track_data( $attachment_id );
			}
		}
	}

	return apply_filters( 'wpm_playlist_tracks', $tracks, $post_id );
}

/**
 * Retrieve the default theme.
 *
 * Will be use for customizer option
 *
 * @return string
 */
function get_wpm_default_theme() {
	return 'dark';
}

/**
 * Display playlist
 *
 * Template tag to dipsplay the playlist
 *
 * @since Wolf Playlist 1.0
 * @param object $post
 * @return array
 */
function wpm_playlist( $post_id, $args = array() ) {

	$post_id = absint( $post_id );
	
	if ( ! $post_id || 'wpm_playlist' !== get_post_type( $post_id ) ) {
		return;
	}

	$tracks = get_wpm_playlist_tracks( $post_id );

	if ( array() == $tracks ) {
		return;
	}

	$post = get_post( $post_id );

	$args = wp_parse_args( $args, array(
		'post_id' => $post_id,
		'container' => true,
		'show_tracklist' => true,
		'player' => '',
		'theme' => get_wpm_default_theme(),
		'template' => '',
		'is_sticky_player' => false,
		'pause_other_players' => true,
	) );

	$classes   = array( 'wpm-playlist' );
	$classes[] = $args['show_tracklist'] ? '' : 'is-playlist-hidden';
	$classes[] = sprintf( 'wpm-theme-%s', sanitize_html_class( $args['theme'] ) );
	$classes   = implode( ' ', array_filter( $classes ) );

	$container_class = 'wpm-playlist-container';

	// is sticky player
	if ( $args['is_sticky_player'] ) {
		$container_class .= ' wpm-sticky-playlist-container';
	}

	$args = apply_filters( 'wpm_playlist_args', $args, $post_id );

	echo '<div class="' . esc_attr( $container_class ) . '">';

	do_action( 'wpm_before_playlist', $post, $tracks, $args );

	include( WPM_DIR . '/templates/playlist.php' );

	do_action( 'wpm_after_playlist', $post, $tracks, $args );

	echo '</div>';
}

/**
 * Print playlist settings as a JSON script tag
 *
 * @since 1.0.0
 * @param WP_Post $post Playlist post object.
 * @param array   $tracks   List of tracks.
 * @param array   $args     Playlist arguments.
 */
function wpm_print_playlist_settings( $post, $tracks, $args ) {
	
	$settings = array();
	$post_id = $post->ID;
	$tracks = get_wpm_playlist_tracks( $post_id );
	$formatted_tracks = wpm_format_tracks_for_script( $tracks );
	$theme = sanitize_title( $args['theme'] );
	$pause_other_players = boolval( $args['pause_other_players'] );

	// background from fetatured image
	$background = ( has_post_thumbnail( $post_id ) ) ? wpm_get_post_thumbnail_url( $post_id ) : '';
	$background = apply_filters( 'wpm_playlist_background', $background );

	$settings = array(
		'skin' => 'wpm-theme-' . $theme,
		'tracks' => $formatted_tracks,
		'thumbnail' => $background,
		'pause_other_players' => $pause_other_players,
	);
	?>
	<script type="application/json" class="wpm-playlist-data"><?php echo wp_json_encode( $settings ); ?></script>
	<?php
}
add_filter( 'wpm_after_playlist', 'wpm_print_playlist_settings', 10, 3 );

/**
 * Format the tracks array to fit the script
 *
 * @since 1.0.0
 * @param array $tracks 
 * @return array
 */
function wpm_format_tracks_for_script( $tracks ) {

	$formatted_tracks = array();

	if ( is_array( $tracks ) ) {
		
		$formatted_tracks = array();

		foreach( $tracks as $key => $track ) {

			if ( $track['artist'] ) {
				$formatted_tracks[ $key ][ 'meta' ]['artist'] = $track['artist'];
			}

			$formatted_tracks[ $key ]['src'] = $track['mp3'];

			if ( $track['artworkUrl'] ) {
				$formatted_tracks[ $key ]['thumb']['src'] = $track['artworkUrl'];
			}

			$formatted_tracks[ $key ]['title'] = $track['title'];
		}
	}

	return $formatted_tracks;
}

/**
 * Output sticky player if theme allows it and a player is set
 *
 * @since 1.0.5
 */
function wpm_output_sticky_player() {

	if ( current_theme_supports( 'wpm_bar' ) && get_option( '_wpm_bar' ) ) {
		wpm_playlist(
			get_option( '_wpm_bar' ),
			array(
				'show_tracklist' => false,
				'is_sticky_player' => true,
			)
		);
	}
}
add_action( 'wolf_body_start', 'wpm_output_sticky_player' );

/**
 * Output sticky player holder to be sure to add space at the bottom
 *
 * @since 1.0.5
 */
function wpm_output_sticky_player_holder() {

	if ( current_theme_supports( 'wpm_bar' ) && get_option( '_wpm_bar' ) ) {
		echo '<div class="wpm-bar-holder"></div>';
	}
}
add_action( 'wolf_body_end', 'wpm_output_sticky_player_holder' );
