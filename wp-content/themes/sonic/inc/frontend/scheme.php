<?php
/**
 * Sonic microdata hook functions
 *
 * Inject microdata content through template hooks
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'sonic_post_microdata' ) ) {
	/**
	 * Output post microdata
	 */
	function sonic_post_microdata() {
		?>
		<meta itemprop="publisher" content="<?php echo esc_url( home_url( '/' ) ); ?>">
		<meta itemprop="mainEntityOfPage" content="<?php the_permalink(); ?>">
		<meta itemprop="name" content="<?php the_title(); ?>">
		<?php if ( is_single() ) : ?>
			<meta itemprop="headline" content="<?php the_title(); ?>">
		<?php endif; ?>
		<meta itemprop="image" content="<?php echo wolf_get_post_thumbnail_url( 'large' ); ?>">
		<meta itemprop="description" content="<?php echo wolf_sample( get_the_excerpt() ); ?>">
		<?php if ( comments_open() ) : ?>
		<meta itemprop="commentCount" content="<?php echo absint( get_comment_count() ); ?>">
		<?php endif; ?>
		<?php
	}
	//add_action( 'wolf_post_start', 'sonic_post_microdata' );
}

/**
 * Get schema type depending on content
 */
function sonic_get_body_schema_type( $type = 'WebPage' ) {

	$type = 'WebPage'; // default
	
	// Is blog home, archive or category
	if ( is_home() || is_archive() || is_category() ) {
		
		$type = 'Blog';
	}
	
	// Is static front page
	else if ( is_front_page() ) {
		
		$type = 'Website';
	}

	// Is search results page
	elseif ( is_search() ) {
	
		$type = 'SearchResultsPage';
	}

	return apply_filters( 'sonic_body_schema_type', $type );
}

/**
 * Ouptut HTML microdata
 */
function sonic_body_schema() {
	
	$schema = 'http://schema.org/';

	echo 'itemscope="itemscope" itemtype="' . esc_attr( $schema ) . esc_attr( sonic_get_body_schema_type() ) . '"';
}

/**
 * Get schema type
 */
function sonic_get_article_schema_type( $type = 'CreativeWork' ) {

	return apply_filters( 'sonic_article_schema_type', $type );
}

/**
 * Ouptut HTML microdata
 */
function sonic_article_schema() {
	
	$schema = 'http://schema.org/';

	echo 'itemscope itemtype="' . esc_attr( $schema ) . esc_attr( sonic_get_article_schema_type() ) . '"';
}

/**
 * Add itemprop attributes to menu links
 */
function sonic_add_menu_atts( $atts, $item, $args ) {
	$atts['itemprop'] = 'url';
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'sonic_add_menu_atts', 10, 3 );