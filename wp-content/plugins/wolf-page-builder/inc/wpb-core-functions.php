<?php
/**
 * Wolf Page Builder core functions
 *
 * General core functions available on admin and frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Core
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ouput page builder meta instead of content
 *
 * @since Wolf Page Builder 1.0
 */
function wpb_get_content( $post_id = null ) {
	
	$post_id = ( $post_id ) ? $post_id : get_the_ID();
	$shortcodes = get_post_meta( $post_id, '_wpb_shortcode_content', true );
	$status = get_post_meta( $post_id, '_wpb_status', true );

	if ( 'on' == $status && ! post_password_required() ) {
		
		$content = '<div id="wpb-inner">';
		$content .= do_shortcode( wpb_clean_shortcodes( $shortcodes ) );
		$content .= '</div><!--#wpb-inner-->';
	} else {
		ob_start();
		the_content();
		$content = ob_get_clean();
	}

	return $content;
}

/**
 * Get socials services
 */
function wpb_get_socials() {

	$wpb_socials = array();
	
	include_once( WPB_DIR . '/inc/globals/socials.php' );

	$wpb_socials = apply_filters( 'wpb_socials', $wpb_socials );

	array_unique( $wpb_socials );
	sort( $wpb_socials );

	return $wpb_socials;
}

/**
 * Get animations
 */
function wpb_get_animations() {

	$wpb_animations = array();
	
	include_once( WPB_DIR . '/inc/globals/animations.php' );

	$wpb_animations = apply_filters( 'wpb_animations', $wpb_animations );

	array_unique( $wpb_animations );
	sort( $wpb_animations );

	return $wpb_animations;
}

/**
 * Get templates services
 */
function wpb_get_templates() {

	$wpb_templates = array();
	
	include_once( WPB_DIR . '/inc/globals/templates.php' );

	$wpb_templates = apply_filters( 'wpb_templates', $wpb_templates );

	return $wpb_templates;
}

/**
 * Get the content of a template
 *
 * @param string $name
 * @return string
 */
function wpb_get_template_content( $name ) {
	$wpb_templates = wpb_get_templates();
	if ( isset( $wpb_templates[ $name ] ) ) {
		return sanitize_text_field( $wpb_templates[ $name ]['content'] );
	}
}

/**
 * Get element list in array top help including files
 */
function wpb_get_element_list() {
	
	$wpb_elements = array();

	include_once( WPB_DIR . '/inc/globals/elements.php' );

	// apply filters
	$wpb_elements = apply_filters( 'wpb_element_list', $wpb_elements );
	
	// sort by alphabetical order
	sort( $wpb_elements );

	// put text blog at first
	unset( $wpb_elements['text-block'] );
	array_unshift( $wpb_elements, 'text-block' );

	return $wpb_elements;
}

/**
 * Add image sizes
 *
 * These size will be ued for galleries and sliders
 */
function wpb_add_image_sizes() {

	// Standard
	add_image_size( 'wpb-thumb', 640, 360, true );
	add_image_size( 'wpb-video-thumb', 480, 270, true );
	add_image_size( 'wpb-portrait', 600, 900, true );

	// Slides
	add_image_size( 'wpb-slide', 1200, 700, true );
	add_image_size( 'wpb-slide-tablet', 625, 450, true );
	add_image_size( 'wpb-slide-laptop', 676, 424, true );
	add_image_size( 'wpb-slide-desktop', 922, 506, true );
	add_image_size( 'wpb-slide-mobile', 277, 494, true );

	// mosaic
	add_image_size( 'wpb-2x1', 960, 480, true ); // landscape
	add_image_size( 'wpb-2x2', 960, 960, true ); // square
	add_image_size( 'wpb-1x2', 480, 960, true ); // portrait
	add_image_size( 'wpb-XL', 2000, 1500, false ); // XL
}
add_action( 'init', 'wpb_add_image_sizes' );

