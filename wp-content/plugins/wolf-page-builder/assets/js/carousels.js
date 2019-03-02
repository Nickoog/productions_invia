/*!
 * Plugin carousels
 *
 * Requires owl.carousel.js
 *
 * Wolf Page Builder 2.9.3 
 */
/* jshint -W062 */
var WPBCarousels =  WPBCarousels || {},
	WPB = WPB || {},
	WPBParams =  WPBParams || {},
	console = console || {};

WPBCarousels = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			this.testimonials();
			this.carouselGallery();
			this.videoCarousel();
			this.clientCarousel();
		},

		/**
		 * Image gallery carousel
		 */
		carouselGallery : function () {
			$( '.wpb-carousel-gallery' ).owlCarousel( {
				dots : false,
				loop : true,
				margin : 0,
				nav : true,
				autoplay : false,
				autoplayTimeout : 4000,
				autoplayHoverPause : true,
				responsive : {
					0 : {
						items : 1
					},
					600 : {
						items : 3
					},
					1000 : {
						items : 5
					}
				},
				onRefreshed : function() {
					WPB.lightbox();
				}
			} );
		},

		/**
		 * Video carousel
		 */
		videoCarousel : function () {

			$( '.wpb-video-carousel' ).owlCarousel( {
				dots : true,
				items: 1,
				merge: true,
				loop: true,
				margin: 10,
				video: true,
				center: true,
				responsive:{
					480:{
						items:2
					},
					600:{
						items:4
					}
				}
			} );
		},

		/**
		 * Client carousel
		 */
		clientCarousel : function () {

			$( '.wpb-client-carousel' ).owlCarousel( {
				dots : false,
				loop : true,
				margin : 0,
				nav : true,
				autoplay : false,
				autoplayTimeout : 4000,
				autoplayHoverPause : true,
				responsive : {
					0 : {
						items : 1
					},
					500 : {
						items : 3
					},
					800 : {
						items : 4
					}
				}
			} );
		},

		/**
		 * Testomonials slider
		 */
		testimonials : function () {
			// var defaultTransition = ( Modernizr.isTouch ) ? 'slide' : 'fade';
			var defaultTransition = 'slide';

			$( '.wpb-testimonials-slider' ).each( function () {
				
				var $slider = $( this ),
					transition,
					dataAutoplay = $slider.data( 'autoplay' ),
					dataSpeed = $slider.data( 'slideshow-speed' ),
					dataPauseonHover = $slider.data( 'pause-on-hover' ),
					dataTransition = $slider.data( 'transition' ),
					dataNavbullets = $slider.data( 'nav-bullets' ),
					dataArrows = $slider.data( 'nav-arrows' );

				transition = ( 'auto' === dataTransition ) ? defaultTransition : dataTransition;

				$slider.owlCarousel( {
					mouseDrag : false,
					loop : true,
					items : 1,
					autoplay : dataAutoplay,
					autoplayTimeout: dataSpeed,
					autoplayHoverPause : dataPauseonHover,
					nav : dataArrows,
					dots : dataNavbullets
				} );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	// $( window ).load( function() {
	$( document ).ready( function() {
		WPBCarousels.init();
	} );

} )( jQuery );