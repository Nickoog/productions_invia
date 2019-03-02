/**
 * Filter by element category in the main elements list dialog box
 */
;( function( $ ) {

	'use strict';

	$( document ).on( 'click', '#wpb-element-filter a', function( event ) {
		event.preventDefault();
		var $this = $( this ),
			category = $this.data( 'category' ),
			$container = $this.parents( '.wpb-dialog-elements' ),
			$elements = $container.find( '.wpb-element' );

		if ( 'all' === category ) {
			$elements.show();
		} else {
			$elements.each( function() {
				var text = $( this ).data( 'element-category' );
				// console.log( text );
				( text.indexOf( category ) === 0 ) ? $( this ).show() : $( this ).hide();
			} );
		}
	} );

	/* Search */
	$( document ).on( 'keyup', 'input#wpb-element-search', function() {
		var valThis = $( this ).val().toLowerCase();
		
		// console.log( valThis );
		
		$( '.wpb-dialog-elements').find( '.wpb-element' ).each( function() {
			
			var text = $( this ).data( 'element-name' ).toLowerCase(),
				tags = $( this ).data( 'element-tags' ).toLowerCase(),
				reg = new RegExp( text );
						
			if ( text.indexOf( valThis ) !== -1 || tags.indexOf( valThis ) !== -1 ) {
				
				$( this ).show();
			
			} else {
				$( this ).hide();
			}
		} );
	} );

} )( jQuery );