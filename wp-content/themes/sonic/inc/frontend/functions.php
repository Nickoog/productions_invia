<?php
/**
 * Sonic frontend functions
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//add_filter('show_admin_bar', '__return_false');

/**
 * Custom login logo Option
 */
function sonic_custom_login_logo() {

	$login_logo = wolf_get_theme_option( 'login_logo' );

	if ( $login_logo ) {
		echo '<style  type="text/css">h1 a { background-image:url(' . esc_url( $login_logo ) .' )  !important; } </style>';
	}
}
add_action( 'login_head',  'sonic_custom_login_logo' );

/**
 * Get image size fallback if the original image isn't big enough
 *
 * @return string
 */
function sonic_get_image_size_fallback( $thumb_size, $fallback = 'sonic-1x1' ) {

	if ( ! sonic_has_high_res_thumbnail( $thumb_size ) ) {
		$thumb_size = $fallback;
	}

	return $thumb_size;
}

/**
 * Check the resolution of the video thumbnail
 *
 * @param int post_id
 * @return bool
 */
function sonic_has_high_res_thumbnail( $size = '', $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$available_image_sizes =  get_intermediate_image_sizes();

	$attachment_id = get_post_thumbnail_id( $post_id );
	$image = wolf_get_url_from_attachment_id( $attachment_id, $size );
	$image = str_replace( esc_url( home_url( '/' ) ), ABSPATH, $image );
	
	if ( sonic_get_image_size( $size ) ) {
		$image_size = sonic_get_image_size( $size );
		$wanted_width = $image_size['width'];
		$wanted_height = $image_size['height'];
	
		if ( is_file( $image ) ) {
			list( $width, $height ) = getimagesize( $image );

			if ( $wanted_width == $width && $wanted_height == $height ) {
				return true;
			}
		}
	}
}

/**
 * Get size information for a specific image size.
 *
 * @uses   get_image_sizes()
 * @param  string $size The image size for which to retrieve data.
 * @return bool|array $size Size data about an image size or false if the size doesn't exist.
 */
function sonic_get_image_size( $size ) {
	$sizes = sonic_get_image_sizes();

	if ( isset( $sizes[ $size ] ) ) {
		return $sizes[ $size ];
	}

	return false;
}

/**
 * Get size information for all currently-registered image sizes.
 *
 * @global $_wp_additional_image_sizes
 * @uses   get_intermediate_image_sizes()
 * @return array $sizes Data for all currently-registered image sizes.
 */
function sonic_get_image_sizes() {
	global $_wp_additional_image_sizes;

	$sizes = array();

	foreach ( get_intermediate_image_sizes() as $_size ) {
		if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);
		}
	}

	return $sizes;
}

/**
 * Excerpt more
 * Render "Read more" link text differenttly depending on post format
 *
 * @return string
 */
function sonic_more_text() {

	$text = '<span>' . esc_html__( 'Continue reading', 'sonic' ) . '</span>';

	return apply_filters( 'sonic_more_text', $text );
}

/**
 * Output "more" button
 */
function sonic_more_button( $more_link_button_class = '' ) {

	if ( ! $more_link_button_class ) {
		$more_link_button_option = wolf_get_theme_mod( 'blog_more_link_type', 'wolf-button' );
		$more_link_button_class = apply_filters( 'sonic_more_link_button_class', $more_link_button_option );
	}
	
	return '<a rel="bookmark" class="more-link ' . esc_attr( 'more-link ' . $more_link_button_class ) . '" href="'. get_permalink() . '">' . sonic_more_text() . '</a>';
}

/**
 * Excerpt length hook 
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function sonic_excerpt_length( $length ) {

	$lenght = 15;

	return $length; 
}
add_filter( 'excerpt_length', 'sonic_excerpt_length' );

/**
 * Excerpt "more" link
 *
 * @param string $more
 * @return string
 */
function sonic_excerpt_more( $more ) {

	return '...<p>' . sonic_more_button() . '</p>';
}
add_filter( 'excerpt_more', 'sonic_excerpt_more' );

/**
 * Add custom class to the more link
 *
 * @param string $link
 * @param string $text
 */
