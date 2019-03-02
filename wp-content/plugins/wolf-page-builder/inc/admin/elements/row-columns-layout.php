<?php
/**
 * rowper layout
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wpb_add_element(
	array(

		'name' => '',
		'base' => 'row_columns_layout',
		'icon' => 'wpb-icon wpb-row-columns',
		'params' => array(

			array(
				'type' => 'hidden',
				'param_name' => 'row_type',
				'value' => 'columns',
			),

			array(
				'type' => 'radio_image',
				// 'label' => esc_html__( 'Layout', 'wolf-page-builder' ),
				'param_name' => 'layout',
				'choices' => array(
					'1-cols' => esc_url( WPB_URI . '/assets/img/admin/layout/columns/1-cols.png' ),
					'2-cols' => esc_url( WPB_URI . '/assets/img/admin/layout/columns/2-cols.png' ),
					'3-cols' => esc_url( WPB_URI . '/assets/img/admin/layout/columns/3-cols.png' ),
					'4-cols' => esc_url( WPB_URI . '/assets/img/admin/layout/columns/4-cols.png' ),
					'6-cols' => esc_url( WPB_URI . '/assets/img/admin/layout/columns/4-cols.png' ),
					'left-sidebar' => esc_url( WPB_URI . '/assets/img/admin/layout/columns/left-sidebar.png' ),
					'right-sidebar' => esc_url( WPB_URI . '/assets/img/admin/layout/columns/right-sidebar.png' ),
					'double-sidebar' => esc_url( WPB_URI . '/assets/img/admin/layout/columns/double-sidebar.png' ),
				),
				'radio_count' => 4,
				'value' => '1-cols',
			),
		)
	)
);