<?php
/**
 * Wolf Page Builder frontend functions
 *
 * General functions available on frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FRontend
 * @version 2.9.3
 */

/**
 * Enqueue CSS
 *
 * @since Wolf Page Builder 1.0
 */
function wpb_enqueue_styles() {

	if ( ! is_wpb() ) {
		// return;
	}

	// Libraries
	wp_register_style( 'animate-css', WPB_CSS . '/lib/animate.min.css', array(), '3.3.0' );
	wp_register_style( 'flexslider', WPB_CSS . '/lib/flexslider.min.css', array(), '2.6.1' );
	wp_register_style( 'owlcarousel', WPB_CSS . '/lib/owl.carousel.min.css', array(), '2.0.0' );
	
	// Plugin scripts
	wp_register_style( 'wpb-icon-pack', WPB_CSS . '/icon-pack.min.css', array(), WPB_VERSION );
	
	wp_register_style( 'wpb-styles', WPB_CSS . '/wpb.css', array(), WPB_VERSION );
	wp_register_style( 'wpb-styles-min', WPB_CSS . '/wpb.min.css', array(), WPB_VERSION );

	// WP icons
	wp_enqueue_style( 'dashicons' );

	$lightbox = wpb_get_option( 'settings', 'lightbox', 'swipebox' );

	// Libraries
	if ( 'swipebox' == $lightbox ) {
			
		// enqueue swipebox styles
		wp_enqueue_style( 'swipebox', WPB_CSS. '/lib/swipebox.min.css', array(), '1.3.0' );
	
	} elseif ( 'fancybox' == $lightbox ) {
		
		// enqueue swipebox styles
		wp_enqueue_style( 'fancybox', WPB_CSS. '/lib/fancybox.css', array(), '2.1.5' );
	}
	
	wp_enqueue_style( 'animate-css' );
	wp_enqueue_style( 'flexslider' );
	wp_enqueue_style( 'owlcarousel' );
	wp_enqueue_style( 'wpb-icon-pack' );

	// Check if the "minify CSS" option is checked
	if ( wpb_get_option( 'settings', 'css_min' ) ) {
		
		// Concat and minified styles
		wp_enqueue_style( 'wpb-styles-min' );
	
	} else {

		// Plugin styles
		wp_enqueue_style( 'wpb-styles' );
	}

}
add_action( 'wp_enqueue_scripts', 'wpb_enqueue_styles', 1 );

/**
 * Output custom styles
 *
 * @since Wolf Page Builder 1.0
 */
function wpb_output_styles() {

	$bg_meta = wpb_get_bg_meta( 'settings', 'body_background' );
	extract( $bg_meta );
	
	$background_style = 'body.wolf-page-builder{';
	
	if ( $color ) {
		$background_style .= 'background-color:' . wpb_sanitize_hex_color( $color ) . ';';
	}

	if ( $image_id ) {
		$background_style .= 'background-image:url(' . esc_url( wpb_get_url_from_attachment_id( $image_id, 'wpb-XL' ) ) . ');';
	}
	
	if ( $repeat ) {
		$background_style .= 'background-repeat:' . esc_attr( $repeat ) . ';';
	}
	
	if ( $position ) {
		$background_style .= 'background-position:' . esc_attr( $position ) . ';';
	}
	
	if ( $size ) {
		
		if ( 'cover' == $size ) {

			$background_style .= '
				-webkit-background-size: 100%;
				-o-background-size: 100%;
				-moz-background-size: 100%;
				background-size: 100%;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;';
		}

		if ( 'resize' == $size ) {

			$background_style .= '
				-webkit-background-size: 100%;
				-o-background-size: 100%;
				-moz-background-size: 100%;
				background-size: 100%;';
		}
	}
	
	if ( $attachment ) {
		$background_style .= 'background-attachment:' . esc_attr( $attachment ) . ';';
	}
	
	$background_style .= '}';

	$output = '<style type="text/css">';
	$output .= '/* WPB Custom styles */';
	//$output .= wpb_esc_style_attr( $background_style );
	$output .= '</style>';

	echo $output;
}
//add_action( 'wp_head', 'wpb_output_styles' );

