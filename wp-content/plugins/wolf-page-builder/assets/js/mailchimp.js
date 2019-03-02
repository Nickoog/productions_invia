/*!
 * Mailchimp
 *
 * Wolf Page Builder 2.9.3 
 */
/* jshint -W062 */
var WPBMailchimp =  WPBMailchimp || {},
	WPBMailchimpParams =  WPBMailchimpParams || {},
	console = console || {};

WPBMailchimp = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			
			$( '.wpb-mailchimp-submit' ).on( 'click', function( event ) {
				event.preventDefault();

				var message = '',
					$submit = $( this ),
					$form = $submit.parents( '.wpb-mailchimp-form' ),
					$result = $form.find( '.wpb-mailchimp-result' ),
					list_id = $form.find( '.wpb-mailchimp-list' ).val(),
					email = $form.find( '.wpb-mailchimp-email' ).val(),
					data = {

						action : 'wpb_mailchimp_ajax',
						list_id : list_id,
						email : email
					};

				$result.animate( { 'opacity' : 0 } );

				$.post( WPBMailchimpParams.ajaxUrl, data, function( response ) {
					if ( response ) {
						
						message = response;
					
					} else {
						message = 'An error occured';
					}

					$result.html( response ).animate( { 'opacity' : 1 } );
					setTimeout( function() {
						$result.animate( { 'opacity' : 0 } );
					}, 3000 );
				} );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	// $( window ).load( function() {
	$( document ).ready( function() {
		WPBMailchimp.init();
	} );

} )( jQuery );