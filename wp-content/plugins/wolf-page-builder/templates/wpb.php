<?php
/**
 * The Template for displaying the shortcode content.
 *
 * Override this template by copying it to yourtheme/wpb-extend/wpb.php
 *
 * @author WolfThemes
 * @package WolfPageBuilder/Templates
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'wpb' ); ?>
	
	<?php
		/**
		 * wpb_before_main_content hook
		 *
		 * @hooked wpb_output_content_wrapper - 10 (outputs opening divs for the content)
		 */
		do_action( 'wpb_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php echo wpb_get_content(); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * wpb_after_main_content hook
		 *
		 * @hooked wpb_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'wpb_after_main_content' );
	?>

<?php get_footer( 'wpb' ); ?>