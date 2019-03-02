<?php
/**
 * Sonic loading
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_loading_mods( $sonic_mods ) {

	$sonic_mods['loading'] = array(

		'id' => 'loading',
		'title' => esc_html__( 'Loading', 'sonic' ),
		'icon' => 'update',
		'options' => array(

			array(
				'label' => esc_html__( 'Loader', 'sonic' ),
				'id' => 'loader_type',
				'help' => 'loaders.jpg',
				'type' => 'select',
				'choices' => array(
					'none'	 => esc_html__( 'None', 'sonic' ),
		 			'loader1' => esc_html__( 'Rotating plane', 'sonic' ),
					'loader2' => esc_html__( 'Double Pulse', 'sonic' ),
					'loader3' => esc_html__( 'Wave', 'sonic' ),
					'loader4' => esc_html__( 'Wandering cubes', 'sonic' ),
					'loader5' => esc_html__( 'Pulse', 'sonic' ),
					'loader6' => esc_html__( 'Chasing dots', 'sonic' ),
					'loader7' => esc_html__( 'Three bounce', 'sonic' ),
					'loader8' => esc_html__( 'Circle', 'sonic' ),
					'loader9' => esc_html__( 'Cube grid', 'sonic' ),
					'loader10' => esc_html__( 'Classic Loader', 'sonic' ),
					'loader11' => esc_html__( 'Folding cube', 'sonic' ),
					'loader12' => esc_html__( 'Ball Pulse', 'sonic' ),
					'loader13' => esc_html__( 'Ball Grid Pulse', 'sonic' ),
					//'loader14' => esc_html__( 'Ball Clip Rotate', 'sonic' ),
					'loader15' => esc_html__( 'Ball Clip Rotate Pulse', 'sonic' ),
					'loader16' => esc_html__( 'Ball Clip Rotate Pulse Multiple', 'sonic' ),
					'loader17' => esc_html__( 'Ball Pulse Rise', 'sonic' ),
					//'loader18' => esc_html__( 'Ball Rotate', 'sonic' ),
					'loader19' => esc_html__( 'Ball Zigzag', 'sonic' ),
					'loader20' => esc_html__( 'Ball Zigzag Deflect', 'sonic' ),
					'loader21' => esc_html__( 'Ball Triangle Path', 'sonic' ),
					'loader22' => esc_html__( 'Ball Scale', 'sonic' ),
					'loader23' => esc_html__( 'Ball Line Scale', 'sonic' ),
					'loader24' => esc_html__( 'Ball Line Scale Party', 'sonic' ),
					'loader25' => esc_html__( 'Ball Scale Multiple', 'sonic' ),
					'loader26' => esc_html__( 'Ball Pulse Sync', 'sonic' ),
					'loader27' => esc_html__( 'Ball Beat', 'sonic' ),
					'loader28' => esc_html__( 'Ball Scale Ripple Multiple', 'sonic' ),
					'loader29' => esc_html__( 'Ball Spin Fade Loader', 'sonic' ),
					'loader30' => esc_html__( 'Line Spin Fade Loader', 'sonic' ),
					'loader31' => esc_html__( 'Pacman', 'sonic' ),
					'loader32' => esc_html__( 'Ball Grid Beat ', 'sonic' ),
					//'loader33' => esc_html__( 'Semi Cirlce Spin ', 'sonic' ),
					//'loader34' => esc_html__( 'Ball ', 'sonic' ),
					//'loader35' => esc_html__( 'Ball ', 'sonic' ),
					//'loader36' => esc_html__( 'Ball ', 'sonic' ),
				),
			),

			'loading_logo' => array(
				'id' => 'loading_logo',
				'label' => esc_html__( 'Optional Loading Logo', 'sonic' ),
				'type' => 'image',
			),

			array(
				'label' => esc_html__( 'Loading Logo Animation', 'sonic' ),
				'id' => 'loading_logo_animation',
				'description' => esc_html__( 'It is recommended to disabled the loader icon if you set a logo animation', 'sonic' ),
				'help' => 'loaders.jpg',
				'type' => 'select',
				'choices' => array(
					'none'	 => esc_html__( 'None', 'sonic' ),
		 			'pulse' => esc_html__( 'Pulse', 'sonic' ),
					
				),
			),

			array(
				'label' => esc_html__( 'No Loading Overlay', 'sonic' ),
				'id' => 'no_loading_overlay',
				'type' => 'checkbox',
			),

			array(
				'label' => esc_html__( 'No Transition Animation', 'sonic' ),
				'id' => 'no_transition_overlay',
				'type' => 'checkbox',
			),

			array(
				'label' => esc_html__( 'No AJAX Progress Bar', 'sonic' ),
				'description' => esc_html__( 'If AJAX navigation is set.', 'sonic' ),
				'id' => 'no_ajax_progress_bar',
				'type' => 'checkbox',
			),
		),
	);
	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_loading_mods' );