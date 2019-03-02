/*!
 * Plugin Youtube Video Background for page header
 *
 * Sonic 2.2.4 
 */
/* jshint -W062 */
var SonicYTVideoBg =  SonicYTVideoBg || {},
	YT = YT || {},
	console = console || {};

SonicYTVideoBg = function( $ ) {

	'use strict';

	return {

		isMobile : ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? true : false,

		playVideo: function( container, videoId ) {
			var _this = this;

			if ( $( '.youtube-video-bg-container' ).length && ! this.isMobile ) {
				if ( 'undefined' === typeof( YT ) || 'undefined' === typeof( YT.Player ) ) {
					
					window.onYouTubePlayerAPIReady = function() {
						
						$( '.youtube-video-bg-container' ).each( function() {
							var $this = $( this ), containerId, videoId;

							containerId = $this.find( '.youtube-player' ).attr( 'id' );
							videoId = $this.data( 'youtube-video-id' );
							
							_this.loadPlayer( containerId, videoId );
						} );
						
					};
					$.getScript( '//www.youtube.com/player_api' );
				
				} else {
					$( '.youtube-video-bg-container' ).each( function() {
						var $this = $( this ), containerId, videoId;

						containerId = $this.find( '.youtube-player' ).attr( 'id' );
						videoId = $this.data( 'youtube-video-id' );
						
						_this.loadPlayer( containerId, videoId );
					} );
				}
			}
		},

		loadPlayer: function( containerId, videoId ) {
			
			new YT.Player( containerId, {
				width: '100%',
				height: '100%',
				videoId: videoId,
				playerVars: {
					playlist: videoId,
					iv_load_policy: 3, // hide annotations
					enablejsapi: 1,
					disablekb: 1,
					autoplay: 1,
					controls: 0,
					showinfo: 0,
					rel: 0,
					loop: 1,
					wmode: 'transparent'
				},
				events: {
					onReady: function ( event ) {
						event.target.mute().setLoop( true );
						var el = document.getElementById( containerId );
						el.className = el.className + ' youtube-player-is-loaded';
					}
				}
			} );

			$( window ).trigger( 'resize' ); // trigger window calculation for video background
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		SonicYTVideoBg.playVideo();
	} );

} )( jQuery );