<?php
/**
 * The template for displaying search forms
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */
?>
<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<input type="search" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo wolf_get_theme_option( 'search_placeholder_text', esc_html__( 'Enter your search', 'sonic' ) ); ?>" />
	<input type="submit" class="searchsubmit" value="<?php esc_html_e( 'Search', 'sonic' ); ?>" />
</form>