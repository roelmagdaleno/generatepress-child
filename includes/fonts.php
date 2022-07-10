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
 * @since 0.4.2   Preload Readex Pro font for titles.
 */
function rmr_preload_fonts() {
	$fonts = array(
		'inter'      => 'inter-v7-latin-regular.woff2',
		'readex-pro' => 'readex-pro-v9-latin-700.woff2',
	);

	if ( is_single() && has_block( 'core/code' ) ) {
		$fonts['jetbrains-mono'] = 'JetBrainsMono-Regular.woff2';
	}

	foreach ( $fonts as $font_family => $font ) {
		echo rmr_get_font_link( $font_family, $font );
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
	$fonts[] = 'Inter';
	$fonts[] = 'Readex Pro';

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
