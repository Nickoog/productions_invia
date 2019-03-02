<?php
/**
 * This is the main dialog box to choose between colmuns section of blocks section
 *
 * @version 2.9.3
 */

// include WP stuff
include_once 'wp.php';
?>
<div class="wpb-dialog-form">
	<div class="wpb-text-center">
		<div class="wpb-table">
			<div class="wpb-table-cell wpb-new-section wpb-section-type wpb-section-type-columns" data-section-type="columns">
				<img src="<?php echo esc_url( WPB_URI . '/assets/img/admin/layout/section_columns.png' ); ?>">
				<label><?php esc_html_e( 'Columns', 'wolf-page-builder' ); ?></label>
			</div><!-- .wpb-table-cell -->
			<div class="wpb-table-cell wpb-new-section wpb-section-type wpb-section-type-blocks" data-section-type="blocks">
				<img src="<?php echo esc_url( WPB_URI . '/assets/img/admin/layout/section_blocks.png' ); ?>">
				<label><?php esc_html_e( 'Blocks', 'wolf-page-builder' ); ?></label>
			</div><!-- .wpb-table-cell -->
		</div><!-- .wpb-table -->
	</div>
</div><!-- .wpb-dialog-form -->