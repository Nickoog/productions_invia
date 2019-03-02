<?php
/**
 * Wolf Page Builder AJAX Functions
 *
 *
 * @author WolfThemes
 * @category Ajax
 * @package WolfPageBuilder/Functions
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  Mailchimp subscription
 *
 * @since 1.0.0
 */
function wpb_mailchimp_ajax() {
	
	extract( $_POST );

	if ( isset( $_POST['email'] ) && isset( $_POST['list_id'] ) ) {
		$email   = esc_attr( $_POST['email'] );
		$list_id = esc_attr( $_POST['list_id'] );

		if ( is_email( $email ) ) {
			global $wpb_mailchimp;
			$wpb_mailchimp->subscribe( $list_id, sanitize_email( $email ) );
			esc_html_e( 'Subscription successful', 'wolf-page-builder' );

		} else {
			esc_html_e( 'Please insert a valid email', 'wolf-page-builder' );
		}
	}
	exit;
}
add_action( 'wp_ajax_wpb_mailchimp_ajax', 'wpb_mailchimp_ajax' );
add_action( 'wp_ajax_nopriv_wpb_mailchimp_ajax', 'wpb_mailchimp_ajax' );

/**
 * Get file content and sanitize/validate it (jquery.fileupload.js)
 *
 * @since 1.0.0
 */