/**
 * Display a slef hosted video background
 *
 * Output a basic HTML5 video markup. Wordpress will apply mediaelement script automatically to it
 *
 * @param string $mp4
 * @param string $webm
 * @param string $ogv
 * @param string $img
 * @param bool $parallax
 * @return string $output
 */
function wpb_video_bg( $mp4 = null, $webm = null, $ogv = null,  $img = null, $parallax = false ) {

	$rand = rand( 0, 9999 );
	$output = '';
	$class = 'wpb-video-bg-container';
	$output .= "<div class='$class'>";

	if ( $img ) {
		$output .= '<div class="wpb-video-bg-fallback" style="background-image:url(' . esc_url( $img ) . ')"></div>';
	}
		
	$output .= '<video class="wpb-video-bg" id="wpb-video-bg-' . absint( $rand ) . '" preload="auto" autoplay loop="loop" muted>';

	if ( $webm ) {
		$output .= '<source src="' . esc_url( $webm ) . '" type="video/webm">';
	}
		
	if ( $mp4 ) {
		$output .= '<source src="' . esc_url( $mp4 ) . '" type="video/mp4">';
	}

	if ( $webm ) {
		$output .= '<source src="' . esc_url( $ogv ) . '" type="video/ogg">';
	}
		
	$output .= '</video>';
	$output .= '<div class="wpb-video-bg-overlay"></div>';
	/*
		Video controls can be found in the shortcode file section.php
	*/
	$output .= '</div>';

	return $output;
}

/**
 * Display a YouTube video background
 *
 * Output YouTube video background markup
 *
 * @param string $url
 * @param string $img_fallback
 * @param bool $parallax
 * @return string $output
 */
function wpb_youtube_video_bg( $url = null, $img_fallback = null, $parallax = false ) {

	$output = $style = '';
	$img_fallback = ( $img_fallback ) ? esc_url( $img_fallback ) : '';
	$class = 'wpb-video-bg-container wpb-youtube-video-bg-container';
	$url = esc_url( $url );
	$random_id = rand( 1, 9999 );

	if (
		preg_match( '#youtube(?:\-nocookie)?\.com/watch\?v=([A-Za-z0-9\-_]+)#', $url, $match )
		|| preg_match( '#youtube(?:\-nocookie)?\.com/v/([A-Za-z0-9\-_]+)#', $url, $match )
		|| preg_match( '#youtube(?:\-nocookie)?\.com/embed/([A-Za-z0-9\-_]+)#', $url, $match )
		|| preg_match( '#youtu.be/([A-Za-z0-9\-_]+)#', $url, $match )
	) {

		if ( $match && isset( $match[1] ) ) {

			$youtube_id = $match[1];
			$embed_url = 'https://youtube.com/embed/' . $youtube_id;

			if ( $parallax ) {
				$class .= ' wpb-video-bg-container-parallax';
			}

			if ( $img_fallback ) {
				$style .= "background:url('$img_fallback') center center no-repeat;";
				$style .= '-webkit-background-size: 100%;
				-o-background-size: 100%;
				-moz-background-size: 100%;
				background-size: 100%;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;';
				$style = wpb_esc_style_attr( $style );
				// debug( $style );
			}

			$output .= "<div class='$class' id='wpb-youtube-video-bg-$random_id-container' data-youtube-video-id='$youtube_id' style='$style'>" . "\n";
				$output .= "<div class='wpb-youtube-player' id='wpb-youtube-player-$random_id'></div>" . "\n";
			$output .= '</div><!-- .wpb-youtube-video-bg -->' . "\n";
		}
	}
	return $output;
}

