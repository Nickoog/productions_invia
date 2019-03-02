/*global jQuery:false, MediaElementPlayer:false */

( function( window, $, undefined )  {
	'use strict';

	$.extend( MediaElementPlayer.prototype, {
	
		buildcuebackground: function( player, controls, layers, media ) {

			
			var $background = player.container.append( $( '<div />', {
				'class': 'wpm-playlist-background',
				'style' : 'background-image:url(' + player.options.cueBackgroundUrl + ');'
			} ) ).find( '.wpm-playlist-background' );

			//// Set each track to use the background image as artwork if it doesn't have artwork.
			//$.each( player.options.cuePlaylistTracks, function( index, track ) {
			//	player.options.cuePlaylistTracks[ index ].thumb.src = track.thumb.src || player.options.cueBackgroundUrl;
			//});
			//player.$node.on( 'setTrack.cue', function( e, track, player ) {
			//	track.thumb = track.thumb || {};

			//	if ( '' === player.options.cueBackgroundUrl ) {
			//		$background.css( { 'background-image' : 'url(' + track.thumb.src + ')' } );
			//	}
			//} ).trigger( 'backgroundCreate.cue', player );
		}
	} );

} )( this, jQuery );