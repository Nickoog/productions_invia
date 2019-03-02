<?php
/**
 * Wolf Page Builder Admin.
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WPB_Admin class.
 */
class WPB_Admin {
	/**
	 * Constructor
	 */
	public function __construct() {

		// plugin row meta
		//add_filter( 'plugin_action_links_' . plugin_basename( WPB_PATH ), array( $this, 'settings_action_links' ) );

		// Update
		add_action( 'admin_init', array( $this, 'update' ), 0 );
		
		// Includes necessary files
		add_action( 'init', array( $this, 'includes' ), 0 );
		//$this->includes();

		// Includes element after init hook to allow filtering by theme
		add_action( 'init', array( $this, 'include_elements' ) );

		// Add admin body class
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
		
		// Add Page Builder metabox
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		// add_action( 'edit_form_after_title', array( $this, 'push_metabox_at_the_top' ) );

		// Save post hook
		add_action( 'save_post', array( $this, 'save_post' ) );

		// Admin notices
		add_action( 'admin_notices', array( $this, 'warning_other_page_builders' ) );
		
		// Create upload folder
		add_action( 'admin_init', array( $this, 'create_import_folder' ) );

		// Plugin update notifications
		add_action( 'admin_init', array( $this, 'plugin_update' ) );
	}

	/**
	 * Perform actions on updating the theme id needed
	 */
	public function update() {

		if ( ! defined( 'IFRAME_REQUEST' ) && ! defined( 'DOING_AJAX' ) && ( get_option( 'wpb_version' ) != WPB_VERSION ) ) {
		
			// Update hook
			do_action( 'wpb_do_update' );

			// Update version
			delete_option( 'wpb_version' );
			add_option( 'wpb_version', WPB_VERSION );

			// After update hook
			do_action( 'wpb_updated' );
		}
	}

