<?php
/**
 * Wolf Page Builder admin functions
 *
 * General  functions available on admin.
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
 * Get WPB content from frontend.
 *
 * It is a temporary soution to pass the page builder content output from the frontend to YOAST for backend analysis
 * Without having to messing with shortcodes in admin and such non-WP things
 */
function wpb_admin_get_content( $post_id ) {
	
	if ( ! $post_id ) {
		return;
	}
	
	$url = get_permalink( $post_id );

	// send request
	$response = wp_remote_get( $url , array(
			'timeout' => 10,
		)
	);

	// get result if no error
	if ( ! is_wp_error( $response ) && is_array( $response ) ) {
		
		$html = wp_remote_retrieve_body( $response ); // use the content

		if ( $html ) {
			$dom = new DOMDocument;
			$dom->preserveWhiteSpace = false;
			libxml_use_internal_errors( true ); // hide HTML5 error
			$dom->loadHTML( $html );
			libxml_use_internal_errors( false );
			$xpath = new DOMXPath( $dom );
			$div = $xpath->query( '//div[@id="wpb-inner"]' );
			$div = $div->item(0);
			return $dom->saveXML( $div );
		}
	}
}

/**
 * Update option index
 *
 * @param string $value
 * @param string $default
 * @return string
 */
function wpb_update_option_index( $index = 'settings', $options_array ) {

	$wpb_settings = ( get_option( 'wpb_settings' ) && is_array( get_option( 'wpb_settings' ) ) ) ? get_option( 'wpb_settings' ) : array();
	
	$wpb_settings[ $index ] = $options_array;

	update_option( 'wpb_settings', $wpb_settings );
}

/**
 * Update option
 *
 * Update an option value from the plugin settings
 *
 * @param string $value
 * @param string $default
 * @return string
 */
function wpb_update_option( $index = 'settings', $key, $value ) {

	$wpb_settings = ( get_option( 'wpb_settings' ) && is_array( get_option( 'wpb_settings' ) ) ) ? get_option( 'wpb_settings' ) : array();
	
	if ( ! isset( $wpb_settings[ $index ] ) ) {
		$wpb_settings[ $index ] = array();
	}

	$wpb_settings[ $index ][ $key ] = $value;

	update_option( 'wpb_settings', $wpb_settings );
}

/**
 * Get element markup
 * @since 1.0
 */
function wpb_get_element_markup( $basename, $params_values = '' ) {
	
	$elements = wpb_get_elements();

	if ( isset( $elements[ $basename ] ) ) {
		$name = ( isset( $elements[ $basename ]['name'] ) ) ? $elements[ $basename ]['name'] : '';
		$icon = ( isset( $elements[ $basename ]['icon'] ) ) ? $elements[ $basename ]['icon'] : '';
		$params = ( isset( $elements[ $basename ]['params'] ) ) ? $elements[ $basename ]['params'] : array();
		$has_child = ( isset( $elements[ $basename ]['has_child'] ) && true == $elements[ $basename ]['has_child']  );

		ob_start();

		echo wpb_get_element_toolbar( $basename, $name );

		if ( $has_child ) {

			$child_basename = $elements[ $basename ]['child'];
			$child_element_params = $elements[ $child_basename ]['params'];
			$child_element_name = $elements[ $child_basename ]['name'];

			echo '<element class="' . $child_basename . ' wpb-element-child" data-element-id="' . $child_basename . '"';

				foreach ( $child_element_params as $key => $param ) {
					$param_name = $param['param_name'];
					$param_value = (  isset( $param['value'] ) ) ? esc_attr( $param['value'] ) : '';
					echo ' data-' . $param_name . '="' . $param_value . '"';
				}

				echo '>';

				echo wpb_get_element_toolbar( $child_basename, $child_element_name );
				
				echo wpb_get_element_properties( $child_basename );
				?>
			</element>
			<?php
		} else {
			echo wpb_get_element_properties( $basename, $params_values );
		}

	}  else { // end if element not known
		echo wpb_get_element_properties( $basename );
	}

	return ob_get_clean();
}

