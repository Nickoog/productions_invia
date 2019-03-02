/**
 * Includes all the logic to manage the page builder backend
 *
 */
var WolfPageBuilderPointers = WolfPageBuilderPointers || {},
	console = console || {},
	WPBAdminParams = WPBAdminParams || {};

/* jshint -W062 */
WolfPageBuilderPointers = function ( $ ) {

	'use strict';

	return {
		
		/**
		 * Init UI
		 */
		init : function () {
			this.addAdminPointers();
		},

		/**
		 * Show admin pointer helper
		 */
		addAdminPointers : function ( node ) {

			$( node).pointer( {
				content: pointer.options.content,
				position: {
					edge: 'left',
					align: 'left'
				},
				close: function() {
					$.post( WPBAdminParams .ajaxurl, {
						pointer: node.attr( 'id' ),
						action: 'dismiss-wp-pointer'
					} );
				}
			} ).pointer( 'open' );
		},

	};

}( jQuery );


;( function( $ ) {

	'use strict';
	WolfPageBuilderPointers.init();

} )( jQuery );