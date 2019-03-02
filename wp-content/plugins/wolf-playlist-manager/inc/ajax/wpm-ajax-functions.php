<?php
/**
 * Wolf Playlist AJAX Functions
 *
 * @author WolfThemes
 * @category Ajax
 * @package WolfPageBuilder/Functions
 * @version 1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get track admin markup
 *
 * @since 1.0
 */
function wpm_ajax_get_track_markup() {

	extract( $_POST );

	if ( isset( $_POST['tracklistIDs'] ) ) {
		// sanitize ids here
		$tracklist_ids = $_POST['tracklistIDs'];
		wpm_get_track_markup( $tracklist_ids );
	}
	exit;

}
add_action( 'wp_ajax_wpm_ajax_get_track_markup', 'wpm_ajax_get_track_markup' );

/**
 * Save track title
 *
 * @since 1.0
 */
function wpm_ajax_update_track_title() {

	extract( $_POST );

	if ( isset( $_POST['newVal'] ) && isset( $_POST['trackId'] ) ) {
		
		$title = sanitize_text_field( $_POST['newVal']  );
		$track_id = absint( $_POST['trackId'] );
		
		$post = array(
			'ID' => $track_id,
			'post_title' => $title,
		);

		// Update the post into the database
		$update_post = wp_update_post( $post );

		if ( ! is_wp_error( $update_post) ) {
			echo $title;
		}
	}
	exit;

}
add_action( 'wp_ajax_wpm_ajax_update_track_title', 'wpm_ajax_update_track_title' );

/**
 * Save track artist
 *
 * @since 1.0
 */
function wpm_ajax_update_track_artist() {

	extract( $_POST );

	if ( isset( $_POST['newVal'] ) && isset( $_POST['trackId'] ) ) {
		
		$artist = sanitize_text_field( $_POST['newVal']  );
		$track_id = absint( $_POST['trackId'] );

		$meta = wp_get_attachment_metadata( $track_id, false);
		$meta['artist'] = $artist;
		
		if ( wp_update_attachment_metadata( $track_id, $meta ) ) {
			echo 'OK';
		}
	}
	exit;

}
add_action( 'wp_ajax_wpm_ajax_update_track_artist', 'wpm_ajax_update_track_artist' );

/**
 * Save track length
 *
 * @since 1.0
 */
function wpm_ajax_update_track_length() {

	extract( $_POST );

	if ( isset( $_POST['newVal'] ) && isset( $_POST['trackId'] ) ) {
		
		$length = sanitize_text_field( $_POST['newVal']  );
		$track_id = absint( $_POST['trackId'] );

		$meta = wp_get_attachment_metadata( $track_id, false);
		$meta['length_formatted'] = $length;
		
		if ( wp_update_attachment_metadata( $track_id, $meta ) ) {
			echo 'OK';
		}
	}
	exit;

}
add_action( 'wp_ajax_wpm_ajax_update_track_length', 'wpm_ajax_update_track_length' );

/**
 * Save track itunes attachement
 *
 * @since 1.0
 */
function wpm_ajax_update_track_itunes_url() {

	extract( $_POST );

	if ( isset( $_POST['newVal'] ) && isset( $_POST['trackId'] ) ) {

		$itunes_url = esc_url( $_POST['newVal'] );
		$track_id = absint( $_POST['trackId'] );

		if ( update_post_meta( $track_id, '_wpm_track_itunes_url', $itunes_url ) ) {
			echo 'OK';
		}
	}
	exit;

}
add_action( 'wp_ajax_wpm_ajax_update_track_itunes_url', 'wpm_ajax_update_track_itunes_url' );

/**
 * Save track amazon attachement
 *
 * @since 1.0
 */
function wpm_ajax_update_track_amazon_url() {

	extract( $_POST );

	if ( isset( $_POST['newVal'] ) && isset( $_POST['trackId'] ) ) {

		$amazon_url = esc_url( $_POST['newVal'] );
		$track_id = absint( $_POST['trackId'] );

		if ( update_post_meta( $track_id, '_wpm_track_amazon_url', $amazon_url ) ) {
			echo 'OK';
		}
	}
	exit;

}
add_action( 'wp_ajax_wpm_ajax_update_track_amazon_url', 'wpm_ajax_update_track_amazon_url' );

/**
 * Save track buy attachement
 *
 * @since 1.0
 */
function wpm_ajax_update_track_buy_url() {

	extract( $_POST );

	if ( isset( $_POST['newVal'] ) && isset( $_POST['trackId'] ) ) {

		$buy_url = esc_url( $_POST['newVal'] );
		$track_id = absint( $_POST['trackId'] );

		if ( update_post_meta( $track_id, '_wpm_track_buy_url', $buy_url ) ) {
			echo 'OK';
		}
	}
	exit;

}
add_action( 'wp_ajax_wpm_ajax_update_track_buy_url', 'wpm_ajax_update_track_buy_url' );

/**
 * Save track artwork attachement
 *
 * @since 1.0
 */
function wpm_ajax_save_track_artwork() {

	extract( $_POST );

	if ( isset( $_POST['attachmentId'] ) && isset( $_POST['trackId'] ) ) {

		$post_id = absint( $_POST['attachmentId'] );
		$track_id = absint( $_POST['trackId'] );

		if ( update_post_meta( $track_id, '_wpm_track_artwork', $post_id ) ) {
			echo 'OK';
		}
	}
	exit;

}
add_action( 'wp_ajax_wpm_ajax_save_track_artwork', 'wpm_ajax_save_track_artwork' );

/**
 * Delete track artwork attachement
 *
 * @since 1.0
 */
function wpm_ajax_delete_track_artwork() {

	extract( $_POST );

	if ( isset( $_POST['trackId'] ) ) {

		$track_id = absint( $_POST['trackId'] );

		if ( delete_post_meta( $track_id, '_wpm_track_artwork' ) ) {
			echo 'OK';
		}
	}
	exit;

}
add_action( 'wp_ajax_wpm_ajax_delete_track_artwork', 'wpm_ajax_delete_track_artwork' );