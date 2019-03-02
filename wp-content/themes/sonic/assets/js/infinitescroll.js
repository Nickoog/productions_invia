/*!
 * Infinite scroll blog
 *
 * Sonic 2.2.4
 */
var SonicParams =  SonicParams || {},
	SonicUi = SonicUi || {},
	SonicInfiniteScroll = SonicInfiniteScroll || {},
	SonicMasonry = SonicMasonry || {},
	console = console || {};

/* jshint -W062 */
SonicInfiniteScroll = function ( $ ) {

	'use strict';

	return {

		extraScrollPx : 2000,

		/**
		 * Init blog
		 */
		init : function () {

			if ( ! $( 'body' ).hasClass( 'is-infinitescroll' ) ) {
				return;
			}

			this.infiniteScroll();
		},

		/**
		 * Infinite Scroll
		 */
		infiniteScroll : function () {

			var  _this = this,
				$container = $( '#content' ),
				i = 1, // pagination
				$trigger = $( '#trigger' ),
				$button = $( '#trigger a' );


			if ( $( 'body' ).hasClass( 'is-infinitescroll-trigger' ) ) {

				$button.html( SonicParams.l10n.loadMoreMsg );

				$trigger.find( 'a' ).on( 'click', function( event ) {
					event.preventDefault();
				} );

				$trigger.on( 'click', function( event ) {
					
					event.preventDefault();
					
					if ( SonicParams.isCustomizer ) {
						event.stopPropagation();
						alert( SonicParams.l10n.infiniteScrollDisabledMsg );
						return;
					}
					
					var link = $( this ).find( 'a' ).attr( 'href' ),
						$content = '#content',
						$anchor = '#trigger a',
						$next_href = $( $anchor ).attr( 'href' ),
						$newElems;

					if ( $( this ).hasClass( 'trigger-loading' ) ) {
						return;
					}

					$( this ).addClass( 'trigger-loading' );
					
					$button.html( SonicParams.l10n.infiniteScrollMsg );
					
					$.get( link + '' , function( data ) {
						
						var newElements = $( $content, data ).wrapInner( '' ).html();
						$next_href = $( $anchor, data ).attr( 'href' );

						$newElems = $( newElements ).css( { opacity: 0 } );
						
						$container.append( $newElems );

						if ( $container.data( 'isotope' ) ) {
							$container.isotope( 'reloadItems' ).isotope( { sortBy: 'original-order' } );
						}
						
						_this.callBack( $newElems );
						
						if ( $( 'body' ).hasClass( 'is-masonry' ) ) {
							SonicMasonry.metroItemDimension(); // resize metro item
						}
						
						setTimeout( function() {

							if ( $container.data( 'isotope' ) ) {
								$container.isotope( 'layout' );
							}

							$newElems.animate( { opacity: 1 } );

							if ( $container.data( 'isotope' ) ) {
								SonicMasonry.resizeTimer();
							}
													
						}, 400 );

						$trigger.removeClass( 'trigger-loading' );
						$button.html( SonicParams.l10n.loadMoreMsg );

						if ( $trigger.data( 'max' ) > i ) {
							
							$button.attr( 'href', $next_href ); // Change the next URL
						} else {
							
							$trigger.remove();
						}
					} );
					i++;
				} );

			} else { // not trigger

				if ( SonicParams.isCustomizer ) {
					return;
				}

				$container.infinitescroll( {
					state: {
						isDestroyed: false,
						isDone: false,
						isDuringAjax : false
					},
					navSelector  : '.nav-previous',
					nextSelector : '.nav-previous a',
					itemSelector : 'article',
					loading: {
						finishedMsg: SonicParams.l10n.infiniteScrollEndMsg,
						msgText : SonicParams.l10n.infiniteScrollMsg,
						img: SonicParams.l10n.infiniteScrollEmptyLoad,
						extraScrollPx: _this.extraScrollPx
					}
				// callback
				}, function( newElements ) {

					var $newElems = $( newElements ).css( { opacity: 0 } );
						
					$newElems.imagesLoaded( function() {
						
						if ( $container.data( 'isotope' ) ) {
							$container.isotope( 'appended', $newElems );
						}

						_this.callBack( $newElems );
						
						if ( $( 'body' ).hasClass( 'is-masonry' ) ) {
							SonicMasonry.metroItemDimension(); // resize metro item
						}
						
						$newElems.animate( { opacity: 1 } );

						if ( $( 'body' ).hasClass( 'is-masonry' ) ) {
							SonicMasonry.resizeTimer();
						}
					} );
				} );

			}
		},

		/**
		 * Refresh everything after posts load
		 */
		callBack : function ( $newElems ) {

			SonicUi.fluidVideos( $newElems );
			SonicUi.youtubeWmode();
			SonicUi.setVimeoOptions();
			SonicUi.flexSlider();
			SonicUi.lightbox();
			SonicUi.likes();
			SonicUi.postBg();

			/* AJAX nav */
			if ( 'undefined' !== typeof SonicAjaxNav ) {
				SonicAjaxNav.setAjaxLinkClass();
			}

			/* Wolf Playilst */
			if ( typeof WPM !== 'undefined') {
				WPM.init();
			}

			if ( $newElems.find( '.twitter-tweet' ).length ) {
				$.getScript( 'http://platform.twitter.com/widgets.js' );
			}

			if ( $newElems.find( '.instagram-media' ).length ) {

				$.getScript( '//platform.instagram.com/en_US/embeds.js' );

				if ( 'undefined' !== typeof window.instgrm  ) {
					window.instgrm.Embeds.process();
				}
			}

			if ( $newElems.find( 'audio.wp-audio-shortcode, video.wp-video-shortcode' ).length ) {
				$newElems.find( 'audio.wp-audio-shortcode, video.wp-video-shortcode' ).mediaelementplayer();
			}
		}
	};

}( jQuery );

;( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		SonicInfiniteScroll.init();
	} );

} )( jQuery );