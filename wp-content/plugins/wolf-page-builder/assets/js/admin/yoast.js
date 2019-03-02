/**
 * Yoast Compatibilty
 */
var WPBYoast = WPBYoast || {},
	console = console || {},
	WPBAdminParams = WPBAdminParams || {};

/* jshint -W062 */
WPBYoast = function ( $ ) {

	'use strict';

	return {

		pluginName : 'wpbVendorYoast',

		init : function () {
			YoastSEO.app.registerPlugin( this.pluginName, { status: 'ready' } );
			YoastSEO.app.pluginReady( this.pluginName );
			YoastSEO.app.registerModification( 'content', this.contentModification, this.pluginName, 5 );
		},

		/**
		 * Set WPB content for analysis
		 */
		contentModification : function ( data ) {
			
			var WPBStatus = $( '#wpb-status' ).val();

			if ( 'on' === WPBStatus && WPBAdminParams.wpbContent ) {

				data = WPBAdminParams.wpbContent;
			}

			//console.log( data );

			return data;
		}
	};

}( jQuery );

;( function( $ ) {

	'use strict';
	
	$( window ).on( 'YoastSEO:ready', function() {
		WPBYoast.init();
	} );

} )( jQuery );