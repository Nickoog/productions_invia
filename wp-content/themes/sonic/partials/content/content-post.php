<?php
/**
 * The post content displayed in the loop
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */
$blog_display = ( 'sidebar' == sonic_get_blog_display() ) ? 'standard' : sonic_get_blog_display();
get_template_part( 'partials/post/post-content', $blog_display );