function sonic_add_more_link_class( $link, $text ) {
	
	$more_link_button_option = wolf_get_theme_mod( 'blog_more_link_type', 'wolf-button' );
	$more_link_button_class = apply_filters( 'sonic_more_link_button_class', $more_link_button_option );

	return str_replace(
		'more-link',
		'more-link ' . $more_link_button_class,
		$link
	);
}
add_action( 'the_content_more_link', 'sonic_add_more_link_class', 10, 2 );

/**
 * Get the most used tags
 *
 * @return int
 */
function sonic_top_tags( $text = '', $nb = 10 ) {
	$tags = get_tags();

	$list = '';

	if ( empty( $tags ) )
		return;

	$counts = $tag_links = array();

	foreach ( (array) $tags as $tag ) {
		$counts[$tag->name] = $tag->count;
		$tag_links[$tag->name] = get_tag_link( $tag->term_id );
	}
	asort( $counts );
	$counts = array_reverse( $counts, true );
	$i = -1;
	foreach ( $counts as $tag => $count ) {
		$i++;
		$tag_link = esc_url( $tag_links[$tag] );

		$tag = str_replace( ' ', '&nbsp;', esc_html( $tag ) );

		if ( $i < $nb ) {
			$list .= "<a href=\"$tag_link\">$tag</a>, ";
		}
	}

	return '<div class="most-used-tags">' . $text . substr( $list, 0, -2 ) . '</div>';
}

/**
 * Add title attribute to next link post navigation
 *
 * @return string
 */
function sonic_posts_link_next_title() {
	return 'title="' . esc_html__( 'Older', 'sonic' ) . '"';
}
add_filter( 'next_posts_link_attributes', 'sonic_posts_link_next_title' );

/**
 * Add title attribute to previous link post navigation
 *
 * @return string
 */
function sonic_posts_link_prev_title() {
	return 'title="' . esc_html__( 'Newer', 'sonic' ) . '"';
}
add_filter( 'previous_posts_link_attributes', 'sonic_posts_link_prev_title' );

/**
 * Avoid page jump when clicking on more link
 *
 * @param string $link
 * @return string $link
 */
function sonic_remove_more_jump_link( $link )  {
	$offset = strpos( $link, '#more-' );
	if ( $offset ) { $end = strpos( $link, '"',$offset ); }
	if ( $end ) { $link = substr_replace( $link, '', $offset, $end-$offset ); }
	return $link;
}
add_filter( 'the_content_more_link', 'sonic_remove_more_jump_link' );