/**
 * Get element properties
 *
 * @since 1.0.0
 */
function wpb_get_element_properties( $basename, $new_params = array() ) {
	$markup = '';

	$elements = wpb_get_elements();
	$params_output = '';

	// element exists
	if ( isset( $elements[ $basename ] ) ) {

		$element_name = ( isset( $elements[ $basename ]['name'] ) ) ? $elements[ $basename ]['name'] : '';
		$icon = ( isset( $elements[ $basename ]['icon'] ) ) ? $elements[ $basename ]['icon'] : '';
		$params = ( isset( $elements[ $basename ]['params'] ) ) ? $elements[ $basename ]['params'] : array();
		$has_child = ( isset( $elements[ $basename ]['has_child'] ) && true == $elements[ $basename ]['has_child'] );

		if ( $has_child ) {
			return;
		}
		
		foreach ( $params as $key => $param ) {

			$param_name =  $param[ 'param_name' ];

			// if param is set
			if ( isset( $new_params[ $param_name ] ) ) {
				
				$name = sanitize_text_field( $param['param_name'] );
				$type = sanitize_text_field( $param['type'] );
				$label = ( isset( $param['label'] ) ) ? sanitize_text_field( $param['label'] ) : '';
				$default_value = ( isset( $param['value'] ) ) ? $param['value'] : null;
				$display = ( isset( $param['display'] ) && true == $param['display'] );

				if ( $display ) {
					$value =$new_params[ $param_name ];

					if ( $value ) {

						$len = 14;
						if ( 'textarea_html' == $type || 'textarea' == $type || 'editor' == $type ) {

							$value = wpb_sample( wpb_decode_textarea_html( $value ), $len );

						} else {
							$value = wpb_sample( sanitize_text_field( stripslashes( $value ) ), $len );
						}

						$params_output .= "<strong>$label</strong> &mdash; $value <br>";
					}
				}
			}
		}

		foreach ( $new_params as $setting_name => $setting_value ) {
			
			// $params_output .= $setting_name . ' &mdash; ' . sanitize_text_field( $setting_value );
		}

		$markup = '<aside class="wpb-element-properties wpb-clearfix">
			<span class="wpb-element-icon-container">
				<span class="' . esc_attr( $icon ) . '"></span>
			</span>
			<span class="wpb-element-properties-caption">
				<span class="wpb-element-title">' . sanitize_text_field( $element_name ) . '</span><br>
				<span class="wpb-element-params">' . $params_output . '</span>
			</span>
		</aside>';

	} else {
		//unknown element
		$message = esc_html__( 'This shortcode is deprecated or is from a disabled plugin', 'wolf-page-builder' );
		$markup = '<aside class="wpb-element-properties wpb-clearfix">
				<span class="wpb-element-icon-container">
					<span class="wpb-icon wpb-unknown"></span>
				</span>
				<span class="wpb-element-properties-caption">
					<span class="wpb-element-title">' . $basename  . '</span><br>
					<span class="wpb-element-params">' . $message . '</span>
				</span>
			</aside>';

		// $markup = '';
	}

	return $markup;
}

/**
 * Get element properties
 *
 * @since 1.0.0
 */