	/**
	 * Add settings link in plugin page
	 */
	public function settings_action_links( $links ) {
		$setting_link = array(
			'<a href="' . admin_url( 'admin.php?page=wpb-settings' ) . '">' . esc_html__( 'Settings', 'wolf-page-builder' ) . '</a>',
		);
		return array_merge( $links, $setting_link );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {

		// Functions
		include_once( 'wpb-admin-functions.php' );
		include_once( 'wpb-parsing.php' );
		include_once( 'wpb-element-fields.php' );
		include_once( 'wpb-elements-functions.php' );
		include_once( 'wpb-update.php' );

		// Settings
		include_once( 'class-wpb-settings.php' );
		include_once( 'wpb-settings.php' );

		// Scripts
		include_once( 'wpb-admin-scripts.php' );
		
		// Welcome message & About page
		include_once( 'class-wpb-welcome-message.php' );
		include_once( 'class-wpb-about-page.php' );

		// Help pointers
		//include_once( 'class-wpb-admin-pointer.php' );
		//include_once( 'wpb-admin-pointers.php' );

		// TinyMCE
		include_once( 'class-wpb-tiny-mce-shortcodes.php' );
	}

	/**
	 * Include element files
	 */
	public function include_elements() {

		// Get elements list
		$elements_slugs = wpb_get_element_list();

		foreach ( $elements_slugs as $slug ) {
			
			include_once( wpb_locate_file( 'elements/' . sanitize_title_with_dashes( $slug ) . '.php', 'admin' ) );
		}

		// Additional elements settings
		include_once( 'wpb-elements-additional-settings.php' );
	}

	/**
	 * Add body class to the admin for cosmetic purpose
	 */
	public function admin_body_class( $classes ) {
		
		$classes .= ' wpb-admin';

		if ( defined( 'WPB_VC_VERSION' ) ) {
			$classes .= ' wolf-page-builder-vc-installed';
		}
		
		return $classes;
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {

		// disable page builder on blog page
		if ( ! wpb_do_admin_wpb() ) {
			return;
		}
		
		$post_types = array( 'page' ); //limit meta box to chosen post types
		
		if ( in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'wpb_content',
				esc_html__( 'Page Builder', 'wolf-page-builder' ),
				array( $this, 'render_meta_box_content' ),
				$post_type,
				'normal',
				'high'
			);
		}
	}

	/**
	 * Be sure that the page builder metabox is a the top, below the title field
	 */
	public function push_metabox_at_the_top() {
		# Get the globals:
		global $post, $wp_meta_boxes;

		// debug(  $wp_meta_boxes );

		# Output the "advanced" meta boxes:
		do_meta_boxes( get_current_screen(), 'above', $post );

		# Remove the initial "advanced" meta boxes:
		unset( $wp_meta_boxes[ get_post_type( $post ) ]['above'] );
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wpb_content', 'wpb_content_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$shortcode_content = get_post_meta( $post->ID, '_wpb_shortcode_content', true );
		$markup = get_post_meta( $post->ID, '_wpb_markup', true );
		$wpb_status = get_post_meta( $post->ID, '_wpb_status', true );

		// debug( $wpb_status );
		// Display the form, using the current values.
		?>
		<input type="hidden" value="<?php echo $wpb_status; ?>" name="wpb_status" id="wpb-status">
		<div id="wpb-panel">
			<div id="wpb-wait">
				<div class="wpb-table">
					<div class="wpb-table-cell">
						<span id="wpb-wait-icon" class="fa fa-coffee"></span>
						<span id="wpb-wait-text"><?php esc_html_e( 'Please wait...', 'wolf-page-builder' ); ?></span>
					</div>
				</div>
			</div>
			<div id="wpb-top-toolbar">
				<a href="#" id="wpb-add-section-prepend" class="wpb-add-section wpb-toolbar-button wpb-tipsy" title="<?php esc_html_e( 'Add a section at the top', 'wolf-page-builder' ); ?>"></a>
				<a target="_blank" href="<?php echo esc_url( WPB_DOC_URI ); ?>" class="wpb-help wpb-toolbar-button wpb-tipsy" title="<?php esc_html_e( 'Documentation', 'wolf-page-builder' ); ?>"></a>
				<!-- <a href="#" class="wpb-settings wpb-toolbar-button wpb-tipsy" title="<?php // esc_html_e( 'Settings', 'wolf-page-builder' ); ?>"></a> -->
				<?php if ( WPB_DEV ) : ?>
					<a href="#" class="wpb-refresh wpb-toolbar-button wpb-tipsy" title="<?php esc_html_e( 'Refresh markup', 'wolf-page-builder' ); ?>"></a>
				<?php endif; ?>
			</div><!-- #wpb-toolbar -->
			
			<div id="wpb-markup-container">
				<div id="wpb-markup"><?php echo wpb_sanitize_html_markup( $markup ); ?></div><!-- #wpb-markup -->
			</div><!-- #wpb-markup-container -->
			
			<div id="wpb-bottom-toolbar">
				<a href="#" id="wpb-add-section-append" class="wpb-add-section wpb-toolbar-button wpb-tipsy" title="<?php esc_html_e( 'Add a section at the bottom', 'wolf-page-builder' ); ?>"></a>
				<a target="_blank" href="<?php echo esc_url( WPB_DOC_URI ); ?>" class="wpb-help wpb-toolbar-button wpb-tipsy" title="<?php esc_html_e( 'Documentation', 'wolf-page-builder' ); ?>"></a>
				<!-- <a href="#" class="wpb-settings wpb-toolbar-button wpb-tipsy" title="<?php // esc_html_e( 'Settings', 'wolf-page-builder' ); ?>"></a> -->
			</div><!-- #wpb-toolbar -->
		</div><!-- #wpb-panel -->
		<?php $hidden_class = ( WPB_DEV ) ? '' : 'wpb-hide'; ?>
		<textarea cols="195" rows="8" name="wpb_shortcodes" class="<?php echo esc_attr( $hidden_class ); ?>" id="wpb_shortcodes_textarea"><?php echo wpb_clean_shortcodes( $shortcode_content ); ?></textarea>
		<textarea cols="195" rows="8" name="wpb_markup" class="<?php echo esc_attr( $hidden_class ); ?>" id="wpb_markup_textarea"><?php echo $markup; ?></textarea>
		<?php
	}

	/**
	 * Process data while saving post
	 */
	public function save_post( $post_id ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['wpb_content_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['wpb_content_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'wpb_content' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			// do autosave metabox
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$shortcode_content = wpb_clean_shortcodes( $_POST['wpb_shortcodes'] );
		$markup = wpb_sanitize_html_markup( $_POST['wpb_markup'] );
		$wpb_status = sanitize_text_field( $_POST['wpb_status'] );

		// Update the meta fields
		update_post_meta( $post_id, '_wpb_shortcode_content', $shortcode_content );
		update_post_meta( $post_id, '_wpb_markup', $markup );
		update_post_meta( $post_id, '_wpb_status', $wpb_status );
	}

	/**
	 * Add an  error notice if another page builder is installed
	 */
	public function warning_other_page_builders() {

		$is_other_page_builder = false;
		$other_page_builder_name = null;
		$other_page_builders_check = array(
			defined( 'WPB_VC_VERSION' ) => 'Visual Composer',
			defined( 'SITEORIGIN_PANELS_VERSION' ) => 'Page Builder by SiteOrigin',
			defined( 'AQPB_PATH' ) => 'Aqua Page Builder',
		);

		foreach ( $other_page_builders_check as $other_page_builder_check => $name ) {
			if ( true == $other_page_builder_check ) {
				$is_other_page_builder = true;
				$other_page_builder_name = $name;
				break;
			}
		}

		$error_message = sprintf(
			wp_kses(
				__( 'It seems that another page builder is installed. Please deactivate the following plugin: <a href="%1$s"><strong>%2$s</strong></a>', 'wolf-page-builder' ),
				array(
					'a' => array( 'href' => array() ),
					'strong' => array()
				)
			),
			esc_url( admin_url( 'plugins.php' ) ),
			$other_page_builder_name
		);

		if ( $is_other_page_builder ) {
			wpb_admin_notice( $error_message, 'error', false, 'wpb_is_other_page_builder' );
		}
	}

	/**
	 * Check if the folder to import page content is writable
	 */
	public function create_import_folder() {
		if ( ! file_exists( WPB_UPLOAD_DIR ) ) {
			wp_mkdir_p( WPB_UPLOAD_DIR );
		}
	}

	/**
	 * Plugin update
	 */
	public function plugin_update() {
		$plugin_slug = WPB_SLUG;
		$plugin_path = WPB_PATH;
		$remote_path = WPB_UPDATE_URL . '/' . $plugin_slug;
		$plugin_data = get_plugin_data( WPB_DIR . '/' . WPB_SLUG . '.php' );
		$current_version = $plugin_data['Version'];
		include_once( 'class-wpb-update.php');
		new WPB_Update( $current_version, $remote_path, $plugin_path );
	}
} // end class

return new WPB_Admin();