if ( ! function_exists( 'sonic_get_post_title' ) ) {
	/**
	 * Returns page title outside the loop
	 *
	 * @return string
	 */
	function sonic_get_post_title() {
		
		global $post, $wp_query;
		$title = '';
		$desc = '';
		$output = '';
		$subheading = sonic_get_the_subheading();

		if ( sonic_is_home_as_blog() ) {
			$title = get_bloginfo( 'name' );
			$desc = get_bloginfo( 'description' );
		}

		if ( is_search() ) {
			$title = sprintf( esc_html__( 'Search results for %s', 'sonic' ), '<span class="search-query-text">&quot;' . esc_html( get_search_query() ) . '&quot;</span>' );
		}

		if ( have_posts() ) {

			/* Main condition not 404 and not woocommerce page */
			if ( ! is_404() && ! sonic_is_woocommerce() ) {

				if ( is_category() ) {
					
					$title   = single_cat_title( '', false );
					$desc = category_description();
						
				} elseif ( is_tag() ) {
					
					$title   = single_tag_title( '', false );
					$desc = category_description();

				} elseif ( is_author() ) {
					
					the_post();
					$title = get_the_author();
					rewind_posts();

				} elseif ( is_day() ) {
					
					get_the_date();

				} elseif ( is_month() ) {
					
					$title = get_the_date( 'F Y' );

				} elseif ( is_year() ) {
					
					$title = get_the_date( 'Y' );

				} elseif ( is_tax() ) {

					$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
					if ( $the_tax && $wp_query && isset($wp_query->queried_object->name) ) {

						$title  = $wp_query->queried_object->name;
						$desc = category_description();
						
					}

				} elseif ( is_search() ) {
				
					$title = sprintf( esc_html__( 'Search Results for: %s', 'sonic' ), get_search_query() );

				} elseif ( is_single() ) {
					
					$format = get_post_format();
					$title = get_the_title();
					$category = sonic_get_first_category();
					
					if ( $category ) {
						$output .= '<span class="category-label" itemprop="genre"><a href="' . sonic_get_first_category_url() . '">' . $category . '</a></span>';
					}
					
					/* is blog index */
				} elseif (
					$wp_query && isset( $wp_query->queried_object->ID ) 
					&& $wp_query->queried_object->ID == get_option( 'page_for_posts' )
				) {
					$title  = $wp_query->queried_object->post_title;
					$desc = wolf_get_theme_option( 'blog_tagline' ); // blog tagline from theme options
					$subheading = get_post_meta( $wp_query->queried_object->ID, '_post_subheading', true );

				} elseif ( $wp_query && isset( $wp_query->queried_object->ID )  ) {
				
					$title = $wp_query->queried_object->post_title;
					$subheading = get_post_meta( $wp_query->queried_object->ID, '_post_subheading', true );
				}

			} elseif ( sonic_is_woocommerce() ) { // shop title

				if ( is_singular( 'product' ) ) {
					$title = get_the_title();
					$subheading = get_post_meta( $wp_query->queried_object->ID, '_post_subheading', true );
				} else {
					$title = ( function_exists( 'woocommerce_page_title' ) ) ? woocommerce_page_title( false ) : '';
					$subheading = get_post_meta( sonic_get_woocommerce_shop_page_id(), '_post_subheading', true );
				}
			}
		
		} // end have posts

		if ( $title ) {
			$output .= '<h1 itemprop="name" class="post-title">' . sanitize_text_field( apply_filters( 'sonic_page_title', $title ) ) . '</h1>';
		}

		if ( is_single() && 'post' == get_post_type() ) {
			
			$date = ( 'human_diff' == wolf_get_theme_mod( 'date_format' ) ) ? sprintf( wp_kses( __( '<span class="post-title-date">%s</span>', 'sonic' ), array( 'span' => array( 'class' => array() ) ) ), sonic_entry_date( false ) ) : sprintf( wp_kses( __( '<span class="post-title-date">%s</span>', 'sonic' ), array( 'span' => array( 'class' => array() ) ) ), sonic_entry_date( false ) );
			$author = '';
			if ( is_multi_author() ) {
				// $author = '<span class="author-meta">';
				// $author .= sprintf(
				// 	'<span id="post-title-author">posted by <span class="author vcard">
				// 	<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></span>',
				// 	esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				// 	esc_attr( sprintf( esc_html__( 'View all posts by %s', 'sonic' ), get_the_author() ) ),
				// 	get_the_author(  )
				// );
				// $author .= '</span>';
			} else {
				$author = '';
			}
			
			$output .= sprintf(
				esc_html__( '%1$s %2$s', 'sonic' ),
				$author,
				$date
			);
		}

		if ( $desc ) {
			$output .= '<div class="category-description">' . sanitize_text_field( apply_filters( 'sonic_page_description', $desc ) ) . '</div><!--.category-description-->';
		}

		if ( $subheading ) {
			$output .= '<div class="subheading">' . sanitize_text_field( apply_filters( 'sonic_page_subheading', $subheading ) ) . '</div>';
		}

		return $output;
	}
}

/**
 * Get blog layout
 *
 * @return string $blog_layout
 */
function sonic_get_blog_layout() {

	$blog_layout = wolf_get_theme_mod( 'blog_layout', 'standard' );

	if ( is_category() ) {
		
		$cat_id = get_query_var( 'cat' );
		$cat_meta = get_option( "_wolf_post_category_meta_$cat_id" );

		if ( $cat_meta ) {
			if ( isset( $cat_meta['blog_layout'] ) && '' != $cat_meta['blog_layout'] ) {
				$blog_layout = $cat_meta['blog_layout'];
			}
		}
	} elseif ( is_single() ) {
		$blog_layout = get_post_meta( get_the_ID(), '_single_post_layout', true );
	}

	return apply_filters( 'sonic_blog_layout', $blog_layout );
}

