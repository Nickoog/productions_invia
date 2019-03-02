/*!
 * Plugin process
 *
 * Wolf Page Builder 2.9.3 
 */
/* jshint -W062 */

var WPBProcess =  WPBProcess || {},
	WPB = WPB || {},
	WPBParams =  WPBParams || {},
	console = console || {};

WPBProcess = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			if ( $( '.wpb-process-container' ).length ) {
				$( '.wpb-process-container' ).each( function() {
					var $section = $( this ).parents( '.wpb-section' ),
						$row = $( this ).parents( '.wpb-row' ),
						sectionBgColor = $section.css( 'background-color' ),
						sectionBgImg = $section.css( 'background-image' ),
						hasParallax = $section.hasClass( 'wpb-section-parallax' ),
						$circle = $section.find( '.fa-stack' ),
						length = $( this ).find( 'ul li' ).length;

					$( this ).addClass( 'wpb-process-' + length + '-elements' );

					if ( 'none' === sectionBgImg && ! hasParallax && $row.hasClass( 'wpb-row-standard-width' ) ) {

						$circle.css( { 'background-color' : sectionBgColor } );

					} else {
						$( this ).addClass( 'wpb-process-no-line' );
					}
				} );
			}
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	// $( window ).load( function() {
	$( document ).ready( function() {
		WPBProcess.init();
	} );

} )( jQuery );