/**
 * Get any thumbnail URL
 *
 * @since Wolf Page Builder 1.7.0
 * @param string $format
 * @param int $post_id
 * @return string
 */
function wpb_get_post_thumbnail_url( $format = 'medium', $post_id = null ) {
	global $post;

	if ( is_object( $post ) && isset( $post->ID ) && null == $post_id ) {

		$ID = $post->ID;
	} else {
		$ID = $post_id;
	}

	if ( $ID && has_post_thumbnail( $ID ) ) {

		$attachment_id = get_post_thumbnail_id( $ID );
		if ( $attachment_id ) {
			$img_src = wp_get_attachment_image_src( $attachment_id, $format );

			if ( $img_src && isset( $img_src[0] ) )
				return esc_url( $img_src[0] );
		}
	}
}

/**
 * Get template part
 *
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function wpb_get_template_part( $slug, $name = '' ) {
	
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/wpb/slug-name.php
	if ( $name ) {
		$template = locate_template( array( "{$slug}-{$name}.php", WPB()->template_path() . "{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( WPB()->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
		$template = WPB()->plugin_path() . "/templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/wpb/slug.php
	if ( ! $template ) {
		$template = locate_template( array( "{$slug}.php", WPB()->template_path() . "{$slug}.php" ) );
	}

	// Allow 3rd party plugin filter template file from their plugin
	if ( $template ) {
		$template = apply_filters( 'wpb_get_template_part', $template, $slug, $name );
	}

	if ( $template ) {
		load_template( $template, false );
	}
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *	yourtheme/	$template_path	/	$template_name
 *	yourtheme/	$template_name
 *	$default_path/	$template_name
 *
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function wpb_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	if ( ! $template_path ) {
		$template_path = WPB()->template_path();
	}

	if ( ! $default_path ) {
		$default_path = WPB()->plugin_path() . '/templates/';
	}

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	// Return what we found
	return apply_filters( 'wpb_locate_template', $template, $template_name, $template_path );
}

/**
 * Get other templates passing attributes and including the file.
 *
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function wpb_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( $args && is_array( $args ) ) {
		extract( $args );
	}

	$located = wpb_locate_template( $template_name, $template_path, $default_path );

	if ( ! file_exists( $located ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.9.3' );
		return;
	}

	// Allow 3rd party plugin filter template file from their plugin
	$located = apply_filters( 'wpb_get_template', $located, $template_name, $args, $template_path, $default_path );

	do_action( 'wpb_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'wpb_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a file and return the path for inclusion.
 *
 * Used to check if the file is in a theme folder of from the original plugin directory
 *
 * @param string $filename
 * @return string
 */
function wpb_locate_file( $filename, $context ) {
	
	if ( is_file( get_stylesheet_directory() . '/' . WPB()->extension_path() . '/' .untrailingslashit( $filename ) ) ) {
		
		$file = get_stylesheet_directory() . '/' . WPB()->extension_path() . '/' .untrailingslashit( $filename );
	
	} elseif ( is_file( get_template_directory() . '/' . WPB()->extension_path() . '/' .untrailingslashit( $filename ) ) ) {

		$file = get_template_directory() . '/' . WPB()->extension_path() . '/' .untrailingslashit( $filename );
	
	} else {
		$root = ( 'admin' == $context ) ? 'inc/admin' : 'inc/frontend';
		$file = WPB()->plugin_path() . '/' . $root . '/' . untrailingslashit( $filename );
	}

	// Return what we found
	return apply_filters( 'wpb_locate_file', $file );
}

/**
 * Get WP widget
 *
 * Get the all WP widgtes from the $wp_widget_factory global variable
 *
 * @return array $widgets
 */
function wpb_get_wp_widgets() {
	global $wp_widget_factory;

	$widgets = array();

	if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets ) ) {
		foreach ( $wp_widget_factory->widgets as $widget ) {
			if ( preg_match( '/WP_Widget_[a-zA-Z_]+/', get_class( $widget ), $match ) || preg_match( '/WP_[a-zA-Z_]+_Widget/', get_class( $widget ), $match ) ) {
				$widgets[ get_class( $widget ) ] = $widget;
			}
		}
	}

	return $widgets;
}

