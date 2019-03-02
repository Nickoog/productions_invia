/*!
 * Plugin counter
 *
 * Wolf Page Builder 2.9.3 
 */
/* jshint -W062 */

var WPBTyped =  WPBTyped || {},
	console = console || {};

WPBTyped = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			$( '.wpb-typed' ).each( function() {
				var $typed = $( this ),
					strings = $typed.data( 'string' ) || [],
					loop = $typed.data( 'loop' ) || false,
					speed = $typed.data( 'speed' ) || false;
					
				if ( [] !== strings ) {
					$typed.typed( {
						strings : strings,
						loop : loop,
						typeSpeed : speed,
						contentType: 'html'
					} );
				}
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WPBTyped.init();
	} );

} )( jQuery );