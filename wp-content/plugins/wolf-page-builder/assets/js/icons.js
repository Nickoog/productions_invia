/*!
 * Plugin icon
 *
 * Wolf Page Builder 2.9.3 
 */
/* jshint -W062 */
var WPBIcons =  WPBIcons || {},
	console = console || {};

WPBIcons = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			$( '.wpb-icon' ).each( function() {
				var $icon = $( this ),
					color = $icon.css( 'color' ),
					colorHover = $icon.data( 'icon-hover-color' );

				if ( colorHover ) {

					$icon.hover(
						function() {
							$icon.css( {
								'color' : colorHover
							} );
						},
						function() {
							$icon.css( {
								'color' : color
							} );
						}
					);
				}
			} );

			$( '.wpb-icon-container' ).each( function() {
				var $iconContainer = $( this ),
					color = $iconContainer.css( 'background-color' ),
					colorHover = $iconContainer.data( 'bg-hover-color' ),
					border = $iconContainer.css( 'border-color' ),
					borderHover = $iconContainer.data( 'border-hover-color' );

				if ( colorHover ) {

					$iconContainer.hover(
						function() {
							$iconContainer.css( {
								'background-color' : colorHover
							} );
						},
						function() {
							$iconContainer.css( {
								'background-color' : color
							} );
						}
					);
				}

				if ( borderHover ) {

					$iconContainer.hover(
						function() {
							$iconContainer.css( {
								'border-color' : borderHover
							} );
						},
						function() {
							$iconContainer.css( {
								'border-color' : border
							} );
						}
					);
				}
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WPBIcons.init();
	} );

} )( jQuery );