/**
 * Close cusotm admin notice
 */
;( function( $ ) {

	'use strict';

	$( '.wpb-close-admin-notice' ).click( function() {

		$( this ).parent().parent().slideUp();
	} );

	$( '.wpb-dismiss-admin-notice' ).click( function() {

		var message = $( this ), id;

		if ( message.attr( 'id' ) ) {
			id = message.attr( 'id' );
			$.cookie( id,  'false', { path: '/', expires: 365 } );
			$( this ).parent().parent().slideUp();
		}
	} );
} )( jQuery );