/**
 * Display a vimeo video background
 *
 * Output vimeo video background markup
 *
 * @param string $url
 * @param string $img_fallback
 * @param bool $parallax
 * @return string $output
 */
function wpb_vimeo_video_bg( $url = null, $img_fallback = null, $parallax = false ) {

	$output = $style = '';
	$img_fallback = ( $img_fallback ) ? esc_url( $img_fallback ) : '';
	$class = 'wpb-video-bg-container wpb-vimeo-video-bg-container';
	$url = esc_url( $url );
	$random_id = rand( 1, 9999 );

	if (
		preg_match( '#vimeo\.com/([0-9]+)#', $url, $match )
	) {

		if ( $match && isset( $match[1] ) ) {

			$vimeo_id = $match[1];
			$embed_url = 'https://player.vimeo.com/' . $vimeo_id;

			if ( $parallax ) {
				$class .= ' wpb-video-bg-container-parallax';
			}

			if ( $img_fallback ) {
				$style .= "background:url('$img_fallback') center center no-repeat;";
				$style .= '-webkit-background-size: 100%;
				-o-background-size: 100%;
				-moz-background-size: 100%;
				background-size: 100%;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;';
				$style = wpb_esc_style_attr( $style );
				// debug( $style );
			}

			// $output .= "<div class='$class' id='wpb-vimeo-video-bg-$random_id-container' data-vimeo-video-id='$vimeo_id' style='$style'>" . "\n";
			// 	$output .= "<div class='wpb-vimeo-player' id='wpb-vimeo-player-$random_id'></div>" . "\n";
			// $output .= '</div><!-- .wpb-vimeo-video-bg -->' . "\n";
			$output .= '<div class="wpb-vimeo-video-bg-container wpb-video-bg-container">';
			
			if ( $img_fallback ) {
				$output .= '<div class="wpb-video-bg-fallback" style="background-image:url(' . esc_url( $img_fallback ) . ')"></div>';
			}

			$output .= '<iframe class="wpb-vimeo-bg" src="https://player.vimeo.com/video/' . esc_attr( $vimeo_id ) . '?autoplay=1&loop=1&byline=0&title=0"></iframe>';
			$output .= '<div class="wpb-video-bg-overlay"></div>';
			$output .= '</div><!--.wpb-video-bg-container-->';
		}
	}
	return $output;
}

/**
 * Convert hex color to rgb
 *
 * @param string $hex
 * @return string
 */
function wpb_hex_to_rgb( $hex ) {
	$hex = str_replace( '#', '', $hex );

	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex,0,1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex,1,1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex,2,1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}
	$rgb = array( $r, $g, $b );
	return implode( ',', $rgb ); // returns the rgb values separated by commas
	//return $rgb; // returns an array with the rgb values
}

/**
 * Try to get a full size image URL from a thumbnail URL
 *
 * @param string $url
 * @return string
 */
function wpb_get_full_size_image_url_from_thumbnail_url( $url ) {
	if ( preg_match( '/-[0-9]+x[0-9]+.(jpg|png|gix)/' , $url, $matches ) ) {
		
		if ( isset( $matches[0] ) && isset( $matches[1] ) ) {
			return str_replace( $matches[0], '.' . $matches[1], $url );
		}
	}
}

