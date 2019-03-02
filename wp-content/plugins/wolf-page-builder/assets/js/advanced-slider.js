/*!
Plugin: Wolf Slider
Version 1.0.0
Author: Constantin Saguin
Twitter: @wolf_themes
Author URL: http://csag.co

An enhanced version of flexslider that support video background and caption transition effects
*/
;( function ( window, document, $, undefined ) {

	$.wpbSlider = function( elem, options ) {
		/* jshint unused:false */
		var isTouch = $( 'html' ).hasClass( 'touch' ),
			ui,
			doVideo = ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? false : true,
			isMobile = ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? true : false,
			defaults = {
				//animation : ( isTouch ) ? 'slide' : 'fade',
				animation : 'fade',
				slideshow : false,
				pauseOnHover: true,
				slideshowSpeed : 4000,
				controlNav : true,
				directionNav : true,
				sliderHeight : '100',
				sliderHeightUnit : '%'
			},

			plugin = this,
			selector = elem.selector,
			$selector = $( selector );

		plugin.settings = {};

		plugin.init = function() {

			plugin.settings = $.extend( {}, defaults, options );

			$selector.flexslider( {
				animation : plugin.settings.animation,
				slideshow : plugin.settings.slideshow,
				pauseOnHover : plugin.settings.pauseOnHover,
				slideshowSpeed : plugin.settings.slideshowSpeed,
				controlNav : plugin.settings.controlNav,
				directionNav : plugin.settings.directionNav,

				start : function () {
					ui.init( plugin.settings.sliderHeight, plugin.settings.sliderHeightUnit );
					ui.playCurrentVideo();
				},
				before : function () {
					ui.pauseAllVideos();

				},
				after : function () {
					ui.playCurrentVideo();
				}
			} );
		};

		ui = {

			/**
			 * Initiate slider
			 */
			init : function ( value, unit ) {
				var _this = this;

				this.setSliderHeight( value, unit );
				this.loadAllVideos();
				this.playCurrentVideo();
				this.playButton();
				this.muteButton();

				/**
				 * Resize event
				 */
				$( window ).resize( function() {
					_this.setSliderHeight( value, unit );
				} ).resize();
			},

			/**
			 * Set element height to full screen
			 */
			setSliderHeight : function( value, unit ) {
				var _this = this,
					winHeight,
					scrollOffset = _this.getToolBarOffset(),
					bleed = 2;

				winHeight = parseInt( value, 10 );
				
				if ( '%' === unit ) {
					winHeight = Math.floor( $( window ).height() * value / 100 );
				}

				if ( $( '.wpm-sticky-playlist-container' ).length ) {
					scrollOffset += $( '.wpm-sticky-playlist-container' ).height();
				}

				winHeight = winHeight - scrollOffset + bleed;

				$selector.find( '.slide' ).each( function() {
					$( this ).css( { 'height' : winHeight  } );
				} );
			},

			getToolBarOffset : function () {

				var scrollOffset = 0;

				if ( $( 'body' ).is( '.admin-bar' ) ) {

					if ( 782 < $( window ).width() ) {
						scrollOffset = 32;
					} else {
						scrollOffset = 46;
					}
				}

				return scrollOffset;
			},

			/**
			 * Preload all slide videos if any
			 *
			 * @todo
			 */
			loadAllVideos : function () {

				$selector.find( '.wpb-slide-video' ).each( function () {
					$( this ).parents( '.wpb-slide' ).addClass( 'pause' );
				} );
			},

			/**
			 * Play video
			 */
			playCurrentVideo : function () {

				if ( $selector.find( '.flex-active-slide .wpb-slide-video' ).length ) {

					var $videoContainer = $( '.flex-active-slide' ),
						$video = $videoContainer.find( '.wpb-slide-video' );
					
					this.playToggleVideo( $video );
				}
			},

			/**
			 * Play/Pause a video
			 */
			playToggleVideo : function ( $video ) {
				
				var $videoContainer = $video.parent().parent(),
					state = $video.data( 'video-play' ),
					id = $video.data( 'video-id' ),
					video = document.getElementById( 'wpb-slide-video-' + id );

				// play
				if ( false === state && doVideo ) {

					$video.get( 0 ).play();
					$video.data( 'video-play', true );
					$videoContainer.toggleClass( 'pause' );
				
				// pause
				} else {
					$video.get( 0 ).pause();
					$video.data( 'video-play', false );
					$videoContainer.toggleClass( 'pause' );
				}

				// Hide image fallback
				if ( doVideo ) {
					if ( video.readyState >= video.HAVE_FUTURE_DATA ) {
						// console.log('video can play!');
						$videoContainer.find( '.wpb-slide-video-container' ).css( { 'opacity' : 1 } );
					} else {
						video.addEventListener( 'canplay', function () {
							// console.log('video can play!');
							$videoContainer.find( '.wpb-slide-video-container' ).css( { 'opacity' : 1 } );
						}, false );
					}
				}
			},

			/**
			 * Mute/Unmute a video
			 */
			muteToggleVideo : function ( $video ) {
				var $videoContainer = $video.parent().parent(),
					state = $video.data( 'video-mute' );
				
				// already muted
				if ( true === state ) {
					$video.prop( 'muted', false );
					$video.data( 'video-mute', false );
					$videoContainer.addClass( 'unmute' );
				} else {
					$video.prop( 'muted', true );
					$video.data( 'video-mute', true );
					$videoContainer.removeClass( 'unmute' );
				}
			},

			/**
			 * Pause all videos
			 */
			pauseAllVideos : function () {

				var _this = this,
					$video;

				if ( $selector.find( '.wpb-slide-video' ).length ) {
					$selector.find( '.wpb-slide-video' ).each( function () {

						$video = $( this );

						// Pause all videos
						$video.get( 0 ).pause();
						$video.data( 'video-play', false );
						$video.parent().parent().addClass( 'pause' );

						//_this.muteToggleVideo( $video ); // mute
					} );
				}
			},

			/**
			 * Mute button
			 */
			muteButton : function () {

				var _this = this;

				$( '.wpb-slide-video-mute-button' ).each( function () {
					$( this ).on( 'click' , function () {
						var id = $( this ).data( 'video-mute-id' ),
							$video = $( '#wpb-slide-video-' + id );
						
						_this.muteToggleVideo( $video );
					} );
				} );
			},

			/**
			 * Play button
			 */
			playButton : function () {

				var _this = this;

				$( '.wpb-slide-video-play-button' ).each( function () {
					$( this ).on( 'click' , function () {

						var id = $( this ).data( 'video-play-id' ),
							$video = $( '#wpb-slide-video-' + id );

						_this.playToggleVideo( $video );
					} );
				} );
			}
		};

		plugin.init();
	};

	$.fn.wpbSlider = function( options ) {

		if ( ! $.data( this, '_wpbSlider' ) ) {
			var wpbSlider = new $.wpbSlider( this, options );
			this.data( '_wpbSlider', wpbSlider );
		}
		return this.data( '_wpbSlider' );
	};

}( window, document, jQuery ) );