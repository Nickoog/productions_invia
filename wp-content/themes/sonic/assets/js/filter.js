/*!
 * AJAX category filter
 *
 * Sonic 2.2.4
 */
/* jshint -W062 */
/* global DocumentTouch */
var SonicCategoryFilter = SonicCategoryFilter || {},
	SonicInfiniteScroll = SonicInfiniteScroll || {},
	SonicMasonry = SonicMasonry || {},
	SonicParams = SonicParams || {},
	console = console || {};

SonicCategoryFilter = function( $ ) {

	'use strict';

	return {

		$dom : null,

		init : function() {
			var _this = this;

			if ( ! $( 'body' ).hasClass( 'is-ajax-category-filter' ) ) {
				return;
			}

			this.addAjaxLoader();
			this.loadContent();
		},

		addAjaxLoader : function() {

			$( '.content-area' ).append( '<span id="grid-ajax-loader" class="fa fa-cog fa-spin fa-1x fa-fw" />' );
		},

		loadContent : function() {

			var _this = this,
				href,
				winLoc,
				urlToReplace,
				getVar,
				selector = '#blog-filter a, #work-filter a, #plugin-filter a, #theme-filter a',
				$content = $( '#content' ),
				$loader = $( '#grid-ajax-loader' ),
				$trigger = $( '.trigger-container' ),
				newPaginationMarkup = '';

			$( selector ).on( 'click', function( event ) {
				
				if ( SonicParams.isCustomizer ) {
					alert( SonicParams.l10n.categoryFilterDisabledMsg );
					return false;
				}

				event.preventDefault();
				event.stopPropagation();

				winLoc = window.location.href;

				/**
				 * Set URL get arguments if any
				 */
				if ( winLoc.indexOf( '?' ) !== -1 ) {

					getVar = winLoc.substr( winLoc.indexOf( '?' ) + 1);

					$( selector ).each( function() {
						if ( $( this ).attr( 'href' ).indexOf( '?' ) === -1 ) {
							urlToReplace = $( this ).attr( 'href' ).replace( $( this ).attr( 'href' ), $( this ).attr( 'href' ) + '?' + getVar );
							$( this ).attr( 'href', urlToReplace );
						}
					} );
				}

				href = $( this ).attr( 'href' );
				
				// cosmetic
				$( selector ).removeClass( 'active' );
				$( this ).addClass( 'active' );
				$content.animate( { 'opacity' : 0 } );
				$trigger.animate( { 'opacity' : 0 } );
				$loader.animate( { 'opacity' : 1 } );

				$.get( href, function( data ) {

					$content.infinitescroll( 'binding', 'unbind' ); // destroy previous infinitescroll instance
					$content.data( 'infinitescroll', null );
					$( window ).unbind( '.infscr' );

					_this.$dom = $( document.createElement( 'html' ) ); // get HTML content
					_this.$dom[0].innerHTML = data; // Here's where the "magic" happens
					
					// replace body classes
					_this.setBodyClasses( _this.$dom.find( 'body' ).attr( 'class' ) );
					
					// update pagination
					if ( undefined !== $( data ).find( '.paging-navigation').html() ) {
						newPaginationMarkup = $( data ).find( '.paging-navigation').html();
					}

					// console.log( newPaginationMarkup );
					$( '.paging-navigation' ).html( newPaginationMarkup );

					// update trigger
					$trigger.html( $( data ).find( '.trigger-container').html() );
					
					// update content
					$content.html( $( data ).find( '#content').html() );
											
					_this.callBack();

					$content.delay( 500 ).animate( { 'opacity' : 1 } );
					$trigger.delay( 500 ).animate( { 'opacity' : 1 } );
					$loader.animate( { 'opacity' : 0 } );

					if ( ! SonicParams.isCustomizer ) {
						window.history.pushState( null, null, href ); // update URL
					}
				} );

				return false;
			} );
		},

		/**
		 * Reset body classes
		 */
		setBodyClasses : function( bodyClasses ) {

			bodyClasses = bodyClasses.replace( 'loading', '' ); // remove laoding class

			bodyClasses += ' loaded';

			if ( SonicParams.isUserLoggedIn ) {
				bodyClasses += ' logged-in admin-bar';
			}

			$( 'body' ).attr( 'class', '' ).addClass( bodyClasses );
		},

		/**
		 * Callback
		 */
		callBack : function() {

			var $content = $( '#content' );

			SonicUi.fluidVideos();
			SonicUi.youtubeWmode();
			SonicUi.setVimeoOptions();
			SonicUi.flexSlider();
			SonicUi.lightbox();
			SonicUi.likes();
			SonicUi.postBg();

			/* YT background */
			if ( 'undefined' !== typeof SonicYTVideoBg ) {
				SonicYTVideoBg.playVideo();
			}

			if ( $( 'body' ).hasClass( 'is-masonry' ) ) {
				SonicMasonry.init();

				if ( $content.data( 'isotope' ) ) {
					$content.isotope( 'reloadItems' ).isotope();
				}
			}
			
			if ( $( 'body' ).hasClass( 'is-infinitescroll' ) ) {
				SonicInfiniteScroll.infiniteScroll();
			}

			/* AJAX nav */
			if ( 'undefined' !== typeof SonicAjaxNav ) {
				SonicAjaxNav.setAjaxLinkClass();
			}
			
			/* Wolf Playilst */
			if ( 'undefined' !== typeof WPM ) {
				WPM.init();
			}

			if ( $content.find( '.twitter-tweet' ).length ) {
				$.getScript( 'http://platform.twitter.com/widgets.js' );
			}

			if ( $content.find( '.instagram-media' ).length ) {

				$.getScript( '//platform.instagram.com/en_US/embeds.js' );

				if ( 'undefined' !== typeof window.instgrm  ) {
					window.instgrm.Embeds.process();
				}
			}

			if ( $content.find( 'audio,video' ).length ) {
				$content.find( 'audio,video' ).mediaelementplayer();
			}
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		SonicCategoryFilter.init();
	} );

} )( jQuery );