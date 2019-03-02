<?php
/**
 * Wolf Page Builder element fields function
 *
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get element setting fields
 */
function wpb_get_element_settings( $element, $values = array() ) {

	$elements = wpb_get_elements();
	$basename = $elements[ $element ]['base'];
	$settings = $elements[ $element ]['params'];

	if ( array() ==  $settings ) {
		esc_html_e( 'There is no settings for this element. You can save it as is.', 'wolf-page-builder' );
	}

	foreach ( $settings as $setting ) {
		$param_name = isset( $setting['param_name'] ) ? $setting['param_name'] : 'param';
		$type = isset( $setting['type'] ) ? $setting['type'] : 'text';
		$label = isset( $setting['label'] ) ? $setting['label'] : '';
		$choices = isset( $setting['choices'] ) ? $setting['choices'] : array();
		$dependency = isset( $setting['dependency'] ) ? $setting['dependency'] : array();
		$class = isset( $setting['class'] ) ? $setting['class'] : '';
		$style = isset( $setting['style'] ) ? $setting['style'] : '';
		$placeholder = isset( $setting['placeholder'] ) ? $setting['placeholder'] : '';
		$video_type_option = isset( $setting['video_type_option'] ) ? $setting['video_type_option'] : true;
		
		$description = isset( $setting['description'] ) ? $setting['description'] : null;
		
		$default_value = isset( $setting['value'] ) ? $setting['value'] : '';
		$data = '';
		$p_class = '';

		$meta = ( isset( $values[ $param_name ] ) ) ? $values[ $param_name ] : $default_value;

		// class
		$class .= ' wpb-param-fieldset';
		$class 	.= ' wpb-param-fieldset-' . esc_attr( $param_name );

		if ( 'int' == $type ) {
			$class .= ' wpb-short-input';
		}

		// data attributes
		if ( array() != $dependency ) {

			$class .= ' wpb-has-dependency';

			$data .= ' data-dependency-element="' . $dependency['element'] . '"';

			$value_list = '';
			foreach ( $dependency['value'] as $v ) {
				$value_list .= '"' . $v . '",';
			}
			$value_list = rtrim( $value_list, ',' );

			$dependency_value = "[$value_list]";

			$data .= " data-dependency-values='$dependency_value'";
		}

		if ( 'hidden' != $type ) {
			echo '<fieldset class="' . wpb_sanitize_html_classes( $class ) . '"' . sanitize_text_field( $data ) . ' style="' . wpb_esc_style_attr( $style ) . '">';
		}

		// label
		if ( 'background' != $type && 'video_background' != $type && 'checkbox' != $type && 'radio' != $type && $label ) {
			echo '<label class="wpb-param-label">' . esc_attr( $label ) . '</label>';
		}

		/**
		 * text, int and URL
		 */

		if ( 'text' == $type || 'int' == $type || 'url' == $type || 'slug' == $type || 'inline_css' == $type ) {

			if ( 'int' == $type ) {
				
				$meta = ( $meta ) ? intval( $meta ) : '';
			
			} 

			if ( 'url' == $type ) {
				
				$meta = esc_url( $meta );
				$placeholder = ( $placeholder ) ? $placeholder : 'http://';

			} 

			if ( 'slug' == $type ) {
				
				$meta = sanitize_title_with_dashes( $meta );

			} 

			if ( 'inline_css' ) {
				
				$meta = wpb_esc_style_attr( $meta );
			
			}

			if ( 'text' == $type ) {
				
				$meta = wpb_sample( sanitize_text_field( stripslashes( $meta ) ), 250 );
			}
			?>
			<input tabindex="-1"  data-element-type="<?php echo esc_attr( $type ); ?>" type="text" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $meta ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>">
			<?php
		}

		/**
		 * Link
		 */
		elseif ( 'link' == $type ) {
			wp_enqueue_script( 'wp-link' );
			$meta_url = ( isset( $values[ $param_name . '_url' ] ) ) ? $values[ $param_name . '_url' ] : '';
			$meta_target = ( isset( $values[ $param_name . '_target' ] ) && '1' == $values[ $param_name . '_target' ] ) ? true : '';
			//debug( $values );
			?>
			<script type="text/javascript">
			jQuery( function( $ ) {

				var field  ='';

				$( 'body' ).on( 'click', '.wpb-link-btn', function( event ) {
					event.preventDefault;
					field = $( this ).parent();
					//wpActiveEditor = true; //we need to override this var as the link dialogue is expecting an actual wp_editor instance
					wpLink.open(); //open the link popup
					
					$( '.wp-link-text-field' ).hide();

					if ( '' !== field.find( '.wpb-link-url' ).val() ) {
						$( '#wp-link-url' ).val( field.find( '.wpb-link-url' ).val() );
					}

					if ( field.find( '.wpb-link-target' ).is( 'checked' ) ) {
						$( '#wp-link-target' ).prop( 'checked', true );
					}

					return false;
				} );
				
				$( 'body' ).on( 'click', '#wp-link-submit', function(event) {
					
					var linkAtts = wpLink.getAttrs(); //the links attributes (href, target) are stored in an object, which can be access via  wpLink.getAttrs()

					field.find( '.wpb-link-url' ).val( linkAtts.href ); //get the href attribute and add to a textfield, or use as you see fit
					
					//console.log( linkAtts );

					if ( '_blank' === linkAtts.target ) {
						field.find( '.wpb-link-target' ).prop( 'checked', true );
					} else {
						field.find( '.wpb-link-target' ).prop( 'checked', false );
					}

					wpLink.textarea = $( 'body' ); //to close the link dialogue, it is again expecting an wp_editor instance, so you need to give it something to set focus back to. In this case, I'm using body, but the textfield with the URL would be fine
					wpLink.close();//close the dialogue
					//trap any events
					event.preventDefault ? event.preventDefault() : event.returnValue = false;
					event.stopPropagation();
					field = '';
					return false;
				} );
				
				$( 'body' ).on( 'click', '#wp-link-cancel, #wp-link-close', function( event ) {
					wpLink.textarea = $( 'body' );
					wpLink.close();
					event.preventDefault ? event.preventDefault() : event.returnValue = false;
					event.stopPropagation();
					return false;
				});
			} );
			</script>
			<button class="button wpb-link-btn"><?php esc_html_e( 'Helper', 'wolf-page-builder' ); ?></button>
			<p>
				<label><?php esc_html_e( 'URL', 'wolf-page-builder' ); ?></label>
				<input value="<?php echo esc_attr( $meta_url ); ?>" tabindex="-1" data-element-type="<?php echo esc_attr( $type ); ?>" type="text" name="<?php echo esc_attr( $param_name . '_url' ); ?>" class="wpb-link-url">
			</p>
			<p>
				<label>
					<input value="0" name="<?php echo esc_attr( $param_name . '_target' ); ?>" type="hidden">
					<input value="1" class="wpb-link-target" name="<?php echo esc_attr( $param_name . '_target' ); ?>"  data-element-type="checkbox" type="checkbox" <?php checked( $meta_target, true ); ?>>
					<?php esc_html_e( 'Open link in a new tab', 'wolf-page-builder' ); ?>
				</label>
			<p>
			<?php
		}

		/**
		 * Textarea
		 */
		elseif ( 'textarea' == $type ) {
			$meta = ( isset( $values[ $param_name ] ) ) ? $values[ $param_name ] : wpb_encode_textarea_html( $default_value );
		?>
			<textarea tabindex="-1" class="wpb-textarea" data-element-type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $param_name ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>"><?php echo str_replace( array( '<br>','<br/>','<br />' ), '', wpb_decode_textarea( $meta ) ); ?></textarea>
			<?php
		}

		/**
		 * Textarea with HTML
		 */
		elseif ( 'textarea_html' == $type ) {
			$meta = ( isset( $values[ $param_name ] ) ) ? $values[ $param_name ] : $default_value;
			?>
			<textarea tabindex="-1" class="wpb-textarea" data-element-type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $param_name ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>"><?php echo wpb_decode_textarea_html( $meta ); ?></textarea>
			<?php
		}

		/**
		 * Editor
		 */
		elseif ( 'editor' == $type ) {
			
			// Force visual mode to avoid glitch
 			add_filter( 'wp_default_editor', create_function( '', 'return "tinymce";') );

			$meta = ( isset( $values[ $param_name ] ) ) ? wpb_decode_textarea_html( $values[ $param_name ] ) : wpb_decode_textarea_html( $default_value );
			$editor_id =  'editorcontent'; // must the same ID as the param name.
			
			wp_editor( $meta, $editor_id, array(
				'editor_height' => 180,
				'drag_drop_upload' => false,
				'wpautop' => false,
			) );
		}

		/**
		 * Hidden
		 */
		elseif ( 'hidden' == $type ) {
			?>
			<input data-element-type="<?php echo esc_attr( $type ); ?>" type="hidden" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $meta ); ?>">
			<?php
		}

		/**
		 * Checkbox
		 */
		elseif ( 'checkbox' == $type) {
			$meta = ( isset( $values[ $param_name ] ) && '1' == $values[ $param_name ] ) ? true : '';
			// debug( $meta );
			?>
			<label class="wpb-checkbox-label">
				<input type="hidden" name="<?php echo esc_attr( $param_name ); ?>" value="0">
				<input data-element-type="<?php echo esc_attr( $type ); ?>" type="checkbox" name="<?php echo esc_attr( $param_name ); ?>" value="1" <?php checked( $meta, true ); ?>>
				<?php echo $label; ?>
			</label>
			<?php
		}

		/**
		 * Select
		 */
		elseif ( 'select' == $type ) {
			?>
			<select tabindex="-1" data-element-type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $param_name ); ?>" >
				<?php if ( array_keys( $choices ) != array_keys( array_keys( $choices ) ) ) : ?>
					<?php foreach ( $choices as $key => $name ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php echo selected( $key, $meta ); ?>><?php echo sanitize_text_field( $name ); ?></option>
					<?php endforeach; ?>
				<?php else:  ?>
					<?php foreach ( $choices as $choice ) : ?>
						<option value="<?php echo esc_attr( $choice ); ?>" <?php echo selected( $choice, $meta ); ?>><?php echo sanitize_text_field( $choice ); ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
			<?php
		}

		/**
		 * Font
		 */
		elseif ( 'font' == $type ) {
			$wpb_google_fonts = wpb_get_google_fonts_options();
			// debug( $wpb_google_fonts );
			?>
			<select tabindex="-1" data-element-type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $param_name ); ?>" >
				<option value=""><?php esc_html_e( 'Default', 'wolf-page-builder' ); ?></option>
				<?php foreach ( $wpb_google_fonts as $name => $font ) : ?>
					<option value="<?php echo esc_attr( $name ); ?>" <?php echo selected( $name, $meta ); ?>><?php echo sanitize_text_field( $name ); ?></option>
				<?php endforeach; ?>
			</select>
			<?php
		}

		/**
		 * Radio image
		 */
		elseif ( 'radio_image' == $type ) {
			$radio_count = isset( $setting['radio_count'] ) ? absint( $setting['radio_count'] ) : 2;
			$itemwidth = $radio_count > 0 ? round( 100 / $radio_count, 2,  PHP_ROUND_HALF_DOWN ) - 0.01 : 100;
			?>
			<div class="wpb-radio-image-label-container">
			<?php foreach ( $choices as $key => $img ) : ?>
				<label class="wpb-radio-image-label" style="width:<?php echo absint( $itemwidth ); ?>%;">
					<input tabindex="-1" type="radio" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php echo checked( $key, $meta ); ?>>
					<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $param_name ); ?>">
				</label>
			<?php endforeach; ?>
			</div>
			<?php
		}

		/**
		 * Radio
		 */
		elseif ( 'radio' == $type ) {
			?>
			<div class="wpb-radio-label-container">
			<?php foreach ( $choices as $key => $img ) : ?>
				<label class="wpb-radio-label">
					<input tabindex="-1" type="radio" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php echo checked( $key, $meta ); ?>>
					<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $param_name ); ?>">
				</label>
			<?php endforeach; ?>
			</div>
			<?php
		}

		/**
		 * Radio
		 */
		elseif ( 'icon' == $type ) {
			$rand = rand( 0, 99999 );
			?>
			<style type="text/css">
				[class^="dashicons-"], [class*=" dashicons-"] {
					font-family: 'dashicons';
				}
			</style>
			<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				$( '#wpb-icon-selector-<?php echo absint( $rand ); ?>' ).fontIconPicker( {
					theme: 'fip-grey',
					iconsPerPage: 64
				} );
			} );
			</script>
			<select tabindex="-1" class="wpb-icon-selector" id="wpb-icon-selector-<?php echo absint( $rand ); ?>" data-element-type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $param_name ); ?>" >
				<?php foreach ( $choices as $class => $name ) : ?>
					<option value="<?php echo esc_attr( $class ); ?>" <?php echo selected( $class, $meta ); ?>><?php echo sanitize_text_field( $name ); ?></option>
				<?php endforeach; ?>
			</select>
			<?php
		}

		/**
		 * Colorpicker
		 */
		elseif ( 'colorpicker' == $type ) {
			/**
			 * Color
			 */
			?>
			<input tabindex="-1" data-element-type="<?php echo esc_attr( $type ); ?>" type="text" class="wpb-param-colorpicker" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo wpb_sanitize_hex_color( $meta ); ?>">
			<?php
		}

		/**
		 * Colorpicker RGBA
		 */
		elseif ( 'colorpicker_rgba' == $type ) {
			/**
			 * Color RGBA
			 */
			?>
			<input tabindex="-1" data-element-type="<?php echo esc_attr( $type ); ?>" type="text" class="wpb-param-colorpicker-rgba cs-wp-color-picker" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $meta ); ?>">
			<?php
		}

		/**
		 * Image upload
		 */
		elseif ( 'image' == $type ) {
			/**
			 * Image
			 */
			$meta = ( isset( $values[ $param_name ] ) ) ? $values[ $param_name ] : '';
			$is_file = wpb_get_url_from_attachment_id( absint( $meta ), 'thumbnail' );

			if ( is_numeric( $meta ) && $is_file ) {
				
				$img_url = wpb_get_url_from_attachment_id( absint( $meta ), 'thumbnail' );
			
			} else {

				if ( wpb_is_url( $meta ) ) {

					$img_url = esc_url( $meta );

				} else {
					global $wpb_image_placeholders;
					$img_url = ( $wpb_image_placeholders[ 'thumbnail' ] ) ? $wpb_image_placeholders[ 'thumbnail' ] : '';
				}
			}
			?>
			<input data-element-type="<?php echo esc_attr( $type ); ?>" type="hidden" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $meta ); ?>">
			<img <?php if ( ! $meta ) echo 'style="display:none;"'; ?> class="wpb-param-img-preview" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $param_name ); ?>">
			<br>
			<a href="#" class="button wpb-param-reset-img"><?php esc_html_e( 'Clear', 'wolf-page-builder' ); ?></a>
			<a href="#" class="button wpb-param-set-img"><?php esc_html_e( 'Choose an Image', 'wolf-page-builder' ); ?></a>
			<?php
		}

		/**
		 * File upload
		 */
		elseif ( 'file' == $type ) {
			/**
			 * file
			 */
			$meta = ( isset( $values[ $param_name ] ) ) ? $values[ $param_name ] : '';
			
			if ( is_numeric( $meta ) ) {
				
				$file_url = wpb_get_url_from_attachment_id( $value, 'thumbnail' );
			} else {
				$file_url = esc_url( $meta );
			}
			?>
			<input data-element-type="<?php echo esc_attr( $type ); ?>" type="text" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $file_url ); ?>">
			<a href="#" class="button wpb-param-reset-file"><?php esc_html_e( 'Clear', 'wolf-page-builder' ); ?></a>
			<a href="#" class="button wpb-param-set-file"><?php esc_html_e( 'Choose a File', 'wolf-page-builder' ); ?></a>
			<?php
		}

		/**
		 * File upload
		 */
		elseif ( 'file_video' == $type ) {
			/**
			 * file
			 */
			$meta = ( isset( $values[ $param_name ] ) ) ? $values[ $param_name ] : '';
			$file_url = esc_url( $meta );
			?>
			<input data-element-type="<?php echo esc_attr( $type ); ?>" type="text" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $file_url ); ?>">
			<a href="#" class="button wpb-param-reset-file"><?php esc_html_e( 'Clear', 'wolf-page-builder' ); ?></a>
			<a href="#" class="button wpb-param-set-video-file"><?php esc_html_e( 'Choose a Video File', 'wolf-page-builder' ); ?></a>
			<?php
		}

		/**
		 * Image upload
		 */
		elseif ( 'multiple_images' == $type ) {
			/**
			 * Image
			 */

			$attachments = array();
			$thumbnail_url = '';
			$meta = wpb_clean_list( $meta );

			if ( is_numeric( $meta ) ) {
				$attachments = array( $meta );
			} else {
				$attachments = explode( ',', $meta );
			}			
			$reset_multiple_image_confirm = esc_html__( 'Are you sure to want to reset all images ?', 'wolf-page-builder' );
			?>
			<div class="wpb-images-set clearfix">
				<?php
				foreach ( $attachments as $attachment_id ) :
					
					if ( $attachment_id ) :

						$is_file = wpb_get_url_from_attachment_id( absint( $attachment_id ), 'thumbnail' );

						if ( is_numeric( $attachment_id ) && $is_file ) {
							
							$thumbnail_url = wpb_get_url_from_attachment_id( absint( $attachment_id ), 'thumbnail' );
						
						} else {

							if ( wpb_is_url( $attachment_id ) ) {

								$thumbnail_url = esc_url( $attachment_id );

							} else {
								global $wpb_image_placeholders;
								$thumbnail_url = ( $wpb_image_placeholders[ 'thumbnail' ] ) ? $wpb_image_placeholders[ 'thumbnail' ] : '';
							}
						}
						if ( $thumbnail_url ) {
							?>
							<span class="wpb-image" data-attachment-id="<?php echo absint( $attachment_id ); ?>">
								<span class="wpb-remove-img"></span>
								<img src="<?php echo esc_url( $thumbnail_url ); ?>">
							</span>
							<?php
						}
					endif;
				endforeach;
				?>
			</div><!-- .images-set -->
			<div class="wpb-clear"></div>
			<br>
			<input data-element-type="<?php echo esc_attr( $type ); ?>" type="hidden" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $meta ); ?>">
			<a href="#" class="button wpb-param-reset-all-img"><?php esc_html_e( 'Clear All', 'wolf-page-builder' ); ?></a>
			<a href="#" class="button wpb-param-set-multiple-img"><?php esc_html_e( 'Select Images', 'wolf-page-builder' ); ?></a>
			<?php
		}

		/**
		 * Background
		 */
		elseif ( 'background' == $type ) {
			/**
			 * Color
			 */
			$p_class = 'wpb-inline-block wpb-col-6 wpb-first';
			$meta = ( isset( $values[ $param_name . '_color' ] ) ) ? $values[ $param_name . '_color' ] : '';
			?>
			<p class="<?php echo wpb_sanitize_html_classes( $p_class ); ?>">
				<label class="wpb-param-label"><?php printf( esc_html__( '%s Color', 'wolf-page-builder' ), sanitize_text_field( $label ) ); ?></label>
				<input data-element-type="<?php echo esc_attr( $type ); ?>" type="text" class="wpb-param-colorpicker" name="<?php echo esc_attr( $param_name . '_color' ); ?>" value="<?php echo esc_attr( $meta ); ?>">
			</p>
			<?php
			/**
			 * image
			 */
			$p_class = 'wpb-inline-block wpb-col-6 wpb-last';
			$meta = ( isset( $values[ $param_name . '_img' ] ) ) ? $values[ $param_name . '_img' ] : '';
			// debug( $meta );
			if ( is_numeric( $meta ) ) {
							
				$img_url = wpb_get_url_from_attachment_id( absint( $meta ), 'thumbnail' );
			
			} else {

				if ( wpb_is_url( $meta ) ) {

					$img_url = esc_url( $meta );

				} else {
					global $wpb_image_placeholders;
					$img_url = ( $wpb_image_placeholders[ 'thumbnail' ] ) ? $wpb_image_placeholders[ 'thumbnail' ] : '';
				}
			}

			// ID set but not an image (maybe from import)
			if ( $meta && '' == $img_url ) {
				global $wpb_image_placeholders;
				$img_url = ( $wpb_image_placeholders[ 'thumbnail' ] ) ? $wpb_image_placeholders[ 'thumbnail' ] : '';
			}
			?>
			<p class="<?php echo wpb_sanitize_html_classes( $p_class ); ?>">
				<label class="wpb-param-label"><?php printf( esc_html__( '%s Image', 'wolf-page-builder' ), sanitize_text_field( $label ) ); ?></label>
				<input data-element-type="<?php echo esc_attr( $type ); ?>" type="hidden" name="<?php echo esc_attr( $param_name . '_img' ); ?>" value="<?php echo esc_attr( $meta ); ?>">
				<img <?php if ( ! $meta ) echo 'style="display:none;"'; ?> class="wpb-param-img-preview" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $param_name . '_img' ); ?>">
				<br>
				<a href="#" class="button wpb-param-reset-bg"><?php esc_html_e( 'Clear', 'wolf-page-builder' ); ?></a>
				<a href="#" class="button wpb-param-set-bg"><?php esc_html_e( 'Choose an Image', 'wolf-page-builder' ); ?></a>
			</p>
			<?php
			$p_class = '';
			/**
			 * Size
			 */
			$bg_settings = array(
				'size' => array(
					'cover' => esc_html__( 'cover', 'wolf-page-builder' ),
					'contain' => esc_html__( 'contain', 'wolf-page-builder' ),
					'100% auto' => esc_html__( '100% width', 'wolf-page-builder' ),
					'auto 100%' => esc_html__( '100% height', 'wolf-page-builder' ),
					'inherit' => esc_html__( 'inherit', 'wolf-page-builder' ),
				),
				'repeat' => array(
					'no-repeat' => esc_html__( 'no repeat', 'wolf-page-builder' ),
					'repeat' => esc_html__( 'repeat', 'wolf-page-builder' ),
					'repeat-x' => esc_html__( 'repeat horizontally', 'wolf-page-builder' ),
					'repeat-y' => esc_html__( 'repeat vertically', 'wolf-page-builder' ),
				),
				'position' => array(
					'center center',
					'center top',
					'left top',
					'right top',
					'center bottom',
					'left bottom',
					'right bottom',
					'left center' ,
					'right center',
				),
			);

			foreach ( $bg_settings as $setting => $choices ) {
				$meta = ( isset( $values[ $param_name . '_' . $setting ] ) ) ? $values[ $param_name . '_' . $setting ] : '';
				// if ( 'size' == $setting ) $p_class = 'wpb-inline-block wpb-col-6 wpb-first';
				if ( 'repeat' == $setting ) $p_class = 'wpb-inline-block wpb-col-6 wpb-first';
				if ( 'position' == $setting ) $p_class = 'wpb-inline-block wpb-col-6 wpb-last';

				// var_dump($p_class);
			?>
			<p class="<?php echo wpb_sanitize_html_classes( $p_class ); ?>">
				<label class="wpb-param-label"><?php echo sanitize_text_field( $label . ' ' .  ucfirst( $setting ) ); ?></label>
				<select data-element-type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $param_name . '_' . $setting ); ?>" >
					<?php if ( array_keys( $choices ) != array_keys( array_keys( $choices ) ) ) : ?>
						<?php foreach ( $choices as $key => $name ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php echo selected( $key, $meta ); ?>><?php echo sanitize_text_field( $name ); ?></option>
						<?php endforeach; ?>
					<?php else:  ?>
						<?php foreach ( $choices as $choice ) : ?>
							<option value="<?php echo esc_attr( $choice ); ?>" <?php echo selected( $choice, $meta ); ?>><?php echo sanitize_text_field( $choice ); ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
				<?php
			}
			?>
			</p>
			<?php
		}

		/**
		 * Video background
		 */
		elseif ( 'video_background' == $type ) {
			
			$meta = ( isset( $values[ $param_name . '_type' ] ) ) ? $values[ $param_name . '_type' ] : 'selfhosted';
			$p_class = 'wpb-param-fieldset-' . esc_attr( $param_name . '_type' );
			?>
			<p style="<?php echo ( $video_type_option ) ? '' : 'display:none'; ?>" class="<?php echo wpb_sanitize_html_classes( $p_class ); ?>">
				<label class="wpb-param-label"><?php printf( esc_html__( '%s Type', 'wolf-page-builder' ), sanitize_text_field( $label ) ); ?></label>
				<select data-element-type="select" name="<?php echo esc_attr( $param_name . '_type' ); ?>">
					<option value="youtube" <?php selected( $meta, 'youtube' ); ?>>YouTube</option>
					<option value="vimeo" <?php selected( $meta, 'vimeo' ); ?>>Vimeo</option>
					<option value="selfhosted" <?php selected( $meta, 'selfhosted' ); ?>><?php _e( 'Self hosted', 'wolf-page-builder' ); ?></option>
				</select>
			</p>
			<?php
			$meta = ( isset( $values[ $param_name . '_youtube_url' ] ) ) ? $values[ $param_name . '_youtube_url' ] : '';
			$p_class = 'wpb-has-dependency';
			?>
			<p data-dependency-element="<?php echo esc_attr( $param_name . '_type' ); ?>" data-dependency-values='["youtube"]' class="<?php echo wpb_sanitize_html_classes( $p_class ); ?>">
				<label class="wpb-param-label"><?php printf( esc_html__( '%s YouTube URL', 'wolf-page-builder' ), sanitize_text_field( $label ) ); ?></label>
				<input data-element-type="<?php echo esc_attr( $type ); ?>" type="text" name="<?php echo esc_attr( $param_name . '_youtube_url' ); ?>" value="<?php echo esc_url( $meta ); ?>" placeholder="https://www.youtube.com/watch?v=nrJtHemSPW4">
			<p>
			<?php
			$meta = ( isset( $values[ $param_name . '_vimeo_url' ] ) ) ? $values[ $param_name . '_vimeo_url' ] : '';
			$p_class = 'wpb-has-dependency';
			?>
			<p data-dependency-element="<?php echo esc_attr( $param_name . '_type' ); ?>" data-dependency-values='["vimeo"]' class="<?php echo wpb_sanitize_html_classes( $p_class ); ?>">
				<label class="wpb-param-label"><?php printf( esc_html__( '%s Vimeo URL', 'wolf-page-builder' ), sanitize_text_field( $label ) ); ?></label>
				<input data-element-type="<?php echo esc_attr( $type ); ?>" type="text" name="<?php echo esc_attr( $param_name . '_vimeo_url' ); ?>" value="<?php echo esc_url( $meta ); ?>" placeholder="https://vimeo.com/90069307">
			<p>
			<!-- <p>
				<?php // esc_html_e( 'more videos formats', 'wolf-page-builder' ); ?>
				<select>
					<option value="hide"><?php // esc_html_e( 'hide', 'wolf-page-builder' ); ?></option>
					<option value="show"><?php // esc_html_e( 'show', 'wolf-page-builder' ); ?></option>
				</select>
			</p> -->
			<?php
			/**
			 * Files
			 */
			$video_files = array(
				'mp4',
				'ogv',
				'webm',
			);
			$p_class = 'wpb-has-dependency';
			foreach ( $video_files as $video_file ) {
				$meta = ( isset( $values[ $param_name . '_' . $video_file ] ) ) ? $values[ $param_name . '_' . $video_file ] : '';
				?>
				<p data-dependency-element="<?php echo esc_attr( $param_name . '_type' ); ?>" data-dependency-values='["selfhosted"]' class="<?php echo wpb_sanitize_html_classes( $p_class ); ?>">
					<label class="wpb-param-label"><?php echo sanitize_text_field( $label . ' ' . $video_file ); ?></label>
					<input data-element-type="<?php echo esc_attr( $type ); ?>" type="text" name="<?php echo esc_attr( $param_name . '_' . $video_file ); ?>" value="<?php echo esc_attr( esc_url( $meta ) ); ?>">
					<a href="#" class="button wpb-param-reset-file"><?php esc_html_e( 'Clear', 'wolf-page-builder' ); ?></a>
					<a href="#" class="button wpb-param-set-video-file"><?php esc_html_e( 'Choose a Video File', 'wolf-page-builder' ); ?></a>
				</p>
				<?php
			}

			/**
			 * image fallback
			 */
			$p_class = '';
			$meta = ( isset( $values[ $param_name . '_img' ] ) ) ? $values[ $param_name . '_img' ] : '';

			if ( is_numeric( $meta ) ) {
				$img_url = wpb_get_url_from_attachment_id( $meta, 'thumbnail' );
			} else {
				$img_url = esc_url( $meta );
			}
			?>
			<p class="<?php echo wpb_sanitize_html_classes( $p_class ); ?>">
				<label class="wpb-param-label"><?php printf( esc_html__( '%s Image Fallback', 'wolf-page-builder' ), sanitize_text_field( $label ) ); ?></label>
				<span class="wpb-description"><?php esc_html_e( 'Used in case the video can\'t be displayed.', 'wolf-page-builder' ); ?></span>
				<input data-element-type="<?php echo esc_attr( $type ); ?>" type="hidden" name="<?php echo esc_attr( $param_name . '_img' ); ?>" value="<?php echo esc_attr( $meta ); ?>">
				<img <?php if ( ! $meta ) echo 'style="display:none;"'; ?> class="wpb-param-img-preview" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $param_name ); ?>">
				<br>
				<a href="#" class="button wpb-param-reset-img"><?php esc_html_e( 'Clear', 'wolf-page-builder' ); ?></a>
				<a href="#" class="button wpb-param-set-img"><?php esc_html_e( 'Choose an Image', 'wolf-page-builder' ); ?></a>
			</p>
			<?php

		}

		/**
		 * Input description
		 */
		if ( $description ) {
			?>
			<span class="wpb-description">
				<?php
				echo wp_kses(
					$description,
					array(
						'a' => array(
							'href' => array(),
							'target' => array(),
							'title' => array(),
							'rel' => array(),
						),
						'br' => array(),
						'em' => array(),
						'strong' => array(),
					)
				);
			?></span>
			<?php
		}

		if ( 'hidden' != $type ) {
			echo '</fieldset><!--.wpb-param-fieldset-->';
		}
	}
}