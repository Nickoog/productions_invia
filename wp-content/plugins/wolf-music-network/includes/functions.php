<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Output markup
 *
 * @param array $networks
 * @param string $height
 * @param string $align
 * @return void
 */
if ( ! function_exists( 'wolf_music_network' ) ) {
	function wolf_music_network( $height = '', $align = '', $networks = array() ) {
		global $wolf_music_network;
		echo wp_kses_post( $wolf_music_network->show( $height, $align, $networks  ) );
	}
}

/**
 * Check if at least on profile is set
 *
 * @return bool
 */
if ( ! function_exists( 'wolf_is_music_network' ) ) {
	function wolf_is_music_network() {
		global $wolf_music_network;
		$networks_available = $wolf_music_network->networks();
		$settings = ( get_option( 'wolf_music_network_settings' ) ) ? get_option( 'wolf_music_network_settings' ) : array();
		foreach ( $networks_available as $n ) {
			if ( isset( $settings[ $n ] ) && '' !== $settings[ $n ] ) {
				return true;
				break;
			}
		}
	}
}