<?php
/**
 * Wolf Page Builder TinyMCE popup HTML wrapper
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */
include_once( 'load.php' );
$popup = null;
if ( isset( $_GET[ 'popup' ] ) )
	$popup = 'popup/' . $_GET['popup'] . '.php';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head></head>
<body>
	<?php include( $popup ); ?>
</body>
</html>