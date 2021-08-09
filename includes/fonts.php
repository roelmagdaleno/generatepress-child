<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_head', 'rmr_preload_fonts', 8 );
add_filter( 'generate_typography_default_fonts', 'rmr_load_local_fonts', 10, 1 );

/**
 * Add "preload" links in <head> HTML tag. These lines will help to reduce GPSI scores.
 *
 * @since 0.1.0
 * @since 0.1.1   Preload JetBrains Mono font.
 */
function rmr_preload_fonts() {
	echo '<link rel="preload" href="' . RMR_THEME_URI . '/assets/fonts/inter/Inter-Regular.woff2" as="font" type="font/woff2" crossorigin>';

	echo '<link rel="preload" href="' . RMR_THEME_URI . '/assets/fonts/inter/Inter-Bold.woff2" as="font" type="font/woff2" crossorigin>';

	if ( is_single() && has_block( 'core/code' ) ) {
		echo '<link rel="preload" href="' . RMR_THEME_URI . '/assets/fonts/jetbrains-mono/JetBrainsMono-Regular.woff2" as="font" type="font/woff2" crossorigin>';
	}
}

/**
 * Load local fonts and use them in theme instead of using Google Fonts CDN.
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
	$fonts[] = 'Inter';
	$fonts[] = 'JetBrains Mono';

	return $fonts;
}
