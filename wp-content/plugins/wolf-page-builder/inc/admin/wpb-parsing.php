<?php
/**
 * Wolf Page Builder parsing functions
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Convert backend shortcode content to markup content
 *
 * Parse shortcodes and update it as HTML admin markup.
 * Allows to change the markup if it has been updated based on the shortocde content
 *
 * @param string $markup
 * @return string $markup
 * @since 1.7
 */
function wpb_shortcode_to_markup_admin( $markup ) {

	$markup = wpb_clean_shortcodes( $markup );
	
	$element_name_regex = '[a-zA-Z0-9-_]+';
	// А-я is cyrilic
	$_attrs_regex = '[a-zA-ZŽžšŠÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçČčÌÍÎÏìíîïÙÚÛÜùúûüÿÑñйА-яц= {}0-9#@|\%_\.:;,+\/\/\?!\'%&€^¨°¤£$§~()`*"-]+';
	$_all_regex = '(.*?)';

	/* 1. Replace closing tags */
	$shortcode_closing_tags = array( '[/wpb_section]', '[/wpb_row]', '[/wpb_col]', '[/wpb_block]' );
	$html_closing_tags = array(
		'</section>',
		'</row>',
		'</column>',
		'</block>'
	);

	$markup = str_replace( $shortcode_closing_tags, $html_closing_tags, $markup );
	$markup = preg_replace( '/\[\/' . $element_name_regex . '\]/', '</element_container>', $markup );

	/* 2. Parse all other opening shortcode */

	// shortcode without attribute
	$markup = preg_replace_callback( '/\[' . $element_name_regex . '\]/', function( $matches ) {

		$output = '';

		foreach ( $matches as $shortcode ) {

			// just in case
			$shortcode = wpb_clean_spaces( $shortcode ); // remove double spaces
			$shortcode = str_replace( ' ', '', $shortcode ); // remove spaces if any

			// shortcode basename
			$basename = str_replace( array( '[', ']' ), '', $shortcode );

			if ( 'wpb_section' == $basename ) {

				$tag = 'section';
				$class .= 'wpb_section';
				$section_type = 'columns';

			} elseif ( 'wpb_row' == $basename ) {

				$tag = 'row';
				$class .= 'wpb-row';

			} elseif ( 'wpb_col' == $basename ) {

				$tag = 'column';
				$class .= 'wpb-column wpb-element-container ';

			} elseif ( 'wpb_block' == $basename ) {

				$tag = 'block';
				$class .= 'wpb-block wpb-element-container ';

			// element
			} else {

				$element_settings = array();
				$all_elements = wpb_get_elements();
				$parent_elements = wpb_get_parent_elements();
				$child_elements = wpb_get_child_elements();
				
				$all_elements_keys = array();
				foreach ( $all_elements as $element => $params ) {
					$all_elements_keys[] = $element;
				}

				$parent_elements_keys = array();
				foreach ( $parent_elements as $element => $params ) {
					$parent_elements_keys[] = $element;
				}

				$children_elements_keys = array();
				foreach ( $child_elements as $element => $params ) {
					$children_elements_keys[] = $element;
				}

				// parent element
				if ( in_array( $basename, $parent_elements_keys ) ) {
					
					$tag = 'element_container';
					$class = $basename . ' wpb-element-has-children';
				
				// child element
				} elseif ( in_array( $basename, $children_elements_keys ) ) {

					$tag = 'element';
					$class = $basename . ' wpb-element-child';

				// standard element
				} elseif ( in_array( $basename, $all_elements_keys ) ) {

					$tag = 'element';
					$class = $basename;

				// unknown element, deprecated or from disabled plugin
				} else {

					// debug( $basename );
					$tag = 'element';
					$class = $basename . ' wpb-unknown-element';
				}

				$data = 'data-element-id="' . $basename . '"';
			}



			$html .= '<' . $tag . ' class="' . wpb_sanitize_html_classes( $class ) . '" ' . $data . '>';

			/* Toobar depending on element type */
			if ( 'section' == $tag ) {
				
				$toolbar .= wpb_get_section_toolbar( "section_$section_type", $layout, $section_type );
			
			} elseif ( 'row' == $tag ) {
				
				$toolbar .= wpb_get_row_toolbar();
			
			} elseif ( 'column' == $tag  || 'block' == $tag ) {

				$toolbar .= wpb_get_container_toolbar( $tag );
			
			} elseif ( 'element_container' == $tag ) {

				$element_name = $all_elements[ $basename ]['name'];
				$toolbar .= wpb_get_element_toolbar( $basename, $element_name );

			} elseif ( 'element' == $tag ) {

				$element_name = ( $all_elements[ $basename ]['name'] ) ? $all_elements[ $basename ]['name'] : '';
				$toolbar .= wpb_get_element_toolbar( $basename, $element_name );
			}

			$html .= $toolbar; // insert toolbar
			
			// close if standard element as it is not handled by the first part of the function
			if ( 'element' === $tag ) {

				$html .= wpb_get_element_properties( $basename, $element_settings );
				$html .= '</element>';
			}

			// replace shortcode my html markup
			$output .= str_replace( $shortcode, $html, $shortcode );
		}

		return $output;

	}, $markup );

	// shortcode with attributes
	$markup = preg_replace_callback( '/\[' . $element_name_regex . ' ' . $_attrs_regex . '\]/', function( $matches ) {
		
		$output = '';

		foreach ( $matches as $shortcode ) {

			$parsed_shortcode = shortcode_parse_atts( $shortcode );
			$basename = str_replace( '[', '', $parsed_shortcode[0] );
			$args = str_replace( array( '[' . $basename, ']' ), '', $shortcode );
			$attrs = shortcode_parse_atts( $args );

			$html = '';
			$toolbar = '';
			$tag = ''; // section, row, column, block, element_container, element
			$data = '';
			$class = '';
			
			if ( 'wpb_section' == $basename ) {

				$tag = 'section';
				$class .= 'wpb_section';
				$section_type = '';

				if ( is_array( $attrs ) ) {
					
					foreach ( $attrs as $attr_name => $attr_value ) {

						if ( '' != $attr_value ) {
							$data .= ' data-' . $attr_name . '="' . $attr_value . '"';

							// section type
							if ( 'section_type' == $attr_name ) {
								$section_type = $attr_value;
								$class .= " wpb_section_$attr_value wpb-$attr_value";
							}

							// section layout
							if ( 'layout' == $attr_name ) {
								$layout = $attr_value;
								$class .= " wpb-$attr_value";
							}
						}
					}
				}
			
			} elseif ( 'wpb_row' == $basename ) {

				$tag = 'row';
				$class .= 'wpb-row';

				if ( is_array( $attrs ) ) {
					foreach ( $attrs as $attr_name => $attr_value ) {

						if ( '' != $attr_value ) {
							$data .= ' data-' . $attr_name . '="' . $attr_value . '"';
						}

						if ( 'layout' == $attr_name ) {
							$class .= " wpb-$attr_value";
						}
					}
				}

			} elseif ( 'wpb_col' == $basename ) {

				$tag = 'column';
				$class .= 'wpb-column wpb-element-container ';

				if ( is_array( $attrs ) ) {
					foreach ( $attrs as $attr_name => $attr_value ) {

						if ( '' != $attr_value && 'class' == $attr_name ) {
							
							$class .= ' ' . $attr_value;
							//$data .= ' data-' . $attr_name . '="' . $attr_value . '"';
						
						} elseif ( '' != $attr_value ) {
							$data .= ' data-' . $attr_name . '="' . $attr_value . '"';
						}
					}
				}
			
			} elseif ( 'wpb_block' == $basename ) {

				$tag = 'block';
				$class .= 'wpb-block wpb-element-container ';

				if ( is_array( $attrs ) ) {
					foreach ( $attrs as $attr_name => $attr_value ) {

						if ( '' != $attr_value ) {
							$data .= ' data-' . $attr_name . '="' . $attr_value . '"';
						}
					}
				}

			// element
			} else {
				$element_settings = array();
				$all_elements = wpb_get_elements();
				$parent_elements = wpb_get_parent_elements();
				$child_elements = wpb_get_child_elements();
				
				$all_elements_keys = array();
				foreach ( $all_elements as $element => $params ) {
					$all_elements_keys[] = $element;
				}

				$parent_elements_keys = array();
				foreach ( $parent_elements as $element => $params ) {
					$parent_elements_keys[] = $element;
				}

				$children_elements_keys = array();
				foreach ( $child_elements as $element => $params ) {
					$children_elements_keys[] = $element;
				}

				// parent element
				if ( in_array( $basename, $parent_elements_keys ) ) {
					
					$tag = 'element_container';
					$class = $basename . ' wpb-element-has-children';
				
				// child element
				} elseif ( in_array( $basename, $children_elements_keys ) ) {

					$tag = 'element';
					$class = $basename . ' wpb-element-child';

				// standard element
				} elseif ( in_array( $basename, $all_elements_keys ) ) {

					$tag = 'element';
					$class = $basename;

				// unknown element, deprecated or from disabled plugin
				} else {

					$tag = 'element';
					$class = $basename . ' wpb-unknown-element';
				}

				$data = 'data-element-id="' . $basename . '"';

				// set data attr for all elements
				if ( is_array( $attrs ) ) {
					foreach ( $attrs as $attr_name => $attr_value ) {

						if ( '' != $attr_value ) {
							$data .= ' data-' . $attr_name . '="' . $attr_value . '"';
							if ( 'class' != $attr_name ) {
								$element_settings[ $attr_name ] = $attr_value;
							}
						}
					}
				}
			}

			$html .= '<' . $tag . ' class="' . wpb_sanitize_html_classes( $class ) . '" ' . $data . '>';

			/* Toobar depending on element type */
			if ( 'section' == $tag ) {
				
				$toolbar .= wpb_get_section_toolbar( "section_$section_type", $layout, $section_type );
			
			} elseif ( 'row' == $tag ) {
				
				$toolbar .= wpb_get_row_toolbar();
			
			} elseif ( 'column' == $tag  || 'block' == $tag ) {

				$toolbar .= wpb_get_container_toolbar( $tag );
			
			} elseif ( 'element_container' == $tag ) {

				$element_name = $all_elements[ $basename ]['name'];
				$toolbar .= wpb_get_element_toolbar( $basename, $element_name );

			} elseif ( 'element' == $tag ) {

				$element_name = ( $all_elements[ $basename ]['name'] ) ? $all_elements[ $basename ]['name'] : '';
				$toolbar .= wpb_get_element_toolbar( $basename, $element_name );
			}

			$html .= $toolbar; // insert toolbar
			
			// close if standard element as it is not handled by the first part of the function
			if ( 'element' === $tag ) {

				$html .= wpb_get_element_properties( $basename, $element_settings );
				$html .= '</element>';
			}

			// replace shortcode my html markup
			$output .= str_replace( $shortcode, $html, $shortcode );
		}

		return $output;
		// return '';
	}, $markup );

	/* 3. Clean up what's left. Just remove anything unclean that couldn't be parsed */
	$markup = preg_replace( '/\[' . $_all_regex . '\]/', '', $markup );
	$markup = preg_replace( '/\[' . $_all_regex . ' ' . $_all_regex . '\]/', '', $markup );

	return wpb_sanitize_html_markup( $markup );
	// return $markup;
}