function wpb_get_element_properties_bak( $basename, $params_values = '' ) {
	$markup = '';
	$elements = wpb_get_elements();

	if ( isset( $elements[ $basename ] ) ) {

		$name = ( isset( $elements[ $basename ]['name'] ) ) ? $elements[ $basename ]['name'] : '';
		$icon = ( isset( $elements[ $basename ]['icon'] ) ) ? $elements[ $basename ]['icon'] : '';
		$params = ( isset( $elements[ $basename ]['params'] ) ) ? $elements[ $basename ]['params'] : array();
		$has_child = ( isset( $elements[ $basename ]['has_child'] ) && true == $elements[ $basename ]['has_child'] );
		$parent = ( isset( $elements[ $basename ]['parent'] ) ) ? $elements[ $basename ]['parent'] : '';

		if ( $has_child ) {
			$child_element = $elements[ $basename ]['child'];
			$child_element_params = $elements[ $child_element ]['params'];
			$child_element_name = $elements[ $child_element ]['name'];

			$markup = '<aside class="wpb-element-action">
				<span class="wpb-edit-element wpb-tipsy" data-element="' . esc_attr( $child_element ) . '" title="' . sprintf( esc_html__( '%s settings', 'wolf-page-builder' ), $child_element_name ) . '"></span>
				<span class="wpb-duplicate-element wpb-tipsy" title="' .  esc_html__( 'Duplicate element', 'wolf-page-builder' ) . '"></span>
				<span class="wpb-remove-element wpb-tipsy" title="' .  esc_html__( 'Remove element', 'wolf-page-builder' ) . '"></span>
				<span class="wpb-move-element-item" title="' .  esc_html__( 'Move element', 'wolf-page-builder' ) . '"></span>
			</aside>';
			$test = '<aside class="wpb-element-properties wpb-clearfix">
				<span class="wpb-element-icon-container">
					<span class="' .  esc_attr( $icon ) . '"></span>
				</span>
				<span class="wpb-element-properties-caption">
					<span class="wpb-element-title">' .  sanitize_text_field( $child_element_name ) . '</span><br>
					<span class="wpb-element-params"></span>
				</span>
			</aside>';
		} else {
			if ( $parent && ! $icon ) {
				$icon = ( isset( $elements[ $parent ]['icon'] ) ) ? $elements[ $parent ]['icon'] : '';
			}
			$markup = '<aside class="wpb-element-properties wpb-clearfix">
				<span class="wpb-element-icon-container">
					<span class="' . esc_attr( $icon ) . '"></span>
				</span>
				<span class="wpb-element-properties-caption">
					<span class="wpb-element-title">' . sanitize_text_field( $name ) . '</span><br>
					<span class="wpb-element-params">' . $params_values . '</span>
				</span>
			</aside>';
		}

	} else {
		// to do
		$message = esc_html__( 'This shortcode is deprecated or is from a disabled plugin', 'wolf-page-builder' );
		$markup = '<aside class="wpb-element-properties wpb-clearfix">
				<span class="wpb-element-icon-container">
					<span class="wpb-icon wpb-unknown"></span>
				</span>
				<span class="wpb-element-properties-caption">
					<span class="wpb-element-title">' . $basename  . '</span><br>
					<span class="wpb-element-params">' . $message . '</span>
				</span>
			</aside>';

		$markup = '';
	}

	return $markup;
}

/**
 * Get section toolbar icons
 *
 * @since 1.0.0
 */
function wpb_get_section_toolbar( $element, $layout, $section_type ) {

	$markup = '';
	$markup .= '<aside class="wpb-section-action">
			<span class="wpb-move-section" data-element="' . $element . '" title="' . esc_html__( 'Move section', 'wolf-page-builder' ) . '"></span>
			<span class="wpb-collapse-section wpb-tipsy" data-element="' . $element . '" title="' . esc_html__( 'Collapse section', 'wolf-page-builder' ) . '"></span>';

	if ( 'blocks' == $section_type ) {
		$markup .= '<span class="wpb-layout-section wpb-tipsy" data-element="section_blocks_layout" title="' . esc_html__( 'Layout', 'wolf-page-builder' ) . '"></span>';
	}

	$markup .= '<span class="wpb-section-title">section</span>
		<span class="wpb-edit-section wpb-tipsy" data-element="section_' . $section_type . '" title="' . esc_html__( 'Section settings', 'wolf-page-builder' ) . '"></span>
		<span class="wpb-duplicate-section wpb-tipsy" title="' . esc_html__( 'Duplicate section', 'wolf-page-builder' ) . '"></span>
		<span class="wpb-remove-section wpb-tipsy" title="' . esc_html__( 'Remove section', 'wolf-page-builder' ) . '"></span>';

	if ( 'columns' == $section_type ) {
		$markup .= '<span class="wpb-add-row wpb-tipsy" data-element="new_row" title="' . esc_html__( 'Add a row of columns', 'wolf-page-builder' ) . '"></span>';
	}

	$markup .= '</aside>';

	return $markup;
}