if ( ! function_exists( 'wpb_post_entry_meta' ) ) {
	/**
	 * Entry Meta
	 *
	 * @return string $output
	 */
	function wpb_post_entry_meta( $echo = true ) {

		$output  = '';
		$post_id = get_the_ID();

		if ( is_sticky() && is_home() && ! is_paged() )
			$output .= '<span class="wpb-featured-post">' . esc_html__( 'Featured', 'wolf-page-builder' ) . '</span>';

		if ( 'post' == get_post_type() || is_search() ) {
			$output .= wpb_entry_date( false );
		}

		// Post author
		if ( 'post' == get_post_type() && is_multi_author() ) {
			
			$output .= '<span class="wpb-author-meta author-meta">';
			$output .='<a class="wpb-author-link author-link" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">';
			$output .= get_avatar( get_the_author_meta( 'user_email' ), 20 );
			$output .= '</a>';
			
			$output .= sprintf(
				'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'wolf-page-builder' ), get_the_author() ) ),
				wpb_the_author( false )
			);

			$output .= '</span><!--.author-meta-->';
		}

		if ( 'work' == get_post_type() ) {
			$categories_list = get_the_term_list( $post_id, 'work_type', '', ', ', '' );

		} elseif ( 'video' == get_post_type() ) {

			$categories_list = get_the_term_list( $post_id, 'video_type', '', ', ', '' );

		} elseif ( 'gallery' == get_post_type() ) {

			$categories_list = get_the_term_list( $post_id, 'gallery_type', '', ', ', '' );

		} elseif ( 'plugin' == get_post_type() ) {

			$categories_list = get_the_term_list( $post_id, 'plugin_cat', '', ', ', '' );

		} elseif ( 'theme' == get_post_type() ) {

			$categories_list = get_the_term_list( $post_id, 'theme_cat', '', ', ', '' );

		} else {
			// Translators: used between list items, there is a space after the comma.
			$categories_list = get_the_category_list( __( ', ', 'wolf-page-builder' ) );
		}

		if ( $categories_list ) {
			$output .= '<span class="wpb-categories-links categories-links">' . $categories_list . '</span>';
		}

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'wolf-page-builder' ) );
		if ( $tag_list ) {
			$output .= '<span class="wpb-tags-links tags-links">' . $tag_list . '</span>';
		}

		if ( $echo )
			echo wp_kses( $output, array(
				'span' => array(
					'class' => array(),
				),
				'a' => array(
					'href' => array(),
					'rel' => array(),
					'class' => array(),
				),
				'time' => array(
					'class' => array(),
					'datetime' => array(),
				),

				'img' => array(
					'src' => array(),
					'class' => array(),
				),
			) );

		return $output;
	}
}

if ( ! function_exists( 'wpb_the_author' ) ) {
	/**
	 * Get the author
	 *
	 * @param bool $echo
	 * @return string $author
	 */
	function wpb_the_author( $echo = true ) {

		global $post;
		
		if ( ! is_object( $post ) )
			return;
		
		$author_id = $post->post_author;
		$author = get_the_author_meta( 'user_nicename', $author_id );

		if ( get_the_author_meta( 'nickname', $author_id ) ) {
			$author = get_the_author_meta( 'nickname', $author_id );
		}

		if ( get_the_author_meta( 'first_name', $author_id ) ) {
			$author = get_the_author_meta( 'first_name', $author_id );

			if ( get_the_author_meta( 'last_name', $author_id ) ) {
				$author .= ' ' .  get_the_author_meta( 'last_name', $author_id );
			}
		}

		$author = sprintf( '<span class="vcard author"><span class="fn">%s</span></span>', $author );

		if ( $echo )
			echo wp_kses( $author, array(
				'span' => array(
					'class' => array()
				),
				'a' => array(
					'href' => array(),
					'rel' => array(),
					'class' => array()
				),
			) );

		return $author;

	}
}