/**
 * Convert backend markup to shortcode content
 *
 * @param string $markup
 * @return string $markup
 */
function wpb_markup_to_shortcode( $markup ) {

	// clean markup
	$markup = wpb_sanitize_html_markup( $markup );

	// remove any style attribute
	$markup = preg_replace( '# style="(.*?)"#', '', $markup );

	// first set the class attribute at first for all
	$tags = array( 'section', 'row', 'column', 'block', 'element_container', 'element' );

	// remove unnecessary content like admin buttons
	$markup = preg_replace( '#<aside(.*?)>(.*?)</aside>#', '', $markup ); // remove action icons
	$markup = preg_replace( '#<button(.*?)>(.*?)</button>#', '', $markup ); // remove add element button
	$markup = preg_replace( '#<templates(.*?)>(.*?)</templates>#', '', $markup ); // remove templates

	// clean up shortcodes
	$markup = preg_replace( '#<section(.*?)>(.*?)</section>#', '[wpb_section $1]$2[/wpb_section]', $markup );
	$markup = preg_replace( '#<row(.*?)>(.*?)</row>#', '[wpb_row $1]$2[/wpb_row]', $markup );
	$markup = preg_replace( '#<column(.*?)>(.*?)</column>#', '[wpb_col $1]$2[/wpb_col]', $markup );
	$markup = preg_replace( '#<block(.*?)>(.*?)</block>#', '[wpb_block $1]$2[/wpb_block]', $markup );

	$markup = preg_replace( '#<element_container(.*?)data-element-id="(.*?)"(.*?)>(.*?)</element_container>#', '[$2 $1 $3]$4[/$2]', $markup );
	$markup = preg_replace( '#<element(.*?)data-element-id="(.*?)"(.*?)>(.*?)</element>#', '[$2 $1 $3]', $markup );

	// remove data prefix and unnecessary classes
	$markup = str_replace( array(
		'data-',
		'-handle',
		'wpb-active-container',
		'ui-sortable',
		'wpb-element-container',
		'wpb-element-child',
		), '', $markup );

	$markup = preg_replace( '# [^\s]+="" #', ' ', $markup );

	//$markup = preg_replace( '# class="(.*?)" class="(.*?)" #', 'class="$1" ', $markup );
	return wpb_clean_shortcodes( $markup );
}