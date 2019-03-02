<?php
/**
 * The category filter
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */
?>
<?php
	if ( ! sonic_do_ajax_category_filter() ) {
		return;
	}

	if ( sonic_is_blog() ) {

		get_template_part( 'partials/filter/filter', 'category-blog' );

	} elseif ( sonic_is_portfolio() ) {

		wolf_portfolio_get_template( 'filter.php' );
	}
?>