if ( ! function_exists( 'wpb_entry_date' ) ) {
	/**
	 * Prints HTML with date information for current post.
	 *
	 * Create your own wpb_entry_date() to override in a child theme.
	 *
	 *
	 * @param boolean $echo Whether to echo the date. Default true.
	 * @return string
	 */
	function wpb_entry_date( $echo = true, $link = true ) {
		$display_time = get_the_date();
		$modified_display_time = get_the_modified_date();

		//if ( 'human_diff' == wpb_get_theme_option( 'date_format' ) ) {
			$display_time = sprintf( __( '%s ago', 'wolf-page-builder' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
			$modified_display_time = sprintf( __( '%s ago', 'wolf-page-builder' ), human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) ) );
		//}

		$date = $display_time;

		$time_string = '<time class="wpb-entry-date entry-date wpb-published published wpb-updated updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="wpb-entry-date entry-date wpb-published published" datetime="%1$s">%2$s</time>
			<time class="wpb-updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( $display_time ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( $modified_display_time )
		);

		if ( $link ) {
			$date = sprintf(
				'<span class="wpb-posted-on posted-on date"><a href="%1$s" rel="bookmark">%2$s</a></span>',
				esc_url( get_permalink() ),
				$time_string
			);
		} else {
			$date = sprintf(
				'<span class="wpb-posted-on posted-on date">%2$s</span>',
				esc_url( get_permalink() ),
				$time_string
			);
		}

		if ( $echo )
			echo wp_kses( $date, array(
				'span' => array(
					'class' => array()
				),
				'a' => array(
					'href' => array(),
					'rel' => array(),
					'class' => array()
				),
			) );

		return $date;
	}
}

if ( ! function_exists( 'wpb_post_gallery_slider' ) ) {
	/**
	 * Get the first gallery shortcode, grab the attachments ids and display a slider
	 *
	 * @param string $size
	 */
	function wpb_post_gallery_slider( $size = 'wpb-2x1', $tag_id = null, $class = null, $post_id = null  ) {

		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'wpb-sliders' );

		$array_ids = array();
		$post_id = ( $post_id ) ?  $post_id : get_the_ID();

		$tag_id = ( $tag_id ) ? esc_attr( $tag_id ) : 'wpb-post-gallery-slider-' . rand( 0, 999 );

		$content_post = get_post( $post_id );
		$content = $content_post->post_content;

		$pattern = get_shortcode_regex();
		if ( preg_match( "/$pattern/s", $content, $match ) ) {

			if ( isset( $match[3] ) && preg_match( '/\ ids="(.*)"/', $content, $ids ) ) {
				if ( $ids[1] ) {
					$array_ids = explode( ',', $ids[1] );
				}
			}
		}

		ob_start();
		if ( array() != $array_ids ) {
			?>
			<div id="<?php echo esc_attr( $tag_id ); ?>-container">
				<div id="<?php echo esc_attr( $tag_id ); ?>" class="flexslider wpb-post-gallery-slider <?php echo sanitize_html_class( $class ); ?>">
					<ul class="slides">
						<?php foreach ( $array_ids as $attachment_id ) : ?>
						<li class="slide">
							<img src="<?php echo esc_url( wpb_get_url_from_attachment_id( $attachment_id, $size ) ); ?>">
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<?php
		}
		return ob_get_clean();
	}
}

/**
 * Return the first video URL in the post if a video URL is found
 *
 * @since Wolf Page Builder 1.7.0
 * @return string
 */
function wpb_get_first_video_url( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$content = get_post_field( 'post_content', $post_id );

	$has_video_url =
	// youtube
	preg_match( '#http?://(?:\www.)?\youtube.com/watch\?v=([A-Za-z0-9\-_]+)#', $content, $match )
	|| preg_match( '#https?://(?:\www.)?\youtube.com/watch\?v=([A-Za-z0-9\-_]+)#', $content, $match )
	|| preg_match( '#http?://(?:\www.)?\youtu.be/([A-Za-z0-9\-_]+)#', $content, $match )
	|| preg_match( '#https?://(?:\www.)?\youtu.be/([A-Za-z0-9\-_]+)#', $content, $match )

	// vimeo
	|| preg_match( '#vimeo\.com/([0-9]+)#', $content, $match );

	$video_url = ( $has_video_url ) ? esc_url( $match[0] ) : null;

	return $video_url;
}

