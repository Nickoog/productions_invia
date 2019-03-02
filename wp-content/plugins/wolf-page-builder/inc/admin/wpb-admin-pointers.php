<?php

/**
 * Plugin Name: My Amdin Pointers 
 * Plugin URI:  https://gist.github.com/brasofilo/6947539
 * Version:     0.1
 * Author:      Rodolfo Buaiz
 * Author URI:  http://brasofilo.com
 * Licence:     GPLv3
 * 
 * Based on 
 * - http://wp.tutsplus.com/tutorials/integrating-with-wordpress-ui-admin-pointers/
 * - https://github.com/rawcreative/wp-help-pointers
 * - http://wpengineer.com/2272/how-to-add-and-deactivate-the-new-feature-pointer-in-wordpress-3-3/
 * 
 */
function wpb_admin_pointers() {
	$pointers = array(
		array(
			'id'       => 'wpb-help-1',
			'screen'   => 'page',
			'target'   => '.toplevel_page_wpb-settings',
			'title'    => esc_html__( 'Add a section', 'wolf-page-builder' ),
			'content'  => esc_html__( 'Start by adding your first section', 'wolf-page-builder' ),
			'position' => array(
				'edge'  => 'left',
				'align' => 'left',
			),
		),
		array(
			'id'       => 'wpb-help-2',
			'screen'   => 'page',
			'target'   => '.wpb-add-element',
			'title'    => 'Show plugin help',
			'content'  => 'Enable to see all the help texts or disable to view it tight.',
			'position' => array(
				'edge'  => 'right',
				'align' => 'right',
			),
		),
	);
	new WPB_Admin_Pointer( $pointers );
}
add_action( 'admin_enqueue_scripts', 'wpb_admin_pointers' );