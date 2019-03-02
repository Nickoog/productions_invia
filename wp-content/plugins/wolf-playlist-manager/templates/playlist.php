<?php
/**
 * Template to render the player and playlist.
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPlaylistManager/Admin
 * @version 1.1.4
 */
?>
<div class="<?php echo esc_attr( $classes ); ?>" id="wpm-playlist-<?php echo absint( $args['post_id'] ); ?>" itemscope itemtype="http://schema.org/MusicPlaylist">
	
	<?php do_action( 'wpm_playlist_top', $post, $tracks, $args ); ?>

	<meta itemprop="numTracks" content="<?php echo count( $tracks ); ?>">

	<audio src="<?php echo esc_url( $tracks[0]['audioUrl'] ); ?>" controls preload="none" class="wpm-audio" style="width: 100%; height: auto"></audio>

	<ol class="wpm-tracks">
		<?php foreach ( $tracks as $track ) : ?>
			<li class="wpm-track" itemprop="track" itemscope itemtype="http://schema.org/MusicRecording">
				<?php do_action( 'wpm_playlist_track_top', $track, $post, $args ); ?>

				<span class="wpm-track-details wpm-track-cell">
					<span class="wpm-track-text">
						<span class="wpm-track-title" itemprop="name"><?php echo esc_html( $track['title'] ); ?></span>
						<span class="wpm-track-artist" itemprop="byArtist"><?php echo esc_html( $track['artist'] ); ?></span>
					</span>
				</span>

				<span class="wpm-track-links wpm-track-cell">
					<span class="wpm-track-buy-links">	
						<?php if ( $track['itunesUrl'] ) : ?>
							<a title="<?php esc_html_e( 'buy on iTunes', 'wolf-playlist-manager' ); ?>" class="wpm-track-itunes wpm-track-icon wpm-icon-itunes" href="<?php echo esc_url( $track['itunesUrl'] ); ?>" target="_blank"></a>
						<?php endif; ?>
						<?php if ( $track['amazonUrl'] ) : ?>
							<a title="<?php esc_html_e( 'buy on amazon', 'wolf-playlist-manager' ); ?>" class="wpm-track-amazon wpm-track-icon wpm-icon-amazon" href="<?php echo esc_url( $track['amazonUrl'] ); ?>" target="_blank"></a>
						<?php endif; ?>
						<?php if ( $track['buyUrl'] ) : ?>
							<a title="<?php esc_html_e( 'buy now', 'wolf-playlist-manager' ); ?>" class="wpm-track-buy wpm-track-icon wpm-icon-cart" href="<?php echo esc_url( $track['buyUrl'] ); ?>" target="_blank"></a>
						<?php endif; ?>
					</span>
				</span>

				<?php do_action( 'wpm_playlist_track_details_after', $track, $post, $args ); ?>

				<span class="wpm-track-length wpm-track-cell"><?php echo esc_html( $track['length'] ); ?></span>

				<?php do_action( 'wpm_playlist_track_bottom', $track, $post, $args ); ?>
			</li>
		<?php endforeach; ?>
	</ol>
	
	<?php do_action( 'wpm_playlist_bottom', $post, $tracks, $args ); ?>
</div>