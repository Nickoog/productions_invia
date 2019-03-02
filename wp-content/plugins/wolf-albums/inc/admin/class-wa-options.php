<?php
/**
 * Wolf Albums Options.
 *
 * @class WA_Options
 * @author WolfThemes
 * @category Admin
 * @package WolfAlbums/Admin
 * @version 1.2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WA_Options class.
 */
class WA_Options {
	/**
	 * Constructor
	 */
	public function __construct() {
		
		// default options
		add_action( 'admin_init', array( $this, 'default_options' ) );

		// register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// add option sub-menu
		add_action( 'admin_menu', array( $this, 'add_settings_menu' ) );
	}

	/**
	 * Add options menu
	 */
	public function add_settings_menu() {

		add_submenu_page( 'edit.php?post_type=gallery', esc_html__( 'Settings', 'wolf-albums' ), esc_html__( 'Settings', 'wolf-albums' ), 'edit_plugins', 'wolf-albums-settings', array( $this, 'options_form' ) );
		add_submenu_page( 'edit.php?post_type=gallery', esc_html__( 'Shortcode', 'wolf-albums' ), esc_html__( 'Shortcode', 'wolf-albums' ), 'edit_plugins', 'wolf-albums-shortcode', array( $this, 'help' ) );
	}

	/**
	 * Set default options
	 */
	public function default_options() {

		global $options;

		if ( false === get_option( 'wolf_albums_settings' ) ) {

			$default = array(
				'col' => 3,
				'layout' => 'standard',
			);

			add_option( 'wolf_albums_settings', $default );
		}
	}

	/**
	 * Init Settings
	 */
	public function register_settings() {

		register_setting( 'wolf-albums-settings', 'wolf_albums_settings', array( $this, 'settings_validate' ) );
		add_settings_section( 'wolf-albums-settings', '', array( $this, 'section_intro' ), 'wolf-albums-settings' );
		add_settings_field( 'page_id', esc_html__( 'Albums Page', 'wolf-albums' ), array( $this, 'setting_page_id' ), 'wolf-albums-settings', 'wolf-albums-settings' );
		// add_settings_field( 'layout', esc_html__( 'Layout', 'wolf-albums' ), array( $this, 'setting_layout' ), 'wolf-albums-settings', 'wolf-albums-settings' );
		add_settings_field( 'columns', esc_html__( 'Max number of column', 'wolf-albums' ), array( $this, 'setting_columns' ), 'wolf-albums-settings', 'wolf-albums-settings', array( 'class' => 'wolf-albums-settings-columns' ) );
	}

	/**
	 * Validate settings
	 */
	public function settings_validate( $input ) {

		$input['col'] = absint( $input['col'] );

		if ( isset( $input['page_id'] ) ) {
			update_option( '_wolf_albums_page_id', intval( $input['page_id'] ) );
			unset( $input['page_id'] );
		}

		return $input;
	}

	/**
	 * Intro section
	 *
	 * @return string
	 */
	public function section_intro() {

		// add instructions
	}

	/**
	 * Page settings
	 *
	 * @return string
	 */
	public function setting_page_id() {
		$pages = get_pages();
		?>
		<select name="wolf_albums_settings[page_id]">
			<option value="-1"><?php esc_html_e( 'Select a page...', 'wolf-albums' ); ?></option>
			<?php foreach ( $pages as $page ) : ?>
				<option <?php selected( absint( $page->ID ), get_option( '_wolf_albums_page_id' ) ); ?> value="<?php echo intval( $page->ID ); ?>"><?php echo sanitize_text_field( $page->post_title ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	/**
	 * Layout
	 */
	public function setting_layout() {
		$columns = array( 1, 2, 3, 4, 5, 6 );
		?>
		<select name="wolf_albums_settings[layout]">
			<?php foreach ( $columns as $column ) : ?>
			<option <?php if ( $column == wolf_albums_get_option( 'col', 3 ) ) echo 'selected="selected"'; ?>><?php echo intval( $column ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php esc_html_e( 'Number of column on desktop screen', 'wolf-albums' ); ?>
		<?php
	}

	/**
	 * Column
	 */
	public function setting_columns() {
		$columns = array( 1, 2, 3, 4, 5, 6 );
		?>
		<select name="wolf_albums_settings[col]">
			<?php foreach ( $columns as $column ) : ?>
			<option <?php if ( $column == wolf_albums_get_option( 'col', 3 ) ) echo 'selected="selected"'; ?>><?php echo intval( $column ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php esc_html_e( 'Number of column on desktop screen', 'wolf-albums' ); ?>
		<?php
	}

	/**
	 * Display options form
	 *
	 */
	public function options_form() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Albums Settings' ) ?></h2>
			<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) { ?>
				<div id="setting-error-settings_updated" class="updated settings-error">
					<p><strong><?php esc_html_e( 'Settings saved.', 'wolf-albums' ); ?></strong></p>
				</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'wolf-albums-settings' ); ?>
				<?php do_settings_sections( 'wolf-albums-settings' ); ?>
				<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'wolf-albums' ); ?>" /></p>
			</form>
		</div>
		<?php
	}

	/**
	 * Displays Shortcode help
	 *
	 */
	public function help() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Albums Shortcode', 'wolf-albums' ) ?></h2>
			<p><?php esc_html_e( 'To display your last albums in your post or page you can use the following shortcode.', 'wolf-albums' ); ?></p>
			<p><code>[wolf_last_albums]</code></p>
			<p><?php esc_html_e( 'Additionally, you can add a count and/or a category attribute.', 'wolf-albums' ); ?></p>
			<p><code>[wolf_last_albums count="6" category="my-category"]</code></p>

			<p><?php esc_html_e( 'You can also add a column count attribute.', 'wolf-albums' ); ?></p>
			<p><code>[wolf_last_albums col="2|3|4" category="my-category"]</code></p>
		</div>
		<?php
	}
}

return new WA_Options();