/**
 * Get blog display
 *
 * @return string $blog_display
 */
function sonic_get_blog_display() {

	$blog_display = wolf_get_theme_mod( 'blog_display', 'classic' );

	if ( is_category() ) {
		
		$cat_id = get_query_var( 'cat' );
		$cat_meta = get_option( "_wolf_post_category_meta_$cat_id" );

		if ( $cat_meta ) {
			if ( isset( $cat_meta['blog_display'] ) && '' != $cat_meta['blog_display'] ) {
				$blog_display = $cat_meta['blog_display'];
			}
		}
	}

	return apply_filters( 'sonic_blog_display', $blog_display );
}

/**
 * Get blog padding
 *
 * @return string $blog_padding
 */
function sonic_get_blog_padding() {

	$blog_padding = wolf_get_theme_mod( 'blog_grid_padding', 'yes' );

	if ( is_category() ) {
		
		$cat_id = get_query_var( 'cat' );
		$cat_meta = get_option( "_wolf_post_category_meta_$cat_id" );

		if ( $cat_meta ) {
			if ( isset( $cat_meta['blog_padding'] ) && '' != $cat_meta['blog_padding'] ) {
				$blog_padding = $cat_meta['blog_padding'];
			}
		}
	}

	return apply_filters( 'sonic_blog_padding', $blog_padding );
}

/**
 * Get portfolio layout
 *
 * @return string $portfolio_layout
 */
function sonic_get_portfolio_layout() {

	$portfolio_layout = wolf_get_theme_mod( 'portfolio_layout', 'standard' );

	if ( is_category() ) {
		
		$cat_id = get_query_var( 'cat' );
		$cat_meta = get_option( "_wolf_post_category_meta_$cat_id" );

		if ( $cat_meta ) {
			if ( isset( $cat_meta['portfolio_layout'] ) && '' != $cat_meta['portfolio_layout'] ) {
				$portfolio_layout = $cat_meta['portfolio_layout'];
			}
		}
	} elseif ( is_single() ) {
		$portfolio_layout = get_post_meta( get_the_ID(), '_single_post_layout', true );
	}

	return apply_filters( 'sonic_portfolio_layout', $portfolio_layout );
}

/**
 * Get portfolio layout
 *
 * @return string $portfolio_display
 */
function sonic_get_portfolio_display() {

	$portfolio_display = wolf_get_theme_mod( 'portfolio_display', 'standard' );

	if ( is_category() ) {
		
		$cat_id = get_query_var( 'cat' );
		$cat_meta = get_option( "_wolf_post_category_meta_$cat_id" );

		if ( $cat_meta ) {
			if ( isset( $cat_meta['portfolio_display'] ) && '' != $cat_meta['portfolio_display'] ) {
				$portfolio_display = $cat_meta['portfolio_display'];
			}
		}
	}

	return apply_filters( 'sonic_portfolio_display', $portfolio_display );
}

/**
 * Get portfolio padding
 *
 * @return string $portfolio_padding
 */
function sonic_get_portfolio_padding() {

	$portfolio_padding = wolf_get_theme_mod( 'portfolio_padding', 'yes' );

	if ( is_category() ) {
		
		$cat_id = get_query_var( 'cat' );
		$cat_meta = get_option( "_wolf_post_category_meta_$cat_id" );

		if ( $cat_meta ) {
			if ( isset( $cat_meta['portfolio_padding'] ) && '' != $cat_meta['portfolio_padding'] ) {
				$portfolio_padding = $cat_meta['portfolio_padding'];
			}
		}
	}

	return apply_filters( 'sonic_portfolio_padding', $portfolio_padding );
}

/**
 * Get album display
 *
 * @return string $album_display
 */
function sonic_get_albums_display() {

	$albums_display = wolf_get_theme_mod( 'albums_display', 'standard' );

	return apply_filters( 'sonic_albums_display', $albums_display );
}


/**
 * Get single post layout
 *
 * @return string $layout
 */
function sonic_get_single_post_layout() {

	$single_post_layout = ( get_post_meta( get_the_ID(), '_single_post_layout', true ) ) ? get_post_meta( get_the_ID(), '_single_post_layout', true ) : 'small-width';

	if ( is_single() ) {
		return apply_filters( 'sonic_single_post_layout', $single_post_layout );
	}
}