/**
 * sanitize_html_class works just fine for a single class
 * Some times le wild <span class="blue hedgehog"> appears, which is when you need this function,
 * to validate both blue and hedgehog,
 * Because sanitize_html_class doesn't allow spaces.
 *
 * @uses sanitize_html_class
 * @param (mixed: string/array) $class   "blue hedgehog goes shopping" or array("blue", "hedgehog", "goes", "shopping")
 * @param (mixed) $fallback Anything you want returned in case of a failure
 * @return (mixed: string / $fallback )
 */
function wpb_sanitize_html_classes( $class, $fallback = null ) {

	// Explode it, if it's a string
	if ( is_string( $class ) ) {
		$class = explode( ' ', $class);
	}

	if ( is_array( $class ) && count( $class ) > 0 ) {
		$class = array_unique( array_map( 'sanitize_html_class', $class ) );
		return trim( implode( ' ', $class ) );
	}
	else {
		return trim( sanitize_html_class( $class, $fallback ) );
	}
}

/**
 * Sanitize html style attribute
 *
 * @param string $style
 * @return string
 */
function wpb_esc_style_attr( $style ) {

	return esc_attr( trim( wpb_clean_spaces( $style ) ) );
}

/**
 * Decode textarea_html
 *
 * The textarea_html field type is encoded in base64 so this function retrieve the clean content
 *
 * @param string $style
 * @return string
 */
function wpb_encode_textarea_html( $string ) {
	//return htmlentities( rawurldecode( base64_decode( $html ) ), ENT_COMPAT, 'UTF-8' );
	$string = base64_encode( $string );
	return $string;
}


/**
 * Decode textarea_html
 *
 * The textarea_html field type is encoded in base64 so this function retrieve the clean content
 *
 * @param string $style
 * @return string
 */
function wpb_decode_textarea_html( $string ) {
	// $string = stripslashes( base64_decode( $string ) );
	$string = wptexturize( rawurldecode( stripslashes( base64_decode( $string ) ) ) );
	return $string;
}

/**
 * Decode textarea
 *
 * Decode, sanitize and output the content of a textarea field
 *
 * @param string $style
 * @return string
 */
function wpb_decode_textarea( $string ) {
	// $string = stripslashes( base64_decode( $string ) );
	$string = wp_kses( nl2br( wpb_decode_textarea_html( $string ) ), array( 'br' => array(), 'strong' => array(), 'em' => array() ) );
	return $string;
}

/**
 * Sanitize color input
 *
 * @param string $color
 * @return string $color
 */
function wpb_sanitize_hex_color( $color ) {
	if ( '' === $color ) {
		return;
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}
}

/**
 * Decode editor
 *
 * @param string $content
 * @return string
 */
function wpb_format_editor_content( $content ) {

	$content = wpb_decode_textarea_html( $content );

	$array = array(
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']',
	);
	$content = strtr( $content, $array );
	$content = apply_filters( 'the_content', $content );

	return $content;
}

/**
 * Get option
 *
 * Retrieve an option value from the plugin settings
 *
 * @param string $value
 * @param string $default
 * @return string
 */
function wpb_get_option( $index = 'settings', $name, $default = null ) {

	global $options;

	$wpb_settings = ( get_option( 'wpb_settings' ) && is_array( get_option( 'wpb_settings' ) ) ) ? get_option( 'wpb_settings' ) : array();

	if ( isset( $wpb_settings[ $index ] ) && is_array( $wpb_settings[ $index ] ) ) {
		
		if ( isset( $wpb_settings[ $index ][ $name ] ) && '' != $wpb_settings[ $index ][ $name ] ) {
			
			return $wpb_settings[ $index ][ $name ];
		
		} elseif ( $default ) {
			
			return $default;
		}
		
	} elseif ( $default ) {
		
		return $default;
	}
}