if ( ! function_exists( 'wpb_socials' ) ) {
	/**
	 * Output social icons
	 *
	 * @access public
	 * @param string $services
	 * @param string $size
	 * @param string $type
	 * @param string $target
	 * @param string $custom_style
	 * @param string $hover_effect
	 * @param string $margin
	 * @param string $bg_color
	 * @param string $icon_color
	 * @param string $border_color
	 * @param string $bg_color_hover
	 * @param string $icon_color_hover
	 * @param string $border_color_hover
	 * @param string $alignment
	 * @return string $output
	 */
	function wpb_socials( $args ) {

		$old_version = false;

		// backward compatibility when $services was the first argument
		if ( ! is_array( $args ) ) {
			$services = $args;
			$old_version = true;
		} else {
			$services = ( isset( $args['services'] ) ) ? $args['services'] : '';
		}

		$args = wp_parse_args( $args, array(
			//'services' => '',
			'size' => '2x',
			'type' => 'normal',
			'target' => '_blank',
			'custom_style' => 'no',
			'hover_effect' => 'none',
			'margin' => '',
			'bg_color' => '',
			'icon_color' => '',
			'border_color' => '',
			'bg_color_hover' => '',
			'icon_color_hover' => '',
			'border_color_hover ' => '',
			'alignment' => 'center',
			'animation' => '',
			'animation_delay' => '',
			'inline_style' => '',
			'extra_class' => ''
		) );

		extract( $args );

		global $ti_icons, $wpb_line_icons, $wpb_linearicons ;
		$is_list = true;

		$wpb_socials = wpb_get_socials();
		
		if ( ! $services ) {
			
			$services = $wpb_socials;
		
		} elseif ( ! is_array( $services ) ) {

			$services = strtolower( preg_replace( '/\s+/', '', sanitize_text_field( $services ) ) );
			$services = explode( ',', $services );
		
		} elseif ( is_array( $services ) ) {
			
			$is_list = false;
		}

		$style = '';
		$icon_style = '';
		$class = ( $extra_class ) ? "$extra_class " : ''; // add space
		$class .= "wpb-socials-container wpb-text-$alignment";

		if ( $animation )
			$class .= " wow $animation";

		if ( $animation_delay && 'none' != $animation ) {
			$inline_style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		$output = '<div class="' . wpb_sanitize_html_classes( $class ) .'" style="' . wpb_esc_style_attr( $inline_style ) . '">'; // container open tag

		$icon_class = "wpb-$type wpb-social-$size wpb-hover-$hover_effect";
		$icon_class .= ( 'yes' == $custom_style ) ? ' wpb-social-custom-style' : ' wpb-social-no-custom-style';

		$data = '';

		if ( $icon_color ) {
			$icon_style .= "color:$icon_color;";
		}

		$icon_style = ( $icon_style ) ? "style='$icon_style'" : '';

		$prefix = '';

		if ( $is_list ) {
			foreach ( $services as $s ) {
				$social = wpb_get_option( 'socials', $s );
				if ( $social ) {
					
					$prefix = 'fa fa';

					if ( in_array( 'ti-' . $s, array_keys( $ti_icons ) ) ) {
						
						$prefix = 'ti';
					
					} elseif ( in_array( 'line-icon-' . $s, array_keys( $wpb_line_icons ) ) ) {

						$prefix = 'fa line-icon';

					} elseif ( in_array( 'lnr-' . $s, array_keys( $wpb_line_icons ) ) ) {

						$prefix = 'fa lnr';
					}

					$title = str_replace( '-', ' ', $s );
					$output .= "<a href='$social' title='$title' target='$target' class='wpb-social-link'>";
					$output .= "<span $icon_style $data class='wpb-social $prefix-$s $icon_class'></span>";
					$output .= '</a>';
				}
			}
		} else {
			foreach ( $services as $s => $url ) {
				$social = $url;
				if ( $social ) {
					$prefix = 'fa fa';

					if ( in_array( 'ti-' . $s, array_keys( $ti_icons ) ) ) {
						
						$prefix = 'ti';
					
					} elseif ( in_array( 'line-icon-' . $s, array_keys( $wpb_line_icons ) ) ) {

						$prefix = 'fa line-icon';

					} elseif ( in_array( 'lnr-' . $s, array_keys( $wpb_line_icons ) ) ) {

						$prefix = 'fa lnr';
					}
					
					$title = str_replace( '-', ' ', $s );
					$output .= "<a href='$social' title='$title' target='$target' class='wpb-social-link'>";
					$output .= "<span $icon_style $data class='wpb-social $prefix-$s $icon_class'></span>";
					$output .= '</a>';
				}
			}
		}

	
		$output .= '</div><!-- .wpb-socials-container -->';

		return $output;
	}
}

/**
 * Get first category of the post if any
 *
 * @param int $post_id
 */
function wpb_get_first_category( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( 'post' ==  get_post_type() ) {
		$category = get_the_category();
		if ( $category ) {
			return $category[0]->name;
		}
	
	} elseif ( 'gallery' ) {
		
		$terms = get_the_terms( $post_id, 'gallery_type' );

		if ( $terms ) {
			$term = array_pop( $terms );

			return $term->name;
		}
	}
}

/**
 * Get first category of the post if any
 *
 * @param int $post_id
 */
function wpb_get_first_category_url( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( 'post' == get_post_type() ) {
		$category = get_the_category();
		if ( $category ) {
			return get_category_link( $category[0]->term_ID );
		}

	} elseif ( 'gallery' ) {
		
		$terms = get_the_terms( $post_id, 'gallery_type' );

		if ( $terms ) {
			$term = $terms[0];

			return get_term_link( $term );
		}
	}
}

/**
 * Helper method to determine if a shortcode attribute is true or false.
 *
 * @since 2.1
 *
 * @param string|int|bool $var Attribute value.
 * @return bool
 */
function wpb_shortcode_bool( $var ) {
	$falsey = array( 'false', '0', 'no', 'n', '', ' ' );
	return ( ! $var || in_array( strtolower( $var ), $falsey, true ) ) ? false : true;
}

/**
 * Ouptut additional post attributes
 */
function wpb_post_attr( $post_attr = '' ) {
	echo apply_filters( 'wpb_post_attr', $post_attr );
}

/**
 * Filtter button text of the last posts big slide button title
 *
 * @param string $text
 * @return string
 */
function wpb_last_posts_big_slide_button_text_filter( $text ) {

	$post_type = get_post_type();
	$format = null;
	$text = esc_html__( 'Continue reading', 'wolf-page-builder' );
	
	if ( 'post' == $post_type || 'work' == $post_type ) {

		$format = get_post_format();
		
		if ( $format ) {

			if ( 'video' == $format ) {

			 	$text = esc_html__( 'Watch the video', 'wolf-page-builder' );

			} elseif ( 'gallery' == $format || 'image' == $format ) {

				$text = esc_html__( 'View more', 'wolf-page-builder' );

			} elseif ( 'audio' == $format ) {

				$text = esc_html__( 'Listen', 'wolf-page-builder' );
			}
		}
	}

	if ( 'gallery' == $post_type ) {
		$text = esc_html__( 'View album', 'wolf-page-builder' );
	}

	if ( 'video' == $post_type ) {
		$text = esc_html__( 'Watch the video', 'wolf-page-builder' );
	}

	if ( 'wpm_playlist' == $post_type ) {
		$text = esc_html__( 'Listen', 'wolf-page-builder' );
	}

	if ( 'show' == $post_type || 'event' == $post_type ) {
		$text = esc_html__( 'View event details', 'wolf-page-builder' );
	}

	if ( 'release' == $post_type ) {
		$text = esc_html__( 'View release details', 'wolf-page-builder' );
	}

	return $text;
}
add_filter( 'wpb_last_posts_big_slide_button_text',  'wpb_last_posts_big_slide_button_text_filter' );