<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'generate_logo_attributes', 'rmr_lazy_logo', 10, 1 );
add_filter( 'generate_typography_default_fonts', 'rmr_load_local_fonts', 10, 1 );

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
