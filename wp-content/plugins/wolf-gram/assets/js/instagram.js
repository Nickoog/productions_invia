/*!
 * WolfGram
 *
 * Wolf Gram 1.5.1
 */
/* jshint -W062 */
/* global DocumentTouch */
var WolfGram = WolfGram || {},
	console = console || {};

WolfGram = function( $ ) {

	'use strict';

	return {

		init : function() {
			
			this.setRelAttr();

			$( '.wolf-instagram-item-container' ).css( { height : $( '.wolf-instagram-item-container' ).first().width() } );

			$( window ).resize( function() {
				$( '.wolf-instagram-item-container' ).css( { height : $( '.wolf-instagram-item-container' ).first().width() } );
			} );
		},

		setRelAttr : function () {
			$( '#wolf-instagram .wolf-instagram-item a' ).each( function() {
				$( this ).attr( 'rel', 'wolfgram-gallery' );
			} );

			$( '.wolf-instagram-list li a' ).each( function() {
				$( this ).attr( 'rel', 'wolfgram-widget-gallery' );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WolfGram.init();
	} );

} )( jQuery );


