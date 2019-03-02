<?php
/**
 * Wolf Playlist core functions
 *
 * General core functions available on admin and frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPlaylistManager/Core
 * @version 1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Hack for old php versions to use boolval()
if ( ! function_exists( 'boolval' ) ) {
	function boolval( $val ) {
		return (bool) $val;
	}
}

/**
 * Add image sizes
 *
 * These size will be ued for the artwork thumbnail and playlist background
 */
function wpm_add_image_sizes() {

	add_image_size( 'wpm-thumb', 150, 150, true );
	add_image_size( 'wpm-cover', 960, 960, true );
}
add_action( 'init', 'wpm_add_image_sizes' );

/**
 * Return a markup of track for the admin from the file ids list
 *
 * @since 1.0.0
 */
function wpm_get_track_markup( $tracklist ) {

	if ( ! $tracklist ) {
		return;
	}

	if ( is_array( $tracklist ) ) {
		$tracks = $tracklist;
	} else {
		$tracks = wpm_list_to_array( $tracklist );
	}

	// var_dump($tracks);

	foreach ( $tracks as $attachment_id ) :

		$id = $attachment_id;
		$track = get_wpm_track_data( $id );
		$has_artwork = $track['artworkUrl'];
		$artwork_bg = ( $has_artwork ) ? 'background-image:url( ' . esc_url( $track['artworkUrl'] ) . ' );' : '';

		// var_dump( $track );
	?>
	<div class="wpm-track-container wpm-track-item" data-track-id="<?php echo absint( $id ); ?>">
		<div class="wpm-track menu-item-bar">
			<div class="menu-item-handle">
				<span class="item-title">
					<span class="menu-item-title wpm-track-title-label"><?php echo $track['title']; ?></span>
				</span>
				<span class="item-controls">
					<span class="item-order">
						<span class="wpm-toggle"><span>
					</span>
				</span>

			</div>
		</div><!-- .wpm-track -->
		<div class="wpm-track-content">
			<div class="wpm-track-loader"></div>
			<div class="wpm-track-column-group">
				<div class="wpm-track-column wpm-track-column-artwork">
					<input type="hidden" data-track-id="<?php echo absint( $id ); ?>" value="<?php echo absint( $track['artworkId'] ); ?>">
					<span style="<?php echo wpm_esc_style_attr( $artwork_bg ); ?>" class="wpm-track-artwork <?php echo ( $has_artwork ) ? 'wpm-track-has-artwork' : ''; ?>"></span>

					<a style="<?php echo ( $has_artwork ) ? 'display:inline-block;' : '' ;?>" data-track-id="<?php echo absint( $id ); ?>" class="wpm-remove-artwork"><?php esc_html_e( 'Remove artwork', 'wolf-playlist-manager' ); ?></a>
				</div><!-- .wpm-track-column-artwork -->

				<div class="wpm-track-column">
					<p>
						<label>
							<?php esc_html_e( 'Title', 'wolf-playlist-manager' ); ?>:<br>
							<input class="wpm-track-title regular-text" type="text" name="artist" placeholder="<?php esc_html_e( 'Title', 'wolf-playlist-manager' ); ?>" value="<?php echo esc_attr( $track['title'] ); ?>">
						</label>
					</p>
					<p>
						<label>
							<?php esc_html_e( 'Artist', 'wolf-playlist-manager' ); ?>:<br>
							<input class="wpm-track-artist regular-text" type="text" name="track" placeholder="<?php esc_html_e( 'Artist', 'wolf-playlist-manager' ); ?>" value="<?php echo esc_attr( $track['artist'] ); ?>">
						</label>
					</p>
					<p>
						<label>
							<?php esc_html_e( 'Lenght', 'wolf-playlist-manager' ); ?>:<br>
							<input class="wpm-track-length regular-text" type="text" name="track" placeholder="00:00" value="<?php echo esc_attr( $track['length'] ); ?>">
						</label>
					</p>
				</div><!-- .wpm-track-column -->

				<div class="wpm-track-column">
					<p>
						<label>
							<?php esc_html_e( 'iTunes', 'wolf-playlist-manager' ); ?>:<br>
							<input class="wpm-track-itunes_url regular-text" type="text" name="artist" placeholder="http://" value="<?php echo esc_url( $track['itunesUrl'] ); ?>">
						</label>
					</p>

					<p>
						<label>
							<?php esc_html_e( 'amazon', 'wolf-playlist-manager' ); ?>:<br>
							<input class="wpm-track-amazon_url regular-text" type="text" name="artist" placeholder="http://" value="<?php echo esc_url( $track['amazonUrl'] ); ?>">
						</label>
					</p>

					<p>
						<label>
							<?php esc_html_e( 'Other buy URL', 'wolf-playlist-manager' ); ?>:<br>
							<input class="wpm-track-buy_url regular-text" type="text" name="artist" placeholder="http://" value="<?php echo esc_url( $track['buyUrl'] ); ?>">
						</label>
					</p>

				</div><!-- .wpm-track-column -->
			</div><!-- .wpm-track-column-group -->
			<div class="wpm-track-actions">
				<a class="wpm-track-remove"><?php esc_html_e( 'Remove', 'wolf-playlist-manager' ); ?></a> |
				<a class="wpm-toggle"><?php esc_html_e( 'Close', 'wolf-playlist-manager' ); ?></a>
			</div>
		</div><!-- .wpm-track-content -->
	</div><!-- .wpm-track-container -->
	<?php endforeach;
}

/**
 * Retreve all track infos and data as an nice array:
 *
 * @since 1.0.0
 * @param int $post_id
 * @return array
 */