/**
 * Get single work layout
 *
 * @return string $layout
 */
function sonic_get_single_work_layout() {

	$single_work_layout = ( get_post_meta( get_the_ID(), '_single_work_layout', true ) ) ? get_post_meta( get_the_ID(), '_single_work_layout', true ) : 'small-width';

	if( is_singular( 'work' ) ) {
		return apply_filters( 'sonic_single_work_layout', $single_work_layout );
	}
}

/**
 * Get single post layout
 *
 * @return string $layout
 */
function sonic_get_single_gallery_layout() {

	$single_gallery_layout = ( get_post_meta( get_the_ID(), '_single_gallery_layout', true ) ) ? get_post_meta( get_the_ID(), '_single_gallery_layout', true ) : 'full-width';

	if ( is_singular( 'gallery' ) ) {
		return apply_filters( 'sonic_single_gallery_layout', $single_gallery_layout );
	}
}

/**
 * Get the menu type
 *
 * @return string
 */
function sonic_get_menu_type() {

	$menu_type = 'standard';

	$header_post_id  = sonic_get_header_post_id();
	$header_bg_type = get_post_meta( $header_post_id, '_post_bg_type', true );
	$header_bg_color = get_post_meta( $header_post_id, '_post_bg_color', true );
	$header_bg_img = get_post_meta( $header_post_id, '_post_bg_img', true );

	// set the menu skin from the settings
	// set the option only if there is at least the default image or if on WPB page
	if ( get_header_image() || sonic_is_wpb() ) {
		$menu_type =  wolf_get_theme_mod( 'auto_menu_type' );
	}
	
	// if featured image is set and option is enabled
	if ( wolf_get_theme_mod( 'auto_header' ) && has_post_thumbnail( $header_post_id ) && ! $header_bg_color && ! $header_bg_img ) {
		
		$menu_type =  wolf_get_theme_mod( 'auto_menu_type' );
	} 

	// If option is set in the post settings force to use this option
	if ( get_post_meta( sonic_get_header_post_id(), '_post_menu_type', true ) ) {
		$menu_type = get_post_meta( sonic_get_header_post_id(), '_post_menu_type', true );
	}

	// force to hide the menu if option is enabled
	if ( 'none' == get_post_meta( sonic_get_header_post_id(), '_post_menu_type', true ) ) {
		$menu_type = 'none';
	}

	return apply_filters( 'sonic_menu_type', $menu_type );
}

/**
 * Get menu type
 *
 * @return string
 */
function sonic_get_header_type() {
	
	$header_type = wolf_get_theme_mod( 'auto_header_type', 'standard' );

	if ( get_post_meta( sonic_get_header_post_id(), '_post_header_type', true ) ) {
		$header_type = get_post_meta( sonic_get_header_post_id(), '_post_header_type', true );
	}

	return apply_filters( 'sonic_header_type', $header_type );
}

/**
 * Get menu layout
 *
 * @return string
 */
function sonic_get_menu_layout() {
	$menu_layout = wolf_get_theme_mod( 'menu_layout', 'standard' );

	return apply_filters( 'sonic_menu_layout', $menu_layout );
}

/**
 * Returns the latest post ID (handles sticky post for blog)
 * Allows to display the first image in the metro style grid bigger disregarding the post type
 *
 * @param string $post_type
 */
function sonic_get_last_post_id( $post_type = 'post' ) {

	$post_id = null;

	if ( $post_type == 'post' ) {
		$args = array(
			'posts_per_page' => 1,
			'post_type' => 'post',
			'post__in'  => get_option( 'sticky_posts' ),
			'ignore_sticky_posts' => 1
		);

	} elseif ( $post_type == 'work' ) {
		
		$args = array(
			'numberposts' => 1,
			'post_type' => 'work'
		);
	}

	$recent_post = wp_get_recent_posts( $args, OBJECT );

	if ( $recent_post && isset( $recent_post[0] ) ) {
		$post_id = $recent_post[0]->ID;
	}

	if ( 'post' == $post_type ) {
		wp_reset_postdata();
	}

	return $post_id;
}

