<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'includes/constants.php';

add_action( 'enqueue_block_editor_assets', 'rmr_load_fonts_in_gutenberg_editor' );
add_action( 'wp_enqueue_scripts', 'rmr_load_custom_code_fonts' );
add_filter( 'generate_logo_attributes', 'rmr_lazy_logo', 10, 1 );
add_filter( 'generate_typography_default_fonts', 'rmr_load_local_fonts', 10, 1 );

/**
 * Load ASAP fonts in Gutenberg editor.
 *
 * Why we have to do this?
 * Gutenberg won't load the local fonts we just added. Previously was
 * adding the fonts from Google Fonts.
 *
 * @since 0.1.0
 */
function rmr_load_fonts_in_gutenberg_editor() {
	wp_enqueue_style( 'rmr-styles', get_stylesheet_uri() );
}

/**
 * Load the "JetBrains Mono" font in single posts and only
 * if the post contains the "core/code" Gutenberg block.
 *
 * @since 0.1.0
 */
function rmr_load_custom_code_fonts() {
	if ( ! is_single() || ! has_block( 'core/code' ) ) {
		return;
	}

	wp_enqueue_style(
		'rmr-single.css',
		get_stylesheet_directory_uri() . '/assets/css/single.css',
		null,
		RMR_VERSION
	);
}

/**
 * Load local fonts and use them in theme instead of
 * using Google Fonts CDN.
 *
 * We're using these fonts locally:
 *
 * - Asap (blog and pages)
 * - JetBrains Mono (for code editor)
 *
 * @since  0.1.0
 *
 * @param  array   $fonts   The current default fonts.
 * @return array            The fonts with our custom ones.
 */
function rmr_load_local_fonts( $fonts ) {
	$fonts[] = 'Asap';
	$fonts[] = 'JetBrains Mono';

	return $fonts;
}

/**
 * Lazy Load Header Logo.
 * We're lazy loading the logo by using "WP Bullet Lazy Load".
 *
 * We have to add the "wp-bullet-lazy-load" class, add the "data-src"
 * attribute and remove "src".
 *
 * It's recommended to add "width" and "height" attributes to keep dimensions.
 *
 * @since  0.1.0
 *
 * @param  array   $attr   The logo attributes.
 * @return array           The logo with lazy load attributes.
 */
function rmr_lazy_logo( $attr ) {
	$attr['data-src'] = $attr['src'];
	$attr['class']    = $attr['class'] . ' ' . 'wp-bullet-lazy-load';
	$attr['width']    = '40';
	$attr['height']   = '60';

	unset( $attr['src'] );

	return $attr;
}
