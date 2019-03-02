<?php
/**
 * Wolf Page Builder Export text file.
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */

if ( empty( $_POST['filename'] ) || empty( $_POST['content'] ) ) {
	exit;
}

// Sanitizing the filename:
$filename = preg_replace( '/[^a-z0-9\-\_\.]/i','',$_POST['filename'] );

// Outputting headers:
header( "Cache-Control: " );
header( "Content-type: text/plain" );
header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

echo $_POST['content'];