/**
 * Get row toolbar
 *
 * @since 1.0.0
 */
function wpb_get_row_toolbar() {
	$markup = '';

	$markup = '<aside>
		<span class="wpb-move-row" data-element="row" title="' . esc_html__( 'Move row', 'wolf-page-builder' ) . '"></span>
		<span class="wpb-layout-row wpb-tipsy" data-element="row_columns_layout" title="' . esc_html__( 'Layout', 'wolf-page-builder' ) . '"></span>
		<span class="wpb-duplicate-row wpb-tipsy" title="' . esc_html__( 'Duplicate row', 'wolf-page-builder' ) . '"></span>
		<span class="wpb-remove-row wpb-tipsy" title="' . esc_html__( 'Remove row', 'wolf-page-builder' ) . '"></span>
		<span class="wpb-edit-row wpb-tipsy" data-element="row" title="' . esc_html__( 'Row Settings', 'wolf-page-builder' ) . '"></span>
	</aside>';

	return $markup;
}

/**
 * Get container toolbar
 *
 * @since 1.0.0
 */
function wpb_get_container_toolbar( $element = 'column' ) {
	$markup = '';

	$markup = '<aside class="wpb-col-action">
		<span class="wpb-action wpb-view-elements wpb-add-element wpb-tipsy" title="' . esc_html__( 'Add element', 'wolf-page-builder' ) . '"></span>
		<span class="wpb-action wpb-edit-column wpb-tipsy" data-element="' . $element . '" title="' . sprintf( esc_html__( '%s Settings', 'wolf-page-builder' ), ucfirst( $element ) ) . '"></span>
		</aside>';

	return $markup;
}

/**
 * Get element toolbar
 *
 * @since 1.0.0
 */
function wpb_get_element_toolbar( $basename, $element_name = '' ) {

	$children_element = wpb_get_child_elements();
	$is_child = isset( $children_element[ $basename ] );
	$markup = '<aside class="wpb-element-action">';

	if ( $is_child && $element_name ) {
		$markup .= '<span class="wpb-move-element-item""></span>';
	}

	if ( $element_name ) {
		$markup .= '<span class="wpb-edit-element wpb-tipsy" data-element="' .  esc_attr( $basename ) . '" title="' . sprintf( esc_html__( '%s Settings', 'wolf-page-builder' ), $element_name ) . '"></span>
		<span class="wpb-duplicate-element wpb-tipsy" title="' .  esc_html__( 'Duplicate element', 'wolf-page-builder' ) . '"></span>';
	}

	$markup .= '<span class="wpb-remove-element wpb-tipsy" title="' .  esc_html__( 'Remove element', 'wolf-page-builder' ) . '"></span>';

	$markup .= '</aside>';

	return $markup;
}

/**
 * Get row layout
 *
 * Returns the row markup for the admin page builder
 *
 * @param string $row_type
 * @param string $layout
 * @return string $markup
 */
