<?php
/**
 * Columns dialog box
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */
$title = esc_html__( 'Columns', 'wolf-page-builder' );
$params = array(

	array(
		'id' => 'col',
		'label' => esc_html__( 'Size', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => array(
			'wpb-col-6' => esc_html__( 'col-6 (one half)', 'wolf-page-builder' ),
			'wpb-col-4' => esc_html__( 'col-4 (one third)', 'wolf-page-builder' ),
			'wpb-col-3' => esc_html__( 'col-3 (one fourth)', 'wolf-page-builder' ),
			'wpb-col-11' => 'col-11',
			'wpb-col-10' => 'col-10',
			'wpb-col-9' => 'col-9',
			'wpb-col-8' => 'col-8',
			'wpb-col-7' => 'col-7',
			'wpb-col-5' => 'col-5',
			'wpb-col-2' => 'col-2',
			'wpb-col-1' => 'col-1',
		),
		'desc' => esc_html__( 'A row consists of a series of columns (col-X) that add up to 12.<br>Check the "First" checkbox below if your column is the first of the row<br>and check the "Last" checkbox if your column is the last of the row.', 'wolf-page-builder' ),
	),

	array(
		'id' => 'first',
		'label' => esc_html__( 'First', 'wolf-page-builder' ),
		'type' => 'checkbox',
	),

	array(
		'id' => 'last',
		'label' => esc_html__( 'Last', 'wolf-page-builder' ),
		'type' => 'checkbox',
	),
);
echo wpb_generate_tinymce_popup( 'wpb_col', $params, $title, true );
