/*!
 * Plugin counter
 *
 * Wolf Page Builder 2.9.3 
 */
/* jshint -W062 */
/* global Waypoint,
Waypoint,
CountUp */

var WPBCounter = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			$( '.wpb-counter' ).each( function() {
				var $counter = $( this ),
					containerId = $counter.parent().attr( 'id' ),
					couterId = $( this ).attr( 'id' ),
					end = $counter.data( 'end' ) || 1000,
					duration = $counter.data( 'duration' ) || 2.5;
					//delay = $counter.data( 'delay' ) || 10;

				var options = {
					useEasing : false, 
					useGrouping : true, 
					separator : ',', 
					decimal : '.', 
					prefix : '', 
					suffix : '' 
				};

				//var demo = new CountUp("counterupJSElement", setting.start, setting.end, setting.decimals, setting.duration, options);
				var counter = new CountUp( couterId, 0, end, 0, duration, options);
				//demo.start();

				new Waypoint( {
					
					element: document.getElementById( containerId ),
					
					//handler: function( direction ) {
					handler: function() {

						counter.start();

					},
					offset: '88%'
				} );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WPBCounter.init();
	} );

} )( jQuery );