function get_wpm_track_data( $post_id ) {

	$track = get_wpm_default_track(); // set default track args

	$post = get_post( $post_id );
	$meta = wp_get_attachment_metadata( $post_id );

	$title = ( $post->post_title ) ? $post->post_title : $post->post_name;
	$file_url = $post->guid;
	$artwork_id = absint( get_post_meta( $post_id, '_wpm_track_artwork', true ) );
	$artwork_url = esc_url( wpm_get_url_from_attachment_id( $artwork_id, 'wpm-thumb' ) );

	// buy URL
	$itunes_url = esc_url( get_post_meta( $post_id, '_wpm_track_itunes_url', true ) );
	$amazon_url = esc_url( get_post_meta( $post_id, '_wpm_track_amazon_url', true ) );
	$buy_url = esc_url( get_post_meta( $post_id, '_wpm_track_buy_url', true ) );

	$track['artist'] = ( isset( $meta['artist'] ) ) ? $meta['artist'] : '';
	$track['title'] = $title;
	$track['length'] = ( isset( $meta['length_formatted'] ) ) ? $meta['length_formatted'] : '';
	$track['format'] = ( isset( $meta['fileformat'] ) ) ? $meta['fileformat'] : '';
	$track['audioId'] = $post_id;
	$track['audioUrl'] = $file_url;
	$track['mp3'] = $file_url;
	$track['artworkId'] = $artwork_id;
	$track['artworkUrl'] = $artwork_url;
	$track['itunesUrl'] = $itunes_url;
	$track['amazonUrl'] = $amazon_url;
	$track['buyUrl'] = $buy_url;

	// var_dump( $track );

	return wpm_sanitize_track( $track );
}

/**
 * Retrieve a default track.
 *
 * Useful for whitelisting allowed keys.
 *
 * @since 1.0.0
 * @return array
 */
function get_wpm_default_track() {
	$args = array(
		'artist'     => '',
		'artworkId'  => '',
		'artworkUrl' => '',
		'audioId'    => '',
		'audioUrl'   => '',
		'length'     => '',
		'format'     => '',
		'order'      => '',
		'title'      => '',
		'itunesUrl' => '',
		'amazonUrl' => '',
		'buyUrl' => '',
	);

	return apply_filters( 'wpm_default_track_properties', $args );
}

/**
 * Sanitize track arguments array
 *
 * @since 1.0.0
 * @param array $track Track data.
 * @return array
 */
function wpm_sanitize_track( $track ) {

	// Sanitize valid properties.
	$track['artist']     = sanitize_text_field( $track['artist'] );
	$track['artworkId']  = absint( $track['artworkId'] );
	$track['artworkUrl'] = esc_url_raw( $track['artworkUrl'] );
	$track['audioId']    = absint( $track['audioId'] );
	$track['audioUrl']   = esc_url_raw( $track['audioUrl'] );
	$track['length']     = sanitize_text_field( $track['length'] );
	$track['format']     = sanitize_text_field( $track['format'] );
	$track['title']      = sanitize_text_field( $track['title'] );
	$track['order']      = absint( $track['order'] );

	return apply_filters( 'wpm_sanitize_track', $track );
}

/**
 * Sanitize html style attribute
 *
 * @since 1.0.0
 * @param string $style
 * @return string
 */
function wpm_esc_style_attr( $style ) {
	return esc_attr( trim( wpm_clean_spaces( $style ) ) );
}

/**
 * Get any thumbnail URL
 *
 * @since 1.0.0
 * @param string $format
 * @param int $post_id
 * @return string
 */
function wpm_get_post_thumbnail_url( $post_id, $format = 'large' ) {
	global $post;

	if ( is_object( $post ) && isset( $post->ID ) && null == $post_id ) {

		$ID = $post->ID;
	} else {
		$ID = $post_id;
	}

	if ( $ID && has_post_thumbnail( $ID ) ) {

		$attachment_id = get_post_thumbnail_id( $ID );
		if ( $attachment_id ) {
			$img_src = wp_get_attachment_image_src( $attachment_id, $format );

			if ( $img_src && isset( $img_src[0] ) )
				return esc_url( $img_src[0] );
		}
	}
}

/**
 * Convert list of IDs to array
 *
 * @since 1.0.0
 * @param string $list
 * @return array
 */
function wpm_list_to_array( $list, $separator = ',' ) {
	return ( $list ) ? explode( $separator, trim( wpm_clean_spaces( wpm_clean_list( $list ) ) ) ) : array();
}

/**
 * Convert array of ids to list
 *
 * @since 1.0.0
 * @param string $list
 * @return array
 */
function wpm_array_to_list( $array ) {

	$list = '';

	if ( is_array( $array ) ) {
		$list = rtrim( implode( ',',  $array ), ',' );
	}

	return wpm_clean_list( $list );
}

/**
 * Clean list of numbers
 *
 * Used to clean the list of IDs
 *
 * @since 1.0.0
 * @param string $list
 * @return string
 */
function wpm_clean_list( $list ) {
	$list = wpm_clean_spaces( trim( rtrim( $list, ',' ) ) );
	$list = preg_replace( "/[^0-9,]/", '', $list );
	return $list;
}

/**
 * Remove all double spaces
 *
 * This function is mainly used to clean up inline CSS
 *
 * @since 1.0.0
 * @param string $css
 * @return string
 */
function wpm_clean_spaces( $string, $hard = true ) {
	return preg_replace( '/\s+/', ' ', $string );
}

/**
 * Get the URL of an attachment from its id
 *
 * @since 1.0.0
 * @param int $id
 * @param string $size
 * @return string
 */
function wpm_get_url_from_attachment_id( $id, $size = 'thumbnail' ) {
	if ( is_numeric( $id ) ) {
		$src = wp_get_attachment_image_src( absint( $id ), $size );

		if ( isset( $src[0] ) ) {
			return esc_url( $src[0] );
		}
	}
}
