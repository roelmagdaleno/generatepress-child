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
	$fonts = array(
		'poppins-v15-latin-600.woff2',
		'poppins-v15-latin-700.woff2',
		'poppins-v15-latin-regular.woff2',
	);

	foreach ( $fonts as $font ) {
		echo rmr_get_font_link( 'poppins', $font );
	}

	if ( is_single() && has_block( 'core/code' ) ) {
		echo rmr_get_font_link( 'jetbrains-mono', 'JetBrainsMono-Regular.woff2' );
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
function rmr_load_local_fonts( array $fonts ) : array {
	$fonts[] = 'Poppins';
	$fonts[] = 'JetBrains Mono';

	return $fonts;
}

/**
 * Get a font <link> to print in <head> tag.
 *
 * @since  0.2.4
 *
 * @param  string   $font_family   Current font family.
 * @param  string   $font          The font to be loaded.
 * @return string                  The font <link>.
 */
function rmr_get_font_link( string $font_family, string $font ) : string {
	$link  = '<link rel="preload" href="' . RMR_THEME_URI . '/assets/fonts/' . $font_family . '/' . $font . '" ';
	$link .= 'as="font" type="font/woff2" crossorigin>';

	return $link;
}