function wpb_get_section_layout( $row_type, $layout, $row = true ) {

	$markup = '';
	$element = ( 'columns' == $row_type ) ? 'column' : 'block'; // default singular

	$icons = wpb_get_container_toolbar( $element );

	if ( 'columns' == $row_type ) {

		if ( $row ) {
			$markup .= '<row class="wpb-row" data-layout="' . esc_attr( $layout ) . '">';
		}

		$markup .= wpb_get_row_toolbar();

		if ( '1-cols' == $layout ) {
			$markup .= "<column class='wpb-$element wpb-element-container'>$icons</column>";
		} elseif ( '2-cols' == $layout ) {
			$markup .= "<column class='wpb-$element wpb-element-container wpb-col-6 wpb-first'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-6 wpb-last'>$icons</column>";
		} elseif ( '3-cols' == $layout ) {
			$markup .= "<column class='wpb-$element wpb-element-container wpb-col-4 wpb-first'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-4'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-4 wpb-last'>$icons</column>";
		} elseif ( '4-cols' == $layout ) {
			$markup .= "<column class='wpb-$element wpb-element-container wpb-col-3 wpb-first'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-3'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-3'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-3 wpb-last'>$icons</column>";
		} elseif ( '6-cols' == $layout ) {
			$markup .= "<column class='wpb-$element wpb-element-container wpb-col-2 wpb-first'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-2'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-2'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-2'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-2'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-2 wpb-last'>$icons</column>";
		} elseif ( 'left-sidebar' == $layout ) {
			$markup = "<column class='wpb-$element wpb-element-container wpb-col-4 wpb-first'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-8 wpb-last'>$icons</column>";
		} elseif ( 'right-sidebar' == $layout ) {
			$markup = "<column class='wpb-$element wpb-element-container wpb-col-8 wpb-first'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-4 wpb-last'>$icons</column>";
		} elseif ( 'double-sidebar' == $layout ) {
			$markup .= "<column class='wpb-$element wpb-element-container wpb-col-3 wpb-first'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-6'>$icons</column>
			<column class='wpb-$element wpb-element-container wpb-col-3 wpb-last'>$icons</column>";
		}

		if ( $row ) {
			$markup .= '</row>';
		}
	}

	if ( 'blocks' == $row_type ) {
		if ( '1-cols' == $layout ) {
			$markup = "<block class='wpb-$element  wpb-element-container'>$icons</block>";
		} elseif ( '2-cols' == $layout ) {
			$markup = "<block class='wpb-$element wpb-element-container'>$icons</block>
			<block class='wpb-$element wpb-element-container'>$icons</block>";
		} elseif ( '3-cols' == $layout ) {
			$markup = "<block class='wpb-$element wpb-element-container'>$icons</block>
			<block class='wpb-$element wpb-element-container'>$icons</block>
			<block class='wpb-$element wpb-element-container'>$icons</block>";
		} elseif ( '4-cols' == $layout ) {
			$markup = "<block class='wpb-$element wpb-element-container'>$icons</block>
			<block class='wpb-$element wpb-element-container'>$icons</block>
			<block class='wpb-$element wpb-element-container'>$icons</block>
			<block class='wpb-$element wpb-element-container'>$icons</block>";
		} elseif ( '6-cols' == $layout ) {
			$markup = "<block class='wpb-$element wpb-element-container'>$icons</block>
			<block class='wpb-$element wpb-element-container'>$icons</block>
			<block class='wpb-$element wpb-element-container'>$icons</block>
			<block class='wpb-$element wpb-element-container'>$icons</block>
			<block class='wpb-$element wpb-element-container'>$icons</block>
			<block class='wpb-$element wpb-element-container'>$icons</block>";
		}
	}

	return $markup;
}

/**
 * Get section markup - will be inserted with ajax
 *
 * @param string $element
 * @param string $layout
 * @param string $section_type
 * @return string $markup
 */
function wpb_get_section_markup( $element, $layout, $section_type ) {

	$markup =  '';

	$markup .= wpb_get_section_layout( $section_type, $layout );
	$markup .= wpb_get_section_toolbar( $element, $layout, $section_type );

	return $markup;
}

/**
 * Get the rev slider list
 *
 * @access public
 * @see http://themeforest.net/forums/thread/add-rev-slider-to-theme-please-authors-reply/97711
 * @return array $result
 */
function wpb_get_revsliders() {

	if ( class_exists( 'RevSlider' ) ) {
		$theslider     = new RevSlider();
		$arrSliders = $theslider->getArrSliders();
		$arrA     = array();
		$arrT     = array();
		foreach( $arrSliders as $slider ) {
			$arrA[]     = $slider->getAlias();
			$arrT[]     = $slider->getTitle();
		}

		if ( $arrA && $arrT ) {
			$result = array_combine( $arrA, $arrT );
		} else {
			$result = array( '' => esc_html__( 'No slider yet', 'wolf-page-builder' ) );
		}
		return $result;
	}
}

