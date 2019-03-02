/*!
 * Plugin toggles
 *
 * Wolf Page Builder 2.9.3 
 */
/* jshint -W062 */

var WPBToggles =  WPBToggles || {},
	console = console || {};

WPBToggles = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			$( '.wpb-toggle-title span' ).on( 'click', function() {

				var $this = $( this ),
					container = $this.parents( '.wpb-toggle' ),
					content = container.find( '.wpb-toggle-content' );

				if ( container.hasClass( 'wpb-toggle-open' ) ) {
					
					content.slideUp( 'fast' );

					setTimeout( function() {
						container.removeClass( 'wpb-toggle-open' );
					}, 500 );
				
				} else {
					setTimeout( function() {
						container.removeClass( 'wpb-toggle-close' );
						container.addClass( 'wpb-toggle-open' );
					}, 500 );
					
					content.slideDown( 'fast' );
				}
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	// $( window ).load( function() {
	$( document ).ready( function() {
		WPBToggles.init();
	} );

} )( jQuery );