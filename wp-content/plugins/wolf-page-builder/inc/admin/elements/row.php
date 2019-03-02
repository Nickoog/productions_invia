<?php
/**
 * Row
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
		'base' => 'row',
		'params' => array(

			array(
				'type' => 'select',
				'label' => esc_html__( 'Content Type', 'wolf-page-builder' ),
				'param_name' => 'content_type',
				'choices' => array(
					'standard' => sprintf( esc_html__( 'Standard Width (%s centered)', 'wolf-page-builder' ), '1140px' ),
					'small' => sprintf( esc_html__( 'Small Width (%s centered)', 'wolf-page-builder' ), '750px' ),
					'large' => sprintf( esc_html__( 'Large Width (%s centered)', 'wolf-page-builder' ), '98%' ),
					'full' => sprintf( esc_html__( 'Full Width (%s)', 'wolf-page-builder' ), '100%' ),
				),
			),

			array(
				'type' => 'text',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Margin Top', 'wolf-page-builder' ),
				'param_name' => 'margin_top',
				'placeholder' => '50px',
				'description' => esc_html__( 'Margin above the content', 'wolf-page-builder' ),
			),

			array(
				'type' => 'text',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Margin Bottom', 'wolf-page-builder' ),
				'param_name' => 'margin_bottom',
				'placeholder' => '50px',
				'description' => esc_html__( 'Margin below the content', 'wolf-page-builder' ),
			),
		)
	)
);