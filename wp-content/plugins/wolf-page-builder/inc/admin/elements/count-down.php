<?php
/**
 * Count down
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Count Down
wpb_add_element(
	array(
		'name' => esc_html__( 'Count Down', 'wolf-page-builder' ),
		'description' => esc_html__( 'See the seconds tick down', 'wolf-page-builder' ),
		'base' => 'wpb_countdown',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-count-down',
		'params' => array(

			array(
				'type' => 'text',
				'label' => esc_html__( 'Date', 'wolf-page-builder' ),
				'param_name' => 'date',
				'description' => esc_html__( 'formatted like 12/24/2020 12:00:00', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'text',
				'class' => '',
				'label' => esc_html__( 'UTC Timezone offset', 'wolf-page-builder' ),
				'param_name' => 'offset',
				'description' => esc_html__( 'e.g : -5 for NY', 'wolf-page-builder' ),
				'display' => true,
			),
		)
	)
);