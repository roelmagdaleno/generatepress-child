<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'includes/required-files.php';

/**
 * Enqueue the admin scripts only in the "post.php"
 * admin page.
 *
 * @since 0.1.0
 *
 * @param string   $hook   	The current admin page.
 */
function rmr_enqueue_scripts( $hook ) {
	if ( 'post.php' !== $hook ) {
		return;
	}

	$assets_path = get_stylesheet_directory_uri() . '/assets/';

	wp_enqueue_script(
		'rmr-admin-assets',
		$assets_path . 'js/admin.js',
		array(),
		RMR_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'rmr_enqueue_scripts' );

new RMR_Post_Types();