/**
 * Get blog URL
 */
function sonic_get_blog_url() {
	if ( get_option( 'page_for_posts' ) ) {
		return esc_url( get_permalink( get_option( 'page_for_posts' ) ) );
	} else {
		return esc_url( home_url( '/' ) );
	}
}

/**
 * Clean a link to display it as text
 *
 * Shorten the link in case it's too large and remove http://||https://
 *
 * @param string $link an URL
 * @return string
 */
function sonic_shorten_link( $link ) {

	return sanitize_text_field( mb_strimwidth( str_replace( array( 'http://', 'https://' ), '', $link ), 0, 25, '...' ) );
}

/**
 * Admin bar css fix
 */
function sonic_adminbar_css_fix() {
	if ( is_user_logged_in() ) {
		?>
		<style type="text/css">
			#wpadminbar{
				position: fixed!important;
				z-index: 99998;
			}
		</style>
		<?php
	}
}
add_action( 'wolf_head', 'sonic_adminbar_css_fix' );

/**
 * Get the post id to use to display a header
 *
 * For example, if a header is set for the blog, we will use it for the archive and search page
 *
 * @return int $id
 */
function sonic_get_header_post_id() {

	if ( is_404() ) {
		return;
	}

	$post_id = null;
	$shop_page_id = ( function_exists( 'sonic_get_woocommerce_shop_page_id' ) ) ? sonic_get_woocommerce_shop_page_id() : false;
	$is_shop_page = function_exists( 'is_shop' ) ? is_shop() || is_cart() || is_checkout() || is_account_page() : false;
	$is_product_taxonomy = function_exists( 'is_product_taxonomy' ) ? is_product_taxonomy() : false;
	$is_single_product = function_exists( 'is_product' ) ? is_product() : false;

	// is blog and not WooCommerce (for some reason WooCommerce fall in the blog condition)
	if ( sonic_is_blog() && false == $is_shop_page && false == $is_product_taxonomy ) {

		$post_id = get_option( 'page_for_posts' );

	// if woocommerce
	} elseif ( $is_shop_page ) {

		$post_id = $shop_page_id;

	// is single product
	//} elseif ( $is_single_product ) {
			
	//		$post_id = get_the_ID();

	} else {
		$post_id = get_the_ID();
	}

	if ( sonic_is_home_as_blog() ) {
		$post_id = null;
	}

	return $post_id;
}

/**
 * Get first category of the post if any
 *
 * @param int $post_id
 */
function sonic_get_first_category( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( 'post' ==  get_post_type() ) {
		$category = get_the_category();
		if ( $category ) {
			return $category[0]->name;
		}
	} elseif ( 'work' == get_post_type() ) {
		$category = get_the_terms( $post->ID, 'work_type' );
		if ( $category ) {
			return $category[0]->name;
		}
	}
}

/**
 * Get first category of the post if any
 *
 * @param int $post_id
 */
function sonic_get_first_category_url( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( 'post' ==  get_post_type() ) {
		$category = get_the_category();
		if ( $category ) {
			return get_category_link( $category[0]->term_ID );
		}
	}
}

/**
 * Add a parent CSS class for nav menu items.
 *
 * @see https://developer.wordpress.org/reference/functions/wp_nav_menu/#How_to_add_a_parent_class_for_menu_item
 * @param array  $items The menu items, sorted by each menu item's menu order.
 * @return array (maybe) modified parent CSS class.
 */
function sonic_add_menu_parent_class( $items ) {
	$parents = array();

	// Collect menu items with parents.
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}

	// Add class.
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'menu-parent-item';
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'sonic_add_menu_parent_class' );

/**
 * Overwrite posts per page
 *
 * @param object $query
 * @return object $query
 */
function sonic_set_posts_per_page( $query ) {

	global $wp_the_query;

	$posts_per_page_option = apply_filters( 'sonic_blog_posts_per_page', wolf_get_theme_mod( 'blog_posts_per_page' ) );

	if ( $posts_per_page_option ) {
		$query->set( 'posts_per_page', $posts_per_page_option );
	}

	return $query;
}
add_action( 'pre_get_posts',  'sonic_set_posts_per_page'  );