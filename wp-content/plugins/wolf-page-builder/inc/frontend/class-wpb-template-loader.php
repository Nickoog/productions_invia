<?php
/**
 * Template Loader
 *
 * @class WPB_Template
 * @version 2.9.3
 * @package WolfPageBuilder/Classes
 * @category Class
 * @author WolfThemes
 */
class WBP_Template_Loader {

	/**
	 * Hook in methods
	 */
	public static function init() {
		add_filter( 'template_include', array( __CLASS__, 'template_loader' ) );
	}

	/**
	 * Load a template.
	 *
	 * Handles template usage so that we can use our own templates instead of the themes.
	 *
	 * Templates are in the 'templates' folder. wpb looks for theme
	 * overrides in /theme/wpb/ by default
	 *
	 * For beginners, it also looks for a wpb.php template first. If the user adds
	 * this to the theme (containing a wpb() inside) this will be used for all
	 * wpb templates.
	 *
	 * @param mixed $template
	 * @return string
	 */
	public static function template_loader( $template ) {
		$post_types = array( 'page' );
		$find = array( 'wpb.php' );
		$file = '';

		if ( is_wpb() ) {
			$file = 'wpb.php';
			$find[] = $file;
			$find[] = WPB()->template_path() . $file;
		}

		if ( $file ) {
			$template = locate_template( array_unique( $find ) );
			if ( ! $template ) {
				$template = WPB()->plugin_path() . '/templates/' . $file;
			}
		}

		return $template;
	}
}

WBP_Template_Loader::init();