<?php
/**
 * Wolf Page Builder helpdesk page
 *
 * Redirect user to the support forum using JS
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/AdminPages
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="wrap"><?php esc_html_e( 'Redirection...', 'wolf-page-builder' ); ?></div>
<script type="text/javascript">
	//<![CDATA[
	window.location.replace("<?php echo esc_url( WPB_SUPPORT_URL . '/' ); ?>");
	//]]>
</script>