/**
 * Get the URL of an attachment from its id
 *
 * @param int $id
 * @param string $size
 * @return string $url
 */
function wpb_get_url_from_attachment_id( $id, $size = 'thumbnail' ) {
	if ( is_numeric( $id ) ) {
		$src = wp_get_attachment_image_src( absint( $id ), $size );
		
		if ( isset( $src[0] ) ) {

			return esc_url( $src[0] );
		}
	}
}

/**
 * Return an ID of an attachment by searching the database with the file URL.
 *
 * First checks to see if the $url is pointing to a file that exists in
 * the wp-content directory. If so, then we search the database for a
 * partial match consisting of the remaining path AFTER the wp-content
 * directory. Finally, if a match is found the attachment ID will be
 * returned.
 *
 * @param string $url The URL of the image (ex: http://mysite.com/wp-content/uploads/2013/05/test-image.jpg)
 * @return int|null $attachment Returns an attachment ID, or null if no attachment is found
 */
function wpb_get_id_from_attachment_url( $url ) {

	// Split the $url into two parts with the wp-content directory as the separator
	$parsed_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );

	// Get the host of the current site and the host of the $url, ignoring www
	$this_host = str_ireplace( 'www.', '', parse_url( esc_url( home_url() ), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );

	// Return nothing if there aren't any $url parts or if the current host and $url host do not match
	if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {
		return;
	}

	// Now we're going to quickly search the DB for any attachment GUID with a partial path match
	// Example: /uploads/2013/05/test-image.jpg
	global $wpdb;

	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ) );

	if ( $attachment  && isset( $attachment[ 0 ] ) ) {
		// Returns null if no attachment is found
		return $attachment[ 0 ];
	}
}

/**
 * Get the URL of an attachment by  from its full size URL
 *
 * @param string $url
 * @param string $size
 * @return string $url
 */
function wpb_get_image_by_size_from_url( $url, $size = 'thumbnail' ) {
	return wpb_get_url_from_attachment_id( wpb_get_id_from_attachment_url( esc_url( $url ) ), $size );
}

/**
 * Clean up shortcode markup
 *
 * Remove undesired space from shortcode content
 *
 * @param string $css
 * @return string
 */
function wpb_clean_shortcodes( $markup ) {
	$markup = trim( wpb_clean_spaces( $markup ) );
	$search = array(
		'] [', '[ ', ' ]', '" "', '" ]',

	);
	$replace = array(
		'][', '[', ']', '""', '"]',
	);

	$markup = str_replace( $search, $replace, $markup );

	$markup = stripslashes( $markup );

	return wp_strip_all_tags( $markup );
}

/**
 * Clean a list
 *
 * Remove first and last comma of a list and remove spaces before and after separator
 *
 * @param string $list
 * @return string $list
 */
function wpb_clean_list( $list, $separator = ',' ) {
	$list = str_replace( array( $separator . ' ', ' ' . $separator ), $separator, $list );
	$list = ltrim( $list, $separator );
	$list = rtrim( $list, $separator );
	return $list;
}

/**
 * Remove all double spaces
 *
 * This function is mainly used to clean up inline CSS
 *
 * @param string $css
 * @return string
 */
function wpb_clean_spaces( $string, $hard = true ) {
	return preg_replace( '/\s+/', ' ', $string );
}

/**
 * Convert list of IDs to array
 *
 * @since 1.0.0
 * @param string $list
 * @return array
 */
function wpb_list_to_array( $list, $separator = ',' ) {
	return ( $list ) ? explode( ',', trim( wpb_clean_spaces( wpb_clean_list( $list ) ) ) ) : array();
}

/**
 * Convert array of ids to list
 *
 * @since 1.0.0
 * @param string $list
 * @return array
 */
function wpb_array_to_list( $array ) {
	$list = '';

	if ( is_array( $array ) ) {
		$list = rtrim( implode( ',',  $array ), ',' );
	}

	return wpb_clean_list( $list );
}

