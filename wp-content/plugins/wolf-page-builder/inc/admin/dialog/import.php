<?php
/**
 * This is the "Import content" dialog box content
 *
 * @version 2.9.3
 */

// include WP stuff
include_once 'wp.php';
?>
<div class="wpb-dialog-form" id="wpb-import-form">
	<div>
		<p><label><?php esc_html_e( 'Choose the import file (it must be a text file)', 'wolf-page-builder' ); ?></label></p>
		<p><input id="wpb-fileupload" type="file" accept=".txt" name="files[]" data-url="<?php echo esc_url( WPB_URI . '/inc/admin/upload/' ); ?>"></p>
		<p><strong><?php esc_html_e( 'Once the content imported, it is recommended to save the page before editing.', 'wolf-page-builder' ); ?></strong></p>
	</div>
</div><!-- .wpb-dialog-form -->