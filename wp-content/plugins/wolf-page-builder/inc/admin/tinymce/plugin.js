/**
 * TinyMCE plugin
 *
 * Add shortcode dropdown menu to tinyMCE
 */
;( function( $ ) {
	'use strict';

	var fontMenu = [];

	//console.log( fontMenu );

	//Shortcodes
	tinymce.PluginManager.add( 'WPBShortcodesTinyMce', function( editor, url ) {

		editor.addCommand( 'WPBPopup', function ( a, params )
		{
			var popup = params.identifier;
			// console.log( popup );
			tb_show( WPBTinyMceParams.insertText, url + "/popup.php?popup=" + popup + "&width=800" );

		});

		editor.addButton( 'wpb_shortcodes_tiny_mce_button', {
			type: 'splitbutton',
			icon: false,
			title:  'Shortcodes',
			menu: [
				{ text: WPBTinyMceParams.anchor, onclick:function() {
					editor.execCommand( 'WPBPopup', false, { title: WPBTinyMceParams.anchor, identifier: 'anchor' } )
				} },
				{ text: WPBTinyMceParams.dropcap, onclick:function() {
					editor.execCommand( 'WPBPopup', false, { title: WPBTinyMceParams.dropcap, identifier: 'dropcap' } )
				} },
				{ text: WPBTinyMceParams.button, onclick:function() {
					editor.execCommand( 'WPBPopup', false, { title: WPBTinyMceParams.button, identifier: 'button' } )
				} },
				{ text: 'Mailchimp', onclick:function() {
					editor.execCommand( 'WPBPopup', false, { title: 'Mailchimp', identifier: 'mailchimp' } )
				} },
				{ text: WPBTinyMceParams.alert, onclick:function() {
					editor.execCommand( 'WPBPopup', false, { title: WPBTinyMceParams.alert, identifier: 'alert' } )
				} },
				{ text: WPBTinyMceParams.highlight, onclick:function() {
					editor.execCommand( 'WPBPopup', false, { title: WPBTinyMceParams.highlight, identifier: 'highlight' } )
				} },
				{ text: WPBTinyMceParams.spacer, onclick:function() {
					editor.execCommand( 'WPBPopup', false, { title: WPBTinyMceParams.spacer, identifier: 'spacer' } )
				} },
				{ text: WPBTinyMceParams.fittext, onclick:function() {
					editor.execCommand( 'WPBPopup', false, { title: WPBTinyMceParams.fittext, identifier: 'fittext' } )
				} },
				{ text: WPBTinyMceParams.socials, onclick:function() {
					editor.execCommand( 'WPBPopup', false, { title: WPBTinyMceParams.socials, identifier: 'socials' } )
				} },
				{ text: WPBTinyMceParams.columns, onclick:function() {
					editor.execCommand( 'WPBPopup', false, { title: WPBTinyMceParams.columns, identifier: 'columns' } )
				} }
			]
		} );
	} );

} )( jQuery );