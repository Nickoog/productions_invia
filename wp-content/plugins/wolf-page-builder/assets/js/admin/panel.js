/**
 * Includes all the logic to manage the page builder backend
 *
 */
var WolfPageBuilderAdminEditor = WolfPageBuilderAdminEditor || {},
	// tinymce = tinymce || {},
	//alert = alert || function(){},
	// confirm = confirm || function(){},
	ui_dialog_interaction = ui_dialog_interaction || {},
	console = console || {},
	WPBAdminParams = WPBAdminParams || {};

/* jshint -W062 */
WolfPageBuilderAdminEditor = function ( $ ) {

	'use strict';

	return {
		tinyMCEglobalSettings : [],
		node : null,
		prepend : null,
		dialogTitle : null,
		addSectionInit : null, // flag to check if the add section event is initiated
		markup : $( '#wpb-markup' ),
		editorInUse : false,
		editor : null,
		editor_id : 'editorcontent',

		/**
		 * Init UI
		 */
		init : function () {

			var _this = this;

			// init
			this.dialogInit();
			//this.initDialogBoxes();
			this.closeDialogButton();
			this.saveDialogButton();
			// this.setSectionTitles();

			// dialog
			this.openSectionDialog();
			this.openSettingsDialog();
			this.openElementsDialog();
			//this.draggableDialog();

			// user action
			this.addNewSection();
			this.collapseSection();
			this.removeSection();
			this.removeRow();
			this.removeElement();
			this.duplicateSection();
			this.duplicateRow();
			this.duplicateElement();
			this.addNewRow();

			this.sortable();

			// 3rd party
			this.toolTip();
			this.colorPicker();
			this.fieldDependencies();

			// Import/Export
			if ( WPBAdminParams.isWPUploadsFolderWritable ) {
				this.setImportExportButtons();
				this.exportContent();
				this.importContent();
			}

			// Toggle editor
			this.toggleEditor();

			// retrieve markup from last shortcode save
			this.shortcodeToMarkup( function() {
				$( '#wpb-markup-container' ).addClass( 'wpb-markup-container-loaded' );
			} );

			$( '.wpb-refresh' ).on( 'click', function( e ) {
				e.preventDefault();
				_this.shortcodeToMarkup();
			} );

			// Preview
			this.preview(); // do nothing yet

			// Save the whole thing
			this.save();
		},

		/**
		 * Make the settings dialog box draggalble and resizable
		 */
		draggableDialog : function () {

			$( '#wpb-settings-dialog, #wpb-section-dialog' )
				.draggable()
				.resizable();
		},

		/**
		 * Set editor content
		 * deprecated
		 */
		setEditorContent : function () {

			// don't do anything if there isn't any editor in the setting fields
			if ( ! $( '#wpb-dialog-form' ).data( 'has-editor' ) ) {
				return;
			}

			if ( null === this.editor ) {
				this.editor = WPBEDITOR;
			}

			// move hidden editor to the form field
			$( '#wpb-settings-dialog > .wpb-dialog-content' ).find( '.wpb_the_editor' ).append( this.editor );

			var _this = this,
				rawContent = $( '.wpb_the_editor' ).data( 'encoded-editor-content' );

			$.post( WPBAdminParams.ajaxUrl, { action : 'wpb_ajax_decode_textarea_html', raw_content : rawContent }, function( response ) {

				_this.moveEditor( _this.editor_id );

				// add data element type
				$( '#wpb-settings-dialog > .wpb-dialog-content' ).find( '#editorcontent' ).attr( 'data-element-type', 'editor' );

				_this.editor = $( '#wpb-settings-dialog > .wpb-dialog-content' ).find( '.wpb_the_editor' ).contents();
				// $( 'button#editorcontent-tmce' ).trigger( 'click' );

				// insert saved or default content in editor
				tinyMCE.activeEditor.setContent( response );

				// cosmetic
				// $( '#wpb-settings-dialog' ).find( '.wpb-param-fieldset-editorcontent' ).animate( { 'opacity' : 1 } );

				return; // avoid odd glitch (loading loop)
			} );
		},

		/**
		 * Reset tinyMCE on moving editor
		 * deprecated
		 */
		moveEditor : function ( editor_id ) {
			tinyMCE.EditorManager.execCommand( 'mceRemoveEditor', false, editor_id );
			tinyMCE.EditorManager.execCommand( 'mceAddEditor', false, editor_id );
			// tinyMCE.EditorManager.execCommand( 'mceAddControl', false, editor_id );
		},

		/**
		 * Init default editor
		 *
		 * deprecated
		 */
		reInitEditor : function () {

			$( '.wpb-hidden-editor-container' ).append( WPBEDITOR );

			this.moveEditor( this.editor_id );

			tinyMCE.activeEditor.setContent( '' );
			// $( 'button#editorcontent-tmce' ).trigger( 'click' );
		},

		/**
		 * Generate and append import and export button
		 */
		setImportExportButtons : function () {
			var exportButton = '<form action="./" method="post"><a href="#" class="wpb-export-content wpb-tipsy button" title="' + WPBAdminParams.exportContentText + '"><span class="fa-upload" /></a></form>',
				importButton = '<a href="#" class="wpb-import-content wpb-tipsy button" title="' + WPBAdminParams.importContentText + '"><span class="fa-download" /></a>',
				ImportExportButtonsMakrup;

			ImportExportButtonsMakrup = '<div id="wpb-import-export-buttons">' + exportButton + importButton + '</div><div class="wpb-clear"></div>';

			$( ImportExportButtonsMakrup ).insertAfter( $( '#titlediv' ) );
		},

		/**
		 * Export content from text file
		 */
		exportContent : function() {

			$( '.wpb-export-content' ).on( 'click', function( event ) {
				event.preventDefault();
				event.stopPropagation();

				var markup = $( '#wpb-markup' ).html();

				// markup content
				$.post( WPBAdminParams.ajaxUrl, { action : 'wpb_ajax_get_markup_content', markup : markup }, function( response ) {

					// shortcode content
					$.post( WPBAdminParams.ajaxUrl, { action : 'wpb_ajax_get_shortcode_content', markup : response }, function( newResponse ) {

						if ( newResponse ) {
							$.generateFile( {
								filename	: WPBAdminParams.exportFileName + '.txt',
								content		: newResponse,
								script		: WPBAdminParams.pluginUrl + '/inc/admin/wpb-download.php'
							} );
						} else {
							alert( WPBAdminParams.pageIsEmpty );
						}
					} );
				} );
			} );
		},

		/**
		 * Import content from text file
		 */
		importContent : function() {
			var _this = this;

			$( document ).on( 'click', '.wpb-import-content', function( event ) {
			//$( '.wpb-import-content' ).on( 'click', function( event ) {

				event.preventDefault();

				_this.openDialog( '#wpb-import-dialog' );

				$( '#wpb-fileupload' ).fileupload( {
					dataType: 'json',
					acceptFileTypes : '/(\.|\/)(txt)$/i',
					done: function ( e, data ) {
						$.each( data.result.files, function ( index, file ) {

							data = {
								action : 'wpb_ajax_get_import_file_content',
								filename : file.name
							};

							$.post( WPBAdminParams.ajaxUrl, data, function( response ) {

								//console.log( response );

								if ( response ) {
									response = $.parseJSON( response );

									//$('<p/>').text( response.result ).appendTo( $( '#wpb-import-form' ) );

									if ( 'OK' === response.result ) {

										// $('<p/>').text( response.content ).appendTo( $( '#wpb-import-form' ) );
										// return;

										$( '#wpb_shortcodes_textarea' ).val( response.content );
										
										_this.shortcodeToMarkup();
										// _this.updateTextareas();
										_this.reInitPanel(); // re initialize new DOM
										_this.closeDialog();

									} else {
										// alert( response.content );
										_this.closeDialog();
									}
								}
							} );
						} );
					}
				} );
			} );
		},

		/**
		 * Toggle between page builder and regular WP editor
		 */
		toggleEditor : function () {

			var buttonText = ( WPBAdminParams.WPBStatus ) ? WPBAdminParams.standardMode : WPBAdminParams.pageBuilderMode,
				WPBStatus = WPBAdminParams.WPBStatus,
				toggleButton = '<a href="#" class="wpb-toggle-editor button button-primary wpb-' + WPBStatus + '" title="' + buttonText + '">' + buttonText + '</a>',
				$importExportButtons = $( '#wpb-import-export-buttons' ),
				$toggleButton,
				WPBEditor = $( '#wpb_content' ),
				WPEditor = $( '.post-type-page .postarea' ),
				WPBStatusInput = $( '#wpb-status' );

			// Insert toggle button
			$( toggleButton ).insertAfter( $( '#titlediv' ) );

			$toggleButton = $( '.wpb-toggle-editor' );

			if ( 'on' === WPBStatus ) {
				$importExportButtons.removeClass( 'wpb-hide' );
				WPBEditor.removeClass( 'wpb-hide' );
				WPEditor.hide();
				$( this ).addClass( 'wpb-on' );
				$( this ).removeClass( 'wpb-off' );
				WPBStatusInput.val( 'on' );
				$toggleButton.html( WPBAdminParams.standardMode );
			} else {
				$importExportButtons.addClass( 'wpb-hide' );
				WPBEditor.addClass( 'wpb-hide' );
				WPEditor.show();
				$( this ).removeClass( 'wpb-on' );
				$( this ).addClass( 'wpb-off' );
				WPBStatusInput.val( 'off' );
				$toggleButton.html( WPBAdminParams.pageBuilderMode );
			}

			$toggleButton.on( 'click', function() {
				// swicth off
				if ( $( this ).hasClass( 'wpb-on' ) ) {
					$importExportButtons.addClass( 'wpb-hide' );
					WPBEditor.addClass( 'wpb-hide' );
					WPEditor.show();
					$( this ).removeClass( 'wpb-on' );
					$( this ).addClass( 'wpb-off' );
					WPBStatusInput.val( 'off' );
					$toggleButton.html( WPBAdminParams.pageBuilderMode );

				// swicth on
				} else {
					$importExportButtons.removeClass( 'wpb-hide' );
					WPBEditor.removeClass( 'wpb-hide' );
					WPEditor.hide();
					$( this ).addClass( 'wpb-on' );
					$( this ).removeClass( 'wpb-off' );
					WPBStatusInput.val( 'on' );
					$toggleButton.html( WPBAdminParams.standardMode );
				}

				$( window ).trigger( 'resize' );
			} );
		},

		/**
		 * Create default content from template
		 */
		insertTemplateContent : function () {

			var _this = this,
				$shortcodeTextarea = $( '#wpb_shortcodes_textarea' ),
				data;

			$( document ).on( 'click',  '.wpb-template-img', function( event ) {

				event.preventDefault();
				
				data = {
					action : 'wpb_get_template_shortcode_markup',
					name : $( this ).attr( 'id' )
				};

				$.post( WPBAdminParams.ajaxUrl, data, function( response ) {
					// console.log( response );
					$shortcodeTextarea.val( response );
					_this.shortcodeToMarkup();
					_this.markup.removeClass( 'wpb-panel-show-templates' );
				} );
			} );
		},

		/**
		 * Show templates choices when panel is empty
		 */
		showTemplates : function () {

			if ( this.markup.is( ':empty' ) || '' === this.markup.html() || 0 === this.markup.find( 'section' ).length ) {

				var _this = this;

				$.post( WPBAdminParams.ajaxUrl, { action : 'wpb_ajax_get_templates' }, function( response ) {
					_this.markup.addClass( 'wpb-panel-show-templates' ).html( response );
					_this.insertTemplateContent();
					_this.sortable();
				} );
			}
		},

		/**
		 * Reset markup content
		 * Be sure that the panel is empty before inserting the first section
		 * Remove the default template choices
		 */
		resetPanel : function () {
			if ( this.markup.hasClass( 'wpb-panel-show-templates' ) ) {
				this.markup.empty().removeClass( 'wpb-panel-show-templates' );
			}
		},

		/**
		 * Insert element in editor
		 */
		insertElement : function ( node ) {
			node = node || null;

			$( 'body' ).addClass( 'wpb-processing' ); // flag processing
			$( '#publish' ).addClass( 'disabled' );

			var _this = this,
				$node,
				formContainer = $( '#wpb-dialog-form' ), // settings form
				form = $( '#wpb-settings-form' ), // settings form
				element = form.data( 'element' ), // element name
				hasChildren = form.data( 'element-has-child' ), // check if element has children
				child = form.data( 'element-child' ), // check if element has children
				rawContent, // column or block html content
				formData, // formatted form data
				settings = '',
				getElementParamAction = 'wpb_ajax_get_element_params',
				layoutchangeAction = 'wpb_ajax_get_section_layout',
				params = [],
				paramName,
				paramValue,
				item = {},
				layout = '',
				section_type = '',
				data = '',
				elClass = '',
				edit = false,
				tag;

			this.resetPanel();

			if ( 'section_blocks_layout' === element || 'row_columns_layout' === element ) {

				if ( 'row_columns_layout' === element ) {
					layoutchangeAction = 'wpb_ajax_get_row_layout';
				}

				formData = form.serializeArray();
				// formData = _this.serializeForm( form );

				$.each( formData, function() {

					paramName = _this.sanitizeParamName( this.name );
					paramValue = _this.sanitizeParamValue( this.value );

					if ( 'layout' === paramName ) {
						layout = paramValue;
					}

					if ( 'section_type' === paramName ) {
						section_type = paramValue;
					}
				} );

				data = {
					action: layoutchangeAction, // get markup from PHP
					layout : layout,
					section_type : section_type
				};

				// column layout change
				$.post( WPBAdminParams.ajaxUrl, data, function( response ) {

					//console.log( response );

					// hide and add class old column temporarily
					$( node ).find( '.wpb-element-container' ).addClass( 'old-col' ).hide();
					$( node ).hide().append( response ); // append new markup and hide

					// push old content in new markup
					$( node ).find( '.old-col' ).each( function( i ) {
						i++;
						$( this ).find( '.wpb-col-action' ).remove(); // remove action icons from old col
						rawContent = $( this ).html();

						if ( $( node ).find( '.wpb-element-container:not(.old-col)' ).eq( i -1 ).length ) {
							$( node ).find( '.wpb-element-container:not(.old-col)' ).eq( i - 1 ).append( rawContent );
						}
					} );

					$( '.old-col' ).remove(); // delete old columns

					$( node ).removeClass( 'wpb-1-cols wpb-2-cols wpb-3-cols wpb-4-cols wpb-6-cols' );
					$( node )
						.addClass( 'wpb-' + $( node ).find( '.wpb-element-container:not(.old-col)' ).length + '-cols' )
						.attr( 'data-layout', layout )
						.show(); // show result

					_this.reInitPanel(); // re initialize new DOM
				} );

			// section containers
			} else if ( 'section_columns' === element || 'section_blocks' === element || 'row' === element  || 'column' === element || 'block' === element ) {

				formData = form.serializeArray();
				// formData = _this.serializeForm( form );

				$.each( formData, function() {

					paramName = _this.sanitizeParamName( this.name );
					paramValue = _this.sanitizeParamValue( this.value );

					settings += ' data-' + paramName + '="' + paramValue + '"';

					if ( 'layout' === paramName ) {
						layout = paramValue;
					}

					if ( 'section_type' === paramName ) {
						section_type = paramValue;
					}

					if ( 'anchor' === paramName ) {
						this.value = _this.sanitizeSlug( paramValue );
					}
				} );

				if ( node ) { // existing element

					$.each( formData, function() {
						paramName = _this.sanitizeParamName( this.name );
						paramValue = _this.sanitizeParamValue( this.value );
						node.attr( 'data-' + paramName, paramValue );
					} );
					_this.setSectionTitles( node ); // set section title from anchor
					_this.reInitPanel(); // re initialize new DOM

					if ( 'section_columns' === element ) {
						_this.setAllSectionsBackgrounds( node );
					}

				// insert new section
				} else {

					data = {
						action : 'wpb_ajax_get_section_markup',
						element : element,
						layout : layout,
						section_type : section_type
					};

					// create a section
					$.post( WPBAdminParams.ajaxUrl, data, function( response ) {

						if ( _this.prepend ) {
							_this.markup.prepend( '<section class="wpb_section wpb_' + element + ' wpb-' + section_type + ' wpb-' + layout + '" ' + settings + '>' + response + '</section>' );
						} else {
							_this.markup.append( '<section class="wpb_section wpb_' + element + ' wpb-' + section_type + ' wpb-' + layout + '" ' + settings + '>' + response + '</section>' );
						}

						_this.reInitPanel(); // re initialize new DOM
					} );
				}

			// simple element
			} else {

				elClass = element;

				if ( node ) {
					edit = true;
				} else {
					if ( 1 === hasChildren ) {
						tag = 'element_container';

					} else {
						tag = 'element';
					}
				}

				node = node || $( '<' + tag + ' />' );

				//node.addClass( elClass );
				node.attr( 'data-element-id', element );

				if ( 1 === hasChildren ) {
					node.addClass( 'wpb-element-has-children' );
				}

				formData = _this.serializeForm( formContainer );

				//console.log( formData );

				// format data
				data = {
					action: 'wpb_ajax_sanitize_data', // sanitize_form
					form_data : formData,
					element : element,
					edit : edit
				};

				// format and sanitize form
				$.post( WPBAdminParams.ajaxUrl, data, function( response ) {

					_this.cleanDataAttr( node ); // clean unwated data attr

					$.each( $.parseJSON( response ), function() {

						//console.log( this );

						paramName = _this.sanitizeParamName( this.name );
						paramValue = _this.sanitizeParamValue( this.value );

						if ( paramValue ) {
							item = {};
							item = { 'name' : paramName, 'value' : paramValue };
							params.push( item );
							node.attr( 'data-' + paramName, paramValue ); // update data attr

						} else {
							node.removeAttr( 'data-' + paramName ); // remove empty attributes
						}
					} );

					//console.log( params );

					// edit
					if ( edit ) {

						//console.log( params );

						var req = {
							action: 'wpb_ajax_get_element_params',
							element : element,
							params : params
						};

						// Don't update visible params value for element container (parent that has a child element)
						if ( 1 !== hasChildren ) {

							// update displayed values
							$.post( WPBAdminParams.ajaxUrl, req, function( response ) {
								//console.log( response );

								$( node ).find( '.wpb-element-params' ).empty().html( response );
								_this.reInitPanel(); // re initialize new DOM
							} );
						} else {
							_this.reInitPanel(); // re initialize new DOM
						}
					// insert
					} else {

						$( '.wpb-active-container' ).append( node );

						data = {
							action: 'wpb_ajax_get_element_markup',
							element : element
						};

						$.post( WPBAdminParams.ajaxUrl, data, function( response ) {

							$( node ).append( response );

							if ( '' !== child ) {
								element = child;
								$node = $( node ).find( '.' + element );
								getElementParamAction = 'wpb_ajax_get_element_first_child_params';

							} else {
								$node = $( node );
							}

							var req = {
								action: getElementParamAction,
								element : element,
								params : params
							};

							// update displayed values
							$.post( WPBAdminParams.ajaxUrl, req, function( response ) {

								$node.find( '.wpb-element-params' ).empty().html( response );
								_this.reInitPanel(); // re initialize new DOM
							} );
						} );
					}
				} );
			}
		},

		/**
		 * Clean unwanted datat attr
		 */
		cleanDataAttr : function( object ) {
			$.each( object.data(), function( i, v ) {
				object.removeAttr( 'data-' + i );
				//console.log( 'removing: '+ i );
			} );
		},

		/**
		 * Initialization - Retrieve markup from last shortcode save
		 *
		 * In case the markup has changed in a plugin update, we use the shortcode content meta as primary content
		 */
		shortcodeToMarkup : function( callbackFunction ) {

			callbackFunction = callbackFunction || function(){};

			var _this = this,
				markup = _this.markup,
				shortcodeTextarea = $( '#wpb_shortcodes_textarea' ).val(),
				$markupTextarea = $( '#wpb_markup_textarea' ),
				$contentTextarea = $( '.wp-editor-area' ),
				percentComplete;


			$.ajax( {

				type : 'POST',
				//dataType : 'html',
				url: WPBAdminParams.ajaxUrl,

				data : {
					action : 'wpb_ajax_shortcode_to_markup_admin',
					markup : shortcodeTextarea
				},

				error : function () {
					console.log( 'unkown error' );
				},

				success: function( response ) {
					markup.html( response );
					$markupTextarea.html( response );
					//_this.openElementsDialog();
					//_this.openSettingsDialog();
					_this.sortable();
					_this.showTemplates();
					_this.setAddElementButtons();
					_this.setSectionTitles();
					_this.setAllSectionsBackgrounds();
					callbackFunction();
					//console.log( 'OK' );
				}
			} );
		},

		/**
		 * Open dialog
		 */
		openDialog : function ( selector, dialogTitle ) {
			
			dialogTitle = dialogTitle || null;

			this.closeDialog(); // first be sure all dialogs are closed

			if ( null !== dialogTitle ) {
				$( selector ).find( '.wpb-dialog-title' ).html( dialogTitle );
			}

			$( 'body' ).addClass( 'wpb-dialog-open' );

			$( selector ).fadeIn();
		},

		/**
		 * Close dialog
		 */
		closeDialog : function () {

			$( 'body' ).removeClass( 'wpb-dialog-open' );
			$( '#wpb-settings-dialog > .wpb-dialog-content' ).empty(); // flush settings form
			$( '#wpb-elements-dialog > .wpb-dialog-content' ).empty(); // flush element list
			
			$( '.wpb-dialog-box' ).hide().removeClass( 'wpb-dialog-loaded' );;
		},

		/**
		 * Close dialog
		 */
		closeDialogButton : function () {

			var _this = this;

			$( document ).on( 'click', '.wpb-dialog-close', function() {
				_this.closeDialog();
			} );
		},

		/**
		 * Save settings and close dialog
		 */
		saveDialog : function () {
			
			tinyMCE.triggerSave(); // save tinymce editor

			this.insertElement( this.node );

			// scroll near element
			if ( this.node ) {
				//console.log( 'scroll' );
				$( window ).scrollTop( this.node.offset().top - 200 );
			}

			// close section dialog
			//$( '#wpb-section-dialog' ).dialog( 'close' );
			this.closeDialog();
		},

		/**
		 * Save settings and close dialog
		 */
		saveDialogButton : function () {

			var _this = this;

			$( document ).on( 'click', '.wpb-dialog-save', function( event ) {

				event.preventDefault();

				_this.saveDialog();
			} );
		},

		/**
		 * Create dialog boxes
		 *
		 * Create 4 empty divs to insert the dialog content
		 */
		dialogInit : function () {

			//$( 'body' ).addClass( 'wpb-dialog-open' );

			// create dialogmarkup
			var dialogContainers = '<div id="wpb-dialog-overlay"></div>\
				<div class="wpb-dialog-box" id="wpb-settings-dialog">\
					<div class="wpb-dialog-head">\
						<span class="wpb-dialog-title"></span>\
						<span class="wpb-dialog-close wpb-dialog-close-times">&times;</span>\
					</div>\
					<div class="wpb-dialog-content"></div>\
					<div class="wpb-dialog-action">\
						<span class="wpb-dialog-button wpb-dialog-save button button-primary">' + WPBAdminParams.saveDialogText + '</span>\
						<span class="wpb-dialog-button wpb-dialog-close wpb-dialog-cancel button">' + WPBAdminParams.cancelDialogText + '</span>\
					</div>\
				</div>\
				<div class="wpb-dialog-box" id="wpb-elements-dialog">\
					<div class="wpb-dialog-head">\
						<span class="wpb-dialog-title">' + WPBAdminParams.elementsListTitle + '</span>\
						<span class="wpb-dialog-close wpb-dialog-close-times">&times;</span>\
					</div>\
					<div class="wpb-dialog-content"></div>\
				</div>\
				<div class="wpb-dialog-box" id="wpb-section-dialog">\
					<div class="wpb-dialog-head">\
						<span class="wpb-dialog-title">' + WPBAdminParams.chooseSectionText + '</span>\
						<span class="wpb-dialog-close wpb-dialog-close-times">&times;</span>\
					</div>\
					<div class="wpb-dialog-content"></div>\
				</div>\
				<div class="wpb-dialog-box" id="wpb-import-dialog">\
					<div class="wpb-dialog-head">\
						<span class="wpb-dialog-title">' + WPBAdminParams.importContentText + '</span>\
						<span class="wpb-dialog-close wpb-dialog-close-times">&times;</span>\
					</div>\
					<div class="wpb-dialog-content"></div>\
				</div>';
			
			$( 'body' ).append( dialogContainers );

			// Set the very first dialog (section layout select) from a static file
			$.post( WPBAdminParams.pluginUrl + '/inc/admin/dialog/section.php' , '', function( response ) {
				$( '#wpb-section-dialog > .wpb-dialog-content' ).html( response );
			} );

			// Set the "import content" form from a static file
			$.post( WPBAdminParams.pluginUrl + '/inc/admin/dialog/import.php' , '', function( response ) {
				$( '#wpb-import-dialog > .wpb-dialog-content' ).html( response );
			} );
		},

		/**
		 * Create dialog boxes
		 *
		 * Init jquery UI dialog
		 * deprecated - jquery UI free!!
		 */
		initDialogBoxes_bak : function() {

			var _this = this;

			// section dialog
			$( '#wpb-section-dialog' ).dialog( {
				dialogClass : 'wpb-dialog',
				modal : true,
				autoOpen : false,
				closeOnEscape : true,
				minWidth : 600,
				minHeight : 300,
				title : WPBAdminParams.chooseSectionText,
				open : function () {
					_this.dialogTitle = null;

					if ( ! _this.addSectionInit ) {
						_this.addNewSection();
						_this.addSectionInit = true;
					}

					$( '.tipsy' ).remove(); // clean up remaining tooltip

				},
				buttons : [
					{
						text:WPBAdminParams.cancelButtonText,
						click: function() {
							// close and empty form dialog
						 	$( this ).dialog( 'close' );
						}
					}
				]
			} );

			// section dialog
			$( '#wpb-import-dialog' ).dialog( {
				dialogClass : 'wpb-dialog',
				modal : true,
				autoOpen : false,
				closeOnEscape : true,
				minWidth : 600,
				minHeight : 300,
				title : WPBAdminParams.importContentText,
				open : function () {
					_this.dialogTitle = null;

					$( '.tipsy' ).remove(); // clean up remaining tooltip

				},
				buttons : [
					{
						text:WPBAdminParams.cancelButtonText,
						click: function() {
							// close and empty form dialog
						 	$( this ).dialog( 'close' );
						}
					}
				]
			} );

			// elements list dialog
			$( '#wpb-elements-dialog' ).dialog( {
				dialogClass : 'wpb-dialog',
				modal : true,
				autoOpen : false,
				closeOnEscape : true,
				minWidth : 1000,
				minHeight : 800,
				title : WPBAdminParams.elementsListTitle,
				open : function () {
					$( 'span.ui-dialog-title' ).text( WPBAdminParams.elementsListTitle );
					_this.dialogTitle = null;
					$( '.tipsy' ).remove(); // clean up remaining tooltip
				}
			} );

			// element settings dialog
			$( '#wpb-settings-dialog' ).dialog( {
				dialogClass : 'wpb-dialog',
				modal : true,
				autoOpen : false,
				closeOnEscape : true,
				minWidth : 650,
				minHeight : 450,
				// position: [ 'center', 'left' ],
				// title : _this.dialogTitle,
				open : function () {
					$( 'span.ui-dialog-title' ).text( _this.dialogTitle );
					_this.dialogTitle = null;
					_this.colorPicker();
					$( '.tipsy' ).remove(); // clean up remaining tooltip

					// fix focus issue on input external to the dialog box
					$.ui.dialog.prototype._allowInteraction = function (e) {
						if ( $( e.target ).closest( 'input[type=text]' ).length) return true;

						return ui_dialog_interaction.apply( this, arguments );
					};
					$.ui.dialog.prototype._allowInteractionRemapped = true;
				},

				close : function () {
					//$( '#wpb-settings-dialog' ).empty().removeClass( 'wpb-settings-dialog-loaded' );
					_this.dialogTitle = null;
				},
				buttons : [

					{
						text:WPBAdminParams.saveButtonText,
						click: function() {

							tinyMCE.triggerSave(); // save tinymce editor

							_this.insertElement( _this.node );

							// scroll near element
							// deprecated as the popup is now in fixed position
							//if ( _this.node ) {
								//console.log( 'scroll' );
								//$( window ).scrollTop( _this.node.offset().top - 200 );
							//}

							// close section dialog
							$( '#wpb-section-dialog' ).dialog( 'close' );

							// close and empty form dialog
							$( this ).dialog( 'close' ).empty();
						}
					},
					{
						text:WPBAdminParams.cancelButtonText,
						click: function() {
							// close and empty form dialog
						 	$( this ).dialog( 'close' ).empty();
						}
					}
				]
			} );
		},

		initDialogBoxes : function() {},

		/**
		 * Open section settings on click
		 */
		openSectionDialog : function () {
			var _this = this;
			
			$( document ).on( 'click', '.wpb-add-section', function( event ) {
				event.preventDefault();
				
				// prepend markup or append markup to div so we know if we must insert the section at the bottom or at the end
				_this.prepend = ( 'wpb-add-section-prepend' === $( this ).attr( 'id' ) );
				//alert( _this.prepend );

				_this.openDialog( '#wpb-section-dialog' );
			} );
		},

		/**
		 * Open the dialog box containing the elements list
		 */
		openElementsDialog : function () {
			var _this = this, container;

			$( document ).on( 'click', '.wpb-view-elements', function( event ) {
			//$( '.wpb-view-elements' ).on( 'click', function() {
				event.preventDefault();

				// set active container
				container = $( this ).parents( '.wpb-element-container' );
				$( '.wpb-element-container' ).removeClass( 'wpb-active-container' );
				container.addClass( 'wpb-active-container' );
				
				$( '#wpb-elements-dialog > .wpb-dialog-content' ).empty();
				
				_this.setElementsList();
				
				_this.openDialog( '#wpb-elements-dialog' );
			} );
		},

		/**
		 * Add new empty section
		 */
		addNewSection : function () {
			var _this = this,
				section_type,
				req;

			$( document ).on( 'click', '.wpb-new-section', function() {

				section_type = $( this ).data( 'section-type' );

				req = {
					action: 'wpb_ajax_get_new_section',
					section_type : section_type
				};

				// update displayed values
				$.post( WPBAdminParams.ajaxUrl, req, function( response ) {

					if ( response ) {

						_this.resetPanel();

						if ( _this.prepend ) {
							_this.markup.prepend( response );
						} else {
							_this.markup.append( response );
						}
					}

					_this.reInitPanel(); // re initialize new DOM
				} );

				// close all dialog boxes
				//$( '#wpb-elements-dialog' ).dialog( 'close' );
				//$( '#wpb-section-dialog' ).dialog( 'close' );
				_this.closeDialog();
			} );
		},

		/**
		 * Add empty row in section
		 */
		addNewRow : function () {
			var _this = this,
				$this,
				req;

			// insert element trigger
			$( document ).on( 'click', '.wpb-add-row', function() {

				$this = $( this ),

				req = {
					action: 'wpb_ajax_get_new_row'
				};

				// update displayed values
				$.post( WPBAdminParams.ajaxUrl, req, function( response ) {

					if ( response ) {
						_this.resetPanel();
						$this.parents( 'section' ).append( response );
					}

					_this.reInitPanel(); // re initialize new DOM
				} );
			} );
		},

		/**
		 * Open the element settings dialog box
		 */
		openSettingsDialog : function () {
			var _this = this;

			// insert element trigger
			$( document ).on( 'click', '.wpb-element', function() {
			//$( '.wpb-element' ).on( 'click', function() {
				var $this =$( this ),
					element = $this.data( 'element' ),
					dialogTitle;

				_this.setDialogSettings( element );

				dialogTitle = ( $( this ).attr( 'original-title' ) ) ? $( this ).attr( 'original-title' ) : $( this ).attr( 'title' );

				// open settings dialog
				$( 'body' ).removeClass( 'wpb-dialog-open' );
				_this.openDialog( '#wpb-settings-dialog', dialogTitle );
			} );

			// edit settings triggers
			$( document ).on( 'click', '.wpb-edit-section, .wpb-edit-row, .wpb-layout-section, .wpb-layout-row, .wpb-edit-column, .wpb-edit-element', function( event ) {

				event.preventDefault();

				var $this = $( this ),
					element = $this.data( 'element' ),
					values,
					dialogTitle;

				// tweak to get the title attribute even if tipsy is used (tipsy mess with the title attr)
				//_this.dialogTitle = ( $( this ).attr( 'original-title' ) ) ? $( this ).attr( 'original-title' ) : $( this ).attr( 'title' );
				dialogTitle = ( $( this ).attr( 'original-title' ) ) ? $( this ).attr( 'original-title' ) : $( this ).attr( 'title' );

				// get current element
				_this.node = $this.parent().parent();

				// get params using data attribute
				values = _this.getDataAttributes( _this.node );

				// create settings form in dialog box
				_this.setDialogSettings( element, values );

				// open dialog box
				_this.openDialog( '#wpb-settings-dialog', dialogTitle );
			} );
		},

		/**
		 * Set the element list in the dialog blox
		 */
		setElementsList : function ( element ) {
			var _this = this,
				data = {
					action: 'wpb_ajax_get_elements'
				};
			$.post( WPBAdminParams.ajaxUrl, data, function( response ) {
				$( '#wpb-elements-dialog > .wpb-dialog-content' ).empty().html( response );
				$( '#wpb-elements-dialog' ).addClass( 'wpb-dialog-loaded' );
			} );
		},

		/**
		 * Set the element settings in the dialog blox
		 */
		setDialogSettings : function ( element, values ) {

			var _this = this,
				editor_id = this.editor_id,
				data = {
				action: 'wpb_ajax_get_element_settings',
				element : element,
				values : values
			};

			// get TMCE WP settings
			this.tinyMCEglobalSettings =  tinyMCEPreInit.mceInit.content;

			$.ajax( {
				type : 'POST',
				url: WPBAdminParams.ajaxUrl,

				data : {
					action: 'wpb_ajax_get_element_settings',
					element : element,
					values : values
				},

				error : function () {
					console.log( 'unkown error' );
				},

				success: function( response ) {
					$( '#wpb-settings-dialog > .wpb-dialog-content' )
						.empty()
						.html( response );

					/* Init TinyMCE here */
					if ( $( '#wpb-dialog-form' ).data( 'has-editor' ) ) {
						// editor ID : editorcontent

						tinymce.init( _this.tinyMCEglobalSettings);
						tinyMCE.execCommand( 'mceRemoveEditor', false, editor_id );
						tinyMCE.execCommand( 'mceAddEditor', false, editor_id );

						quicktags( { id : editor_id } ); // init qtags
						QTags._buttonsInit(); // init qtags buttons

						$( '#editorcontent' ).attr( 'data-element-type', 'editor' ); // set element type data attribute
					}

				 	_this.sortableImagesSet();
					_this.reInitSettingsForm();
					$( '#wpb-settings-dialog' ).addClass( 'wpb-dialog-loaded' );
				}
			} );
		},

		/**
		 * Sortable for multiple images field
		 *
		 * Uses to reorder gallery images
		 */
		sortableImagesSet : function () {
			$( '.wpb-images-set' ).sortable( {
				update : function() {
					$( this ).parent().find( 'input' ).val( $( this ).sortable( 'toArray', { attribute: 'data-attachment-id' } ) );
				},
				helper: 'clone',
				items: '.wpb-image'
			} );
		},

		/**
		 * Reinit scripts
		 */
		reInitPanel : function () {
			this.updateTextareas();
			this.sortable();
			this.setAddElementButtons();
			this.node = null;
			this.prepend = null;
			$( '#wpb-settings-dialog > .wpb-dialog-content' ).empty();
			$( '#wpb-elements-dialog > .wpb-dialog-content' ).empty();
			$( '.tipsy' ).remove(); // clean up remaining tooltip
			$( 'body' ).removeClass( 'wpb-processing' ); // flag processing
			$( '#publish' ).removeClass( 'disabled' );
		},

		/**
		 * Reinit scripts
		 */
		reInitSettingsForm : function () {
			this.colorPicker();
			this.fieldDependencies();
		},

		/**
		 * Remove section block in editor
		 */
		removeSection : function () {

			var _this = this,
				sectionBlock;

			$( document ).on( 'click', '.wpb-remove-section', function() {
				if ( confirm( WPBAdminParams.removeSectionConfirmation ) ) {
					sectionBlock = $( this ).parents( 'section' );
					sectionBlock.fadeOut( 'fast', function() {
						$( this ).remove();
						$( '.tipsy' ).remove(); // clean up remaining tooltip
						_this.reInitPanel(); // re initialize new DOM
						_this.showTemplates(); // show template if div is empty
					} );
				} else {
					$( '.tipsy' ).remove();
					_this.reInitPanel();
				}
			} );
		},

		/**
		 * Remove row block in editor
		 */
		removeRow : function () {

			var _this = this,
				row, section;

			$( document ).on( 'click', '.wpb-remove-row', function() {
				row = $( this ).parents( 'row' );
				section = $( this ).parents( 'section' );

				if ( section.find( '.wpb-row' ).length < 2 ) {

					alert( WPBAdminParams.rowLenght );

				} else if ( confirm( WPBAdminParams.removeRowConfirmation ) ) {

					row.fadeOut( 'fast', function() {
						$( this ).remove();
						$( '.tipsy' ).remove(); // clean up remaining tooltip
						_this.reInitPanel(); // re initialize new DOM
						_this.showTemplates(); // show template if div is empty
					} );
				} else {
					$( '.tipsy' ).remove();
					_this.reInitPanel();
				}
			} );
		},

		/**
		 * Remove element in editor
		 */
		removeElement : function () {

			var _this = this,
				item, parent;

			$( document ).on( 'click', '.wpb-remove-element', function() {
				item = $( this ).parent().parent(),
				parent = item.parents( '.wpb-element-has-children' );

				// can't delete last nested element
				if ( item.hasClass( 'wpb-element-child' ) && parent.find( '.wpb-element-child' ).length < 2 ) {

					alert( WPBAdminParams.childrenElementLenght );

				// confirmation message to delete an element
				} else if ( confirm( WPBAdminParams.removeElementConfirmation ) ) {
					item.fadeOut( 'fast', function() {
						$( this ).remove();
						$( '.tipsy' ).remove(); // clean up remaining tooltip
						_this.reInitPanel(); // re initialize new DOM
					} );
				} else {
					$( '.tipsy' ).remove();
					_this.reInitPanel();
				}
			} );
		},

		/**
		 * Duplicate section block in editor
		 */
		duplicateElement : function () {

			var _this = this,
				item;

			$( document ).on( 'click', '.wpb-duplicate-element', function() {
				item = $( this ).parent().parent();
				item.after( item.clone() );
				_this.reInitPanel(); // re initialize new DOM
			} );
		},

		/**
		 * Duplicate section block in editor
		 */
		duplicateSection : function () {

			var _this = this,
				sectionBlock;

			$( document ).on( 'click', '.wpb-duplicate-section', function() {
				sectionBlock = $( this ).parents( 'section' );
				sectionBlock.after( sectionBlock.clone() );
				_this.reInitPanel(); // re initialize new DOM
			} );
		},

		/**
		 * Duplicate row block in editor
		 */
		duplicateRow : function () {

			var _this = this,
				row;

			$( document ).on( 'click', '.wpb-duplicate-row', function() {
				row = $( this ).parents( 'row' );
				row.after( row.clone() );
				_this.reInitPanel(); // re initialize new DOM
			} );
		},

		/**
		 * Collapse section
		 */
		collapseSection : function () {

			var _this = this;

			$( document ).on( 'click', '.wpb-collapse-section', function() {
				var section = $( this ).parents( '.wpb_section' );

				if ( section.hasClass( 'wpb-section-collapsed' ) || section.attr( 'data-admin_collapse' ) ) {
					section.removeAttr( 'data-admin_collapse' );
					section.removeClass( 'wpb-section-collapsed' );
				} else {
					section.attr( 'data-admin_collapse', 'true' );
					section.addClass( 'wpb-section-collapsed' );
				}
			} );
		},

		/**
		 * Add a button to insert element in empty column and blocks
		 */
		setAddElementButtons : function () {

			this.markup.find( 'column, block' ).each( function () {

				//console.log( $( this ).find( 'element' ).length );
				
				if ( ! $( this ).find( 'element' ).length ) { // if element empty

					if ( ! $( this ).find( 'button' ).length ) { // if button not already there
						// console.log( 'button not there' );
						$( this ).append( '<button class="button wpb-add-element-button wpb-view-elements">' + WPBAdminParams.addElementText + '</button>' );
					}

				} else {
					$( this ).find( 'button' ).remove(); // remove button if element is found
				}
			} );
		},

		/**
		 * Sortable element in panel
		 */
		sortable : function () {

			var _this = this,
				$container;

			// section
			$( '.wpb-move-section' ).on( 'mousedown', function() {

				$container = _this.markup;

				$container.sortable( {
					placeholder: 'state-highlight',
					item: '.wpb_section',
					// connectWith: '.wpb_section',
					stop: function() {

						_this.markup.disableSelection();
						// Remove the sortable feature to prevent bad state caused by unbinding all
						_this.markup.sortable( 'destroy' );
						// Unbind all event handlers!
						_this.markup.unbind();

						_this.reInitPanel(); // re initialize new DOM
					}
				} ).disableSelection();
			} );

			// row
			$( '.wpb-move-row' ).on( 'mousedown', function() {

				$container = $( '.wpb_section_columns' );

				$container.sortable( {
					placeholder: 'state-highlight',
					item: '.wpb-row',
					connectWith: '.wpb_section_columns',
					// zIndex: 10000,
					stop: function() {

						$( '.wpb_section_columns' ).disableSelection();
						// Remove the sortable feature to prevent bad state caused by unbinding all
						$( '.wpb_section_columns' ).sortable('destroy');
						// Unbind all event handlers!
						$( '.wpb_section_columns' ).unbind();

						_this.reInitPanel(); // re initialize new DOM
					}
				} ).disableSelection();
			} );

			// element
			$( '.wpb-element-container' ).sortable( {
				placeholder: 'state-highlight',
				connectWith: '.wpb-element-container',
				helper: 'clone',
				appendTo: 'body',
				zIndex: 10000,
				
				start: function(){
					$( this ).addClass( 'wpb-sortable-hover' );
					//console.log( 'start' );
				},
				
				over: function(){
					$( this ).addClass( 'wpb-sortable-hover' );
					//console.log( 'over' );
				},

				stop: function() {
					$( '.wpb-element-container' ).removeClass( 'wpb-sortable-hover' );
					//console.log( 'stop' );
					_this.reInitPanel(); // re initialize new DOM
				}
			
			} ).disableSelection();

			// element child
			$( '.wpb-move-element-item' ).mousedown(function() {

				$container = $( '.wpb-element-has-children' );

				$container.sortable( {
					
					placeholder: 'state-highlight',
					item: '.wpb-element-child',

					start: function(){
						//console.log( 'start' );
					},
					
					over: function(){
						//console.log( 'over' );
					},
	
					stop: function() {

						//console.log( 'stop' );

						$( '.wpb-element-has-children' ).disableSelection();
						// Remove the sortable feature to prevent bad state caused by unbinding all
						$( '.wpb-element-has-children' ).sortable( 'destroy' );
						// Unbind all event handlers!
						$( '.wpb-element-has-children' ).unbind();

						_this.reInitPanel(); // re initialize new DOM
					}
				} ).disableSelection();
			} );
		},

		/**
		 * Tooltip, just for cosmetic
		 */
		toolTip : function () {
			$( '.wpb-tipsy' ).tipsy( {
				fade: true,
				live: true,
				gravity: 's'
			} );
		},

		/**
		 * Colorpicker
		 */
		colorPicker : function () {
			var colorpickerOptions = {
				palettes: WPBAdminParams.defaultPalette
			};

			if ( {} !== WPBAdminParams && WPBAdminParams.defaultPalette ) {
				$( '.wpb-param-colorpicker' ).wpColorPicker( colorpickerOptions );
			} else {
				$( '.wpb-param-colorpicker' ).wpColorPicker();
			}
		},

		/**
		 * Hide or show settings depending on user choice
		 */
		fieldDependencies : function () {

			$( '.wpb-has-dependency' ).each( function () {

				var $this = $( this ),
					selectValue,
					relatedElement = $( this ).data( 'dependency-element' ),
					values = $( this ).data( 'dependency-values' );

				selectValue = $( '.wpb-param-fieldset-' + relatedElement ).find( 'select' ).val();

				if ( $.inArray( selectValue, values )  !== -1 ) {
					$this.show();
				} else {
					$this.hide();
				}

				// console.log( values );

				$( '.wpb-param-fieldset-' + relatedElement ).find( 'select' ).on( 'change', function() {
					selectValue = $( this ).val();

					if ( $.inArray( selectValue, values )  !== -1 ) {
						$this.show();
					} else {
						$this.hide();
					}
				} );

				// $( '.wpb-icon-selector' ).fontIconPicker( {
				// 	theme: 'fip-grey',
				// 	iconsPerPage: 64
				// } );
			} );
		},

		/**
		 * Gety all html data attribute of an element
		 */
		getDataAttributes : function ( node ) {
			var d = {},
				re_dataAttr = /^data\-(.+)$/;

			$.each( node.get( 0 ).attributes, function( index, attr ) {
				if ( re_dataAttr.test( attr.nodeName ) ) {
					var key = attr.nodeName.match( re_dataAttr ) [ 1 ];
					d[ key ] = attr.nodeValue;
				}
			} );

			return d;
		},

		/**
		 * Serialize form data
		 */
		serializeForm : function ( form ) {

			var serializedData = [], item;
			form.find( 'input, textarea#editorcontent, textarea.wpb-textarea, select, checkbox' ).each( function() {
				item = {};
				item.name = $( this ).attr( 'name' );
				item.value = $( this ).val();
				item.type = $( this ).data( 'element-type' );

				if ( 'checkbox' === item.type ) {
					if ( $( this ).is( ':checked' ) ) {
						serializedData.push( item );
					}
				} else {
					serializedData.push( item );
				}
			} );

			//console.log( serializedData );
			return serializedData;
		},

		/**
		 * Sanitize slug
		 */
		sanitizeSlug : function ( str ) {
			var slug = '',
				trimmed = $.trim( str );
			slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
			replace(/-+/g, '-').
			replace(/^-|-$/g, '');
			return slug.toLowerCase();
		},

		/**
		 * Sanitize param value
		 */
		sanitizeParamValue : function ( str ) {
			str = str || '';

			return str;
		},

		/**
		 * Sanitize param name
		 */
		sanitizeParamName : function ( str ) {
			str = str || '';
			str = $.trim( str );
			str = str.replace( /[^a-z0-9_]/gi, '');
			return str.toLowerCase();
			return str;
		},

		/**
		 * Set section title legend
		 */
		setSectionTitles : function( $section ) {
			$section = $section || null;

			var _this = this, anchor;

			if ( $section ) {
				
				anchor = ( $section.attr( 'data-anchor' ) ) || 'section';
				
				if ( anchor ) {
					if ( 'section' !== anchor ) {
						anchor = '#' + anchor;
					}
					$section.find( '.wpb-section-title' ).empty().append( anchor );
				}
			
			} else {

				this.markup.find( '.wpb_section' ).each( function() {
					
					anchor = ( $( this ).attr( 'data-anchor' ) ) || 'section';

					if ( anchor ) {
						if ( 'section' !== anchor ) {
							anchor = '#' + anchor;
						}
						//console.log( anchor );
						$( this ).find( '.wpb-section-title' ).empty().append( _this.sanitizeSlug( anchor ) );
					}
				} );
			}
		},

		/**
		 * Set section backgrounds
		 *
		 * @todo
		 */
		setAllSectionsBackgrounds : function ( $section ) {

			$section = $section || null;

			var _this = this;

			// when set
			if ( $section ) {

				this.setSectionBackground( $section );

			// on markup load
			} else {
				this.markup.find( '.wpb_section' ).each( function() {

					_this.setSectionBackground( $( this ) );
				} );
			}
		},

		/**
		 * Set section background
		 */
		setSectionBackground : function ( $section ) {

			$section = $section || null;

			var bgImageId, bgType, skin, imageIdsList, imageIdsArray;

			// when set
			if ( $section ) {

				skin = $section.attr( 'data-skin' ) || '';
				bgType = $section.attr( 'data-background_type' ) || '';

				// if image background
				if ( 'image' === bgType || 'video' === bgType || 'slideshow' === bgType ) {

					if ( 'image' === bgType ) {

						bgImageId = $section.attr( 'data-background_img' ) || '';

					} else if ( 'video' === bgType ) {

						bgImageId = $section.attr( 'data-video_bg_img' ) || '';

					} else if ( 'slideshow' === bgType ) {

						imageIdsList = $section.attr( 'data-slideshow_img_ids' ) || '';

						if ( imageIdsList ) {
							imageIdsArray = imageIdsList.split( ',' );
							bgImageId = imageIdsArray[0];
							// console.log( bgImageId );
						}

					}

					if ( bgImageId ) {
						$.post( WPBAdminParams.ajaxUrl, { attachmentId : bgImageId, action : 'wpb_ajax_get_url_from_attachment_id' }, function( response ) {
							if ( response ) {
								// console.log( response );
								$section.attr( 'style', 'background-image:url(' + response + ');' );
								$section.addClass( 'has-bg' );
							}
						} );

					} else {
						// remove bg
						$section.removeAttr( 'style' );
						$section.removeClass( 'has-bg' );
					}

				} else {
					// remove bg
					$section.removeAttr( 'style' );
					$section.removeClass( 'has-bg' );
				}

				if ( skin ) {
					$section.removeClass( 'skin-light skin-dark' );
					$section.addClass( 'skin-' + skin );
				} else {
					$section.removeClass( 'skin-light skin-dark' );
				}
			}
		},

		/**
		 * Update the markup and shortocde when clicking on the "Preview changes button"
		 *
		 * @todo
		 */
		preview : function () {

			var _this = this;

			// $( '#post-preview' ).on( 'click', function( event ) {

				// event.preventDefault();
				// event.stopPropagation();

				// _this.updateTextareas();
			// } );
		},

		/**
		 * Update the text areas when the user click on the publish button
		 */
		save : function () {

			// Don't hook the save button if standard mode
			if ( $( '.wpb-toggle-editor' ).hasClass( 'wpb-off' ) ) {
				return;
			}

			$( '#publish' ).on( 'click', function( event ) {

				event.preventDefault();

				var _this = this,
					markup = $( '#wpb-markup' ).html(),
					$markupTextarea = $( '#wpb_markup_textarea' );

					// fade the editor for cosmetic
					$( 'body' ).addClass( 'wpb-processing' );

				/* Sanitize via PHP */
				$.ajax( {
					type: 'POST',
					cache: false,
					url: WPBAdminParams.ajaxUrl,
					data: {
						action: 'wpb_ajax_get_markup_content',
						markup : markup
					},
					success: function( response ) {
						$markupTextarea.val( response );
						WolfPageBuilderAdminEditor.submit( response );
					},
					error: function( response ) {

					}
				} );
			} );
		},

		/**
		 * Submit post form and save metabox data
		 *
		 * Convert HTML markup to shortcode and fire the submit form event
		 */
		submit : function( response ) {
			$.ajax( {
				type: 'POST',
				cache: false,
				url: WPBAdminParams.ajaxUrl,
				data: {
					action: 'wpb_ajax_get_shortcode_content',
					markup : response
				},
				success: function( shortcodeResponse ) {
					$( '#wpb_shortcodes_textarea' ).val( shortcodeResponse );
					// console.log( response );

					//  trick to avoid post being saved as draft for some reason
					$( 'form#post' ).append( '<input type="hidden" name="publish" value="Publish">' );

					setTimeout(
						function() {
							$( 'form#post' ).submit();
						}, 500
					);
				}
			} );
		},

		/**
		 * Update content in different formats
		 *
		 * Not used waiting to find a solution to use the funciton with a callback
		 */
		updateTextareas : function () {
			var _this = this,
				markup = $( '#wpb-markup' ).html(),
				$markupTextarea = $( '#wpb_markup_textarea' ),
				$shortcodeTextarea = $( '#wpb_shortcodes_textarea' ),
				$contentTextarea = $( '.wp-editor-area' );

			// markup content
			$.post( WPBAdminParams.ajaxUrl, { action : 'wpb_ajax_get_markup_content', markup : markup }, function( response ) {

				$markupTextarea.val( response );

				// shortcode content
				$.post( WPBAdminParams.ajaxUrl, { action : 'wpb_ajax_get_shortcode_content', markup : response }, function( newResponse ) {

					$shortcodeTextarea.val( newResponse );
					// callback;
				} );
			} );
		}
	};

}( jQuery );


;( function( $ ) {

	'use strict';
	WolfPageBuilderAdminEditor.init();

	$( window ).load( function() {} );

} )( jQuery );