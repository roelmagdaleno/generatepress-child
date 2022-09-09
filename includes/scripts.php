<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'rmr_load_custom_assets' );

/**
 * Load the "JetBrains Mono" font in single posts and only if the post contains
 * the "core/code" Gutenberg block.
 *
 * @since 0.1.1
 * @since 0.2.3 Deregister jQuery for non logged-in users.
 */
function rmr_load_custom_assets() {
	if ( ! is_user_logged_in() ) {
		wp_deregister_script( 'jquery' );
	}

	wp_deregister_script( 'wp-embed' );

	$uri = get_stylesheet_directory_uri();

	if ( 'hub' === get_post_type() ) {
		wp_enqueue_style(
			'rmr-hub.css',
			$uri . '/assets/css/hub.css',
			null,
			RMR_VERSION
		);
	}

	if ( is_single() ) {
		wp_enqueue_style(
			'rmr-single.css',
			$uri . '/assets/css/single.css',
			null,
			RMR_VERSION
		);
	}
}
