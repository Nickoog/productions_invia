/*!
 * Plugin youtube
 *
 * Wolf Page Builder 2.9.3 
 */
/* jshint -W062 */

var WPBYoutube =  WPBYoutube || {},
	console = console || {};

WPBYoutube = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			$( document ).on( 'click', '.wpb-youtube-play-button', function() {
 				var $this = $( this ),
 					$container = $this.parent().parent(),
					$iframe = $container.find( 'iframe' );

				$iframe[0].src += '&autoplay=1';
				$container.find( '.wpb-youtube-cover' ).delay( 500 ).fadeOut();
				$container.addClass( 'wpb-youtube-playing' );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WPBYoutube.init();
	} );

} )( jQuery );