/**
 * Convert textarea linee to an array of each lines 
 *
 * @param sting
 * @param string type text|html
 * @return array 
 */
function wpb_texarea_lines_to_array( $text, $type = 'text' ) {
	$array = array();
	$raw_content = wpb_decode_textarea( $text );
	//$raw_content = '';
	$lines = str_replace(
		'\r',
		'\n',
		str_replace( '\r\n', '\n', $raw_content )
	);

	$lines = explode( "\n", $lines );

	if ( is_array( $lines ) ) {
		foreach ( $lines as $line ) {
			 $array[] = ( 'text' == $type ) ? sanitize_text_field( $line ) : $line;
		}
	}

	return $array;
}

/**
 * Get the URL of an iframe src attribute
 *
 * @param string $iframe
 * @return void
 */
function wpb_get_iframe_src( $iframe ) {

	if ( preg_match( '/src="([^"]+)"/', $iframe, $matches ) ) {
		return esc_url( $matches[1] );
	}
}

/**
 * Create a formatted sample of any text
 *
 * Remove HTML and shortcode, sanitize and shorten a string
 *
 * @param string $text
 * @param int $num_words
 * @param string $more
 * @return string
 */
function wpb_sample( $text, $num_words = 55, $more = '...' ) {
	return wp_trim_words( strip_shortcodes( $text ), $num_words, $more );
}

/**
 * Check if a string is an URL
 *
 * @param string $string
 * @return bool
 * @since 1.2.7
 */
function wpb_is_url( $string ) {

	$is_url = filter_var( $string, FILTER_VALIDATE_URL ); // is it a valid URL ?
	//$get_image_size = @getimagesize( $external_link ); // is the URL an image?
	if ( $is_url ) {
		return true;
	}
}

/**
 * Get the post types where the page builder is allowed
 */
function wpb_get_allowed_post_types() {
	$post_types = array( 'page' );

	return $post_types;
}

/**
 * Set default background meta
 */
function wpb_get_bg_meta( $settings_slug, $field_id ) {
	
	$meta = wpb_set_bg_meta(); // default array
	
	$option = wpb_get_option( $settings_slug, $field_id );
	$option = ( is_array( $option ) ) ? $option : array();
	$meta['color'] = ( isset( $option['color'] ) ) ? $option['color'] : '';
	$meta['image_id'] = ( isset( $option['image_id'] ) ) ? $option['image_id'] : '';
	$meta['repeat'] = ( isset( $option['repeat'] ) ) ? $option['repeat'] : '';
	$meta['size'] = ( isset( $option['size'] ) ) ? $option['size'] : '';
	$meta['position'] = ( isset( $option['position'] ) ) ? $option['position'] : '';
	$meta['attachment'] = ( isset( $option['attachment'] ) ) ? $option['attachment'] : '';

	return wpb_sanitize_bg_meta( $meta );
}

/**
 * Set default background meta
 */
function wpb_set_bg_meta() {
	return array(
		'color' => '',
		'image_id' => '',
		'repeat' => 'no-repeat',
		'size' => 'cover',
		'position' => 'center center',
		'attachment' => 'scroll',
	);
}

/**
 * Sanitize background meta
 */
function wpb_sanitize_bg_meta( $meta = array() ) {
	
	$meta['color'] = wpb_sanitize_hex_color( $meta['color'] );
	$meta['image_id'] = absint( $meta['image_id'] );
	$meta['repeat'] = esc_attr( $meta['repeat'] );
	$meta['size'] = esc_attr( $meta['size'] );
	$meta['position'] = esc_attr( $meta['position'] );
	$meta['attachment'] = esc_attr( $meta['attachment'] );
	
	return $meta;
}

if ( ! function_exists( 'debug' ) ) {
	function debug( $var ) {
		echo '<br><pre class="wpb-debug">';
		print_r( $var );
		echo '</pre>';
	}
}