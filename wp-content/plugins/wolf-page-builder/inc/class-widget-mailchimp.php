<?php
/**
 * Mailchimp signup widget
 *
 * Displays mailchimp newsletter subscription form
 *
 * @author WolfThemes
 * @category Widgets
 * @extends WP_Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* Register the widget */
function wpb_widget_mailchimp_init() {

	register_widget( 'WPB_Widget_Mailchimp' );
}
add_action( 'widgets_init', 'wpb_widget_mailchimp_init' );

class WPB_Widget_Mailchimp extends WP_Widget {

	var $wpb_widget_cssclass;
	var $wpb_widget_description;
	var $wpb_widget_idbase;
	var $wpb_widget_name;

	/**
	 * Constructor
	 */
	public function __construct() {

		/* Widget variable settings. */
		$this->wpb_widget_name 	= 'Mailchimp';
		$this->wpb_widget_description = esc_html__( 'Newsletter signup form', 'wolf-page-builder' );
		$this->wpb_widget_cssclass 	= 'widget_mailchimp';
		$this->wpb_widget_idbase 	= 'widget_mailchimp';

		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->wpb_widget_cssclass, 'description' => $this->wpb_widget_description );

		/* Create the widget. */
		parent::__construct( $this->wpb_widget_idbase, $this->wpb_widget_name, $widget_ops );
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		wp_enqueue_script( 'wpb-mailchimp', WPB_JS . '/min/mailchimp.min.js', array( 'jquery' ), WPB_VERSION, true );
		// add JS global variables
		wp_localize_script(
			'wpb-mailchimp', 'WPBMailchimpParams', array(
				'ajaxUrl' => esc_url( admin_url( 'admin-ajax.php' ) ),
			)
		);
		extract( $args );
		$list = esc_attr( $instance['list'] );
		echo $before_widget;
		echo wpb_mailchimp( $list );
		echo $after_widget;
	}

	/**
	 * update function.
	 *
	 * @see WP_Widget->update
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['list'] = esc_attr( $new_instance['list'] );
		return $instance;
	}

	/**
	 * form function.
	 *
	 * @see WP_Widget->form
	 * @param array $instance
	 */
	function form( $instance ) {

		// Set up some default widget settings
		$defaults = array(
			'list' => wpb_get_option( 'mailchimp', 'default_mailchimp_list_id' ),
		);
		$instance = wp_parse_args( ( array ) $instance, $defaults);
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'list' ) ); ?>"><?php _e( 'List ID', 'wolf-page-builder' ); ?>:</label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'list' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('list') ); ?>" value="<?php echo esc_attr( $instance['list'] ); ?>">
			<br>
			<small><?php _e( 'Can be found in your mailchimp account -> Lists -> Your List Name -> Settings -> List Name & default', 'wolf-page-builder' ); ?></small>
		</p>
		<?php
	}
}