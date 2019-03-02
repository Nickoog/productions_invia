/*!
 * Front end plugin methods
 *
 * Wolf Page Builder 2.9.3
 */
/* jshint -W062 */
/* global DocumentTouch,
WPBParams,
WPBYTVideoBg,
WPBSliders,
WPBAccordion,
WPBTabs,
WPBToggles,
WPBProcess,
WPBButtons,
WPBIcons,
WPBCounter,
WPBMailchimp,
WPBTyped,
WPBCountdown,
WPBCarousels,
WolfFrameworkJSParams,
WOW
*/

var WPB = function( $ ) {

	'use strict';

	return {
		doParallax : true,
		doAnimation : true,
		body : $( 'body' ),
		isMobile : ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? true : false,
		isApple : ( navigator.userAgent.match( /(Safari)|(iPad)|(iPhone)|(iPod)/i ) && navigator.userAgent.indexOf( 'Chrome' ) === -1 && navigator.userAgent.indexOf( 'Android' ) === -1 ) ? true : false,
		supportSVG : !! document.createElementNS && !! document.createElementNS( 'https://www.w3.org/2000/svg', 'svg').createSVGRect,
		isTouch : 'ontouchstart' in window || window.DocumentTouch && document instanceof DocumentTouch,

		/**
		 * Init functions
		 */
		init : function () {

			var _this = this;

			$( window ).trigger( 'resize' ); // trigger resize event to force all window size related calculation
			$( window ).trigger( 'scroll' ); // trigger scroll event to force all window scroll related calculation

			this.doParallax = ( ! this.isMobile ) || ( this.isMobile && WPBParams.doParallaxOnMobile );
			this.doAnimation = ( ! this.isMobile ) || ( this.isMobile && WPBParams.doAnimationOnMobile );

			this.setClasses();

			this.videoBackground();
			this.playButton();
			this.muteButton();

			this.fullHeightSection();

			this.parallax();

			this.fitText();

			this.bigText();

			this.fluidVideos();

			this.wowAnimate();

			this.youtubeWmode();

			this.closeAlertMessage();

			this.lightbox();

			this.videoShortcode();

			this.scrollDownArrow();

			this.smoothScroll();

			this.relGalleryAttr();

			this.maps();

			this.lazyLoad();

			/**
			 * Resize event
			 */
			$( window ).resize( function() {
				_this.fullHeightSection();
				_this.videoBackground();
				_this.videoShortcode();
				_this.scrollDownArrowDisplay();
			} ).resize();
		},

		/**
		 * Check if IE
		 */
		isIE : function () {
			var ua = window.navigator.userAgent,
				msie = ua.indexOf( 'MSIE ' ),
				trident = ua.indexOf( 'Trident/' );

			if ( msie > 0 ) {
				return true;
			}

			if ( trident > 0 ) {
				// IE 11 (or newer) => return version number
				return true;
			}

			// other browser
			return false;
		},

		setClasses : function () {

			if ( this.supportSVG ) {
				$( 'html' ).addClass( 'wpb-svg' );
			}

			if ( this.isTouch ) {
				$( 'html' ).addClass( 'wpb-touch' );
			} else {
				$( 'html' ).addClass( 'wpb-no-touch' );
			}

			if ( this.isMobile ) {
				this.body.addClass( 'wpb-is-mobile' );
			}

			if ( this.doParallax ) {
				this.body.addClass( 'wpb-do-parallax' );
			}

			if ( this.isApple ) {
				this.body.addClass( 'wpb-is-apple' );
			}
		},

		/**
		 * Get admin toolbar offset
		 */
		getToolBarOffset : function () {

			var scrollOffset = 0;

			if ( $( 'body' ).is( '.admin-bar' ) ) {

				if ( 782 < $( window ).width() ) {
					scrollOffset = 32;
				} else {
					scrollOffset = 46;
				}
			}

			return parseInt( scrollOffset, 10 );
		},

		/**
		 * Set element height to full screen
		 */
		fullHeightSection : function() {
			var _this = this,
				scrollOffset = _this.getToolBarOffset(),
				bleed = 2;

			if ( $( '.wpm-sticky-playlist-container' ).length ) {
				scrollOffset += $( '.wpm-sticky-playlist-container' ).height();
			}

			$( '.wpb-section-full-height' ).each( function() {
				$( this ).css( { 'height' : $( window ).height() - scrollOffset + bleed } );
			} );
		},

		/**
		 * Fluid Video wrapper
		 */
		fluidVideos : function ( container ) {

			container = container || $( '.wpb-section-inner' );

			var videoSelectors = [
				'iframe[src*="player.vimeo.com"]',
				'iframe[src*="youtube.com"]',
				'iframe[src*="youtube-nocookie.com"]',
				'iframe[src*="youtu.be"]',
				'iframe[src*="kickstarter.com"][src*="video.html"]',
				'iframe[src*="screenr.com"]',
				'iframe[src*="blip.tv"]',
				'iframe[src*="dailymotion.com"]',
				'iframe[src*="viddler.com"]',
				'iframe[src*="qik.com"]',
				'iframe[src*="revision3.com"]',
				'iframe[src*="hulu.com"]',
				'iframe[src*="funnyordie.com"]',
				'iframe[src*="flickr.com"]',
				'embed[src*="v.wordpress.com"]'
			];

			container.find( videoSelectors.join( ',' ) ).wrap( '<span class="wpb-fluid-video" />' );
			$( '.wpb-fluid-video' ).parent().addClass( 'wpb-fluid-video-container' );
		},

		/**
		 * Video Background
		 */
		videoBackground : function () {

			var _this = this;

			$( '.wpb-video-bg-container').each( function() {
				var videoContainer = $( this ),
					containerWidth = $( this ).width(),
					containerHeight = $( this ).height(),
					ratioWidth = 640,
					ratioHeight = 360,
					//ratio = ratioWidth/ratioHeight,
					$video = $( this ).find( '.wpb-video-bg' ),
					//video = document.getElementById( $video.attr( 'id' ) ),
					newHeight,
					newWidth,
					newMarginLeft,
					newMarginTop,
					newCss;

				if ( videoContainer.hasClass( 'wpb-youtube-video-bg-container' ) ) {
					
					$video = videoContainer.find( 'iframe' );
					ratioWidth = 560;
					ratioHeight = 315;

				} else if ( videoContainer.hasClass( 'wpb-vimeo-video-bg-container' ) ) {
					
					$video = videoContainer.find( 'iframe' );
					ratioWidth = 560;
					ratioHeight = 315;

				} else {

					if ( _this.isMobile ) {
						// console.log( this.isTouch );
						videoContainer.find( '.wpb-video-bg-fallback' ).css( { 'z-index' : 1 } );
						$video.remove();
						return;
					} else {
						// Safari fix
						$video.prop( 'muted', true );
						setTimeout( function () {
							$video.get(0).play();
						}, 500 );
					}
				}

				if ( ( containerWidth / containerHeight ) >= 1.8 ) {
					newWidth = containerWidth;

					// console.log( containerWidth / containerHeight );

					newHeight = Math.ceil( ( containerWidth/ratioWidth ) * ratioHeight ) + 2;
					newMarginTop =  - ( Math.ceil( ( newHeight - containerHeight  ) ) / 2 );
					newMarginLeft =  - ( Math.ceil( ( newWidth - containerWidth  ) ) / 2 );

					newCss = {
						width : newWidth,
						height : newHeight,
						marginTop :  newMarginTop,
						marginLeft : newMarginLeft
					};

					$video.css( newCss );

				} else {

					// console.log( containerHeight );

					newHeight = containerHeight;
					newWidth = Math.ceil( ( containerHeight/ratioHeight ) * ratioWidth );
					newMarginLeft =  - ( Math.ceil( ( newWidth - containerWidth  ) ) / 2 );

					newCss = {
						width : newWidth,
						height : newHeight,
						marginLeft :  newMarginLeft,
						marginTop : 0
					};

					$video.css( newCss );
				}
			} );
		},

		/**
		 * Video play button
		 */
		playButton : function () {

			$( '.wpb-video-bg-play-button' ).on( 'click', function () {
				var $button = $( this ),
					$section = $button.parents( '.wpb-section' ),
					$video = $section.find( '.wpb-video-bg' ),
					videoId = $video.attr( 'id' ),
					video = document.getElementById( videoId ),
					videoSelector = $video;

				if ( videoSelector.hasClass( 'paused' ) ) {
					video.play();
					videoSelector.removeClass( 'paused' );
					$button.removeClass( 'pause' );
				} else {
					video.pause();
					videoSelector.addClass( 'paused' );
					$button.addClass( 'pause' );
				}
			} );
		},

		/**
		 * Video mute button
		 */
		muteButton : function () {

			$( '.wpb-video-bg-mute-button' ).on( 'click', function () {

				var $button = $( this ),
					$section = $button.parents( '.wpb-section' ),
					$video = $section.find( '.wpb-video-bg' ),
					videoId = $video.attr( 'id' ),
					video = document.getElementById( videoId ),
					videoSelector = $video;

				if ( videoSelector.hasClass( 'unmuted' ) ) {
					video.muted = true;
					videoSelector.removeClass( 'unmuted' );
					$button.removeClass( 'unmute' );
				} else {
					video.muted = false;
					videoSelector.addClass( 'unmuted' );
					$button.addClass( 'unmute' );
				}
			} );
		},

		/**
		 * Use Wow plugin to reveal animation on page scroll
		 */
		wowAnimate : function () {
			if ( this.doAnimation ) {
				var wowAnimate = new WOW( { offset : 50 } ); // init wow for CSS animation
				wowAnimate.init();
			}
		},

		/**
		 * Fix wmode  with youtube videos
		 */
		youtubeWmode : function() {

			var iframes, $iframes,
				youtubeSelector = [
					'iframe[src*="youtube.com"]',
					'iframe[src*="youtu.be"]',
					'iframe[src*="youtube-nocookie.com"]'
				];

			iframes = youtubeSelector.join( ',' );
			$iframes = $( iframes );

			if ( $iframes.length ) {

				$iframes.each(function(){

					var url = $( this ).attr( 'src' );

					if ( url  ) {

						if ( url.indexOf( '?' ) !== -1) {

							// if attribute is not already there
							if ( ! url.match( '/wmode=transparent/' ) ) {
								$( this ).attr( 'src', url + '&wmode=transparent' );
							}

						} else {

							$( this ).attr( 'src', url + '?wmode=transparent' );
						}
					}
				} );
			}
		},

		/**
		 * Fittext
		 */
		fitText : function () {
			$( '.wpb-fittext' ).each( function() {
				var maxFontSize = $( this ).data( 'max-font-size' ) || 60;
				$( this ).fitText( 1.2, { minFontSize: '14px', maxFontSize: maxFontSize + 'px' } );
			} );
		},

		/**
		 * bigText
		 */
		bigText : function () {
			$( '.wpb-bigtext' ).each( function() {
				$( this ).bigtext();
			} );
		},

		/**
		 * Close alert message
		 */
		closeAlertMessage : function () {

			$( '.wpb-notification-close' ).on( 'click', function() {
				$( this ).parents( '.wpb-notification' ).slideUp();
			} );
		},

		/**
		 *  Parallax Background
		 */
		parallax : function () {

			if ( this.doParallax ) {
				$( '.wpb-parallax-window' ).each( function () {
					var $this = $( this ),
						//naturalWidth = $this.data( 'natural-width' ),
						//naturalHeight = $this.data( 'natural-height' ),
						backgroundImageUrl = $this.data( 'background-url' );

					$this.parallax( {
						imageSrc : backgroundImageUrl,
						//naturalWidth : naturalWidth,
						//naturalHeight : naturalHeight,
						mainContainer :'#page'
					} );
				} );
			}
		},

		/**
		 *  Lightbox
		 */
		lightbox : function () {

			var _this = this;

			// add rel attribute for galleries
			$( '.wpb-gallery .wpb-lightbox' ).each( function() { $( this ).attr( 'rel', 'gallery' ); } );

			if ( 'swipebox' === WPBParams.lightbox && $.isFunction( $.swipebox ) ) {

				$( '.wpb-lightbox, .wpb-gallery-lightbox' ).swipebox();

				$( '.wpb-video-lightbox' ).swipebox( {
					hideBarsDelay : 0,
					afterOpen : function () {
						_this.setVimeoOptions();
					}
				} );
			
			} else if ( 'fancybox' === WPBParams.lightbox ) {

				$( '.wpb-lightbox, .wpb-gallery-lightbox' ).fancybox();

				$( '.wpb-video-lightbox' ).fancybox( {
					padding : 0,
					nextEffect : 'none',
					prevEffect : 'none',
					openEffect  : 'none',
					closeEffect : 'none',
					helpers : {
						media : {},
						title : {
							type : 'outside'
						},
						overlay : {
							opacity: 0.9
						}
					}
				} );
			}
		},

		/**
		 * Remove title from vimeo videos
		 */
		setVimeoOptions : function() {

			var iframes, $iframes,
				vimeoSelector = [
					'iframe[src*="player.vimeo.com"]'
				];

			iframes = vimeoSelector.join( ',' );
			$iframes = $( iframes );

			if ( $iframes.length ) {

				$iframes.each(function(){

					var url = $( this ).attr( 'src' );

					if ( url ) {

						if ( url.indexOf( '?' ) !== -1) {

							$( this ).attr( 'src', url + '&title=0&byline=0&portrait=0' );

						} else {

							$( this ).attr( 'src', url + '?title=0&byline=0&portrait=0' );
						}
					}
				} );
			}
		},

		/**
		 * Make WP video shortcode responsive
		 */
		videoShortcode : function () {

			$( '.wpb-section .wp-video' ).each( function() {
				var $this = $( this ),
					width = $this.parent().width(),
					height = Math.floor( ( width/16 ) * 9 );

				$this.css( {
					'width' : width,
					'height' : height
				} );
			} );
		},

		/**
		 * Trick to customize the embed tweet
		 */
		loadTwitter : function() {

			var tweet = $( '.twitter-tweet-rendered' ),
				tweetItems = $( '.post.is-tweet' );

			setTimeout( function() {
				if ( tweet.length ) {
					tweet.each( function() {
						$( this ).removeAttr( 'style' )
						.attr( 'height' , 'auto' )
						.animate( { 'opacity' : 1 } );
					} );
				}

				if ( tweetItems.length ) {
					tweetItems.each( function() {
						$( this ).animate( { 'opacity' : 1} );
					} );
				}
			}, 500 );
		},

		/**
		 * Instagrams fade in
		 */
		loadInstagram : function() {
			var instagramItems = $( '.post-item.is-instagram' );

			if ( instagramItems.length ) {
				instagramItems.each( function() {
					$( this ).animate( { 'opacity' : 1} );
				} );
			}
		},

		/**
		 * Hide the scroll down arrow if height is too small
		 */
		scrollDownArrowDisplay : function () {
			var $arrow,
				$section,
				$sectionInner,
				sectionInnerHeight = 0,
				marginOffset = 250;

			$( '.wpb-arrow-down' ).each( function() {
				$arrow = $( this ),
				$section = $arrow.parent(),
				$sectionInner = $section.find( '.wpb-section-inner' ),
				sectionInnerHeight = 0;

				$sectionInner.find( '.wpb-row' ).each( function() {
					sectionInnerHeight += $( this ).height();
				} );

				//console.log( 'innder ' + sectionInnerHeight );
				//console.log( 'win ' + $( window ).height() );

				if ( $( window ).height()  <= sectionInnerHeight + marginOffset ) {

					$arrow.hide();

				} else {
					$arrow.show();
				}
			} );
		},

		/**
		 * Smooth scroll
		 */
		smoothScroll : function () {
			var _this = this;

			$( '.wpb-nav-scroll a, .wpb-scroll, .wpb-scroll a' ).on( 'click', function( event ) {

				event.preventDefault();
				event.stopPropagation();

				var menuOffset = 0,
					toolBarOffset = _this.getToolBarOffset(),
					$this = $( this ),
					href = $this.attr( 'href' ),
					$targetSection,
					hash;

				if ( href && href.indexOf( '#' ) !== -1 ) {

					hash = href.substring( href.indexOf( '#' ) + 1 );

					$targetSection = $( '#' + hash );

					if ( $targetSection.hasClass( 'wpb-section-full-height' ) ) {

						menuOffset = 0;

						//console.log( 'no offset' );

					} else {
						menuOffset = _this.getMenuOffsetFromTheme();

						//console.log( 'do offset' );
					}

					if ( $targetSection.length ) {
						
						$( 'html, body' ).stop().animate( {
							
							scrollTop: $targetSection.offset().top - toolBarOffset - menuOffset
						
						}, 1E3, 'swing', function() {

							if ( '' !== hash ) {
								// push hash
								history.pushState( null, null, '#' + hash );
								//window.location.hash = hash;
							}
						} );
					}
				}
			} );
		},

		/**
		 * Display an arrow to scroll to the next section
		 */
		scrollDownArrow : function () {
			var _this = this,
				$this,
				$arrow,
				$section = $( '.wpb-section' ),
				$nextSection,
				$targetSection,
				menuOffset = 0,
				toolBarOffset = 0,
				sectionOffsetTop,
				hash;

			$section.each( function( i ) {

				$this = $( this ),
				$arrow = $this.find( '.wpb-arrow-down' ),
				$nextSection = $section.eq( i + 1 ),
				toolBarOffset = _this.getToolBarOffset();

				if ( $arrow && 0 < $nextSection.length ) {

					$this.addClass( 'wpb-has-next-section' );

					$arrow.on( 'click', function( event ) {

						event.preventDefault();
						event.stopPropagation();

						$targetSection = $( this ).parent().parent().next( '.wpb-section-container' );
						sectionOffsetTop = parseInt( $targetSection.offset().top, 10 );

						if ( $targetSection.find( '.wpb-section' ).hasClass( 'wpb-section-full-height' ) ) {

							menuOffset = 0;

							// console.log( 'no offset' );

						} else {
							menuOffset = _this.getMenuOffsetFromTheme();

							// console.log( 'do offset' );
						}

						if ( $targetSection.find( '.wpb-section' ).attr( 'id' ) ) {
							hash = $targetSection.find( '.wpb-section' ).attr( 'id' );
						}

						$( 'html, body' ).stop().animate( {

							scrollTop: sectionOffsetTop - toolBarOffset - menuOffset

						}, 1200, 'swing', function() {

							if ( '' !== hash && 'undefined' !== typeof hash ) {
								// push hash
								history.pushState( null, null, '#' + hash );
								//window.location.hash = hash;
							}
						} );
					} );

				} else {
					$this.addClass( 'wpb-no-next-section' );
				}
			} );
		},

		/**
		 * Get menu offset from Theme if available
		 */
		getMenuOffsetFromTheme : function () {

			var menuOffset = 0;

			if ( ! $.isEmptyObject( WolfFrameworkJSParams ) ) {

				// if mobile
				if ( WolfFrameworkJSParams.menuOffsetMobile && $( 'body' ).hasClass( 'mobile' ) ) {

					menuOffset = WolfFrameworkJSParams.menuOffsetMobile;

				// if tablet
				} else if ( WolfFrameworkJSParams.menuOffsetBreakpoint && ! $( 'body' ).hasClass( 'desktop' ) ) {

					menuOffset = WolfFrameworkJSParams.menuOffsetBreakpoint;

				// if desktop
				} else if ( WolfFrameworkJSParams.menuOffsetDesktop ) {

					menuOffset = WolfFrameworkJSParams.menuOffsetDesktop;

				// if default
				} else if ( WolfFrameworkJSParams.menuOffset ) {

					menuOffset = WolfFrameworkJSParams.menuOffset;
				}
			}

			// console.log( menuOffset );

			return parseInt( menuOffset, 10 );
		},

		/**
		 * Set gallery rel attribute for HTML validation
		 */
		relGalleryAttr : function () {
			$( '.wolf-images-gallery .wpb-image-inner, .wpb-item-price-image-container a' ).each( function() {
				if ( $( this ).data( 'wpb-rel' ) ) {
					$( this ).attr( 'rel', $( this ).data( 'wpb-rel' ) );
				}
			} );
		},

		/**
		 * Google map fix to avoid scroll
		 */
		maps : function () {
			$( '.wpb-map-container' ).click( function () {
				$( '.wpb-map-container iframe' ).css( 'pointer-events', 'auto' );
			} );

			$( '.wpb-map-container' ).mouseleave( function() {
				$( '.wpb-map-container iframe' ).css( 'pointer-events', 'none' );
			} );
		},

		/**
		 * Function to fire on page load
		 */
		pageLoad : function () {

			$( window ).trigger( 'resize' ); // trigger resize event to force all window size related calculation
			$( window ).trigger( 'scroll' ); // trigger scroll event to force all window scroll related calculation

			this.videoShortcode();
			this.loadInstagram();
			this.loadTwitter();

			$( 'body' ).addClass( 'wpb-loaded' );
		},

		/**
		 * Lazy load gallery image
		 */
		lazyLoad : function () {

			if ( WPBParams.doLazyLoad ) {
				$( 'img.lazy-hidden' ).lazyLoadXT();
			}
		},

		/**
		 * AJAX Callback
		 *
		 * Reinitiate all plugins.
		 * This function can be called after an AJAX request to restore all JS functionality
		 */
		ajaxCallback : function () {

			this.init();
			this.fullHeightSection();

			if ( 'undefined' !== typeof WPBYTVideoBg ) {
				WPBYTVideoBg.playVideo();
			}

			// Sliders
			if ( 'undefined' !== typeof WPBSliders ) {
				WPBSliders.init();
			}

			// Accordion
			if ( 'undefined' !== typeof WPBAccordion ) {
				WPBAccordion.init();
			}

			// Tabs
			if ( 'undefined' !== typeof WPBTabs ) {
				WPBTabs.init();
			}

			// Toggles
			if ( 'undefined' !== typeof WPBToggles ) {
				WPBToggles.init();
			}

			// Process
			if ( 'undefined' !== typeof WPBProcess ) {
				WPBProcess.init();
			}

			// Buttons and calls to action
			if ( 'undefined' !== typeof WPBButtons ) {
				WPBButtons.init();
			}

			// Icons
			if ( 'undefined' !== typeof WPBIcons ) {
				WPBIcons.init();
			}

			// Counter
			if ( 'undefined' !== typeof WPBCounter ) {
				WPBCounter.init();
			}

			// Mailchimp
			if ( 'undefined' !== typeof WPBMailchimp ) {
				WPBMailchimp.init();
			}

			// Typed
			if ( 'undefined' !== typeof WPBTyped ) {
				WPBTyped.init();
			}

			// Count down
			if ( 'undefined' !== typeof WPBCountdown ) {

				WPBCountdown.init();
				$( '.wpb-countdown-container' ).addClass( 'wpb-countdown-container-loaded' );
			}

			// Carousels
			if ( 'undefined' !== typeof WPBCarousels ) {
				WPBCarousels.init();
			}
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WPB.init();
	} );

	$( window ).load( function() {
		WPB.pageLoad();
	} );

} )( jQuery );