/**
 * Custom admin notice
 *
 * @access public
 * @param string $message
 * @param string $type
 * @param bool $dismiss
 * @param string $id
 * @return bool
 */
function wpb_admin_notice( $message = null, $type = null, $dismiss = false, $id = null ) {

	if ( $dismiss ) {

		$dismiss = esc_html__( 'Hide permanently', 'wolf-page-builder' );

		if ( $id ) {
			if ( ! isset( $_COOKIE[ $id ] ) )
				echo "<div class='$type'><p>$message<span class='wpb-close-admin-notice'>&times;</span><span id='$id' class='wpb-dismiss-admin-notice'>$dismiss</span></p></div>";
		} else {
			echo "<div class='$type'><p>$message<span class='wpb-close-admin-notice'>&times;</span></p></div>";
		}
	} else {
		echo "<div class='$type'><p>$message</p></div>";
	}

	return false;
}
add_action( 'admin_notices', 'wpb_admin_notice' );

/**
 * Get twitter username from plugin options
 */
function wpb_get_twitter_usename() {
	$default_twitter_username = wpb_get_option( 'socials', 'twitter' );

	if ( $default_twitter_username ) {
		if ( preg_match( '/twitter.com\/[a-zA-Z0-9_]+/', $default_twitter_username, $match) ) {
			$default_twitter_username = str_replace( 'twitter.com/', '', $match[0] );
			return $default_twitter_username;
		}
	}
}

/**
 * Change colors depending on admin skin
 */
function wpb_set_admin_color() {
	global $_wp_admin_css_colors;
	$admin_colors = $_wp_admin_css_colors;
	$current_scheme = get_user_option( 'admin_color' );
	$admin_basic_color = $admin_colors[ $current_scheme ]->colors[1];
	$admin_accent_color = $admin_colors[ $current_scheme ]->colors[3];

	// var_dump( $admin_colors );

	$css = "
	.wpb-add-section:before {
	  color:$admin_basic_color;
	}

	.wpb-welcome-panel a:hover,
	label.wpb-radio-image-label input[type=radio]:checked + img {
	  border-color: $admin_accent_color;
	}

	.wpb-welcome-panel a:hover{
		color:$admin_accent_color;
	}

	.wpb-dialog-elements .wpb-element:hover{
		background-color: $admin_accent_color;
	}
	";
	?>
	<style type="text/css">
	/* Admin accent color */
	<?php echo wpb_esc_style_attr( $css ); ?>
	</style>
	<?php
}
add_action( 'admin_head', 'wpb_set_admin_color' );

/**
 * Remove all files in a folder
 *
 * Used to clean the template text file after importation in the uploads/wpb-export-tmp
 *
 * @param string $dirname
 */
function wpb_clean_folder( $dirname ) {
	$files = glob( $dirname . '/*' ); // get all file names
	foreach( $files as $file ){ // iterate files
	if( is_file( $file ) )
		unlink( $file ); // delete file
	}
}

/**
 * Get the content of a file using WP_filesystem
 *
 * @param string $file
 */
function wpb_file_get_contents( $file ) {

	if ( $file ) { // ensure we're in the admin
		$response = wp_remote_get( $file );
		if ( is_array( $response ) ) {
			return $response['body'];
		}
	}
}

/**
 * Sanitize HTML markup by allowing all elements params as data attributes
 *
 * @param string $string
 * @return string $string
 */
