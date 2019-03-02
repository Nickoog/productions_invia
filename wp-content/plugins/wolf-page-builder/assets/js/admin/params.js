/**
 * Open WP media manager
 */
var WPBAdminParams =  WPBAdminParams || {};

;( function( $ ) {

	'use strict';
	
	/**
	 * Set image
	 */
	$( document ).on( 'click', '.wpb-param-set-img, .wpb-param-set-bg', function( e ) {
		e.preventDefault();

		var $el = $( this ).parent(),
			size = $el.parents( 'form' ).find( '.wpb-param-fieldset > select[name=image_size]' ).val(),
		uploader = wp.media( {
			title : WPBAdminParams.chooseImage,
			library : { type : 'image'},
			multiple : false
		} )
		.on( 'select', function() {

			$( '<div id="wpb-image-loading" />' ).insertAfter( $el.find( '.wpb-param-img-preview' ) );

			if ( undefined === size ) {

				if ( $el.parents( 'form' ).find( '[name=image_size]' ).length ) {
					size = $el.parents( 'form' ).find( '[name=image_size]' ).val();
				} else {
					size = 'wpb-XL';
				}
			}

			// console.log( size );

			var selection = uploader.state().get( 'selection' ),
				attachment = selection.first().toJSON(),
				data = {
					action : 'wpb_ajax_get_url_from_attachment_id',
					attachmentId : attachment.id,
					size : size
				};
			
			// if ( WPBAdminParams.isDev ) {
				
			// 	$.post( WPBAdminParams.adminUrl, data, function( response ) {

			// 		// console.log( response );

			// 		if ( response ) {
			// 			$( 'input', $el ).val( response );
			// 		}
			// 	} );
			
			// } else {
			// 	$( 'input', $el ).val( attachment.id );
			// }

			$( 'input', $el ).val( attachment.id );

			$( 'img', $el ).attr( 'src', attachment.url ).show();
			$( '#wpb-image-loading' ).remove();
		} )
		.open();
	} );

	/**
 	 * make sure the previews are sortable 
 	 */
 	$( '.wpb-images-set' ).sortable( {
		update : function() {
			$( this ).parent().find( 'input' ).html( $( this ).sortable( 'toArray', { attribute: 'data-attachment-id' } ) );
		},
		helper: 'clone',
		items: '.wpb-image'
	} );

	/**
	 * activate media uploader to select multiple images for a slideshow
	 */
	$( document ).on( 'click', '.wpb-param-set-multiple-img', function( e ) {
		e.preventDefault();
		/* if there is a frame created, use it */
		if ( frame ) {
			frame.open();
			return;
		}
		/* get the hidden input ID from the button's inputid data attribute */
		var $el = $( this ).parent(),
			input = $el.find( 'input' ),
			size = $el.parents( 'form' ).find( '.wpb-param-fieldset > select[name=image_size]' ).val(),
		
		/* open the wp.media frame with our localised title */
		frame = wp.media.frames.file_frame = wp.media( {
			title : WPBAdminParams.chooseMultipleImage,
			library : { type : 'image' },
			multiple : 'add',
			button : { text : WPBAdminParams.chooseMultipleImage }
		} );

		frame.on( 'close', function() {
			/* get the selection object */
			var selection = frame.state().get('selection'),
				/* array variable to hold new image IDs */
				imageIDs = [],
				/* variable to hold new HTML for the preview */
				newImages = '',
				length = selection.length,
				images = selection.models,
				ids = [];

			/* maps a function to each selected image which constructs the preview and saves the ID */
			selection.map( function( attachment ) {
				var image = attachment.toJSON(),
					imageID,
					imageURL = ( image.sizes && image.sizes[ 'thumbnail' ] ) ? image.sizes[ 'thumbnail' ].url : image.url,
					data = {
						action : 'wpb_ajax_get_url_from_attachment_id',
						attachmentId : image.id,
						size : size
					};


				if ( image.id ) {

					imageID = image.id;
					
					if ( imageURL ) {

						imageIDs.push( imageID );

						/* jshint multistr: true */
						newImages += '<span class="wpb-image" data-attachment-id="' + imageID + '">\
							<span class="wpb-remove-img"></span>\
							<img src="' + imageURL + '">\
						</span>';
					}
				}
			} );

			// inser image IDs list in hidden input
			$( 'input', $el ).val( imageIDs );

			if ( imageIDs.length ) {
				/* populate hidden input and preview */
				$el.find( '.wpb-images-set' ).html( newImages ).sortable( 'refresh' );
			}
		} );

		/* opens the wp.media frame and selects the appropriate images */
		frame.on( 'open', function() {
			
			/* get the image IDs from the hidden input */
			var imgIDs = input.val().split( ',' ),
				/* get the selection object for the wp.media frame */
				selection = frame.state().get( 'selection' ),
				attachment;
			
			if ( imgIDs && imgIDs.length ) {
				
				/* add each image to the selection */
				$.each( imgIDs, function( idx, val ) {
					var attachment;
					
					if ( $.isNumeric( val ) ) {
						attachment = wp.media.attachment( val );
					}

					if ( attachment ) {
						attachment.fetch();
						selection.add( attachment ? [ attachment ] : [] );
					}
				} );
			}
		} );
		frame.open();
	} );

	/**
	 * Remove all images from gallery
	 */
	$( document ).on( 'click', '.wpb-param-reset-all-img', function( e ) {
		e.preventDefault();

		if ( confirm( WPBAdminParams.confirmRemoveAllImages ) ) {
			$( this ).parent().find( 'input' ).val( '' );
			$( this ).parent().find( '.wpb-images-set' ).empty();
		}
	} );

	/**
	 * Remove image from images set
	 */
	$( document ).on( 'click', '.wpb-remove-img', function( e ) {
		e.preventDefault();
		var newImages = '',
			$el = $( this ).parent(),
			$imagesSet = $el.parent(),
			$input = $imagesSet.parent().find( 'input' ),
			id = $el.data( 'attachment-id' );

		$el.fadeOut( 'fast', function() {

			$( this ).remove();
			
			$.each( $imagesSet.find( '.wpb-image' ), function() {
				
				if ( id !== $( this ).data( 'attachment-id' ) ) {
					newImages += $( this ).data( 'attachment-id' ) + ',';
				}
			} );

			$input.val( newImages );
			$imagesSet.sortable( 'refresh' );
		} );
	} );

	/**
	 * Set file
	 */
	$( document ).on( 'click', '.wpb-param-set-file', function( e ) {
		e.preventDefault();
		var $el = $( this ).parent(),
		uploader = wp.media( {
			title : WPBAdminParams.chooseFile,
			multiple : false
		} )
		.on( 'select', function() {
			var selection = uploader.state().get( 'selection' ),
				attachment = selection.first().toJSON();
			$( 'input' , $el ).val( attachment.url );
			$( 'span' , $el ).html( attachment.url ).show();
		} )
		.open();
	} );

	$( document ).on( 'click', '.wpb-param-set-video-file', function( e ) {
		e.preventDefault();
		var $el = $( this ).parent(),
		uploader = wp.media( {
			title : WPBAdminParams.chooseVideoFile,
			library : { type : 'video'},
			multiple : false
		} )
		.on( 'select', function() {
			var selection = uploader.state().get( 'selection' ),
				attachment = selection.first().toJSON();
			$( 'input' , $el ).val( attachment.url );
		} )
		.open();
	} );

	/**
	 * Remove single image
	 */
	$( document ).on( 'click', '.wpb-param-reset-img, .wpb-param-reset-bg', function( e ) {
		e.preventDefault();
		$( this ).parent().find( 'input' ).val( '' );
		$( this ).parent().find( '.wpb-param-img-preview' ).hide();
	} );

	/**
	 * Remove file
	 */
	$( document ).on( 'click', '.wpb-param-reset-file', function( e ) {
		e.preventDefault();
		$( this ).parent().find( 'input' ).val( '' );
		$( this ).parent().find( 'span' ).empty();
	} );
} )( jQuery );