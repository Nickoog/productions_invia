<?php
/**
 * Wolf Page Builder Settings.
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
 * WPB_Settings class.
 */
class WPB_Settings {

	/**
	 * @var settings id
	 */
	private $settings_id = 'wpb-settings';

	/**
	 * @var settings slug
	 */
	private $settings_slug = 'settings';

	/**
	 * @var array
	 */
	public $settings = array();

	/**
	 * Constructor
	 */
	public function __construct( $settings = array() ) {

		$this->settings = $settings + $this->settings;

		// Add menu
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		// Add settings form
		add_action( 'admin_init', array( $this, 'settings' ) );

		// set default options
		add_action( 'admin_init', array( $this, 'default_options' ) );

		// Add settings scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
  	 * Enqueue scripts
	 */
	public function scripts() {
		wp_enqueue_script( 'wp-color-picker' ); // colorpicker
	}

	/**
	 * Add the Theme menu to the WP admin menu
	 */
	public function admin_menu() {

		$icon = 'dashicons-hammer';

		add_menu_page( esc_html__( 'Page Builder', 'wolf-page-builder' ), esc_html__( 'Page Builder', 'wolf-page-builder' ), 'activate_plugins', 'wpb-settings', array( $this, 'settings' ), $icon, 44 );

		foreach ( $this->settings as $section ) {
			$this->settings_id = $section['settings_id'];
			add_submenu_page( 'wpb-settings', $section['title'], $section['title'], 'activate_plugins', $section['settings_id'], array( $this, 'settings_form' ) );
		}
	}

	/**
	 * Init Settings
	 */
	public function settings() {
		
		foreach ( $this->settings as $setting ) {
			$this->settings_id = $setting['settings_id'];
			$this->settings_slug = $setting['settings_slug'];
			
			register_setting( $this->settings_id, $this->settings_slug, array( $this, 'settings_validate' ) );
			add_settings_section( $this->settings_id, '', array( $this, 'section_intro' ), $this->settings_id );
						
			foreach ( $setting['fields'] as $key => $field ) {
				$type = ( isset( $field['type'] ) ) ? $field['type'] : 'text';
				$label = ( isset( $field['label'] ) ) ? $field['label'] : '';
				$description = ( isset( $field['description'] ) ) ? $field['description'] : '';
				$placeholder = ( isset( $field['placeholder'] ) ) ? $field['placeholder'] : '';
				$value = ( isset( $field['value'] ) ) ? $field['value'] : '';
				$choices = ( isset( $field['choices'] ) && 'select' == $type  ) ? $field['choices'] : array();
				add_settings_field(
					$field['field_id'],
					$label,
					array( $this, 'setting_field' ),
					$this->settings_id,
					$this->settings_id,
					array( 
						'field_id' => $field['field_id'],
						'type' => $type,
						'settings_slug' => $this->settings_slug,
						'description' => $description,
						'placeholder' => $placeholder,
						'value' => $value,
						'choices' => $choices,
					)
				);
			}

			add_settings_field( 'settings_index', '', array( $this, 'section_slug' ), $this->settings_id, $this->settings_id, array( 'settings_slug' => $this->settings_slug ) );
		}
	}

	/**
	 * Intro section
	 */
	public function section_slug( $args ) {
		$settings_slug = $args['settings_slug'];
		?>
		<input type="hidden" name="<?php echo esc_attr( $settings_slug . '[settings_slug]' ); ?>" value="<?php echo esc_attr( $settings_slug ); ?>">
		<?php
	}

	/**
	 * Validate settings
	 */
	public function settings_validate( $input ) {

		do_action( 'wpb_before_options_save', $input );

		$setting_index = esc_attr( $input['settings_slug'] );
		wpb_update_option_index( $setting_index, $input );

		do_action( 'wpb_after_options_save', $input );

		return $input;
	}

	/**
	 * Intro section
	 */
	public function section_intro() {
		//var_dump( get_option( 'wpb_settings' ) );
		//var_dump( wpb_get_option( 'mailchimp', 'mailchimp_api_key' ) );
		// add instructions
		?>
		<script type="text/javascript">
			jQuery( function( $ ) {
				$( '.wpb-settings-colorpicker' ).wpColorPicker();

				$( document ).on( 'click', '.wpb-set-img', function( event ) {
					event.preventDefault();
					var $el = $( this ).parent();
					var uploader = wp.media({
						title : '<?php esc_js( esc_html_e( 'Choose an image', 'wolf-page-builder' ) ); ?>',
						library : { type : 'image'},
						multiple : false
					} )
					.on( 'select', function(){
						var selection = uploader.state().get('selection');
						var attachment = selection.first().toJSON();
						$('input', $el).val(attachment.id);
						$('img', $el).attr('src', attachment.url).show();
					} )
					.open();
				} );

				$( document ).on( 'click', '.wpb-reset-img', function(){

					$( this ).parent().find('input').val('');
					$( this ).parent().find('.wpb-img-preview').hide();
					return false;

				} );
			} );
		</script>
		<?php
	}

	/**
	 * Create field using passed arguments
	 *
	 * @param array $args
	 * @return string
	 */
	public function setting_field( $args ) {
		$type = $args['type'];
		$field_id = $args['field_id'];
		$settings_slug = $args['settings_slug'];
		$placeholder = $args['placeholder'];
		$value = ( wpb_get_option( $settings_slug, $field_id ) ) ? wpb_get_option( $settings_slug, $field_id ) : $args['value'];
		$choices = $args['choices'];
		$description = $args['description'];

		if ( 'text' == $type || 'url' == $type ) {
			?>
			<input placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( wpb_get_option( $settings_slug, $field_id ) ); ?>" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>" class="regular-text">
			<?php
		} elseif ( 'checkbox' == $type ) {
			?>
			<input type="hidden" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>" value="0">
			<label>
				<input type="checkbox" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>" value="1" <?php checked( wpb_get_option( $settings_slug, $field_id ), 1 ); ?>>
			</label>
			<?php
		} elseif ( 'colorpicker' == $type ) {
			?>
			<input value="<?php echo wpb_sanitize_hex_color( wpb_get_option( $settings_slug, $field_id ) ); ?>" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>" class="wpb-settings-colorpicker">
			<?php

		} elseif ( 'select' == $type ) {
			?>
			<select name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>">
				<?php if ( array_keys( $choices ) != array_keys( array_keys( $choices ) ) ) : ?>
					<?php foreach ( $choices as $key => $name) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $value, $key ); ?>><?php echo sanitize_text_field( $name ); ?></option>
					<?php endforeach; ?>
				<?php else : ?>
					<?php foreach ( $choices as $choice ) : ?>
						<option value="<?php echo esc_attr( $choice ); ?>" <?php selected( $value, $choice ); ?>><?php echo sanitize_text_field( $choice ); ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
			<?php
		} elseif ( 'image' == $type ) {
			/**
			 * Bg image
			 */
			wp_enqueue_media();
			$image_id = absint( $value );
			$image_url = wpb_get_url_from_attachment_id( $image_id );
			?>
			<input type="hidden" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>" value="<?php echo esc_attr( $image_id); ?>">
			<img style="max-width:150px;<?php if ( ! $image_id ) echo 'display:none;'; ?>" class="wpb-img-preview" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $field_id ); ?>">
			<br>
			<a href="#" class="button wpb-reset-img"><?php esc_html_e( 'Clear', 'wolf-page-builder' ); ?></a>
			<a href="#" class="button wpb-set-img"><?php esc_html_e( 'Choose an image', 'wolf-page-builder' ); ?></a>
			<?php
		} elseif ( 'background' == $type ) {
			$bg_meta = wpb_get_bg_meta( $settings_slug, $field_id  );
			extract( $bg_meta );
			$image_url = wpb_get_url_from_attachment_id( $image_id );
			/**
			 * Bg color
			 */
			?>
			<p>
				<label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][color]' ); ?>">
					<?php esc_html_e( 'Color', 'wolf-page-builder' ); ?>
				</label><br>
				<input value="<?php echo wpb_sanitize_hex_color( $color ); ?>" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][color]' ); ?>" class="wpb-settings-colorpicker">
			</p>
			<?php
			/**
			 * Bg image
			 */
			wp_enqueue_media();
			?>
			<p>
				<label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][image_id]' ); ?>">
					<?php esc_html_e( 'Image', 'wolf-page-builder' ); ?>
				</label><br>
				<input type="hidden" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][image_id]' ); ?>" value="<?php echo esc_attr( $image_id); ?>">
				<img style="max-width:150px;<?php if ( ! $image_id ) echo 'display:none;'; ?>" class="wpb-img-preview" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $field_id ); ?>">
				<br>
				<a href="#" class="button wpb-reset-img"><?php esc_html_e( 'Clear', 'wolf-page-builder' ); ?></a>
				<a href="#" class="button wpb-set-img"><?php esc_html_e( 'Choose an image', 'wolf-page-builder' ); ?></a>
			</p>
			<?php

			/**
			 * Bg repeat
			 */
			$options = array( 'no-repeat', 'repeat', 'repeat-x', 'repeat-y' );
			?>
			<p>
				<label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][repeat]' ); ?>">
					<?php esc_html_e( 'Repeat', 'wolf-page-builder' ); ?>
				</label><br>
				<select name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][repeat]' ); ?>">
					<?php foreach ( $options as $option ) : ?>
						<option <?php selected( $repeat, $option ); ?>><?php echo sanitize_text_field( $option ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php
			/**
			 * Bg position
			 */
			$options = array(
				'center center',
				'center top',
				'left top' ,
				'right top' ,
				'center bottom',
				'left bottom' ,
				'right bottom' ,
				'left center' ,
				'right center',
			);
			 ?>
			 <p>
				 <label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][position]' ); ?>">
					<?php esc_html_e( 'Position', 'wolf-page-builder' ); ?>
				</label><br>
				 <select name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][position]' ); ?>">
				 	<?php foreach ( $options as $option ) : ?>
						<option <?php selected( $position, $option ); ?>><?php echo sanitize_text_field( $option ); ?></option>
					<?php endforeach; ?>
				 </select>
			</p>
			 <?php

			/**
			 * Bg size
			 */
			$options = array(
				'cover' => esc_html__( 'cover (resize)', 'wolf-page-builder' ),
				'normal' => esc_html__( 'normal', 'wolf-page-builder' ),
				'resize' => esc_html__( 'responsive (hard resize)', 'wolf-page-builder' ),
			);
			?>
			<p>
				<label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][size]' ); ?>">
					<?php esc_html_e( 'Size', 'wolf-page-builder' ); ?>
				</label><br>
				<select name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][size]' ); ?>">
					<?php foreach ( $options as $option => $display ) : ?>
						<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $size, $option ); ?>><?php echo sanitize_text_field( $display ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php

			/**
			 * Bg attachment
			 */
			$options = array(
				'scroll',
				'fixed',
			);
			?>
			<p>
				<label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][attachment]' ); ?>">
					<?php esc_html_e( 'Attachment', 'wolf-page-builder' ); ?>
				</label><br>
				<select name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][attachment]' ); ?>">
					<?php foreach ( $options as $option ) : ?>
						<option <?php selected( $attachment, $option ); ?>><?php echo sanitize_text_field( $option ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php
		}

		if ( $description ) {
			echo '<p class="description">' . sanitize_text_field( $description ) . '</p>';
		}
	}

	/**
	 * Plugin Settings
	 */
	public function settings_form() {
		$this->settings_id = ( isset( $_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : '';
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Page Builder Settings' ) ?></h2>
			<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) { ?>
				<div id="setting-error-settings_updated" class="updated settings-error">
					<p><strong><?php esc_html_e( 'Settings saved.', 'wolf-page-builder' ); ?></strong></p>
				</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields( $this->settings_id ); ?>
				<?php do_settings_sections( $this->settings_id ); ?>
				<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'wolf-page-builder' ); ?>" /></p>
			</form>
		</div>
		<?php
	}

	/**
	 * Set default options
	 */
	public function default_options() {

		global $options;

		//delete_option( 'wpb_settings' );

		if ( ! get_option( 'wpb_settings' )  ) {

			$default_twitter_url = ( get_user_meta( get_current_user_id(), 'twitter', true ) ) ? 'https://twitter.com/' . esc_attr( get_user_meta( get_current_user_id(), 'twitter', true ) ) : '#';
			$default_facebook_url = ( get_user_meta( get_current_user_id(), 'facebook', true ) ) ? get_user_meta( get_current_user_id(), 'facebook', true ) : '#';
			
			$default = apply_filters( 'wpb_default_settings',
				array(

					'settings' => array(
						'lightbox' => 'swipebox',
						'lazyload' => true,
						'css_min' => true,
						'js_min' => true,
					),
					'mailchimp' => array(
						'label' => esc_html__( 'Subscribe to our newsletter', 'wolf-page-builder' ),
						'subscribe_text' => esc_html__( 'Subscribe', 'wolf-page-builder' ),
						'placeholder' => esc_html__( 'your email', 'wolf-page-builder' ),
					),
					'fonts' => array(),
					
					'socials' => array(
						'twitter' => $default_twitter_url,
						'facebook' => $default_facebook_url,
					),
				)
			);

			add_option( 'wpb_settings', $default );
		}

		//var_dump( get_option( 'wpb_settings' ) );
	}
} // end class