function wpb_sanitize_html_markup( $string = '' ) {

	$sanitize_string = wpb_clean_spaces( stripslashes( force_balance_tags( $string ) ) ); // clean up a bit before sanitize

	$data_attributes = array();
	$elements = wpb_get_elements();
	$allowed_tags = array( 'section', 'row', 'block', 'column', 'element', 'element_container' );

	if ( isset( $value['params'] ) ) {
		foreach ( $elements as $key => $value ) {
			foreach ( $value['params'] as $param ) {
				array_push( $data_attributes,  $param['param_name'] );
			}
		}
	}

	$allowed_html = array(
		'label' => array(),
		'strong' => array(),
		'br' => array(),
		'div' => array(
			'class' => array(),
		),
		'span' => array(
			'class' => array(),
			'title' => array(),
			'data-element' => array(),
		),
		'aside' => array(
			'class' => array(),
		),
	);

	// $data_attributes = array_unique( $data_attributes );

	foreach ( $allowed_tags as $tags ) {

		$allowed_html[ $tags ] = array(
			//'style' => array(),
			'class' => array(),
			'data-element-id' => array(),
			'data-section_type' => array(),
			'data-layout' => array(),
		);

		foreach ( $data_attributes as $data ) {

			if ( '' != $data ) {
				$allowed_html[ $tags ][ "data-$data" ] = array();
			}
		}
	}

	//debug( $allowed_html );
	$sanitize_string = preg_replace( '/<!--(.*?)-->/s', '', $sanitize_string );

	// return wp_kses( $sanitize_string, $allowed_html );
	return $sanitize_string;
}

/**
 * Check if we can't enable the page builder admin
 */
function wpb_do_admin_wpb() {

	global $pagenow;

	$new_page = 'post-new.php' == $pagenow && in_array( get_post_type(), wpb_get_allowed_post_types() );
	$edit_page = 'post.php' == $pagenow && in_array( get_post_type(), wpb_get_allowed_post_types() );

	$is_blog_page = ( isset( $_GET['post'] ) && get_option( 'page_for_posts' ) == absint( $_GET['post'] ) );

	if ( ! $is_blog_page ) {
		return $new_page || $edit_page;
	}
}

/**
  * Get theme author name
  */
function wpb_is_wolf_theme() {
	$theme = wp_get_theme();

	return 'WolfThemes' == $theme->Author;
}

/**
 * Fetch XML changelog file from remote server
 *
 * Get the theme changelog and cache it in a transient key
 *
 * @return string
 */
function wpb_get_changelog() {

	$xml = null;
	$changelog_url = 'http://plugins.' . WPB_WOLF_DOMAIN .'/wolf-page-builder/changelog.xml';
	$cache_time = 21600;

	if ( WPB_DEV ) {
		$changelog_url = WPB_URI . '/pack/dist/changelog.xml';
		$cache_time = 60 * 60;
	}

	$trans_key = '_wpb_latest_version';

	// delete_transient( $trans_key );

	if ( false === ( $cached_xml = get_transient( $trans_key ) ) ) {

		$response = wp_remote_get( $changelog_url , array( 'timeout' => 10 ) );

		if ( is_array( $response ) ) {
			$xml = $response['body']; // use the content
		}

		if ( $xml ) {
			set_transient( $trans_key, $xml, $cache_time );
		}
	} else {
		$xml = $cached_xml;
	}

	if ( $xml ) {
		return @simplexml_load_string( $xml );
	}
}

/**
 * Check if Firefox
 *
 * @return bool
 */
function wpb_is_firefox() {

	if ( preg_match( '#Firefox#', $_SERVER['HTTP_USER_AGENT'], $browser_version ) ) {
		if ( $browser_version[0] ) {
			return $_SERVER['HTTP_USER_AGENT'];
		}
	}
}

/**
 * Put content in a file using WP_filesystem
 *
 * @param string $file
 * @param string $content
 */
function wpb_file_put_contents( $file, $content ) {

	if ( function_exists( 'WP_Filesystem' ) ) { // ensure we're in the admin
		WP_Filesystem();
		global $wp_filesystem;
		return $wp_filesystem->put_contents( $file, $content, FS_CHMOD_FILE );
	}
}

/**
 * Check if the WP uploads folder is writable
 *
 * @since 1.8
 * @return bool
 */
function wpb_is_wp_upload_folder_writable() {

	$upload_dir = wp_upload_dir();
	$path = $upload_dir['basedir'];
	return wp_is_writable( $path );
}

/**
 * Fix to show changes on preview page
 *
 * @see https://support.advancedcustomfields.com/forums/topic/preview-solution/
 */