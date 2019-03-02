<?php
/**
 * Highlight dialog box
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package wpbPageBuilder/Admin
 * @version 2.9.3
 */
?>
<script type="text/javascript">
jQuery( function( $ ) {

	$( '#wpb-insert' ).click( function() {

		var html = tinyMCE.activeEditor.selection.getContent(),
		//var html = 'test';
		// set up variables to contain our input values
			color = $( '#highlight' ).val();

		output = '[wpb_highlight';
		output += ' color="' +color + '"';
		output += ']'+ html + '[/wpb_highlight]';

		if ( window.tinyMCE  ) {

			//alert(output);
			window.parent.send_to_editor( output );
			//window.tinyMCE.execInstanceCommand( 'content', 'mceInsertContent', false, output);
			tb_remove();
			return false;
		}
	} );
} );
</script>
<div id="wpb-popup-head"><strong><?php esc_html_e( 'Highlight Text', 'wolf-page-builder' ); ?></strong></div>
<div id="wpb-popup">
	<form action="#" method="get">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="highlight"><?php esc_html_e( 'Color', 'wolf-page-builder' ); ?></label></th>
					<td>
						<select name="highlight" id="highlight">
							<option value="yellow"  selected="selected"><?php esc_html_e( 'yellow', 'wolf-page-builder' ); ?></option>
							<option value="green"><?php esc_html_e( 'green', 'wolf-page-builder' ); ?></option>
							<option value="red"><?php esc_html_e( 'red', 'wolf-page-builder' ); ?></option>
							<option value="black"><?php esc_html_e( 'black', 'wolf-page-builder' ); ?></option>
							<option value="white"><?php esc_html_e( 'white', 'wolf-page-builder' ); ?></option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" id="wpb-insert" class="button-primary" value="<?php esc_html_e( 'Wrap selected words', 'wolf-page-builder' ); ?>"></p>
	</form>
</div>