function wpb_ajax_get_import_file_content() {
	
	extract( $_POST );

	if ( isset( $_POST['filename'] ) ) {

		$result = array(
			'result' => '',
			'content' => '',
		);

		$filename = $_POST['filename'];

		$ext = pathinfo( $filename, PATHINFO_EXTENSION );

		if ( 'txt' != $ext ) {
			
			$result['result'] = 'error';
			$result['content'] = esc_html__( 'It must be a text file', 'wolf-page-builder' );
		
		} else {
			$folder = WPB_UPLOAD_URI;
			$file = $folder . '/' . $filename;

			// sanitize_data

			// decode
			$content = wpb_file_get_contents( $file );
			$content = wpb_clean_shortcodes( $content );

			$result['result'] = 'OK';
			$result['content'] = $content;

			wpb_clean_folder( WPB_UPLOAD_DIR );
		}
		
		echo json_encode( $result );
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_import_file_content', 'wpb_ajax_get_import_file_content' );

/**
 * Get file content and sanitize/validate it (jquery.fileupload.js)
 *
 * @since 1.0.0
 */
function wpb_ajax_decode_textarea_html() {
	extract( $_POST );

	if ( isset( $_POST['raw_content'] ) ) {
		echo wpb_decode_textarea_html( $_POST['raw_content'] );
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_decode_textarea_html', 'wpb_ajax_decode_textarea_html' );

/**
 * New empty section markup
 *
 * @since 1.0.0
 */
function wpb_ajax_get_new_section() {
	extract( $_POST );

	if ( isset( $_POST['section_type'] ) ) {
		$section_type = sanitize_text_field( $_POST['section_type'] );
		$layout = ( 'columns' == $section_type ) ? '1-cols' : '2-cols';
		$element = "wpb-section-$section_type";
		echo "<section class='wpb_section wpb_section_$section_type wpb-$section_type wpb-$layout' data-section_type='$section_type' data-layout='$layout'>";
		echo wpb_get_section_markup( $element, $layout, $section_type );
		echo '</section>';
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_new_section', 'wpb_ajax_get_new_section' );

/**
 * New empty section markup
 *
 * @since 1.0.0
 */
function wpb_ajax_get_new_row() {

	$markup = '<row class="wpb-row">';

	$markup .= wpb_get_row_toolbar();

	$icons = wpb_get_container_toolbar();
	$markup .= "<column class='wpb-column wpb-element-container'>$icons</column>";
	$markup .= '</row>';
	
	echo $markup;
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_new_row', 'wpb_ajax_get_new_row' );

/**
 * Get template content
 *
 * @since 1.0.0
 */
function wpb_get_template_shortcode_markup() {
	extract( $_POST );

	if ( isset( $_POST['name'] ) ) {
		$name = sanitize_text_field( $_POST['name'] );
		echo wpb_get_template_content( $name );
	}
	exit;
}
add_action( 'wp_ajax_wpb_get_template_shortcode_markup', 'wpb_get_template_shortcode_markup' );

/**
 * Get templates
 *
 * @since 1.0.0
 */
function wpb_ajax_get_templates() {
	?>
	<templates id="wpb-templates" class="wpb-table">
		<div class="wpb-table-cell">
			<a href="#" id="wpb-add-section-default" class="wpb-add-section button button-large"><?php esc_html_e( 'Add a section', 'wolf-page-builder' ); ?></a>
			<p id="wpb-template-separator"><?php esc_html_e( 'or choose a template', 'wolf-page-builder' ); ?></p>
			<?php foreach ( wpb_get_templates() as $template ) : ?>
				<a title="<?php echo esc_attr( $template['title'] ); ?>" href="#" class="wpb-template-img" id="<?php echo esc_attr( $template['name'] ); ?>">
					<img src="<?php echo esc_attr( $template['image'] ); ?>">
					<?php echo sanitize_text_field( $template['title'] ); ?>
				</a>
			<?php endforeach; ?>
		</div><!-- .wpb-table-cell -->
	</templates><!-- .wpb-templates -->
	<?php
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_templates', 'wpb_ajax_get_templates' );

/**
 * Convert backend shortcode content to markup content for admin
 *
 * @since 1.0
 */
function wpb_ajax_shortcode_to_markup_admin() {
	extract( $_POST );

	if ( isset( $_POST['markup'] ) ) {
		echo wpb_shortcode_to_markup_admin( stripslashes( $_POST['markup'] ) );
	}
	exit();
}
add_action( 'wp_ajax_wpb_ajax_shortcode_to_markup_admin', 'wpb_ajax_shortcode_to_markup_admin' );

/**
 * Get row layout
 *
 * Used for layout change
 *
 * @since 1.0
 */
function wpb_ajax_get_row_layout() {
	extract( $_POST );

	if ( isset( $_POST['layout'] ) ) {
		$layout = sanitize_text_field( $_POST['layout'] );
		echo wpb_get_section_layout( 'columns', $layout, false );
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_row_layout', 'wpb_ajax_get_row_layout' );

/**
 * Get section layout
 *
 * Used for layout change
 *
 * @since 1.0
 */
function wpb_ajax_get_section_layout() {
	extract( $_POST );

	if ( isset( $_POST['section_type'] ) && isset( $_POST['layout'] ) ) {
		$layout = sanitize_text_field( $_POST['layout'] );
		$section_type = sanitize_text_field( $_POST['section_type'] );
		echo wpb_get_section_layout( $section_type, $layout );
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_section_layout', 'wpb_ajax_get_section_layout' );

/**
 * Format ajax data 
 *
 * @since 1.0
 */
function wpb_ajax_sanitize_data() {
	extract( $_POST );

	if ( isset( $_POST['form_data'] ) && isset( $_POST['element'] ) ) {
		$form_data = $_POST['form_data'];
		$new_form_data = array();
		$available_params = array();
		$element = sanitize_text_field( $_POST['element'] );
		$elements = wpb_get_elements();

		// if element exists
		if ( isset( $elements[ $element ] ) ) {

			// create an array of available params
			$elements_params =  $elements[ $element ]['params'];
			foreach ( $elements_params as $param_key => $param ) {
				$available_params[] = $param['param_name'];
			}

			// add background params manually
			$available_params[] = 'background_img';
			$available_params[] = 'background_color';
			$available_params[] = 'background_size';
			$available_params[] = 'background_repeat';
			$available_params[] = 'video_bg_type';
			$available_params[] = 'video_bg_youtube_url';
			$available_params[] = 'video_bg_vimeo_url';
			$available_params[] = 'video_bg_mp4';
			$available_params[] = 'video_bg_webm';
			$available_params[] = 'video_bg_ogv';
			$available_params[] = 'video_bg_img';
			$available_params[] = 'video_bg_controls';
			$available_params[] = 'admin_collapse';
			$available_params[] = 'link_url';
			$available_params[] = 'link_target';
			$available_params[] = 'button_1_link_url';
			$available_params[] = 'button_1_link_target';
			$available_params[] = 'button_2_link_url';
			$available_params[] = 'button_2_link_target';

			// loop trough for inputs
			foreach ( $form_data as $input_key => $input ) {

				$param_name = isset( $input['name'] ) ? $input['name'] : '';
				
				if ( in_array( $param_name, $available_params ) ) {

					$type = isset( $input['type'] ) ? $input['type'] : 'text';
					$value = isset( $input['value'] ) ? $input['value'] : '';

					// sanitize
					$new_form_data[ $input_key ]['name'] = esc_attr( $param_name ); // set name

					if ( 'textarea_html' == $type || 'editor' == $type || 'textarea' == $type ) {
						
						$new_form_data[ $input_key ]['value'] = wpb_encode_textarea_html( $value );

					} elseif ( 'background' == $type ) {

						$bg_options = array( 'color', 'img', 'position', 'repeat', 'attachment', 'size', 'parallax', 'font_color' );

						$new_form_data[ $input_key ]['value'] = esc_attr( $value );
											
					} elseif ( 'checkbox' == $type ) {

						$new_form_data[ $input_key ]['value'] = ( $value ) ? '1' : '0';

					} elseif ( 'slug' == $type ) {
						
						$new_form_data[ $input_key ]['value'] = sanitize_title_with_dashes( $value );
					
					} elseif ( 'text' == $type ) {

						$new_form_data[ $input_key ]['value'] = wpb_sample( sanitize_text_field( stripslashes( $value ) ), 250 );

					} else {

						$new_form_data[ $input_key ]['value'] = esc_attr( $value );
					}
				}
			}
			// output result for ajax
			echo json_encode( $new_form_data );
		}
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_sanitize_data', 'wpb_ajax_sanitize_data' );


/**
 * Get the default params value of the first child of a element container
 *
 * @since 1.0
 */
function wpb_ajax_get_element_first_child_params() {

	extract( $_POST );

	if ( isset( $_POST['element'] ) ) {
		$element = sanitize_text_field( $_POST['element'] );
		$available_params = array();
		$elements = wpb_get_elements();

		// if element exists
		if ( isset( $elements[ $element ] ) ) {

			// get the default params values
			$elements_params = $elements[ $element ]['params'];

			// debug( $elements_params );

			foreach ( $elements_params as $p ) {

				if ( isset( $p['param_name'] ) && isset( $p['value'] ) && isset( $p['display'] ) && isset( $p['label'] ) ) {
					$name = sanitize_text_field( $p['param_name'] );
					$type = sanitize_text_field( $p['type'] );
					$value = ( isset( $p['value'] ) ) ? $p['value'] : null;
					$label = sanitize_text_field( $p['label'] );

					if ( $value ) {
						$len = 14;
						if ( 'textarea_html' == $type || 'editor' == $type ) {
								
							$value = wpb_sample( wpb_decode_textarea_html( $value ), $len );

						} elseif ( 'textarea' == $type ) {
							
							$value = wpb_sample( wpb_decode_textarea( $value ), $len );
						
						} else {
							$value = sanitize_text_field( $value );
						}

						echo "<strong>$label</strong> &mdash; $value <br>";
					}
				}
			}
		}
	}
	exit;

}
add_action( 'wp_ajax_wpb_ajax_get_element_first_child_params', 'wpb_ajax_get_element_first_child_params' );

/**
 * 
 * @since 1.0
 */
function wpb_ajax_get_element_params() {
	extract( $_POST );

	if ( isset( $_POST['params'] ) && isset( $_POST['element'] ) ) {
		$params = $_POST['params'];
		$new_params = array();
		$available_params = array();
		$element = sanitize_text_field( $_POST['element'] );
		$elements = wpb_get_elements();

		// if element exists
		if ( isset( $elements[ $element ] ) ) {

			// create an array of available params
			$elements_params = $elements[ $element ]['params'];
			
			$index = 0;
			foreach ( $elements_params as $element_param_key => $element_param ) {
				$available_params[ $element_param['param_name'] ] = array(
					'index' => $index,
					'name' => $element_param['param_name'],
					'label' => isset( $element_param['label'] ) ? $element_param['label'] : '',
					'type' => $element_param['type'],
					'display' => isset( $element_param['display'] ) ? true : false
				);
				$index++;
			}

			// loop trough
			foreach ( $params as $p ) {

				if ( isset( $p['name'] ) && isset( $p['value'] ) ) {
					$name = $p['name'];
					$value = $p['value'];

					if ( isset( $available_params[ $name ] ) ) {

						$display = $available_params[ $name ]['display'];
						$type = $available_params[ $name ]['type'];
						$index = $available_params[ $name ]['index'];

						if ( $display && 'hidden' != $type ) {
							$len = 50;
							$label = $available_params[ $name ]['label'];

							if ( 'select' == $type || 'icon' == $type || 'font' == $type ) {

								//debug( $value );
								//debug( $elements[ $element ]['params'][ $index ]['choices'][ $value ] );

								if ( isset( $elements[ $element ]['params'][ $index ]['choices'][ $value ] ) ) {
									$value = sanitize_text_field( $elements[ $element ]['params'][ $index ]['choices'][ $value ] );
								} else {
									$value = sanitize_text_field( $value );
								}

							} elseif ( 'checkbox' == $type ) {

								$value = ( 1 == $value ) ? esc_html__( 'Yes', 'wolf-page-builder' ) : '';
							
							} elseif ( 'textarea_html' == $type || 'editor' == $type ) {
								
								$value = wpb_sample( wpb_decode_textarea_html( $value ), $len );

							} elseif ( 'textarea' == $type ) {
								
								$value = wpb_sample( wpb_decode_textarea( $value ), $len );

							} else {
								$value = sanitize_text_field( $value );
							}

							if ( $value ) {
								echo "<strong>$label</strong> &mdash; $value <br>";
							}
						}
					}
				}
			}
		}
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_element_params', 'wpb_ajax_get_element_params' );

/**
 * 
 * @since 1.0
 */
function wpb_ajax_get_section_markup() {
	extract( $_POST );

	if ( isset( $_POST['element'] ) ) {
		$markup = '';
		$element = str_replace( '-', '_', sanitize_title( $_POST['element'] ) );
		$elements = wpb_get_elements();
		$section_type = ( isset( $_POST['section_type'] ) ) ? $_POST['section_type'] : 'columns';
		$layout = ( isset( $_POST['layout'] ) ) ? $_POST['layout'] : '2-cols';
		$element = ( 'columns' == $section_type ) ? 'column' : 'block';
		echo wpb_get_section_markup( $element, $layout, $section_type );
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_section_markup', 'wpb_ajax_get_section_markup' );

/**
 * 
 * @since 1.0
 */
function wpb_ajax_get_element_markup() {
	extract( $_POST );

	if ( isset( $_POST['element'] ) ) {
		echo wpb_get_element_markup( sanitize_text_field( $_POST['element'] ) ); 
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_element_markup', 'wpb_ajax_get_element_markup' );

/**
 * 
 * @since 1.0
 */
function wpb_ajax_get_markup_content() {
	extract( $_POST );

	if ( $_POST['markup'] ) {
		echo wpb_sanitize_html_markup( $_POST['markup'] );
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_markup_content', 'wpb_ajax_get_markup_content' );

/**
 * 
 * @since 1.0
 */
function wpb_ajax_get_shortcode_content() {
	extract( $_POST );

	if ( $_POST['markup'] ) {
		echo wpb_markup_to_shortcode( $markup );
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_shortcode_content', 'wpb_ajax_get_shortcode_content' );

/**
 * 
 * @since 1.0
 */
function wpb_ajax_get_elements() {	
	$elements = wpb_get_elements();
	?>
	<div class="wpb-dialog-elements">
		<div id="wpb-element-nav">
			<div id="wpb-element-filter">
				<a href="#" data-category="all"><?php esc_html_e( 'All', 'wolf-page-builder' ); ?></a>
				<?php 
				foreach ( wpb_get_element_categories() as $cat ) {
					?>
					<a href="#" data-category="<?php echo esc_attr( $cat ); ?>"><?php echo sanitize_text_field( $cat ); ?></a>
					<?php
				}
				?>
			</div><!-- #wpb-element-filter -->
			<div id="wpb-element-search-container">
				<input tabindex="-1" id="wpb-element-search" type="text" placeholder="<?php esc_html_e( 'Search an element...', 'wolf-page-builder' ); ?>">
			</div><!-- #wpb-element-search -->
		</div><!-- #wpb-element-nav -->
		<?php foreach ( $elements as $element ) :

			if ( ! isset( $element['nested'] ) ) :
				$exclude = array( 'section_columns', 'section_blocks', 'section_columns_layout', 'section_blocks_layout', 'column', 'block' );
				$base = $element['base'];
				if ( ! in_array( $base, $exclude ) ) :
					$category = isset( $element['category'] ) ? $element['category'] : '';
					$name = isset( $element['name'] ) ? $element['name'] : '';
					$description = ( isset( $element['description'] ) ) ? $element['description'] : '';
					$tags = ( isset( $element['tags'] ) ) ? $element['tags'] : '';
					$icon = ( isset( $element['icon'] ) ) ? $element['icon'] : '';
				
					if ( $name ) :
				?>
					<div class="wpb-element" data-element-name="<?php echo esc_attr( $name ); ?>" data-element="<?php echo esc_attr( $base ); ?>" data-element-category="<?php echo esc_attr( $category ); ?>" data-element-tags="<?php echo esc_attr( $tags ); ?>" original-title="<?php printf( __( '%s Settings', 'wolf-page-builder' ), $name ); ?>">
						<div class="wpb-icon-container">
							<span class="<?php echo esc_attr( $icon ); ?>"></span>
						</div>
						<span class="wpb-element-name"><?php echo sanitize_text_field( $name ); ?></span>
						<span class="wpb-element-description"><?php echo sanitize_text_field( $description ); ?></span>
					</div><!-- .wpb-element -->
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach;  ?>
	</div><!-- .wpb-dialog-form -->
	<?php
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_elements', 'wpb_ajax_get_elements' );

/**
 * 
 * @since 1.0
 */
function wpb_ajax_get_element_settings() {
	
	extract( $_POST );

	if ( isset( $_POST['element'] ) ) {
		$has_editor_array = array( 'wpb_toggle', 'wpb_text_block', 'wpb_accordion', 'wpb_tab' );
		$elements = wpb_get_elements();
		$error_message = esc_html__( 'Error retrieving the element settings. It seems that this element doesn\'t exist.', 'wolf-page-builder' );
		$values = isset( $_POST['values'] ) ? $_POST['values'] : array();
		$element = sanitize_text_field( $_POST['element'] );
		$name = ( isset( $elements[ $element ]['name'] ) ) ? $elements[ $element ]['name'] : '';
		$help = ( isset( $elements[ $element ]['help'] ) ) ? $elements[ $element ]['help'] : '';
		$has_child = ( isset( $elements[ $element ]['has_child'] ) ) ? '1' : '';
		$element_child = ( isset( $elements[ $element ]['child'] ) ) ? $elements[ $element ]['child'] : null;
		$has_editor = ( in_array( $element, $has_editor_array ) ) ? true : false;
		if ( isset( $elements[ $element ] ) ) {
			?>
			<div id="wpb-dialog-form"
				data-has-editor="<?php echo esc_attr( $has_editor ); ?>"
				data-element="<?php echo esc_attr( $element ); ?>"
				data-element-has-child="<?php echo esc_attr( $has_child ); ?>"
				data-element-child="<?php echo esc_attr( $element_child ); ?>"
				data-title="<?php echo esc_attr( $name ); ?>">
				<form id="wpb-settings-form"
					data-element="<?php echo esc_attr( $element ); ?>"
					data-element-has-child="<?php echo esc_attr( $has_child ); ?>"
					data-element-child="<?php echo esc_attr( $element_child ); ?>"
					data-title="<?php echo esc_attr( $name ); ?>">
					<?php if ( $help ) : ?>
					<p class="wpb-element-settings-help help">
						<?php echo sanitize_text_field( $help ); ?>
					</p>
					<?php endif; ?>
					<?php wpb_get_element_settings( $element, $values ); ?>
				</form>
			</div><!-- #wpb-dialog-form -->
			<?php
		} else {
			printf( $error_message );
		}
	} else {
		printf( $error_message );
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_element_settings', 'wpb_ajax_get_element_settings' );

/**
 * Get URL of an attachment post by ID
 */
function wpb_ajax_get_url_from_attachment_id() {
	
	extract( $_POST );

	if ( isset( $_POST['attachmentId'] ) ) {
		$attachment_id = absint( $_POST['attachmentId'] );
		$size = (  isset( $_POST['size'] ) ) ? sanitize_text_field( $_POST['size'] ) : 'wpb-thumbnail';
		if ( wpb_get_url_from_attachment_id( $attachment_id, $size ) ) {
			echo wpb_get_url_from_attachment_id( $attachment_id, $size );
		}
	}
	exit;
}
add_action( 'wp_ajax_wpb_ajax_get_url_from_attachment_id', 'wpb_ajax_get_url_from_attachment_id' );