<?php
/*
You can overwrite any functions here.
Make sure that the function you want to overwrite is wrapped by a condition in the parent theme like this :

if ( ! functions_exists( 'the_function_name' ) ) {
	function the_function_name(){}
}

----------
Example :

if ( ! functions_exists( 'my_custom_function' ) ) {

	function my_custom_function() {
		//your fancy code here
	}

}
*/

//-------------------------------------------------------------------------

/**
 * You can overwrite the parent theme constants here
 */

// Display the theme update notice
define( 'WOLF_UPDATE_NOTICE', true );

if ( ! function_exists( 'wolf_set_lang' ) ) {
	/**
	 * Set your language here
	 *
	 * Uncomment the line below the function to make the wolf_set_lang function active
	 * The .pot file can be found in the languages/ folder of the parent theme
	 * http://help.wolfthemes.com/2013/11/translate-your-wordpress-theme/
	 *
	 * @param string $locale
	 * @return string
	 */
	function wolf_set_lang( $locale ) {
		return 'en_US'; // this is your Locale Code see http://wpcentral.io/internationalization/
	}
	add_filter( 'locale', 'wolf_set_lang' );
}

// Have fun!